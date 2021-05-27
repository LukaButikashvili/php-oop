<?php

function get_data($dataName, $id = null)
{
    $data = json_decode(file_get_contents("data/$dataName.json"), true)[$dataName];
    if(!is_null($id)) {
        
        foreach($data as $person) { 
            if($person['id'] == $id) {
                return $person;
            }
        }
        return "Sorry, data with id $id does not exist";
    }

    return $data;
}
