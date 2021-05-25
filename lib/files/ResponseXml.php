<?php

require_once 'ResponseInterface.php';

class ResponseXml implements ResponseInterface
{
    protected $data;

    protected $accept;

    public function __construct(array $data, string $accept)
    {
        $this->data = $data;
        
        $this->accept = $accept;

    }

    public function arrayToXml($array, $rootElement = null, $xml = null) {
        $_xml = $xml;  
        // If there is no Root Element then insert root
        if ($_xml === null) {
            $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
        }
        // Visit all key value pair
        foreach ($array as $k => $v) {
            // If there is nested array then
            if (is_array($v)) {  
                // Call function for nested array
                $this->arrayToXml($v, $k, $_xml->addChild($k));
            } 
            else {
                // Simply add child element. 
                $_xml->addChild($k, $v);
            }
        }
        return $_xml->asXML();
    }

    public function send_response( $force_send = false )
    {
        header("Content-Type: $this->accept");
        http_response_code(200);

        print_r($this->arrayToXml($this->data));
    }
}
