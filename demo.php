<?php
require_once ("Bsfb.php");

$form = new Bsfb("agent_edit");
$form->setTarget("/site_mods/agenthunter/system/agent_details.php","POST");
$form->setGrid(array(2,1,1));


$form->addControl(array("id" => "ag_agentname","value" => "","placeholder" => "Agent Name","type" => "text"));

$form->addControl(array("id" => "ag_photo","value" => "","placeholder" => "Agent Photo","type" => "text"));
$form->addControl(array("id" => "ag_pers_email","value" => "","placeholder" => "Personal Email","type" => "text"));

$form->addControl(array("id" => "ag_shortbio","value" => "","placeholder" => "Short Biography","type" => "textarea", "rows" => 5));


//add buttons
$form->addButton(array("id" => "form_submit", "value" => "Save Changes","version" => "success", "type" => "submit", "css" => "pull-right "));
$form->addButton(array("id" => "form_cancel", "value" => "Cancel","version" => "warning", "type" => "cancel", "css" => "pull-right "));

//show the form onscreen
$form->displayForm();