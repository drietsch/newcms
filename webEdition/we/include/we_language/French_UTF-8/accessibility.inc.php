<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


$l_validation['headline'] = 'Validation online d\'un document.';

//  variables for checking html files.
$l_validation['description'] = 'Vous pouvez vous servir des services de web, pour vérfifier la validité et accessibilité de votre site.';
$l_validation['available_services'] = 'Service inscrit';
$l_validation['category'] = 'Catégorie';
$l_validation['service_name'] = 'Nom du Service';
$l_validation['service'] = 'Service'; // TRANSLATE
$l_validation['host'] = 'Hôte';
$l_validation['path'] = 'Chemin';
$l_validation['ctype'] = 'Type-de-fichier';
$l_validation['desc']['ctype'] = 'Caractéristique de reconnaissance pou le serveur cible, pour qu\'il puisse reconnaître de quel fichier il s\'agit. (text/html ou text/css)';
$l_validation['fileEndings'] = 'Extension-de-fichier';
$l_validation['desc']['fileEndings'] = 'Les extension pour lequelles ce service sera utilisé, peuvent être saisi ici. (.html,.css)';
$l_validation['method'] = 'Methode';
$l_validation['checkvia']  = 'Envoyer par';
$l_validation['checkvia_upload'] = 'Datei-Upload';
$l_validation['checkvia_url'] = 'Transmission d\'URL';
$l_validation['varname'] = 'Nom de variable';
$l_validation['desc']['varname']  = '(saisir le nom de la saisie-d\'HTML du fichier / URL)';
$l_validation['additionalVars'] = 'Paramètre supplémentaire';
$l_validation['desc']['additionalVars']  = 'optionnel: var1=valeur1&var2=valeur2&...';
$l_validation['result']  = 'Résultat';
$l_validation['active'] = 'Actif';
$l_validation['desc']['active']  = 'Vous pouvez cacher/désactiver ces services.';
$l_validation['no_services_available'] = 'Pour ce type de fichier aucun service a été enocre défini.';

//  the different predefined services
$l_validation['adjust_service'] = 'Éditer les service de validation';

$l_validation['art_custom'] = 'Benutzerdefinierte Dienste';
$l_validation['art_default'] = 'Services allégué';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Liens';
$l_validation['category_css'] = 'Cascading Style Sheets'; // TRANSLATE
$l_validation['category_accessibility'] = 'Accessibilité';


$l_validation['edit_service']['new'] = 'Nouveau Service';
$l_validation['edit_service']['saved_success'] = 'Le service a été enregistré avec succès.';
$l_validation['edit_service']['saved_failure'] = 'Le service n\'a pas pu être enregistré.';
$l_validation['edit_service']['delete_success'] = 'Le service a été enregistré avec succès.';
$l_validation['edit_service']['delete_failure'] = 'Le service n\'a pas pu être supprimé.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = 'Validation d\'(X)HTML du W3C par téléchargement de fichier';
$l_validation['service_xhtml_url'] = 'Validation d\'(X)HTML du W3C par transmission d\'URL';

//  services for css
$l_validation['service_css_upload'] = 'Validation CSS par téléchargement de fichier';
$l_validation['service_css_url'] = 'Validation CSS par transmission d\'URL';

$l_validation['connection_problems'] = '<strong>Erreur en connectant au service choisi.</strong><br /><br />Considerez: L\'option "Transmission d\'URL" ne peut être utilisé, que si votre Installation de webEdition est accessible par l\'internet (alors en dehors de votre reseau local). Ce n\'est pas le cas avec installation local (localhost).<br /><br />Ainsi peuvent se produire des problèmes avec des serveur-proxy ou des pare-feux. Dans ce cas vérifiez votre configuration s\'il vous plaît.<br /><br />Réponse-HTTP: %s';
?>