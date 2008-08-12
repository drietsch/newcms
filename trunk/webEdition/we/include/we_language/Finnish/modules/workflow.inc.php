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

$l_workflow["new_workflow"] = "Uusi ty�nkulku";
$l_workflow["workflow"] = "Ty�nkulku";

$l_workflow["doc_in_wf_warning"] = "Dokumentti on ty�nkulussa!";
$l_workflow["message"] = "Viesti";
$l_workflow["in_workflow"] = "Dokumentti ty�nkulussa";
$l_workflow["decline_workflow"] = "Hylk�� dokumentti";
$l_workflow["pass_workflow"] = "Edelleenohjaa dokumentti";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Dokumentti on siirretty ty�nkulkuun!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Dokumenttia ei voitu siirt�� ty�nkulkuun!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Objekti on siirretty ty�nkulkuun!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Objektia ei voitu siirt�� ty�nkulkuun!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Objekti on edelleenl�hetetty!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Objektia ei voitu edelleenl�hett��!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Objekti on palautettu laatijalle!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Objektia ei voitu palauttaa laatijalle!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Dokumentti on edelleenl�hetetty!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Dokumenttia ei voitu edelleenl�hett��!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Dokumentti on palautettu laatijalle!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Dokumenttia ei voitu palauttaa laatijalle!";

$l_workflow["no_wf_defined"] = "Dokumentille ei ole m��ritetty ty�nkulkua!";

$l_workflow["document"] = "Dokumentti";

$l_workflow["del_last_step"] = "Viimeist� sarjavaihetta ei voitu poistaa!";
$l_workflow["del_last_task"] = "Viimeist� rinnakkaisvaihetta ei voitu poistaa!";
$l_workflow["save_ok"] = "Ty�nkulku on tallennettu.";
$l_workflow["delete_ok"] = "Ty�nkulku on poistettu.";
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

$l_workflow["active"] = "Ty�nkulku on aktiivinen.";

$l_workflow["step"] = "Vaihe";
$l_workflow["and_or"] = "JA&nbsp;/&nbsp;TAI";
$l_workflow["worktime"] = "Ty�aika (H)";
$l_workflow["user"] = "K�ytt�j�";

$l_workflow["edit"] = "Muokkaa";
$l_workflow["send_mail"] = "L�het� s�hk�postia";
$l_workflow["select_user"] = "Valitse k�ytt�j�";

$l_workflow["and"] = " ja ";
$l_workflow["or"] = " tai ";

$l_workflow["waiting_on_approval"] = "Odotetaan hyv�ksynt�� k�ytt�j�lt� %s.";
$l_workflow["status"] = "Tila";
$l_workflow["step_from"] = "Vaihe %s / %s";

$l_workflow["step_time"] = "Vaiheen aika";
$l_workflow["step_start"] = "Vaiheen aloitusp�iv�m��r�";
$l_workflow["step_plan"] = "Lopetusp�iv�m��r�";
$l_workflow["step_worktime"] = "Suunniteltu ty�aika";

$l_workflow["current_time"] = "T�m�nhetkinen aika";
$l_workflow["time_elapsed"] = "K�ytetty aika";
$l_workflow["time_remained"] = "Aikaa j�ljell�";

$l_workflow["todo_subject"] = "Ty�nkulun teht�v�";
$l_workflow["todo_next"] = "Sinulle on odottamassa dokumentti ty�nkulussa.";

$l_workflow["go_next"] = "Seuraava vaihe";

$l_workflow["new_step"] = "Luo per�kk�inen lis�vaihe.";
$l_workflow["new_task"] = "Luo rinnakkainen lis�vaihe.";

$l_workflow["delete_step"] = "Poista per�kk�isvaihe.";
$l_workflow["delete_task"] = "Poista rinnakkaisvaihe.";

$l_workflow["save_question"] = "Kaikki ty�nkulkuun m��ritellyt dokumentit poistetaan ty�nkulusta.\\nOletko varma ett� haluat jatkaa?";
$l_workflow["nothing_to_save"] = "Ei mit��n tallennettavaa!";
$l_workflow["save_changed_workflow"] = "Workflow has been changed.\\nDo you want to save your changes?"; // TRANSLATE

$l_workflow["delete_question"] = "Kaikki ty�nkulun tiedot poistetaan!\\nOletko varma ett� haluat jatkaa?";
$l_workflow["nothing_to_delete"] = "Ei mit��n poistettavaa!";

$l_workflow["user_empty"] = "Vaiheelle %s ei ole m��ritelty k�ytt�ji�.";
$l_workflow["folders_empty"] = "Hakemistoa ei ole m��ritelty ty�nkululle!";
$l_workflow["objects_empty"] = "Objektia ei ole m��ritelty ty�nkululle!";
$l_workflow["doctype_empty"] = "Dokumenttityyppi� tai kategoriaa ei ole m��ritelty ty�nkululle";
$l_workflow["worktime_empty"] = "Ty�aikaa ei ole m��ritelty vaiheelle %s!";
$l_workflow["name_empty"] = "Ty�nkululle ei ole m��ritelty nime�!";
$l_workflow["cannot_find_active_step"] = "Aktiivista vaihetta ei l�ydy!";

$l_workflow["no_perms"] = "Ei k�ytt�oikeutta!";
$l_workflow["plan"] = "(suunnitelma)";

$l_workflow["todo_returned"] = "Dokumentti on palautettu ty�nkulkuun.";

$l_workflow["description"] = "Kuvaus";
$l_workflow["time"] = "Aika";

$l_workflow["log_approve_force"] = "K�ytt�j� on pakkohyv�ksynyt dokumentin.";
$l_workflow["log_approve"] = "K�ytt�j� on hyv�ksynyt dokumentin.";
$l_workflow["log_decline_force"] = "K�ytt�j� on pakkokeskeytt�nyt dokumentin ty�nkulun.";
$l_workflow["log_decline"] = "K�ytt�j� on keskeytt�nyt ty�nkulun.";
$l_workflow["log_doc_finished_force"] = "Ty�nkulku on pakottaen viety loppuun.";
$l_workflow["log_doc_finished"] = "Ty�nkulku on lopetettu.";
$l_workflow["log_insert_doc"] = "Dokumentti on asetettu ty�nkulkuun.";

$l_workflow["logbook"] = "Lokikirja";
$l_workflow["empty_log"] = "Tyhjenn� lokikirja";
$l_workflow["emty_log_question"] = "Haluatko varmasti tyhjent�� lokikirjan?";
$l_workflow["empty_log_ok"] = "Lokikirja on nyt tyhj�.";
$l_workflow["log_is_empty"] = "Lokikirja on tyhj�.";

$l_workflow["log_question_all"] = "Tyhjenn� kaikki";
$l_workflow["log_question_time"] = "Tyhjenn� vanhemmat kuin";
$l_workflow["log_question_text"] = "Valitse vaihtoehto:";

$l_workflow["log_remove_doc"] = "Dokumentti on poistettu ty�nkulusta.";
$l_workflow["action"] = "Toiminto";

$l_workflow[FILE_TABLE]["messagePath"] = "Dokumentti";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Objekti";
}
$l_workflow["auto_approved"] = "Dokumentti on automaattisesti hyv�ksytty.";
$l_workflow["auto_declined"] = "Dokumentti on automaattisesti hyl�tty.";

$l_workflow["doc_deleted"] = "Dokumentti on poistettu!";
$l_workflow["ask_before_recover"] = "Ty�nkulussa on yh� dokumentteja/objekteja! Haluatko poistaa ne ty�nkulkuprosessista?";

$l_workflow["double_name"] = "Ty�nkulun nimi on jo k�yt�ss�!";

$l_workflow["more_information"] = "Lis�tietdot";
$l_workflow["less_information"] = "Piilota lis�tiedot";

$l_workflow["no_wf_defined_object"] = "T�lle objektille ei ole m��ritelty ty�nkulkua!";
?>