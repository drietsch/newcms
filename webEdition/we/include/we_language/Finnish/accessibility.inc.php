<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Dokumentin validointi internetin v�lityksell�';

//  variables for checking html files.
$l_validation['description'] = 'Voit valita palvelun verkosta tarkistaaksesi dokumentin validiteetin/k�ytett�vyyden.';
$l_validation['available_services'] = 'Olemassaolevat palvelut';
$l_validation['category'] = 'Kategoria';
$l_validation['service_name'] = 'Palvelun nimi';
$l_validation['service'] = 'Palvelu';
$l_validation['host'] = 'Palvelin';
$l_validation['path'] = 'Polku';
$l_validation['ctype'] = 'Sis�ll�n tyyppi';
$l_validation['desc']['ctype'] = 'L�hetett�v�n tiedoston tyypin tarkistuksen toiminto kohdepalvelimelle (text/html oder text/css)';
$l_validation['fileEndings'] = 'Tiedoston p��tteet';
$l_validation['desc']['fileEndings'] = 'Sy�t� kaikki p��tteet jotka on k�ytett�viss� t�lle palvelulle. (.html,.css)';
$l_validation['method'] = 'Siirtotapa';
$l_validation['checkvia']  = 'L�het� k�ytt�en';
$l_validation['checkvia_upload'] = 'Tiedoston latausta';
$l_validation['checkvia_url'] = 'URL -siirtoa';
$l_validation['varname'] = 'Muuttujan nimi';
$l_validation['desc']['varname']  = 'Sy�t� tiedoston/url -kent�n nimi';
$l_validation['additionalVars'] = 'Lis�parametrit';
$l_validation['desc']['additionalVars']  = 'valinneinen: var1=wert1&var2=wert2&...';
$l_validation['result']  = 'Tulos';
$l_validation['active'] = 'Aktiivinen';
$l_validation['desc']['active']  = 'Piilota palvelu v�liaikaisesti.';
$l_validation['no_services_available'] = 'Ei palveluita k�ytett�viss� t�lle tiedostotyypille.';

//  the different predefined services
$l_validation['adjust_service'] = 'Muuta validointipalvelua';

$l_validation['art_custom'] = 'R��t�l�idyt palvelut';
$l_validation['art_default'] = 'Esim��ritetyt palvelut';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Linkit';
$l_validation['category_css'] = 'CSS -tyylitiedostot';
$l_validation['category_accessibility'] = 'K�ytett�vyys';


$l_validation['edit_service']['new'] = 'Uusi palvelu';
$l_validation['edit_service']['saved_success'] = 'Palvelu on tallennettu.';
$l_validation['edit_service']['saved_failure'] = 'Palvelua ei voitu tallentaa.';
$l_validation['edit_service']['delete_success'] = 'Palvelu on poistettu.';
$l_validation['edit_service']['delete_failure'] = 'Palvelua ei voitu poistaa.';
$l_validation['edit_service']['servicename_already_exists'] = 'T�m�n niminen palvelu on jo olemassa.';

//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML W3C -validointi tiedostolatauksen kautta';
$l_validation['service_xhtml_url'] = '(X)HTML W3C -validointi URL -siirron kautta';

//  services for css
$l_validation['service_css_upload'] = 'CSS -validointi tiedostolatauksen kautta';
$l_validation['service_css_url'] = 'CSS -validointi URL -siirron kautta';

$l_validation['connection_problems'] = '<strong>Virhe yhteydenmuodostuksessa palveluun<(/trong><br /><br /><br />Huomioi: valinta "url siirto" on k�ytett�viss� vain, jos webEdition j�rjestelm�n p��sy on sallittu internetiin.Siirto ei ole mahdollinen paikallisasennuksessa.<br /><br />Ongelmia voi my�s esiinty� k�ytett�ess� palomuureja tai proxy-palvelimia. Tarkista asetukset t�ss� tapauksessa.<br /><br />HTTP-Response: %s';
?>