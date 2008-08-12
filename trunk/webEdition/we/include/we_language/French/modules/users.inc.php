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
 * Language file: users.inc.php
 * Provides language strings.
 * Language: English
 */
$l_users["user_same"] = "The owner cannot be deleted!"; // TRANSLATE
$l_users["grant_owners_ok"] = "L'utilisateur a �t� transmis avec succ�s!";
$l_users["grant_owners_notok"] = "Une erreur s'est produit en transmettant l'utilisateur!";
$l_users["grant_owners"] = "Transmettre l'utilisateur";
$l_users["grant_owners_expl"] = "Transmettez les propri�taires de tous les fichiers et r�pertoires, qui sont dans le r�pertoire actuel au propri�taire affich� en haut";
$l_users["make_def_ws"] = "Standard";
$l_users["user_saved_ok"] = "L'utilisateur '%s' a �t� enregistr� avec succ�s";
$l_users["group_saved_ok"] = "Le groupe '%s' a �t� enregistr� avec succ�s";
$l_users["alias_saved_ok"] = "Le pseudonym '%s' a �t� enregistr� avec succ�s";
$l_users["user_saved_nok"] = "L'utilisateur '%s' ne peut pas �tre enregistr�!";
$l_users["nothing_to_save"] = "Rien � enregister!";
$l_users["username_exists"] = "Le nom d'utilisateur '%s' existe d�j�!";
$l_users["username_empty"] = "Le nom d'utilisateur n'est pas rempli!";
$l_users["user_deleted"] = "L'utilisateur '%s' a �t� supprim� avec succ�s!";
$l_users["nothing_to_delete"] = "Rien � supprimer!";
$l_users["delete_last_user"] = "Pour l'administration au moins un administrateur est n�cessaire.\\nVous ne pouvez pas supprimer le dernier administrateur.";
$l_users["modify_last_admin"] = "Pour l'administration au moins un administrateur est n�cessaire.\\nVous ne pouvez pas changer les droits du dernier administrateur.";
$l_users["user_path_nok"] = "Le chemin n'est pas correct!";
$l_users["user_data"] = "Donn�e de l'utilisateur";
$l_users["first_name"] = "Pr�nom";
$l_users["second_name"] = "Nom";
$l_users["username"] = "Nom d'Utilisateur";
$l_users["password"] = "Mot de Passe";
$l_users["workspace_specify"] = "D�finir un �space de travail";
$l_users["permissions"] = "Droits";
$l_users["user_permissions"] = "Redacteur";
$l_users["admin_permissions"] = "Administrateur";
$l_users["password_alert"] = "Le mot de passe doit avoir au moins un longeur de 4 chiffres";
$l_users["delete_alert_user"] = "Tous les donn�es du nom d'utilisateur '%s' seront supprim�.\\n �tes-vous s�r?";
$l_users["delete_alert_alias"] = "Tous les donn�es du pseudonyme '%s' seront supprim�.\\n �tes-vous s�r?";
$l_users["delete_alert_group"] = "Tous les donn�es de groupe et utilisateurs de groupe, du groupe '%s' seront supprim�.\\n �tes-vous s�r?";
$l_users["created_by"] = "Cr�� par";
$l_users["changed_by"] = "Modifi� par";
$l_users["no_perms"] = "Vous n'�tes pas authoris�, d'effectuer cette option!";
$l_users["publish_specify"] = "L'utilisateur a le droit de publier";
$l_users["work_permissions"] = "Droits de travail";
$l_users["control_permissions"] = "Droits de contr�le";
$l_users["log_permissions"] = "Droits pour le journal";
$l_users["file_locked"][FILE_TABLE] = "Le fichier '%s' est �dit� par '%s' en ce moment!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Le mod�le '%s' est �dit� par '%s' en ce moment!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "La classe '%s' est �dit� par '%s' en ce moment!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "L'object '%s' st �dit� par '%s' en ce moment!";
}
$l_users["acces_temp_denied"] = "L'acc�s n'est pas possible en ce moment";
$l_users["description"] = "D�scription";
$l_users["group_data"] = "Donn�es de Groupe";
$l_users["group_name"] = "Nom du Groupe";
$l_users["group_member"] = "Affiliation au groupe";
$l_users["group"] = "Groupe";
$l_users["address"] = "Adresse";
$l_users["houseno"] = "Num�ro";
$l_users["state"] = "Land";
$l_users["PLZ"] = "Code postal";
$l_users["city"] = "Ville";
$l_users["country"] = "Pays";
$l_users["tel_pre"] = "Prefix du t�l�phone";
$l_users["fax_pre"] = "Prefix du Fax";
$l_users["telephone"] = "T�l�phone";
$l_users["fax"] = "Fax"; // TRANSLATE
$l_users["mobile"] = "Portable";
$l_users["email"] = "E-Mail"; // TRANSLATE
$l_users["general_data"] = "Donn�es g�n�rales";
$l_users["workspace_documents"] = "�space de travail pour les documents";
$l_users["workspace_templates"] = "�space de travail pour les mod�les";
$l_users["workspace_objects"] = "Workspace Objects"; // TRANSLATE
$l_users["save_changed_user"] = "L'utilisateur a �t� modifi�.\\nVoulez-vous enregistrer les modifications?";
$l_users["not_able_to_save"] = " Les donn�es n'ont pas �t� enregistr�es, parce qu'elles sont invalides!";
$l_users["cannot_save_used"] = " L'�tat ne peut pas �tre chang�, parce que l'utilisateur est utilis�r en ce moment!";
$l_users["geaendert_von"] = "Modifi�  par";
$l_users["geaendert_am"] = "Modifi�  le";
$l_users["angelegt_am"] = "Cr��  le";
$l_users["angelegt_von"] = "Cr��  par";
$l_users["status"] = "�tat";
$l_users["value"] = " Valeur ";
$l_users["gesperrt"] = "bloqu�";
$l_users["freigegeben"] = "d�bloqu�";
$l_users["gel�scht"] = "supprim�";
$l_users["ohne"] = "Sans";
$l_users["user"] = "Utilisateur";
$l_users["usertyp"] = "Type d'utilisateur";
$l_users["search"] = "Suche"; // TRANSLATE
$l_users["search_result"] = "Ergebnis"; // TRANSLATE
$l_users["search_for"] = "Suche nach"; // TRANSLATE
$l_users["inherit"] = "Adopter les droits du goupe parental";
$l_users["inherit_ws"] = "Adopter l'�space de travail du goupe parental";
$l_users["inherit_wst"] = "Adopter l'�space de travail des mod�les du goupe parentale";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organisation";
$l_users["give_org_name"] = "Le nom de l'Organisation";
$l_users["can_not_create_org"] = "L'Organisation ne peut pas �tre cr��";
$l_users["org_name_empty"] = "Le nom de l'Organisation est vide";
$l_users["salutation"] = "Titre";
$l_users["sucheleer"] = "Il manque un termes de recherche.";
$l_users["alias_data"] = "Donn�e du pseudonyme";
$l_users["rights_and_workspaces"] = "Droit et<br>�spaces de travail";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspace_newsletter"] = "Workspace Newsletter"; // TRANSLATE
$l_users["inherit_wsnl"] = "Inherit newsletter workspaces from parent group"; // TRANSLATE

$l_users["delete_user_same"] = "Sie k�nnen nicht Ihr eigenes Konto l�schen."; // TRANSLATE
$l_users["delete_group_user_same"] = "Sie k�nnen nicht Ihre eigene Gruppe l�schen."; // TRANSLATE

$l_users["login_denied"] = "Login denied"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!"; // TRANSLATE
$l_users["noGroupError"] = "Error: Invalid entry in field group!"; // TRANSLATE

?>