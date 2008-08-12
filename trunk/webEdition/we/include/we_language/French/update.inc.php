<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: update.inc.php,v 1.9 2007/05/23 15:39:35 holger.meyer Exp $

/**
 * Language file: update.inc.php
 * Provides language strings.
 * Language: French
 */
$l_update["title"] = "Mise à Jour de webEdition";
$l_navi["update"] = "Mise à Jour";
$l_navi["modul"] = "Installation de Module";
$l_navi["log"] = "Journal";
$l_navi["language"] = "Langues";
$l_update["check"]["headline"] = "Rechercher une nouvelle Version";
$l_update["check"]["actualVersion"] = "Version Installé:";
$l_update["check"]["lastUpdate"] = "Dernière Installation:";
$l_update["check"]["lookForUpdate"] = "Rechercher une nouvelle Version.";
$l_update["check"]["neverUpdated"] = "-";
$l_update["log"]["title"] = "Journal d'Installation";
$l_update["log"]["date"] = "Date / heure";
$l_update["log"]["aktion"] = "Action";
$l_update["log"]["version"] = "Version";
$l_update["log"]["empty_log"] = "Le Journal d'Installation est vide";
$l_update["log"]["entries_total"] = "Entrées en tout :";
$l_update["log"]["entries_page"] = "Page";
$l_update["log"]["confirm_delete"] = "Si vous précéder tous les %s seront supprimé?";
$l_update["log"]["legend"]["title"] = "Afficher:";
$l_update["log"]["legend"]["messages"] = "Messages";
$l_update["log"]["legend"]["notices"] = "Renseignement";
$l_update["log"]["legend"]["errors"] = "Erreur";
$l_update["connection_error"]["headline"] = "Une mise à jour n'est pas possible en ce moment.";
$l_update["connection_error"]["text"] = "Il ne pas possible de joindre le webEdition-Server (www.webedition.de). Essayer le de nouveau à une date ultérieure.<br><br>Si vous êtes branché par un Server-Proxy, controllez les préférences s'il vous plaît.";
$l_update["connection_error"]["js_alert"] = "Il n'etait pas possible de joindre le webEdition-Server.\\nAppuyer sur le bouton mettre à jour, pour répéter l'actuel processus,\\nou essayer le de nouveau à une date ultérieure.";
$l_update["language"]["headline"] = "Installation des langues";
$l_update["language"]["description"] = "Dès la Version 3.0 de webEdition il es possible d'installer des langues supplémentaire. Dépendant de la Version de differentes langues sont disponibles. Des Mises à Jour sont seulement possible a faire s'ils sont disponibles dans tous les langues installées. Pour cette raison installer seulement les langues, que vous nécessitez vraiment.<br><br>Actuellement vous utiliser la Version webEdition %s.";
$l_update["language"]["sysLng"] = "Langue de System";
$l_update["language"]["usedLng"] = "Langue utilisée";
$l_update["language"]["installed_lngs"] = "Langues installées";
$l_update["language"]["search"] = "Recherche de Langue";
$l_update["language"]["delete"] = "Supprimer les langues marquées";
$l_update["language"]["confirm_delete"] = "Si vous contiunuer les langues chossi seront supprimer de votre webEdition. Des utilisateur qui avaintla langue comme langue standard seront remit sur la langue de system %s.";
$l_update["language"]["delete_error_file"] = "Erreur en supprimant les fichiers de langue.\\nUn fichier n'a pas pu être supprimé:\\n";
$l_update["language"]["delete_error_folder"] = "Erreur en supprimant les fichiers de langue.\\nUn répertoire n'a pas pu être supprimé:\\n";
?>