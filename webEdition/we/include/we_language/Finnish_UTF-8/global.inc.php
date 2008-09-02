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
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "Uusi linkki"; // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "Ladataan tietoja!<br>Lataaminen voi kestää jonkin aikaa kun ladataan useita valikkoelementtejä ...";
$GLOBALS["l_global"]["text"] = "Teksti";
$GLOBALS["l_global"]["yes"] = "Kyllä";
$GLOBALS["l_global"]["no"] = "Ei";
$GLOBALS["l_global"]["checked"] = "Rastitettu";
$GLOBALS["l_global"]["max_file_size"] = "Maksimi tiedoston koko (tavuina)";
$GLOBALS["l_global"]["default"] = "Oletus";
$GLOBALS["l_global"]["values"] = "Arvot";
$GLOBALS["l_global"]["name"] = "Nimi";
$GLOBALS["l_global"]["type"] = "Tyyppi";
$GLOBALS["l_global"]["attributes"] = "Määreet";
$GLOBALS["l_global"]["formmailerror"] = "Lomaketta ei voitu lähettä, koska:";
$GLOBALS["l_global"]["email_notallfields"] = "Et ole täyttänyt kaikkia tarvittavia kenttiä!";
$GLOBALS["l_global"]["email_ban"] = "Sinulla ei ole oikeuksia käyttää tätä skriptiä!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "Vastaanottajan osoite on virheellinen!";
$GLOBALS["l_global"]["email_no_recipient"] = "Vastaanottajan osoitetta ei ole olemassa!";
$GLOBALS["l_global"]["email_invalid"] = "<b>Sähköpostiosoitteesi</b> on virheellinen!";
$GLOBALS["l_global"]["captcha_invalid"] = "The entered security code is wrong!"; // TRANSLATE
$GLOBALS["l_global"]["question"] = "Kysymys";
$GLOBALS["l_global"]["warning"] = "Varoitus";
$GLOBALS["l_global"]["we_alert"] = "Toimintoa ei ole webEditionin demoversiossa!";
$GLOBALS["l_global"]["index_table"] = "Indeksitaulukko";
$GLOBALS["l_global"]["cannotconnect"] = "Ei voitu yhdistää webEdition -palvelimeen!";
$GLOBALS["l_global"]["recipients"] = "Formmail -vastaanottajat";
$GLOBALS["l_global"]["recipients_txt"] = "Kirjoita kaikki sähköpostiosoitteet jotka voivat vastaanottaa lomakkeita jotka lähetetään formmail -funktiolla (&lt;we:form type=&quot;formmail&quot; ..&gt;). Jos et kirjoita sähköpostiosoitetta, et voi lähettää lomakkeita käyttämällä formmail -funktiota!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Uusi objekti %s Luokkaan %s on luotu!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Uusi objekti";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Uusi dokumentti";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Uusi dokumentti %s on luotu!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Objekti poistettu";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "Objekti %s on poistettu!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Dokumentti poistettu";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "Dokumentti %s on poistettu!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "Uusi sivu tallentamisen jälkeen";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "Tuloksia ei löytynyt!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Tallenna väliaikaiset dokumentit";
$GLOBALS["l_global"]["save_mainTable"] = "Tallenna uudelleen päätietokannan taulu";
$GLOBALS["l_global"]["add_workspace"] = "Lisää työtila";
$GLOBALS["l_global"]["folder_not_editable"] = "Tätä hakemisto ei voida valita!";
$GLOBALS["l_global"]["modules"] = "Moduulit";
$GLOBALS["l_global"]["modules_and_tools"] = "Moduulit ja työkalut";
$GLOBALS["l_global"]["center"] = "Keskellä";
$GLOBALS["l_global"]["jswin"] = "Ponnahdusikkuna";
$GLOBALS["l_global"]["open"] = "Avaa";
$GLOBALS["l_global"]["posx"] = "x kohdistus";
$GLOBALS["l_global"]["posy"] = "y kohdistus";
$GLOBALS["l_global"]["status"] = "Tila";
$GLOBALS["l_global"]["scrollbars"] = "Vierityspalkit";
$GLOBALS["l_global"]["menubar"] = "Valikkopalkki";
$GLOBALS["l_global"]["toolbar"] = "Työkalupalkki";
$GLOBALS["l_global"]["resizable"] = "Muutettavissa";
$GLOBALS["l_global"]["location"] = "Paikka";
$GLOBALS["l_global"]["title"] = "Otsikko";
$GLOBALS["l_global"]["description"] = "Kuvaus";
$GLOBALS["l_global"]["required_field"] = "Pakolliset kentät";
$GLOBALS["l_global"]["from"] = "Mistä";
$GLOBALS["l_global"]["to"] = "Mihin";
$GLOBALS["l_global"]["search"]="Etsi";
$GLOBALS["l_global"]["in"]="mistä";
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Automaattinen uudelleen rakennus";
$GLOBALS["l_global"]["we_publish_at_save"] = "Julkaise tallentamisen jälkeen";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "Uusi dokumentti tallentamisen jälkeen";
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving"; // TRANSLATE
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving"; // TRANSLATE
$GLOBALS["l_global"]["wrapcheck"] = "Rivitys";
$GLOBALS["l_global"]["static_docs"] = "Staattinen dokumentti";
$GLOBALS["l_global"]["save_templates_before"] = "Tallenna sivupohjat ensin";
$GLOBALS["l_global"]["specify_docs"] = "Dokumenttit tietyllä tavalla";
$GLOBALS["l_global"]["object_docs"] = "Kaikki objektit";
$GLOBALS["l_global"]["all_docs"] = "Kaikki dokumentit";
$GLOBALS["l_global"]["ask_for_editor"] = "Kysy editoria";
$GLOBALS["l_global"]["cockpit"] = "Aloitus";
$GLOBALS["l_global"]["introduction"] = "Johdanto";
$GLOBALS["l_global"]["doctypes"] = "Dokumenttityypit";
$GLOBALS["l_global"]["content"] = "Sisältö";
$GLOBALS["l_global"]["site_not_exist"] = "Sivua ei ole olemassa!";
$GLOBALS["l_global"]["site_not_published"] = "Sivua ei ole julkaistu!";
$GLOBALS["l_global"]["required"] = "Syöte vaaditaan!";
$GLOBALS["l_global"]["all_rights_reserved"] = "Kaikki oikeudet pidätetään";
$GLOBALS["l_global"]["width"] = "Leveys";
$GLOBALS["l_global"]["height"] = "Korkeus";
$GLOBALS["l_global"]["new_username"] = "Uusi käyttäjänimi";
$GLOBALS["l_global"]["username"] = "Käyttäjänimi";
$GLOBALS["l_global"]["password"] = "Salasana";
$GLOBALS["l_global"]["documents"] = "Dokumentit";
$GLOBALS["l_global"]["templates"] = "Sivupohjat";
$GLOBALS["l_global"]["objects"] = "Objektit";
$GLOBALS["l_global"]["licensed_to"] = "Lisenssin haltija";
$GLOBALS["l_global"]["left"] = "Vasen";
$GLOBALS["l_global"]["right"] = "Oikea";
$GLOBALS["l_global"]["top"] = "Ylä";
$GLOBALS["l_global"]["bottom"] = "Ala";
$GLOBALS["l_global"]["topleft"] = "Ylävasen";
$GLOBALS["l_global"]["topright"] = "Yläoikea";
$GLOBALS["l_global"]["bottomleft"] = "Alavasen";
$GLOBALS["l_global"]["bottomright"] = "Alaoikea";
$GLOBALS["l_global"]["true"] = "Kyllä";
$GLOBALS["l_global"]["false"] = "Ei";
$GLOBALS["l_global"]["showall"] = "Näytä kaikki";
$GLOBALS["l_global"]["noborder"] = "Ei reunusta";
$GLOBALS["l_global"]["border"] = "Reunus";
$GLOBALS["l_global"]["align"] = "Paikka";
$GLOBALS["l_global"]["hspace"] = "Vaakaväli (Hspace)";
$GLOBALS["l_global"]["vspace"] = "Pystyväli (Vspace)";
$GLOBALS["l_global"]["exactfit"] = "Tarkka sovitus";
$GLOBALS["l_global"]["select_color"] = "Valitse väri";
$GLOBALS["l_global"]["changeUsername"] = "Vaihda käyttäjänimi";
$GLOBALS["l_global"]["changePass"] = "Vaihda salasana";
$GLOBALS["l_global"]["oldPass"] = "Vanha salasana";
$GLOBALS["l_global"]["newPass"] = "Uusi salasana";
$GLOBALS["l_global"]["newPass2"] = "Toista uusi salasana";
$GLOBALS["l_global"]["pass_not_confirmed"] = "Salasanat eivät täsmää!";
$GLOBALS["l_global"]["pass_not_match"] = "Vanha salasana on väärä!";
$GLOBALS["l_global"]["passwd_not_match"] = "Salasanat eivät täsmää!";
$GLOBALS["l_global"]["pass_to_short"] = "Salasanan pituus on oltava vähintaa 4 merkkiä!";
$GLOBALS["l_global"]["pass_changed"] = "Salasana vaihdettu!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Salasana voi sisältää vain alfa-numeerisia merkkejä (a-z, A-Z ja 0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Käyttäjätunnus voi sisältää vain alfa-numeerisia merkkejä (a-z, A-Z ja 0-9) ja '.', '_' tai '-'!";
$GLOBALS["l_global"]["all"] = "Kaikki";
$GLOBALS["l_global"]["selected"] = "Valittu";
$GLOBALS["l_global"]["username_to_short"] = "Käyttäjänimessä on oltava vähintään 4 merkkiä!";
$GLOBALS["l_global"]["username_changed"] = "Käyttäjänimi vaihdettu!";
$GLOBALS["l_global"]["published"] = "Julkaistu";
$GLOBALS["l_global"]["help_welcome"] = "Tervetuloa webEdition ohjeeseen";
$GLOBALS["l_global"]["edit_file"] = "Muokkaa tiedostoa";
$GLOBALS["l_global"]["docs_saved"] = "Dokumentit tallennettu!";
$GLOBALS["l_global"]["preview"] = "Esikatsele";
$GLOBALS["l_global"]["close"] = "Sulje ikkuna";
$GLOBALS["l_global"]["loginok"] =  "<strong>Kirjautuminen onnistui, Odota hetkinen!</strong><br>webEdition avautuu uuteen ikkunaan. Jos ikkuna ei avaudu, varmista ettet ole estänyt ponnahdusikkunoiden avautumista selaimestasi!";
$GLOBALS["l_global"]["apple"] = "&#x2318;"; // TRANSLATE
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "CTRL"; // TRANSLATE
$GLOBALS["l_global"]["required_fields"] = "Pakolliset kentät";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">Tuo tiedosto.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Avaa/Sulje";
$GLOBALS["l_global"]["rebuild"] = "Rakenna uudelleen";
$GLOBALS["l_global"]["welcome_to_we"] = "Tervetuloa webEdition 3 -järjestelmään";
$GLOBALS["l_global"]["tofit"] = "Tervetuloa webEdition 3 -järjestelmään";
$GLOBALS["l_global"]["unlocking_document"] = "poistaa lukinnan webEdition -dokumentista";
$GLOBALS["l_global"]["variant_field"] = "Muunnelmakenttä";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Klikkaa seuraavaa linkkiä jos selaintasi ei uudelleenohjata seuraanvan 30 sekunnin kuluessa ";
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition kirjautumisnimi";
$GLOBALS["l_global"]["untitled"] = "Nimetön";
$GLOBALS["l_global"]["no_document_opened"] = "There is no document opened!"; // TRANSLATE
?>