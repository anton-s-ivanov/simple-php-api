<?
    require 'routes.php';
    require 'DB/DbOperationsClass.php';
    require 'Responses\Responses.php';
   
    $uri = $_SERVER['REQUEST_URI'] ?? '/';

    if(!array_key_exists($uri, routes)){
        return (new Responses())->notFound();
    }

    if ($_SERVER['REQUEST_METHOD'] != routes[$uri]['REQUEST_METHOD']) {
        return (new Responses())->wrongRequestMethod();
    }

    $namespace = routes[$uri]['namespace'];
    $class = routes[$uri]['class'];
    $method = routes[$uri]['method'];

    require $namespace.'/'. $class.'.php';

    $data = (object)(new $class())->$method($_REQUEST);
    $response = ['data' => $data];

    return json_encode($response);
    
    // var_dump(json_encode($response));


    
    




