<?php
//$html = show_source('http://1stg.web/email_template/activation');
//
//$html = str_ireplace("FULLNAME", "Muhammad Asyraf Bin Othman", $html);

$html = file_get_contents('http://1stg.web/email_template/activation');
$html = htmlspecialchars($html);

$html = str_replace('[USERNAME]','aloongjerr',$html);
$html = str_replace('[ACTIVATION_CODE]','aloongjerr',$html);

$html = html_entity_decode($html);

echo $html;
?>