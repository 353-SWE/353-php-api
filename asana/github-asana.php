<?php
    include('asana.php');

    // id generali di Asana
    define('ID_WORKSPACE', 477495891602483);
    define('ID_PROJECT', 599087460317432);
    define('ID_SECTION', 599087460317433);

    // users id
    define('ID_DAVIDE', 477499463971210);
    define('ID_ELENA', 477499463971221);
    define('ID_GIANLUCA', 53863020133019);
    define('ID_MIRCO', 477499463971191);
    define('ID_VALENTINA', 477499463971232);
    define('ID_RICCARDO', 431129689538819);
    define('ID_PARWINDER', 477499463971243);

    // array con i colori possibili per i tags su Asana
    $tag_color = [
        'dark-pink',
        'dark-green',
        'dark-blue',
        'dark-red',
        'dark-teal',
        'dark-brown',
        'dark-orange',
        'dark-purple',
        'dark-warm-gray',
        'light-pink',
        'light-green',
        'light-blue',
        'light-green',
        'light-red',
        'light-teal',
        'light-yellow',
        'light-orange',
        'light-purple',
        'light-warm-gray'
    ];

    $data_github = $_GET;

    $assignee = null;
    if(isset($data_github['assignee'])) {
        switch($data_github['assignee']) {
            case 'Stocci':
                $assignee = ID_DAVIDE;
                break;

            case 'elenamattiazzo':
                $assignee = ID_ELENA;
                break;

            case 'gmarraffa':
                $assignee = ID_GIANLUCA;
                break;

            case 'M9k':
                $assignee = ID_MIRCO;
                break;

            case 'ValeMarcon':
                $assignee = ID_VALENTINA;
                break;

            case 'Giorat':
                $assignee = ID_RICCARDO;
                break;

            case 'SinghParwinder':
                $assignee = ID_PARWINDER;
                break;
        }
    } 

    // accessToken dell'account 353swe, tutte le task saranno segnate come create da 353
    $asana = new Asana([
        'personalAccessToken' => '0/cea694f41d3bf363d094c7d86c06cfd9'
    ]);

    // viene creato il task
    $risp = $asana->createTask([
        'workspace' => ID_WORKSPACE,
        'name' => $data_github['title'],
        'assignee' => $assignee
     ]);

     $array = json_decode($risp, true);
     $data_task = $array['data'];
     
     // il nuovo task viene assegnato al project GitHub e messo nella colonna To Do
     $risp = $asana->addProjectToTask(
         $data_task['id'],
         ID_PROJECT,
         ['section' => ID_SECTION]
     );
    
     // vengono aggiunti i tags (se presenti)
     if(isset($data_github['labels'])) {
         $array_tags = explode(', ', $data_github['labels']);
         foreach($array_tags as $tag) {
            $risp = $asana->getTagId($tag, ID_WORKSPACE);
            $array = json_decode($risp, true);
            $data_tag = $array['data'];      
            if(sizeof($data_tag) == 0) {                        // il tag non esite su Asana, viene aggiunto
                $color = $tag_color[rand(0, 17)];
                $risp = $asana->createTag(
                    $tag, 
                    ['workspace' => ID_WORKSPACE],
                    ['color' => $color]
                );
                $array = json_decode($risp, true);
                $data_tag = $array['data']; 
                $tag_id = $data_tag['id'];
            } else {
                $tag_id = $data_tag[0]['id'];
            }        
            $asana->addTagToTask($data_task['id'], $tag_id);
         } 
     }
?>