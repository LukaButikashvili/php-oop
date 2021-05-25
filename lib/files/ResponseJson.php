<?php

require_once 'ResponseInterface.php';

class ResponseJson implements ResponseInterface
{
    protected $data;

    protected $accept;

    public function __construct(array $data, string $accept)
    {
        $this->data = $data;
        
        $this->accept = $accept;

    }

    public function convertArrayToJson() {
        return json_encode($this->data);
    }

    public function send_response( $force_send = false )
    {
        header("Content-Type: $this->accept");
        http_response_code(200);

        print_r($this->convertArrayToJson());
    }
}