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


$l_validation['headline'] = 'Dokumentin validointi internetin välityksellä';

//  variables for checking html files.
$l_validation['description'] = 'Voit valita palvelun verkosta tarkistaaksesi dokumentin validiteetin/käytettävyyden.';
$l_validation['available_services'] = 'Olemassaolevat palvelut';
$l_validation['category'] = 'Kategoria';
$l_validation['service_name'] = 'Palvelun nimi';
$l_validation['service'] = 'Palvelu';
$l_validation['host'] = 'Palvelin';
$l_validation['path'] = 'Polku';
$l_validation['ctype'] = 'Sisällön tyyppi';
$l_validation['desc']['ctype'] = 'Lähetettävän tiedoston tyypin tarkistuksen toiminto kohdepalvelimelle (text/html oder text/css)';
$l_validation['fileEndings'] = 'Tiedoston päätteet';
$l_validation['desc']['fileEndings'] = 'Syötä kaikki päätteet jotka on käytettävissä tälle palvelulle. (.html,.css)';
$l_validation['method'] = 'Siirtotapa';
$l_validation['checkvia']  = 'Lähetä käyttäen';
$l_validation['checkvia_upload'] = 'Tiedoston latausta';
$l_validation['checkvia_url'] = 'URL -siirtoa';
$l_validation['varname'] = 'Muuttujan nimi';
$l_validation['desc']['varname']  = 'Syötä tiedoston/url -kentän nimi';
$l_validation['additionalVars'] = 'Lisäparametrit';
$l_validation['desc']['additionalVars']  = 'valinneinen: var1=wert1&var2=wert2&...';
$l_validation['result']  = 'Tulos';
$l_validation['active'] = 'Aktiivinen';
$l_validation['desc']['active']  = 'Piilota palvelu väliaikaisesti.';
$l_validation['no_services_available'] = 'Ei palveluita käytettävissä tälle tiedostotyypille.';

//  the different predefined services
$l_validation['adjust_service'] = 'Muuta validointipalvelua';

$l_validation['art_custom'] = 'Räätälöidyt palvelut';
$l_validation['art_default'] = 'Esimääritetyt palvelut';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Linkit';
$l_validation['category_css'] = 'CSS -tyylitiedostot';
$l_validation['category_accessibility'] = 'Käytettävyys';


$l_validation['edit_service']['new'] = 'Uusi palvelu';
$l_validation['edit_service']['saved_success'] = 'Palvelu on tallennettu.';
$l_validation['edit_service']['saved_failure'] = 'Palvelua ei voitu tallentaa.';
$l_validation['edit_service']['delete_success'] = 'Palvelu on poistettu.';
$l_validation['edit_service']['delete_failure'] = 'Palvelua ei voitu poistaa.';
$l_validation['edit_service']['servicename_already_exists'] = 'Tämän niminen palvelu on jo olemassa.';

//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML W3C -validointi tiedostolatauksen kautta';
$l_validation['service_xhtml_url'] = '(X)HTML W3C -validointi URL -siirron kautta';

//  services for css
$l_validation['service_css_upload'] = 'CSS -validointi tiedostolatauksen kautta';
$l_validation['service_css_url'] = 'CSS -validointi URL -siirron kautta';

$l_validation['connection_problems'] = '<strong>Virhe yhteydenmuodostuksessa palveluun<(/trong><br /><br /><br />Huomioi: valinta "url siirto" on käytettävissä vain, jos webEdition järjestelmän pääsy on sallittu internetiin.Siirto ei ole mahdollinen paikallisasennuksessa.<br /><br />Ongelmia voi myös esiintyä käytettäessä palomuureja tai proxy-palvelimia. Tarkista asetukset tässä tapauksessa.<br /><br />HTTP-Response: %s';
?>