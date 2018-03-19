<?php

require_once("../connection.php");

echo ("Let's get some data from Github");

$page = "repos/M9k/PoC-Marvin-353/commits";

$url = "https://api.github.com/" . $page;

        $curl = curl_init();

        $header = array();
        $header[] = 'User-Agent: API Explorer';
        $header[] = 'Authorization: token 220c693603a65c450067c352d622bf857c4bc37e';

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $header
        ));

        $resp = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($resp, true);

        echo $resp;

        echo "Numero di commit: ".count($data);

        foreach ($data as $commit) {
            echo (($commit["commit"])["author"])["name"];
            echo (($commit["commit"])["message"]);

            $dateIso = (($commit["commit"])["author"])["date"];
            $date = DateTime::createFromFormat(DateTime::ISO8601, $dateIso);
            echo $date -> format("Y-m-d H:m:s");

            echo "<br>";
        }
        