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

/**
 * Проверяет была ли отправлена форма
 * @return bool
 */
function isFormSubmitted(){
    return (isset($_POST) AND !empty($_POST));
}

/**
 * Возвращает массив данных ассоциированных с формой
 * @return array
 */
function getFormData(){
    $arr = array();
    $arr['userName'] = isset($_POST['userName'])? trim($_POST['userName']): "";
    $arr['userEmail'] = isset($_POST['userEmail'])? trim($_POST['userEmail']): "";
    $arr['messageText'] = isset($_POST['messageText'])? trim($_POST['messageText']): "";
    $arr['captcha'] = isset($_POST['captcha'])? trim($_POST['captcha']): "";
    return $arr;
}

/**
 * Проверяет правильность введенной капчи
 * @return bool
 */
function checkCaptchaAnswer($answ){
    $rightAnsw = isset($_SESSION['captcha'])? $_SESSION['captcha']: '';
    return $answ == $rightAnsw;
}

/**
 * Проверяет валидность заполлнения полей формы
 * @param array $formData - массив с данными формы
 * @return array|bool - TRUE если форма валидка, массив со списком ошибок, если нет
 */
function isFormVaild(array $formData){
    $resp = true;
    $errors = array();

    if(strlen($formData['userName']) < 5){
        $resp = false;
        $errors['userName'] = 'Проверьте ввод имени';
    }

    if(strlen($formData['userEmail']) < 5){
        $resp = false;
        $errors['userEmail'] = 'Проверьте ввод email';
    }


    if(strlen($formData['messageText']) < 50){
        $resp = false;
        $errors['messageText'] = 'Сообщение должно содержать от 50 символов';
    }

    if(!checkCaptchaAnswer($formData['captcha'])){
        $resp = false;
        $errors['captcha'] = 'Неправильный ответ';
    }

    if(!$resp){
        return $errors;
    } else {
        return $resp;
    }
}

/**
 * Выводит сообщения об ошибках в переданный шаблон
 * @param $tpl - входной html
 * @param array $data
 * @return string
 */
function processTemplateErrorOutput($tpl, array $data = array()){
    foreach($data as $key => $val){
        $tpl = str_replace(
            "<p class=\"help-block\" data-name=\"$key\"></p>",
            "<p class=\"help-block\" data-name=\"$key\">$val</p>",
            $tpl
        );
    };

    return $tpl;
}

/**
 * Генерирует капчу. Возвращает вопрос. Ответ устанавливает в сессию
 * @return string
 */
function generateCaptcha(){
    $answ = rand(1, 20);
    $marker = rand(0,1)? '+': '-';

    $b = rand(1,$answ);
    switch($marker){
        case '+':
            $a = $answ - $b;
            break;
        case '-':
            $a = $answ + $b;
            break;
    }

    $_SESSION['captcha'] = $answ;
    return $a.' '.$marker.' '.$b;
}

/**
 * @param array $msgData
 * @return bool
 */
function saveMessage(array $msgData){
    return false;
}
