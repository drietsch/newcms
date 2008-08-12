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
$l_users["grant_owners_ok"] = "L'utilisateur a été transmis avec succès!";
$l_users["grant_owners_notok"] = "Une erreur s'est produit en transmettant l'utilisateur!";
$l_users["grant_owners"] = "Transmettre l'utilisateur";
$l_users["grant_owners_expl"] = "Transmettez les propriétaires de tous les fichiers et répertoires, qui sont dans le répertoire actuel au propriétaire affiché en haut";
$l_users["make_def_ws"] = "Standard";
$l_users["user_saved_ok"] = "L'utilisateur '%s' a été enregistré avec succès";
$l_users["group_saved_ok"] = "Le groupe '%s' a été enregistré avec succès";
$l_users["alias_saved_ok"] = "Le pseudonym '%s' a été enregistré avec succès";
$l_users["user_saved_nok"] = "L'utilisateur '%s' ne peut pas être enregistré!";
$l_users["nothing_to_save"] = "Rien à enregister!";
$l_users["username_exists"] = "Le nom d'utilisateur '%s' existe déjà!";
$l_users["username_empty"] = "Le nom d'utilisateur n'est pas rempli!";
$l_users["user_deleted"] = "L'utilisateur '%s' a été supprimé avec succès!";
$l_users["nothing_to_delete"] = "Rien à supprimer!";
$l_users["delete_last_user"] = "Pour l'administration au moins un administrateur est nécessaire.\\nVous ne pouvez pas supprimer le dernier administrateur.";
$l_users["modify_last_admin"] = "Pour l'administration au moins un administrateur est nécessaire.\\nVous ne pouvez pas changer les droits du dernier administrateur.";
$l_users["user_path_nok"] = "Le chemin n'est pas correct!";
$l_users["user_data"] = "Donnée de l'utilisateur";
$l_users["first_name"] = "Prénom";
$l_users["second_name"] = "Nom";
$l_users["username"] = "Nom d'Utilisateur";
$l_users["password"] = "Mot de Passe";
$l_users["workspace_specify"] = "Définir un éspace de travail";
$l_users["permissions"] = "Droits";
$l_users["user_permissions"] = "Redacteur";
$l_users["admin_permissions"] = "Administrateur";
$l_users["password_alert"] = "Le mot de passe doit avoir au moins un longeur de 4 chiffres";
$l_users["delete_alert_user"] = "Tous les données du nom d'utilisateur '%s' seront supprimé.\\n Êtes-vous sûr?";
$l_users["delete_alert_alias"] = "Tous les données du pseudonyme '%s' seront supprimé.\\n Êtes-vous sûr?";
$l_users["delete_alert_group"] = "Tous les données de groupe et utilisateurs de groupe, du groupe '%s' seront supprimé.\\n Êtes-vous sûr?";
$l_users["created_by"] = "Créé par";
$l_users["changed_by"] = "Modifié par";
$l_users["no_perms"] = "Vous n'êtes pas authorisé, d'effectuer cette option!";
$l_users["publish_specify"] = "L'utilisateur a le droit de publier";
$l_users["work_permissions"] = "Droits de travail";
$l_users["control_permissions"] = "Droits de contrôle";
$l_users["log_permissions"] = "Droits pour le journal";
$l_users["file_locked"][FILE_TABLE] = "Le fichier '%s' est édité par '%s' en ce moment!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Le modèle '%s' est édité par '%s' en ce moment!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "La classe '%s' est édité par '%s' en ce moment!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "L'object '%s' st édité par '%s' en ce moment!";
}
$l_users["acces_temp_denied"] = "L'accès n'est pas possible en ce moment";
$l_users["description"] = "Déscription";
$l_users["group_data"] = "Données de Groupe";
$l_users["group_name"] = "Nom du Groupe";
$l_users["group_member"] = "Affiliation au groupe";
$l_users["group"] = "Groupe";
$l_users["address"] = "Adresse";
$l_users["houseno"] = "Numéro";
$l_users["state"] = "Land";
$l_users["PLZ"] = "Code postal";
$l_users["city"] = "Ville";
$l_users["country"] = "Pays";
$l_users["tel_pre"] = "Prefix du téléphone";
$l_users["fax_pre"] = "Prefix du Fax";
$l_users["telephone"] = "Téléphone";
$l_users["fax"] = "Fax"; // TRANSLATE
$l_users["mobile"] = "Portable";
$l_users["email"] = "E-Mail"; // TRANSLATE
$l_users["general_data"] = "Données générales";
$l_users["workspace_documents"] = "Éspace de travail pour les documents";
$l_users["workspace_templates"] = "Éspace de travail pour les modèles";
$l_users["workspace_objects"] = "Workspace Objects"; // TRANSLATE
$l_users["save_changed_user"] = "L'utilisateur a été modifié.\\nVoulez-vous enregistrer les modifications?";
$l_users["not_able_to_save"] = " Les données n'ont pas été enregistrées, parce qu'elles sont invalides!";
$l_users["cannot_save_used"] = " L'État ne peut pas être changé, parce que l'utilisateur est utilisér en ce moment!";
$l_users["geaendert_von"] = "Modifié  par";
$l_users["geaendert_am"] = "Modifié  le";
$l_users["angelegt_am"] = "Créé  le";
$l_users["angelegt_von"] = "Créé  par";
$l_users["status"] = "État";
$l_users["value"] = " Valeur ";
$l_users["gesperrt"] = "bloqué";
$l_users["freigegeben"] = "débloqué";
$l_users["gelöscht"] = "supprimé";
$l_users["ohne"] = "Sans";
$l_users["user"] = "Utilisateur";
$l_users["usertyp"] = "Type d'utilisateur";
$l_users["search"] = "Suche"; // TRANSLATE
$l_users["search_result"] = "Ergebnis"; // TRANSLATE
$l_users["search_for"] = "Suche nach"; // TRANSLATE
$l_users["inherit"] = "Adopter les droits du goupe parental";
$l_users["inherit_ws"] = "Adopter l'éspace de travail du goupe parental";
$l_users["inherit_wst"] = "Adopter l'éspace de travail des modèles du goupe parentale";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organisation";
$l_users["give_org_name"] = "Le nom de l'Organisation";
$l_users["can_not_create_org"] = "L'Organisation ne peut pas être créé";
$l_users["org_name_empty"] = "Le nom de l'Organisation est vide";
$l_users["salutation"] = "Titre";
$l_users["sucheleer"] = "Il manque un termes de recherche.";
$l_users["alias_data"] = "Donnée du pseudonyme";
$l_users["rights_and_workspaces"] = "Droit et<br>éspaces de travail";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspace_newsletter"] = "Workspace Newsletter"; // TRANSLATE
$l_users["inherit_wsnl"] = "Inherit newsletter workspaces from parent group"; // TRANSLATE

$l_users["delete_user_same"] = "Sie können nicht Ihr eigenes Konto löschen."; // TRANSLATE
$l_users["delete_group_user_same"] = "Sie können nicht Ihre eigene Gruppe löschen."; // TRANSLATE

$l_users["login_denied"] = "Login denied"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!"; // TRANSLATE
$l_users["noGroupError"] = "Error: Invalid entry in field group!"; // TRANSLATE

?>