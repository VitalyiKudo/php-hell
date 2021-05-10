<?php

function createAdditionalDataArray($data, $key){
    $comments_array = [];
    $comments_list = explode(PHP_EOL, $data);
    foreach($comments_list as $comments){
        if($comments != ""){
            $comments_item = explode(": ", $comments);
            if(isset($comments_item[0]) && isset($comments_item[1])){
                $comments_array[strtolower(str_replace(" ", "_", $comments_item[0]))] = str_replace(";", "", $comments_item[1]);
            }
        }
    }
    //exit();
    //print_r($comments_array);
    return $comments_array[$key] ?? "";
}

function removeBottomSlash($data){
    $data = str_replace("_", " ", $data);
    return $data;
}

function createAdditionalDataArrayRewerse($data, $keys){
    $comments_array = [];
    $comments_list = explode(PHP_EOL, $data);
    foreach($comments_list as $comments){
        if($comments != ""){
            $comments_item = explode(": ", $comments);
            if(isset($comments_item[0]) && isset($comments_item[1])){
                if($comments_item[0] && in_array($comments_item[0], $keys)){ 
                    $comments_array[] = $comments_item[0];
                }
            }
        }
    }
    $comments_string = implode(", ", $comments_array);
    
    return rtrim($comments_string, ", ");
}
