<?php

interface ResponseInterface 
{
    public function send_response( $force_send = false );
}