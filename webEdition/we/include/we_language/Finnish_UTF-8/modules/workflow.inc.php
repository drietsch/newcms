<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Language file: workflow.inc.php
 * Provides language strings.
 * Language: English
 */

$l_workflow["new_workflow"] = "Uusi työnkulku";
$l_workflow["workflow"] = "Työnkulku";

$l_workflow["doc_in_wf_warning"] = "Dokumentti on työnkulussa!";
$l_workflow["message"] = "Viesti";
$l_workflow["in_workflow"] = "Dokumentti työnkulussa";
$l_workflow["decline_workflow"] = "Hylkää dokumentti";
$l_workflow["pass_workflow"] = "Edelleenohjaa dokumentti";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Dokumentti on siirretty työnkulkuun!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Dokumenttia ei voitu siirtää työnkulkuun!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Objekti on siirretty työnkulkuun!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Objektia ei voitu siirtää työnkulkuun!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Objekti on edelleenlähetetty!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Objektia ei voitu edelleenlähettää!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Objekti on palautettu laatijalle!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Objektia ei voitu palauttaa laatijalle!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Dokumentti on edelleenlähetetty!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Dokumenttia ei voitu edelleenlähettää!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Dokumentti on palautettu laatijalle!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Dokumenttia ei voitu palauttaa laatijalle!";

$l_workflow["no_wf_defined"] = "Dokumentille ei ole määritetty työnkulkua!";

$l_workflow["document"] = "Dokumentti";

$l_workflow["del_last_step"] = "Viimeistä sarjavaihetta ei voitu poistaa!";
$l_workflow["del_last_task"] = "Viimeistä rinnakkaisvaihetta ei voitu poistaa!";
$l_workflow["save_ok"] = "Työnkulku on tallennettu.";
$l_workflow["delete_ok"] = "Työnkulku on poistettu.";
$l_workflow["delete_nok"] = "Poistaminen ei onnistunut.";

$l_workflow["name"] = "Nimi";
$l_workflow["type"] = "Tyyppi";
$l_workflow["type_dir"] = "Hakemistopohjainen";
$l_workflow["type_doctype"] = "Dokumenttityyppi/Kategoriapohjainen";
$l_workflow["type_object"] = "Objektipohjainen";

$l_workflow["dirs"] = "Hakemistot";
$l_workflow["doctype"] = "Dokumenttin tyyppi";
$l_workflow["categories"] = "Kategoriat";
$l_workflow["classes"] = "Luokat";

$l_workflow["active"] = "Työnkulku on aktiivinen.";

$l_workflow["step"] = "Vaihe";
$l_workflow["and_or"] = "JA&nbsp;/&nbsp;TAI";
$l_workflow["worktime"] = "Työaika (H)";
$l_workflow["user"] = "Käyttäjä";

$l_workflow["edit"] = "Muokkaa";
$l_workflow["send_mail"] = "Lähetä sähköpostia";
$l_workflow["select_user"] = "Valitse käyttäjä";

$l_workflow["and"] = " ja ";
$l_workflow["or"] = " tai ";

$l_workflow["waiting_on_approval"] = "Odotetaan hyväksyntää käyttäjältä %s.";
$l_workflow["status"] = "Tila";
$l_workflow["step_from"] = "Vaihe %s / %s";

$l_workflow["step_time"] = "Vaiheen aika";
$l_workflow["step_start"] = "Vaiheen aloituspäivämäärä";
$l_workflow["step_plan"] = "Lopetuspäivämäärä";
$l_workflow["step_worktime"] = "Suunniteltu työaika";

$l_workflow["current_time"] = "Tämänhetkinen aika";
$l_workflow["time_elapsed"] = "Käytetty aika";
$l_workflow["time_remained"] = "Aikaa jäljellä";

$l_workflow["todo_subject"] = "Työnkulun tehtävä";
$l_workflow["todo_next"] = "Sinulle on odottamassa dokumentti työnkulussa.";

$l_workflow["go_next"] = "Seuraava vaihe";

$l_workflow["new_step"] = "Luo peräkkäinen lisävaihe.";
$l_workflow["new_task"] = "Luo rinnakkainen lisävaihe.";

$l_workflow["delete_step"] = "Poista peräkkäisvaihe.";
$l_workflow["delete_task"] = "Poista rinnakkaisvaihe.";

$l_workflow["save_question"] = "Kaikki työnkulkuun määritellyt dokumentit poistetaan työnkulusta.\\nOletko varma että haluat jatkaa?";
$l_workflow["nothing_to_save"] = "Ei mitään tallennettavaa!";
$l_workflow["save_changed_workflow"] = "Workflow has been changed.\\nDo you want to save your changes?"; // TRANSLATE

$l_workflow["delete_question"] = "Kaikki työnkulun tiedot poistetaan!\\nOletko varma että haluat jatkaa?";
$l_workflow["nothing_to_delete"] = "Ei mitään poistettavaa!";

$l_workflow["user_empty"] = "Vaiheelle %s ei ole määritelty käyttäjiä.";
$l_workflow["folders_empty"] = "Hakemistoa ei ole määritelty työnkululle!";
$l_workflow["objects_empty"] = "Objektia ei ole määritelty työnkululle!";
$l_workflow["doctype_empty"] = "Dokumenttityyppiä tai kategoriaa ei ole määritelty työnkululle";
$l_workflow["worktime_empty"] = "Työaikaa ei ole määritelty vaiheelle %s!";
$l_workflow["name_empty"] = "Työnkululle ei ole määritelty nimeä!";
$l_workflow["cannot_find_active_step"] = "Aktiivista vaihetta ei löydy!";

$l_workflow["no_perms"] = "Ei käyttöoikeutta!";
$l_workflow["plan"] = "(suunnitelma)";

$l_workflow["todo_returned"] = "Dokumentti on palautettu työnkulkuun.";

$l_workflow["description"] = "Kuvaus";
$l_workflow["time"] = "Aika";

$l_workflow["log_approve_force"] = "Käyttäjä on pakkohyväksynyt dokumentin.";
$l_workflow["log_approve"] = "Käyttäjä on hyväksynyt dokumentin.";
$l_workflow["log_decline_force"] = "Käyttäjä on pakkokeskeyttänyt dokumentin työnkulun.";
$l_workflow["log_decline"] = "Käyttäjä on keskeyttänyt työnkulun.";
$l_workflow["log_doc_finished_force"] = "Työnkulku on pakottaen viety loppuun.";
$l_workflow["log_doc_finished"] = "Työnkulku on lopetettu.";
$l_workflow["log_insert_doc"] = "Dokumentti on asetettu työnkulkuun.";

$l_workflow["logbook"] = "Lokikirja";
$l_workflow["empty_log"] = "Tyhjennä lokikirja";
$l_workflow["emty_log_question"] = "Haluatko varmasti tyhjentää lokikirjan?";
$l_workflow["empty_log_ok"] = "Lokikirja on nyt tyhjä.";
$l_workflow["log_is_empty"] = "Lokikirja on tyhjä.";

$l_workflow["log_question_all"] = "Tyhjennä kaikki";
$l_workflow["log_question_time"] = "Tyhjennä vanhemmat kuin";
$l_workflow["log_question_text"] = "Valitse vaihtoehto:";

$l_workflow["log_remove_doc"] = "Dokumentti on poistettu työnkulusta.";
$l_workflow["action"] = "Toiminto";

$l_workflow[FILE_TABLE]["messagePath"] = "Dokumentti";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Objekti";
}
$l_workflow["auto_approved"] = "Dokumentti on automaattisesti hyväksytty.";
$l_workflow["auto_declined"] = "Dokumentti on automaattisesti hylätty.";

$l_workflow["doc_deleted"] = "Dokumentti on poistettu!";
$l_workflow["ask_before_recover"] = "Työnkulussa on yhä dokumentteja/objekteja! Haluatko poistaa ne työnkulkuprosessista?";

$l_workflow["double_name"] = "Työnkulun nimi on jo käytössä!";

$l_workflow["more_information"] = "Lisätietdot";
$l_workflow["less_information"] = "Piilota lisätiedot";

$l_workflow["no_wf_defined_object"] = "Tälle objektille ei ole määritelty työnkulkua!";
?>