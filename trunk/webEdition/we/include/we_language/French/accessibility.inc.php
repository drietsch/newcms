<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Validation online d\'un document.';

//  variables for checking html files.
$l_validation['description'] = 'Vous pouvez vous servir des services de web, pour v�rfifier la validit� et accessibilit� de votre site.';
$l_validation['available_services'] = 'Service inscrit';
$l_validation['category'] = 'Cat�gorie';
$l_validation['service_name'] = 'Nom du Service';
$l_validation['service'] = 'Service'; // TRANSLATE
$l_validation['host'] = 'H�te';
$l_validation['path'] = 'Chemin';
$l_validation['ctype'] = 'Type-de-fichier';
$l_validation['desc']['ctype'] = 'Caract�ristique de reconnaissance pou le serveur cible, pour qu\'il puisse reconna�tre de quel fichier il s\'agit. (text/html ou text/css)';
$l_validation['fileEndings'] = 'Extension-de-fichier';
$l_validation['desc']['fileEndings'] = 'Les extension pour lequelles ce service sera utilis�, peuvent �tre saisi ici. (.html,.css)';
$l_validation['method'] = 'Methode';
$l_validation['checkvia']  = 'Envoyer par';
$l_validation['checkvia_upload'] = 'Datei-Upload';
$l_validation['checkvia_url'] = 'Transmission d\'URL';
$l_validation['varname'] = 'Nom de variable';
$l_validation['desc']['varname']  = '(saisir le nom de la saisie-d\'HTML du fichier / URL)';
$l_validation['additionalVars'] = 'Param�tre suppl�mentaire';
$l_validation['desc']['additionalVars']  = 'optionnel: var1=valeur1&var2=valeur2&...';
$l_validation['result']  = 'R�sultat';
$l_validation['active'] = 'Actif';
$l_validation['desc']['active']  = 'Vous pouvez cacher/d�sactiver ces services.';
$l_validation['no_services_available'] = 'Pour ce type de fichier aucun service a �t� enocre d�fini.';

//  the different predefined services
$l_validation['adjust_service'] = '�diter les service de validation';

$l_validation['art_custom'] = 'Benutzerdefinierte Dienste';
$l_validation['art_default'] = 'Services all�gu�';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Liens';
$l_validation['category_css'] = 'Cascading Style Sheets'; // TRANSLATE
$l_validation['category_accessibility'] = 'Accessibilit�';


$l_validation['edit_service']['new'] = 'Nouveau Service';
$l_validation['edit_service']['saved_success'] = 'Le service a �t� enregistr� avec succ�s.';
$l_validation['edit_service']['saved_failure'] = 'Le service n\'a pas pu �tre enregistr�.';
$l_validation['edit_service']['delete_success'] = 'Le service a �t� enregistr� avec succ�s.';
$l_validation['edit_service']['delete_failure'] = 'Le service n\'a pas pu �tre supprim�.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = 'Validation d\'(X)HTML du W3C par t�l�chargement de fichier';
$l_validation['service_xhtml_url'] = 'Validation d\'(X)HTML du W3C par transmission d\'URL';

//  services for css
$l_validation['service_css_upload'] = 'Validation CSS par t�l�chargement de fichier';
$l_validation['service_css_url'] = 'Validation CSS par transmission d\'URL';

$l_validation['connection_problems'] = '<strong>Erreur en connectant au service choisi.</strong><br /><br />Considerez: L\'option "Transmission d\'URL" ne peut �tre utilis�, que si votre Installation de webEdition est accessible par l\'internet (alors en dehors de votre reseau local). Ce n\'est pas le cas avec installation local (localhost).<br /><br />Ainsi peuvent se produire des probl�mes avec des serveur-proxy ou des pare-feux. Dans ce cas v�rifiez votre configuration s\'il vous pla�t.<br /><br />R�ponse-HTTP: %s';
?>