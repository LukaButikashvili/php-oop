<?php

class ResponseFactory {

    public static function createResponse(array $data) {
        
        $accept = self::readConfigFormat();
        $format = explode('/', $accept)[1];

        //$data = self::returnDataInArrayFormat($dataName);

        $requestClasses = [
            'html' => 'ResponseTxt',
            'json' => 'ResponseJson',
            'xml' => 'ResponseXml',
        ];

        if(!isset($requestClasses[$format])) {
            throw new Exception(sprintf("Supplied format %s doesn't exist", $format));
        }

        $class = $requestClasses[$format];
        $classFile = 'lib/files/' . $class . '.php';

        if(!file_exists($classFile)) {
            throw new Exception(sprintf("the file for the class %s doesn't exist", $class));
        }

        require_once $classFile;

        return new $class($data, $accept);

    }

    public static function readConfigFormat() {
        $config = json_decode(file_get_contents('core/config/config.json'), true);

        return $config['content']['type'];
    }

    // public static function returnDataInArrayFormat(string $dataName) {
    //     $DATA_PATH = "data/";
    //     $fetchData = json_decode(file_get_contents($DATA_PATH . $dataName . ".json"), true);

    //     return $fetchData;
    // }

}