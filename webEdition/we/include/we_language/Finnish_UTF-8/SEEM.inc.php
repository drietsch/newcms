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
 * Language file: SEEM.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_SEEM["ext_doc_selected"] = "Olet valinnut linkin, joka osoittaa dokumenttiin joka ei ole webEdition -järjestelmässä. Jatketaanko?";
$l_we_SEEM["ext_document_on_other_server_selected"] = "Olet valinnut linkin joka osoittaa dokumenttiin toisella palvelimella.\\nLinkki avautuu toiseen ikkunaan. Jatketaanko?";
$l_we_SEEM["ext_form_target_other_server"] = "Olet aikeissa lähettää lomakkeen toiselle palvelimelle.\\n Lomake avautuu uuteen ikkunaan. Jatketaanko? ";
$l_we_SEEM["ext_form_target_we_server"] = "Lomakekäsittelijä lähettää tietoa dokumentille, joka ei ole webEdition -dokumentti.\\nJatketaanko?";

$l_we_SEEM["ext_doc"] = "Kyseinen dokumentti: <b>%s</b> <u>ei ole</u> muokattavissa webEdition -järjestelmästä.";
$l_we_SEEM["ext_doc_not_found"] = "Sivua <b>%s</b> ei löytynyt.";
$l_we_SEEM["ext_doc_tmp"] = "webEdition ei avannut dokumenttia oikein. Käytä sivuston normaalinavigointia päästäksesi dokumenttiin.";

$l_we_SEEM["info_ext_doc"] = "Ei webEdition -linkki";
$l_we_SEEM["info_doc_with_parameter"] = "Parametrillinen linkki";
$l_we_SEEM["link_does_not_work"] = "Tämä linkki ei ole aktivoitu esikatselutilassa. Käytä navigointia siirtyäksesi sivulle.";
$l_we_SEEM["info_link_does_not_work"] = "Ei aktivoitu.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "Olet aikeissa muuttaa webEdition -ikkunan sisältöä. Ikkuna suljetaan. Jatketaanko?";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Tila";
$l_we_SEEM["start_mode_normal"] = "Normaali";
$l_we_SEEM["start_mode_seem"] = "Helppokäyttötila";

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Aloitussivua ei ole määritetty.\nJärjestelmänvalvoja asettaa aloitussivusi.";
$l_we_SEEM["only_seem_mode_allowed"] = "Sinulla ei ole tarvittavia oikeuksia kirjautua webEdition -järjestelmään normaalitilassa.\\nKirjaudutaan helppokäyttötilaan ...";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Helppokäyttötilan<br>aloitussivu";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Yritä uudestaan";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "Sinulla ei ole oikeuksia muokata tätä dokumenttia.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "Aloitussivua ei ole määritetty.\\nHaluatko määrittää aloitussivun Asetukset välilehdeltä?";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "Sinulla ei ole oikeuksia muokata tätä dokumenttia.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Haluatko vaihtaa takaisin esikatselutilaan?";

$l_we_SEEM["alert"]["changed_include"] = "Sisällytettyä tiedostoa on muokattu. Päädokumentti ladataan uudelleen.";
$l_we_SEEM["alert"]["close_include"] = "Tämä ei ole webEdition dokumentti. Sisällytysikkuna on suljettu.";
?>