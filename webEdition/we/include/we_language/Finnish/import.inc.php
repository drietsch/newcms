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
 * Language file: import.inc.php
 * Provides language strings.
 * Language: English
 */
$l_import['title'] = 'Tuontivelho';
$l_import['wxml_import'] = 'webEdition XML tuonti';
$l_import['gxml_import'] = 'Yleinen XML tuonti';
$l_import['csv_import'] = 'CSV tuonti';
$l_import['import'] = 'Tuodaan';
$l_import['none'] = '-- ei mitään --';
$l_import['any'] = '-- ei mitään --';
$l_import['source_file'] = 'Lähdetiedosto';
$l_import['import_dir'] = 'Kohdehakemisto';
$l_import['select_source_file'] = 'Ole hyvä ja valitse lähdetiedosto.';
$l_import['we_title'] = 'Otsikko';
$l_import['we_description'] = 'Kuvaus';
$l_import['we_keywords'] = 'Avainsanat';
$l_import['uts'] = 'Unix-aikaleima';
$l_import['unix_timestamp'] = 'Unix aikaleima on tapa seurata aikaa sekuntien kulumisena. Sekuntien laskeminen aloitetaan unix aikakauden alusta tammikuun 1. 1970.';
$l_import['gts'] = 'GMT Aikaleima';
$l_import['gmt_timestamp'] = 'General Mean Time ie. Greenwich Mean Time (GMT).'; // TRANSLATE
$l_import['fts'] = 'Määritelty muoto';
$l_import['format_timestamp'] = 'Seuraavat merkit tunnistetaan parametrimerkkijonossa:: Y (numeerinen esitys vuodesta, 4 numeroa), y (kaksinumeroinen vuoden esitys), m (numeerinen kuukauden esitys, etunollilla), n (numeerinen kuukauden esitys, ei etunollia), d (kuukauden päivä, 2 numeroa etunollalla), j (kuukauden päivä, 2 numeroa ilman etunollaa), H (24-tuntinen esitys tunnista etunollalla), G (24-tuntinen esitys tunnista ilman etunollaa), i (minuutit etunollalla), s (sekunnit etunollalla)';
$l_import['import_progress'] = 'Tuodaan';
$l_import['prepare_progress'] = 'Valmistellaan';
$l_import['finish_progress'] = 'Valmis';
$l_import['finish_import'] = 'Tuonti onnistui!';
$l_import['import_file'] = 'Tiedoston tuonti';
$l_import['import_data'] = 'Tiedon tuonti';
$l_import['file_import'] = 'Tuo paikallisia tiedostoja';
$l_import['txt_file_import'] = 'Tuo yksi tai useampia tiedostoja paikalliselta kovalevyltä.';
$l_import['site_import'] = 'Tuo tiedostoja palvelimelta';
$l_import['site_import_isp'] = 'Tuo grafiikkaa palvelimelta';
$l_import['txt_site_import_isp'] = 'Tuo grafiikkaa palvelimen juurihakemistosta. Aseta suodatusasetukset valitaksesi mitä grafiikkaa tuodaan.';
$l_import['txt_site_import'] = 'Tuo tiedostoja palvelimen juurihakemistosta. Aseta suodattimen asetuksista tuodaanko HTML-sivuja, Flash-esityksiä, JavaScript-tiedostoja, CSS-tiedostoja, tekstidokumentteja tai muun tyyppisiä dokumentteja.';
$l_import['txt_wxml_import'] = 'webEdition XML-tiedostot sisältävät tietoa webEdition dokumenteista, sivupohjista tai objekteista. Valitse hakemisto minne tiedostot tuodaan.';
$l_import['txt_gxml_import'] = 'Tuo "flat" XML-tiedostoja (kuten phpMyAdminin tuottamia). Tietueen kenttien täytyy täsmätä webEditionin tietueen kenttiin. Käytä tätä vaihtoehtoa tuodaksesi XML-tiedostoja jotka on viety webEditionista ilman Vientimoduulia.';
$l_import['txt_csv_import'] = 'Tuo CSV-tiedostoja (Comma Separated Values) tai muokattuja tekstiformaatteja (esim. *.txt). Tietueen kentät asetetaan vastaamaan webEditionin kenttiä.';
$l_import['add_expat_support'] = 'Sisällyttääksesi tuen XML expat parseroijalle, sinun täytyy kääntää PHP -komentotulkki uudelleen ja lisätä tuki tälle kirjastolle. Expat laajennus (Tekijä: James Clark) löytyy osoitteesta http://www.jclark.com/xml/.';
$l_import['xml_file'] = 'XML -tiedosto';
$l_import['templates'] = 'Sivupohjat';
$l_import['classes'] = 'Luokat';
$l_import['predetermined_paths'] = 'Polkuasetukset';
$l_import['maintain_paths'] = 'Säilytä polut';
$l_import['import_options'] = 'Tuontiasetukset';
$l_import['file_collision'] = 'Tiedoston korvaus';
$l_import['collision_txt'] = 'Tuodessasi tiedostoja kensioon jossa on olemassa jo samalla nimellä oleva tiedosto voidaan tälle tilanteelle määrittää asetus jota tuontivelho noudattaa tuotaessa uusia ja olemassaolevia tiedostoja.';
$l_import['replace'] = 'Korvaa';
$l_import['replace_txt'] = 'Poista olemassaoleva tiedosto ja korvaa se uudella.';
$l_import['rename'] = 'Uudelleennimeä';
$l_import['rename_txt'] = 'Luo yksilöllinen nimi uudelle tiedostolle. Kaikki linkitykset asetetaan uudelle tiedostolle.';
$l_import['skip'] = 'Ohita';
$l_import['skip_txt'] = 'Ohita kyseinen tiedosto ja jätä molemmat kopiot alkuperäiseen sijaintiinsa.';
$l_import['extra_data'] = 'Lisätiedot';
$l_import['integrated_data'] = 'Tuo sisällytetty tiedo';
$l_import['integrated_data_txt'] = 'Valitse tämä toimito tuodaksesi sivupohjien ja dokumenttien sisällyttämää tietoa.';
$l_import['max_level'] = 'Maksimitaso';
$l_import['import_doctypes'] = 'Tuo dokumenttityyppejä';
$l_import['import_categories'] = 'Tuo kategorioita';
$l_import['invalid_wxml'] = 'XML-dokumentti on oikein muodostettu (well-formed) mutta ei muuten sopiva. Se ei sovi yhteen webEditionin tietotyyppimäärittelyn kanssa (webEdition document type definition, DTD).';
$l_import['valid_wxml'] = 'XML-dokumentti on oikein muodostettu ja sopiva. Se sopii yhteen webEditionin tietotyyppimäärittelyn kanssa (webEdition document type definition, DTD).';
$l_import['specify_docs'] = 'Valitse tuotavat dokumentit.';
$l_import['specify_objs'] = 'Valitse tuotavat objektit.';
$l_import['specify_docs_objs'] = 'Valitse tuodaanko dokumentteja ja objekteja.';
$l_import['no_object_rights'] = 'Sinulla ei ole oikeutta tuoda objekteja.';
$l_import['display_validation'] = 'Näytä XML validointi';
$l_import['xml_validation'] = 'XML validointi';
$l_import['warning'] = 'Varoitus';
$l_import['attribute'] = 'Attribuutti';
$l_import['invalid_nodes'] = 'Epäkelpo XML solmu sijainnissa ';
$l_import['no_attrib_node'] = 'Ei XML elementtiä  "attrib" sijainnissa ';
$l_import['invalid_attributes'] = 'Epäkelpoja attribuutteja sijainnissa ';
$l_import['attrs_incomplete'] = 'Attribuuttien #required ja #fixed lista on epäkelpo sijainnissa ';
$l_import['wrong_attribute'] = 'Attribuutin nimi ei ole määritelty kummaksikaan #required tai #implied sijainnissa ';
$l_import['documents'] = 'Dokumentit';
$l_import['objects'] = 'Objektit';
$l_import['fileselect_server'] = 'Lataa tiedosto palvelimelta';
$l_import['fileselect_local'] = 'Lataa tiedosto paikalliselta kovalevyltä';
$l_import['filesize_local'] = 'PHP:hen asetettujen rajoitusten takia ladattavan tiedoston koko ei saa olla yli %s.';
$l_import['xml_mime_type'] = 'Valittua tiedostoa ei voida tuoda. Mime-type:';
$l_import['invalid_path'] = 'Lähdetiedoston polku on epäkelpo.';
$l_import['ext_xml'] = 'Valitse lähdetiedostoksi tiedosto päätteellä ".xml".';
$l_import['store_docs'] = 'Kohdehakemiston dokumentit';
$l_import['store_tpls'] = 'Kohdehakemiston sivupohjat';
$l_import['store_objs'] = 'Kohdehakemiston objektit';
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'Yleinen XML';
$l_import['data_import'] = 'Tuo tietoja';
$l_import['documents'] = 'Dokumentit';
$l_import['objects'] = 'Objektit';
$l_import['type'] = 'Tyyppi';
$l_import['template'] = 'Sivupohja';
$l_import['class'] = 'Luokka';
$l_import['categories'] = 'Kategoriat';
$l_import['isDynamic'] = 'Luo sivu dynaamisesti';
$l_import['extension'] = 'Pääte';
$l_import['filetype'] = 'Tiedostotyyppi';
$l_import['directory'] = 'Hakemisto';
$l_import['select_data_set'] = 'Valitse tietue';
$l_import['select_docType'] = 'Valitse sivupohja.';
$l_import['file_exists'] = 'Valittua lähdetiedostoa ei ole olemassa. Tarkista annettu polku. Polku: ';
$l_import['file_readable'] = 'Valittu lähdetiedosto ei ole luettavissa ja siten sitä ei voida tuoda.';
$l_import['asgn_rcd_flds'] = 'Määrittele tietokentät';
$l_import['we_flds'] = 'webEdition&nbsp;kentät';
$l_import['rcd_flds'] = 'Tietueen&nbsp;kentät';
$l_import['name'] = 'Nimi';
$l_import['auto'] = 'Automaattinen';
$l_import['asgnd'] = 'Määritelty';
$l_import['pfx'] = 'Etuliite';
$l_import['pfx_doc'] = 'Dokumentti';
$l_import['pfx_obj'] = 'Objekti';
$l_import['rcd_fld'] = 'Tietueen kenttä';
$l_import['import_settings'] = 'Tuonnin asetukset';
$l_import['xml_valid_1'] = 'XML tiedosto on kelvollinen ja sisältää';
$l_import['xml_valid_s2'] = 'elementtiä. Valitse tuotavat elementit.';
$l_import['xml_valid_m2'] = 'XML lapsisolmu ensimmäisellä tasolla eri nimellä. Valitse XML solmu ja tuotavien elementtien määrä.';
$l_import['well_formed'] = 'XML-dokumentti on oikein muodostettu (well-formed).';
$l_import['not_well_formed'] = 'XML-dokumentti ei ole oikein muodostettu (well-formed) joten sitä ei voida tuoda.';
$l_import['missing_child_node'] = 'XML-dokumentti on oikein muodostettu (well-formed), mutta koska se ei sisällä XML solmuja sitä ei voida tuoda.';
$l_import['select_elements'] = 'Valitse tuotavat tietueet.';
$l_import['num_elements'] = 'Valitse tietueiden numerot alkaen numerosta 1 ja päättyen ';
$l_import['xml_invalid'] = 'XML Invalid';
$l_import['option_select'] = 'Valinta..';
$l_import['num_data_sets'] = 'Tietueet:';
$l_import['to'] = 'mihin';
$l_import['assign_record_fields'] = 'Määrittele tietokentät';
$l_import['we_fields'] = 'webEdition kentät';
$l_import['record_fields'] = 'Tietueen kentät';
$l_import['record_field'] = 'Tietuekenttä ';
$l_import['attributes'] = 'Attribuutit';
$l_import['settings'] = 'Asetukset';
$l_import['field_options'] = 'Kentän optiot';
$l_import['csv_file'] = 'CSV tiedosto';
$l_import['csv_settings'] = 'CSV asetukset';
$l_import['xml_settings'] = 'XML asetukset';
$l_import['file_format'] = 'Tiedostomuoto';
$l_import['field_delimiter'] = 'Erotin';
$l_import['comma'] = ', {pilkku}';
$l_import['semicolon'] = '; {puolipiste}';
$l_import['colon'] = ': {kaksoispiste}';
$l_import['tab'] = "\\t {tabulaattori}";
$l_import['space'] = '  {välilyönti}';
$l_import['text_delimiter'] = 'Tekstin erotin';
$l_import['double_quote'] = '" {lainausmerkit}';
$l_import['single_quote'] = '\' {heittomerkki}';
$l_import['contains'] = 'Ensimmäinen rivi sisältää kenttien nimet';
$l_import['split_xml'] = 'Tuo tietueet peräkkäin';
$l_import['wellformed_xml'] = 'XML-dokumentin oikeellisuustarkastus (onko "well-formed")';
$l_import['validate_xml'] = 'XML validointi';
$l_import['select_csv_file'] = 'Valitse CSV lähdetiedosto.';
$l_import['select_seperator'] = 'Valitse erotinmerkki.';
$l_import['format_date'] = 'Päivämäärän formaatti';
$l_import['info_sdate'] = 'Valitse webEdition kentän aikaformaatti';
$l_import['info_mdate'] = 'Valitse webEdition kentän aikaformaatti';
$l_import['remark_csv'] = 'Voit tuoda CSV (Comma Separated Values) tiedostoja ja mukautettuja tekstitiedostoja (esim. *.txt). Kenttien erottimet (esim. , ; tab, space) ja tekstin rajoitusmerkki (= joka sulkee tekstisyötteet) voivat olla mukana näissä tiedostomuodoissa.';
$l_import['remark_xml'] = 'Tuodessasi isoja tiedostoja valitse valitse vaihtoehto "Tuo tietueet erillisinä" välttääksesi ennaltamääritellyn PHP-skriptien aikakatkaisun.<br>Jos olet epävarma siitä onko tiedosto webEdition XML-formaatin mukainen, sen muoto ja syntaksi voidaan testata.';

$l_import["import_docs"]="Tuo dokumentteja";
$l_import["import_templ"]="Tuo sivupohjia";
$l_import["import_objs"]="Tuo objekteja";
$l_import["import_classes"]="Tuo luokkia";
$l_import["import_doctypes"]="Tuo dokumenttityypit";
$l_import["import_cats"]="Tuo kategorioita";
$l_import["documents_desc"]="Valitse hakemisto johon dokumentit tuodaan. Jos valinta \"".$l_import['maintain_paths']."\" on valittu, dokumenttien polut palautetaan, muussa tapauksessa polkutieto jätetään huomioimatta.";
$l_import["templates_desc"]="Valitse hakemisto johon sivupohjat tuodaan. Jos valinta \"".$l_import['maintain_paths']."\" on valittu, sivupohjien polut palautetaan, muussa tapauksessa polkutieto jätetään huomioimatta.";
$l_import['handle_document_options'] = 'Dokumentit';
$l_import['handle_template_options'] = 'Sivupohjat';
$l_import['handle_object_options'] = 'Objektit';
$l_import['handle_class_options'] = 'Luokat';
$l_import["handle_doctype_options"] = "Dokumenttityyppi";
$l_import["handle_category_options"] = "Kategoria";
$l_import['log'] = 'Lisätiedot';
$l_import['start_import'] = 'Aloita tuonti';
$l_import['prepare'] = 'Valmistellaan...';
$l_import['update_links'] = 'Päivitä linkit...';
$l_import['doctype'] = 'Dokumenttityyppi';
$l_import['category'] = 'Kategoria';
$l_import['end_import'] = 'Vienti päättynyt';

$l_import['handle_owners_option'] = 'Omistajan tieto';
$l_import['txt_owners'] = 'Tuo linkitetty omistajan tieto';
$l_import['handle_owners'] = 'Palauta omistajan tieto';
$l_import['notexist_overwrite'] = 'Jos käyttäjää ei ole olemassa, käytetään toimintoa "Ylikirjoita omistajan tieto"!';
$l_import['owner_overwrite'] = 'Ylikirjoita omistajan tieto';

$l_import['name_collision'] = 'Nimivirhe';

$l_import['item'] = 'Tuoteartikkeli';
$l_import['backup_file_found'] = 'Tiedosto vaikuttaa webEditionin varmuuskopiotiedostolta. Käytä \"Varmuuskopioi\" toimintoa \"Tiedosto\" valikosta palauttaaksesi varmuuskopiotiedoston tiedot.';
$l_import['backup_file_found_question'] = 'Haluaisitko sulkea tämän dialogin ja käynnistää varmuuskopiointivelhon?';
$l_import['close'] = 'Sulje';
$l_import['handle_file_options'] = 'Tiedostot';
$l_import['import_files'] = 'Tuo tiedostoja';
$l_import['weBinary'] = 'Tiedosto';
$l_import['format_unknown'] = 'Tiedostomuoto on tuntematon!';
$l_import['customer_import_file_found'] = 'Tiedosto vaikuttaa asiakashallinnan asikastietojen tuontitiedostolta. Käytä \"Tuo\Vie\" toimintoa asiakashallinta pro moduulista.';
$l_import['upload_failed'] = 'Tiedostoa ei voitu siirtää. Varmista että tiedostokoko on suurempi kuin %s';

$l_import['import_navigation'] = 'Tuo navigointi';
$l_import['weNavigation'] = 'Navigointi';
$l_import['navigation_desc'] = 'Valitse hakemisto jonne navigointi tuodaan.';
$l_import['weNavigationRule'] = 'Navigaatiosääntö';
$l_import['weThumbnail'] = 'Pikkukuva';
$l_import['import_thumbnails'] = 'Tuo pikkukuvat';
$l_import['rebuild'] = 'Uudelleenrakennus';
$l_import['rebuild_txt'] = 'Automaattinen uudelleenrakennus';
$l_import['finished_success'] = 'Tietojen tuonti on suoritettu onnistuneesti.';
?>