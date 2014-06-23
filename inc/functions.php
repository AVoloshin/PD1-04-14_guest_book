<?php

function getTemplate($name){
    $tpl = "";
    $fileName = 'tpl' . DIRECTORY_SEPARATOR . $name . '.html';
    if(file_exists($fileName)){
        $tpl = file_get_contents($fileName);
    }
    return $tpl;
}