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
 * Language file: SEEM.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_SEEM["ext_doc_selected"] = "Olet valinnut linkin, joka osoittaa dokumenttiin joka ei ole webEdition -j�rjestelm�ss�. Jatketaanko?";
$l_we_SEEM["ext_document_on_other_server_selected"] = "Olet valinnut linkin joka osoittaa dokumenttiin toisella palvelimella.\\nLinkki avautuu toiseen ikkunaan. Jatketaanko?";
$l_we_SEEM["ext_form_target_other_server"] = "Olet aikeissa l�hett�� lomakkeen toiselle palvelimelle.\\n Lomake avautuu uuteen ikkunaan. Jatketaanko? ";
$l_we_SEEM["ext_form_target_we_server"] = "Lomakek�sittelij� l�hett�� tietoa dokumentille, joka ei ole webEdition -dokumentti.\\nJatketaanko?";

$l_we_SEEM["ext_doc"] = "Kyseinen dokumentti: <b>%s</b> <u>ei ole</u> muokattavissa webEdition -j�rjestelm�st�.";
$l_we_SEEM["ext_doc_not_found"] = "Sivua <b>%s</b> ei l�ytynyt.";
$l_we_SEEM["ext_doc_tmp"] = "webEdition ei avannut dokumenttia oikein. K�yt� sivuston normaalinavigointia p��st�ksesi dokumenttiin.";

$l_we_SEEM["info_ext_doc"] = "Ei webEdition -linkki";
$l_we_SEEM["info_doc_with_parameter"] = "Parametrillinen linkki";
$l_we_SEEM["link_does_not_work"] = "T�m� linkki ei ole aktivoitu esikatselutilassa. K�yt� navigointia siirty�ksesi sivulle.";
$l_we_SEEM["info_link_does_not_work"] = "Ei aktivoitu.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "Olet aikeissa muuttaa webEdition -ikkunan sis�lt��. Ikkuna suljetaan. Jatketaanko?";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Tila";
$l_we_SEEM["start_mode_normal"] = "Normaali";
$l_we_SEEM["start_mode_seem"] = "Helppok�ytt�tila";

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Aloitussivua ei ole m��ritetty.\nJ�rjestelm�nvalvoja asettaa aloitussivusi.";
$l_we_SEEM["only_seem_mode_allowed"] = "Sinulla ei ole tarvittavia oikeuksia kirjautua webEdition -j�rjestelm��n normaalitilassa.\\nKirjaudutaan helppok�ytt�tilaan ...";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Helppok�ytt�tilan<br>aloitussivu";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Yrit� uudestaan";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "Sinulla ei ole oikeuksia muokata t�t� dokumenttia.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "Aloitussivua ei ole m��ritetty.\\nHaluatko m��ritt�� aloitussivun Asetukset v�lilehdelt�?";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "Sinulla ei ole oikeuksia muokata t�t� dokumenttia.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Haluatko vaihtaa takaisin esikatselutilaan?";

$l_we_SEEM["alert"]["changed_include"] = "Sis�llytetty� tiedostoa on muokattu. P��dokumentti ladataan uudelleen.";
$l_we_SEEM["alert"]["close_include"] = "T�m� ei ole webEdition dokumentti. Sis�llytysikkuna on suljettu.";
?>