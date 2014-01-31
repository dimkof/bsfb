<?php
require_once ("Bsfb.php");

$form = new Bsfb("login");
$form->setTarget("login.php","POST");
$form->setGrid(array(2));


$form->addControl(array("id" => "email","value" => "","placeholder" => "Login Email","type" => "text"));
$form->addControl(array("id" => "password","value" => "","placeholder" => "Password","type" => "password"));

//add buttons
$form->addButton(array("id" => "form_submit", "value" => "Login","version" => "success", "type" => "submit", "css" => "pull-right "));
$form->addButton(array("id" => "form_cancel", "value" => "Cancel","version" => "warning", "type" => "cancel", "css" => "pull-right "));

//show the form onscreen
$form->displayForm();