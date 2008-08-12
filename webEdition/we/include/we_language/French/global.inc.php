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
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "New Link"; // TRANSLATE // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "Chargement des donn�es en cours!<br>Cela peut n�cessiter du temps si le menu a beaucoup d'entr�es ...";
$GLOBALS["l_global"]["text"] = "Texte";
$GLOBALS["l_global"]["yes"] = "oui";
$GLOBALS["l_global"]["no"] = "non";
$GLOBALS["l_global"]["checked"] = "Active";
$GLOBALS["l_global"]["max_file_size"] = "Taille de fichier max. (en Octet)";
$GLOBALS["l_global"]["default"] = "Pr�r�glage";
$GLOBALS["l_global"]["values"] = "Valeurs";
$GLOBALS["l_global"]["name"] = "Nom";
$GLOBALS["l_global"]["type"] = "Type"; // TRANSLATE
$GLOBALS["l_global"]["attributes"] = "Attributs";
$GLOBALS["l_global"]["formmailerror"] = "Le formulaire n'a pas �t� transmis pour la raison suivant:";
$GLOBALS["l_global"]["email_notallfields"] = "Vous n'avez pas rempli tous les champs!";
$GLOBALS["l_global"]["email_ban"] = "Vous n'�tes pas autoris� de utiliser ce script!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "L'adresse destinataire est invalide!";
$GLOBALS["l_global"]["email_no_recipient"] = "L'adresse destinataire n'existe pas!";
$GLOBALS["l_global"]["email_invalid"] = "Votre <b>Adresse E-Mail</b> n'est pas valide!";
$GLOBALS["l_global"]["captcha_invalid"] = "The entered security code is wrong!"; // TRANSLATE
$GLOBALS["l_global"]["question"] = "Question"; // TRANSLATE
$GLOBALS["l_global"]["warning"] = "Avertissement";
$GLOBALS["l_global"]["we_alert"] = "Cette fonction n'est pas disponible dans la Version D�mo de webEdition!";
$GLOBALS["l_global"]["index_table"] = "Tableau Index";
$GLOBALS["l_global"]["cannotconnect"] = "Il n'�tait pas possible de connecter au serveur de webEdition!";
$GLOBALS["l_global"]["recipients"] = "Destinataire-Formmail";
$GLOBALS["l_global"]["recipients_txt"] = "Ins�rer ici tous les adresses e-mail, aux quelles des formulaires avec la fonction-formmail  (&lt;we:form type=\"formmail\" ..&gt;) sont �tre envoy�s.<br><br>Si aucun d'adresse e-mail est saisie ici, il n'est pas possible d'envoyer des formulaires avec la fonction-Formmail!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Un nouveau object %s a �t� cr�� dans la classe %s!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Nouveau Object";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Nouveau Document";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Un nouveau Object %s a �t� cr��!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Object supprim�";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "L'object %s a �t� supprim�!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Document supprim�";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "Le document %s a �t� supprim�!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "Apr�s l'enregistrement nouveau Site";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "Aucune Entr�e!";
$GLOBALS["l_global"]["save_temporaryTable"] = "R�crire les documents de travail temporaires";
$GLOBALS["l_global"]["save_mainTable"] = "R�crire le tableau principal de la base de donn�e";
$GLOBALS["l_global"]["add_workspace"] = "Ajouter un �space de travail";
$GLOBALS["l_global"]["folder_not_editable"] = "Ce r�pertoire ne doit pas �tre choisi!";
$GLOBALS["l_global"]["modules"] = "Modules"; // TRANSLATE
$GLOBALS["l_global"]["modules_and_tools"] = "Modules and Tools"; // TRANSLATE
$GLOBALS["l_global"]["center"] = "Centrer";
$GLOBALS["l_global"]["jswin"] = "Fen�tre Popup";
$GLOBALS["l_global"]["open"] = "Ouvrir";
$GLOBALS["l_global"]["posx"] = "Position x";
$GLOBALS["l_global"]["posy"] = "Position y";
$GLOBALS["l_global"]["status"] = "�tat";
$GLOBALS["l_global"]["scrollbars"] = "Barres de d�filement";
$GLOBALS["l_global"]["menubar"] = "Barre de menue";
$GLOBALS["l_global"]["toolbar"] = "Toolbar"; // TRANSLATE
$GLOBALS["l_global"]["resizable"] = "Taille modifiable";
$GLOBALS["l_global"]["location"] = "Lieu";
$GLOBALS["l_global"]["title"] = "Titre";
$GLOBALS["l_global"]["description"] = "D�scription";
$GLOBALS["l_global"]["required_field"] = "Champ obligatoire";
$GLOBALS["l_global"]["from"] = "de";
$GLOBALS["l_global"]["to"] = "�";
$GLOBALS["l_global"]["search"]="Search"; // TRANSLATE
$GLOBALS["l_global"]["in"]="in"; // TRANSLATE
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Rebuild automatique";
$GLOBALS["l_global"]["we_publish_at_save"] = "Publier en enregistrant";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "New Document after saving"; // TRANSLATE
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving"; // TRANSLATE
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving"; // TRANSLATE
$GLOBALS["l_global"]["wrapcheck"] = "Passage � ligne";
$GLOBALS["l_global"]["static_docs"] = "Documents statiques";
$GLOBALS["l_global"]["save_templates_before"] = "Enregistrer les mod�les avant";
$GLOBALS["l_global"]["specify_docs"] = "Documents avec les crit�res suivant";
$GLOBALS["l_global"]["object_docs"] = "Tous les Objects";
$GLOBALS["l_global"]["all_docs"] = "Tous les Documents";
$GLOBALS["l_global"]["ask_for_editor"] = "dabord demander quel editeur doit �tre utilis�";
$GLOBALS["l_global"]["cockpit"] = "Cockpit"; // TRANSLATE
$GLOBALS["l_global"]["introduction"] = "Introduction"; // TRANSLATE
$GLOBALS["l_global"]["doctypes"] = "Type-de-Documents";
$GLOBALS["l_global"]["content"] = "Contenu";
$GLOBALS["l_global"]["site_not_exist"] = "Ce site n'existe pas!";
$GLOBALS["l_global"]["site_not_published"] = "Ce site ne pas encore publi�!";
$GLOBALS["l_global"]["required"] = "Entr�e n�c�ssaire";
$GLOBALS["l_global"]["all_rights_reserved"] = "Tous droits r�serv�s";
$GLOBALS["l_global"]["width"] = "Largeur";
$GLOBALS["l_global"]["height"] = "Hauteur";
$GLOBALS["l_global"]["new_username"] = "Nouveau nom d'utilisateur";
$GLOBALS["l_global"]["username"] = "Nom d'Utilisateur";
$GLOBALS["l_global"]["password"] = "Mot de Passe";
$GLOBALS["l_global"]["documents"] = "Documents"; // TRANSLATE
$GLOBALS["l_global"]["templates"] = "Mod�les";
$GLOBALS["l_global"]["objects"] = "Objects"; // TRANSLATE
$GLOBALS["l_global"]["licensed_to"] = "Licenci�";
$GLOBALS["l_global"]["left"] = "gauche";
$GLOBALS["l_global"]["right"] = "droite";
$GLOBALS["l_global"]["top"] = "en haut";
$GLOBALS["l_global"]["bottom"] = "en bas";
$GLOBALS["l_global"]["topleft"] = "en haut � gauche";
$GLOBALS["l_global"]["topright"] = "en haut � droite";
$GLOBALS["l_global"]["bottomleft"] = "en bas � gauche";
$GLOBALS["l_global"]["bottomright"] = "en bas � droite";
$GLOBALS["l_global"]["true"] = "oui";
$GLOBALS["l_global"]["false"] = "non";
$GLOBALS["l_global"]["showall"] = "afficher tous";
$GLOBALS["l_global"]["noborder"] = "sans bordure";
$GLOBALS["l_global"]["border"] = "bordure";
$GLOBALS["l_global"]["align"] = "alignement";
$GLOBALS["l_global"]["hspace"] = "distance horiz.";
$GLOBALS["l_global"]["vspace"] = "distance vert.";
$GLOBALS["l_global"]["exactfit"] = "exactfit";
$GLOBALS["l_global"]["select_color"] = "Choisir une couleur";
$GLOBALS["l_global"]["changeUsername"] = "Changer le nom d'utilisateur";
$GLOBALS["l_global"]["changePass"] = "Changer le mot de passe";
$GLOBALS["l_global"]["oldPass"] = "Ancien mot de passe";
$GLOBALS["l_global"]["newPass"] = "Nouveau mot de passe";
$GLOBALS["l_global"]["newPass2"] = "Nouveau mot de passe r�p�tition";
$GLOBALS["l_global"]["pass_not_confirmed"] = "La r�p�tition du nouveau mot de passe ne correspond pas au nouveau mot de passe!";
$GLOBALS["l_global"]["pass_not_match"] = "L'ancien mot de passe n'est pas correcte!";
$GLOBALS["l_global"]["passwd_not_match"] = "Le mot de passe n'est pas correcte!";
$GLOBALS["l_global"]["pass_to_short"] = "Le mot de passe doit au moins avoir une longeur de 4 chiffres!";
$GLOBALS["l_global"]["pass_changed"] = "Le mot de passe a �t� chang� avec succ�s!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Le mot de passe doit seulement contenir des lettres (a-z et A-Z) et des chiffres (0 � 9)";
$GLOBALS["l_global"]["username_wrong_chars"] = "Username may only contain alpha-numeric characters (a-z, A-Z and 0-9) and '.', '_' or '-'!"; // TRANSLATE
$GLOBALS["l_global"]["all"] = "Tous";
$GLOBALS["l_global"]["selected"] = "Choisi";
$GLOBALS["l_global"]["username_to_short"] = "Le nom d'utilisateur doit au moins avoir une longeur de 4 chiffres!";
$GLOBALS["l_global"]["username_changed"] = "Le nom d'utilisateur � �t� chang� avec succ�s!";
$GLOBALS["l_global"]["published"] = "Publi�";
$GLOBALS["l_global"]["help_welcome"] = "Bienvenue dans le system d'aide de webEdition";
$GLOBALS["l_global"]["edit_file"] = "�diter le fichier";
$GLOBALS["l_global"]["docs_saved"] = "Documents enregistr�s avec succ�s!";
$GLOBALS["l_global"]["preview"] = "Pr�vision";
$GLOBALS["l_global"]["close"] = "Fermer la fen�tre";
$GLOBALS["l_global"]["loginok"] =  "<strong>Autentifacation ok!</strong><br>webEdition devrait s'ouvrir dans une nouvelle fen�tre.<br>Si ce n'est pas le cas, vous avez probablement bloquez les popups dans votre navigateur!";
$GLOBALS["l_global"]["apple"] = "&#x2318;"; // TRANSLATE
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "CTRL"; // TRANSLATE
$GLOBALS["l_global"]["required_fields"] = "Champs obligatoires";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">Aucun document � �t� t�l�charg�.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Ouvrir/Fermer";
$GLOBALS["l_global"]["rebuild"] = "Rebuild"; // TRANSLATE
$GLOBALS["l_global"]["welcome_to_we"] = "Bienvenue chez webEdition 3";
$GLOBALS["l_global"]["tofit"] = "Bienvenue chez webEdition 3";
$GLOBALS["l_global"]["unlocking_document"] = "d�bloque le Document";
$GLOBALS["l_global"]["variant_field"] = "Champs de variantes";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Please press the following link, if you are not redirected within the next 30 seconds "; // TRANSLATE
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition login"; // TRANSLATE
$GLOBALS["l_global"]["untitled"] = "Untitled"; // TRANSLATE
$GLOBALS["l_global"]["no_document_opened"] = "There is no document opened!"; // TRANSLATE
?>