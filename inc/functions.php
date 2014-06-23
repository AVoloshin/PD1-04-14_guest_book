<?php

/**
 * Возвращает  шаблон по его имени, если он найден в папке шаблонов. иначе - пустую строку
 * @param $name string - имя шаблона
 * @return string
 */
function getTemplate($name){
    $tpl = "";
    $fileName = 'tpl' . DIRECTORY_SEPARATOR . $name . '.html';
    if(file_exists($fileName)){
        $tpl = file_get_contents($fileName);
    }
    return $tpl;
}

/**
 * Выполняет подстановки в переданный шаблон
 * @param $tpl string - строка с макросами подстановки вида {{NAME}}
 * @param array $data - массив подстановок вида array('NAME' => 'code')
 * @return string
 */
function processTemplace($tpl, array $data = array()){
    foreach($data as $key => $val){
        $tpl = str_replace('{{'.$key.'}}', $val, $tpl);
    }
    return $tpl;
}