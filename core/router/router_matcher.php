<?php

function get_routes(string $routes_file) {
    if (!file_exists($routes_file)) {
        http_response_code(500);
        echo "The given routes file doesn't exist: " . $routes_file;
        die();
    }

    return json_decode(file_get_contents($routes_file), true);
}

function register_handlers($handlers_file)
{
    if (file_exists($handlers_file)) {
        require_once $handlers_file;
    } else {
        http_response_code(500);
        echo "The given router handler directory doesn't exist: " . $handlers_file;
    }
}

function matchRoute(string $path, string $routes_file)
{
    if(strlen($path) === 0) {
        print "Home page";
        exit;
    }

    $routes = get_routes($routes_file);

    //If path was found directly, call its handler function.
    if(isset($routes[$path])) {
        $function = $routes[$path];

        return call_user_func($function);
    }

    //Try to match route with parameters
    $param_delimiter = ":";
    foreach( $routes as $route => $handler) {
        // : adgilmdebarebis indexs bechdavs tu ver ipova false (returns number)
        $delimiter_pos = strpos($route, $param_delimiter); //teachers ->10
        //1 param- romeli stringidan; 2 param- romeli indexidan; 3- sadamde 
        $base_route = substr($route, 0, $delimiter_pos -1 ); // teachers -> /teachers
        //basename- stringis bolo nawils amoagdebs (/ rocaa gamoyofili)
        $path_param = basename($path); // 1
        $base_path = substr($path, 0, strpos($path, $path_param) - 1); // teachers -> /teachers

        $get_data_name = explode('/', $path)[1];
        if($delimiter_pos !== false) {
            $function = $handler;
            if ($base_path == $base_route) {
                return $function($get_data_name, $path_param); //sheaswore
            } else if ($path == $base_route) {
                return $function($get_data_name);
            }
        }
    }

    //In other cases, route is not registered.
    http_response_code(404);
    echo 'Page not found';
    die;
}


