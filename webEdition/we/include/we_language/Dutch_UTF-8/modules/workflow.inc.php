<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


/**
 * Language file: workflow.inc.php
 * Provides language strings.
 * Language: Dutch
 */

$l_workflow["new_workflow"] = "Nieuwe workflow";
$l_workflow["workflow"] = "Workflow";

$l_workflow["doc_in_wf_warning"] = "Het document bevindt zich in de workflow!";
$l_workflow["message"] = "Bericht";
$l_workflow["in_workflow"] = "Document in workflow";
$l_workflow["decline_workflow"] = "Document afwijzen";
$l_workflow["pass_workflow"] = "Document doorsturen";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Het document is succesvol in de workflow geplaatst!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Het document kan niet in de workflow geplaatst worden!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Het object is succesvol in de workflow geplaatst!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Het object kan niet in de workflow geplaatst worden!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Het object is succesvol door gegeven!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Het object kan niet door gegeven worden!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Het object is terug gestuurd naar de auteur!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Het object kan niet terug gestuur worden naar de auteur!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Het document is succesvol door gestuurd!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Het document kan niet doorgestuurd worden!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Het document is door gestuurd naar de auteur!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Het document kan niet door gestuurd worden naar de auteur!";

$l_workflow["no_wf_defined"] = "Geen workflow gedefinieerd voor dit document!";

$l_workflow["document"] = "Document";

$l_workflow["del_last_step"] = "Kan laatste seriële stap niet verwijderen!";
$l_workflow["del_last_task"] = "Kan laatste parallele stap niet verwijderen!";
$l_workflow["save_ok"] = "Workflow is bewaard.";
$l_workflow["delete_ok"] = "Workflow is verwijderd.";
$l_workflow["delete_nok"] = "Verwijderen mislukt!";

$l_workflow["name"] = "Naam";
$l_workflow["type"] = "Type";
$l_workflow["type_dir"] = "Directory-gebaseerd";
$l_workflow["type_doctype"] = "Document type/Categorie-gebaseerd";
$l_workflow["type_object"] = "Object-gebaseerd";

$l_workflow["dirs"] = "Directories"; 
$l_workflow["doctype"] = "Document type"; 
$l_workflow["categories"] = "Categorieën";
$l_workflow["classes"] = "Classen";

$l_workflow["active"] = "Workflow is actief.";

$l_workflow["step"] = "Stap";
$l_workflow["and_or"] = "EN&nbsp;/&nbsp;OF";
$l_workflow["worktime"] = "Werktijd (U)";
$l_workflow["user"] = "Gebruiker";

$l_workflow["edit"] = "Wijzig";
$l_workflow["send_mail"] = "Verstuur mail";
$l_workflow["select_user"] = "Selecteer gebruiker";

$l_workflow["and"] = " en ";
$l_workflow["or"] = " of ";

$l_workflow["waiting_on_approval"] = "Wacht op goedkeuring van %s.";
$l_workflow["status"] = "Status"; 
$l_workflow["step_from"] = "Stap %s van %s";

$l_workflow["step_time"] = "Tijd per stap";
$l_workflow["step_start"] = "Start datum vam stap";
$l_workflow["step_plan"] = "Eind datum";
$l_workflow["step_worktime"] = "Geplande werktijd";

$l_workflow["current_time"] = "Huidige tijd";
$l_workflow["time_elapsed"] = "Tijd verstreken";
$l_workflow["time_remained"] = "Tijd resterend";

$l_workflow["todo_subject"] = "Workflow taak";
$l_workflow["todo_next"] = "Er is een document voor u in de workflow.";

$l_workflow["go_next"] = "Volgende stap";

$l_workflow["new_step"] = "Maak aditionele seriële stap aan.";
$l_workflow["new_task"] = "Maak aditionele parallele stap aan.";

$l_workflow["delete_step"] = "Verwijder seriële stap.";
$l_workflow["delete_task"] = "Verwijder parallele stap.";

$l_workflow["save_question"] = "Alle documenten die zich bevinden in de workflow worden verwijderd uit de workflow.\\nWeet u zeker dat u door wilt gaan?";
$l_workflow["nothing_to_save"] = "Er is niks om te bewaren!";
$l_workflow["save_changed_workflow"] = "Workflow has been changed.\\nDo you want to save your changes?";

$l_workflow["delete_question"] = "Alle workflow data wordt verwijderd!\\nWeet u zeker dat u door wilt gaan?";
$l_workflow["nothing_to_delete"] = "Er is niks om te verwijderen!";

$l_workflow["user_empty"] = "Geen gedefinieerde gebruikers voor stap %s.";
$l_workflow["folders_empty"] = "De map is niet gedefinieerd voor de workflow!";
$l_workflow["objects_empty"] = "Het Object is niet gedefinieerd voor workflow!";
$l_workflow["doctype_empty"] = "Document type of categorie zijn niet gedefinieerd voor de workflow";
$l_workflow["worktime_empty"] = "De werktijd is niet gedefinieerd voor stap %s!";
$l_workflow["name_empty"] = "Deanam is niet gedefinieerd voor de workflow!";
$l_workflow["cannot_find_active_step"] = "Kan actieve stap niet vinden!";

$l_workflow["no_perms"] = "Geen toestemming!";
$l_workflow["plan"] = "(plan)";

$l_workflow["todo_returned"] = "Het document is terug gekeerd uit het werkschema.";

$l_workflow["description"] = "Omschrijving";
$l_workflow["time"] = "Tijd";

$l_workflow["log_approve_force"] = "Gebruiker heeft document geforceerd goed gekeurd.";
$l_workflow["log_approve"] = "Gebruiker heeft document goed gekeurd.";
$l_workflow["log_decline_force"] = "Gebruiker heeft document workflow geforceerd geannuleerd.";
$l_workflow["log_decline"] = "Gebruiker heeft document workflow geannuleerd.";
$l_workflow["log_doc_finished_force"] = "Workflow is geforceerd gestopt.";
$l_workflow["log_doc_finished"] = "Workflow is voltooid.";
$l_workflow["log_insert_doc"] = "Document is ingevoegd in de wokflow.";

$l_workflow["logbook"] = "Logboek";
$l_workflow["empty_log"] = "Leeg logboek";
$l_workflow["emty_log_question"] = "Weet u zeker dat u het logboek leeg wilt maken?";
$l_workflow["empty_log_ok"] = "Het logboek is nu leeg.";
$l_workflow["log_is_empty"] = "Het logboek is leeg.";

$l_workflow["log_question_all"] = "Leeg alles";
$l_workflow["log_question_time"] = "Leeg ouder dan";
$l_workflow["log_question_text"] = "Kies optie:";

$l_workflow["log_remove_doc"] = "Document is verwijderd uit de workflow.";
$l_workflow["action"] = "Actie";

$l_workflow[FILE_TABLE]["messagePath"] = "Document";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Object"; 
}
$l_workflow["auto_approved"] = "Document is automatisch goedgekeurd.";
$l_workflow["auto_declined"] = "Document is automatisch afgewezen.";

$l_workflow["doc_deleted"] = "Document is verwijderd!";
$l_workflow["ask_before_recover"] = "Er bevinden zich nog steeds documenten/objecten in het werkschema proces! Wilt u ze uit het workflow proces verwijderen?";

$l_workflow["double_name"] = "Workflow naam bestaat al!";

$l_workflow["more_information"] = "Meer informatie";
$l_workflow["less_information"] = "Minder informatie";

$l_workflow["no_wf_defined_object"] = "Er is geen workflow gedefinieerd voor dit object!";
?>