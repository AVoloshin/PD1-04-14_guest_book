<?php

require_once('inc/inc.php');

$pageTpl = getTemplate('page');
$form = getTemplate('form');

$formData = getFormData();

if(isFormSubmitted()){
    $validateFormResult = isFormVaild($formData);
    if($validateFormResult!== true) {
        $form = processTemplateErrorOutput($form, $validateFormResult);
    } else {
        $formData['messageText'] = "";
    }
}

$form = processTemplace($form, $formData);

$page = processTemplace($pageTpl, array(
    'FORM' => $form,
    'CAPTCHA' => generateCaptcha()
));

echo $page;