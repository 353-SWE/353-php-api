<?php

require_once("../connection.php");

echo ("Let's get some data from travis");

//default limit is 25 increased by two to get less pagination

//DOCUMENTAZIONE ID 3696003
//POC e CODICE ID 3876807

DB::query('DELETE FROM travisci');

$repos[] = 3696003;
$repos[] = 3876807;

foreach ($repos as $repo) {
    getRepoBuild($repo);
}

function getRepoBuild($id)
{
    $page = "/repo/" . $id . "/builds?limit=50";
    $continue = true;
    while ($continue) {
        $url = "https://api.travis-ci.com" . $page;

        $curl = curl_init();

        $header = array();
        $header[] = 'Travis-API-Version: 3';
        $header[] = 'User-Agent: API Explorer';
        $header[] = 'Authorization: token nlVuJPTI9LIJECSiVwK9Zw';

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $header
        ));

        $resp = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($resp, true);

        $page = (($data["@pagination"])["next"])["@href"];

        echo "<h1>" . $page . "</h1>";

        foreach ($data["builds"] as $build) {
           
            //echo $build["id"] . " " . $build["number"] . " " . $build["state"] . " " . $build["duration"] . "<br>";

            $built["id"] = $build["id"];
            $built["number"] = $build["number"];
            $built["state"] = $build["state"];
        
            $date = DateTime::createFromFormat(DateTime::ISO8601, $build["started_at"]);
            if($date)
                $built["at"] = $date -> format("Y-m-d H:m:s");
            else
                $built["at"] = $build["started_at"];

            $built["repo"] = $id;

            if($built["state"] != "canceled")
                DB::insert('travisci', $built);

        }

        if (($data["@pagination"])["is_last"] === true)
            $continue = false;
    }
}

?>




