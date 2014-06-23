<?php

require_once('inc/inc.php');

$pageTpl = getTemplate('page');
$form = getTemplate('form');
$msg = "";

$formData = getFormData();

if(isFormSubmitted()){
    $validateFormResult = isFormVaild($formData);
    if($validateFormResult!== true) {
        $form = processTemplateErrorOutput($form, $validateFormResult);
    } else {
        if(saveMessage($formData)){
            header('Location: '.$_SERVER['REQUEST_URI']);
        } else {
            $msg = 'Ошибка сохранения';
        }

    }
}

$form = processTemplace($form, $formData);

$page = processTemplace($pageTpl, array(
    'FORM' => $form,
    'CAPTCHA' => generateCaptcha(),
    'MSG' => $msg
));

echo $page;