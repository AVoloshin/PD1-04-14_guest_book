<?php

require_once('inc/inc.php');

$pageTpl = getTemplate('page');
$formTpl = getTemplate('form');

$page = processTemplace($pageTpl, array(
    'FORM' => $formTpl
));

echo $page;