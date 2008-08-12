<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or later                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2005 living-e AG                   |
// +----------------------------------------------------------------------+
//

/**
 * Language file: navigation.inc.php
 * Provides language strings.
 * Language: English
 */

$l_navigation = array();
$l_navigation['no_perms'] = 'You do not have the permission to select this option.';
$l_navigation['delete_alert'] = 'Poistetaan t�m�nhetkinen linkki/hakemisto.\\n Oletko varma?';
$l_navigation['nothing_to_delete'] = 'Linkki� ei voida poistaa!';
$l_navigation['nothing_to_save'] = 'Linkki� ei voida tallentaa!';
$l_navigation['nothing_selected'] = 'Valitse poistettava linkki/kansio.';
$l_navigation['we_filename_notValid'] = 'K�ytt�j�nimi ei ole oikein!\\nSallittuja ovat numerot, isot ja pienet kirjaimet, alaviiva, viiva, piste ja v�limerkki (a-z, A-Z, 0-9, _,-.,)';

$l_navigation['menu_new'] = 'Uusi';
$l_navigation['menu_save'] = 'Tallenna';
$l_navigation['menu_delete'] = 'Poista';
$l_navigation['menu_exit'] = 'Lopeta';

$l_navigation['menu_options'] = 'Valinnat';
$l_navigation['menu_generate'] = 'Luo l�hdekoodi';

$l_navigation['menu_settings'] = 'Asetukset';
$l_navigation['menu_highlight_rules'] = 'Korostuss��nn�t';

$l_navigation['menu_info'] = 'Tietoja';
$l_navigation['menu_help'] = 'Ohje';

$l_navigation['property'] = 'Ominaisuudet';
$l_navigation['preview'] = 'Esikatselu';
$l_navigation['preview_code'] = 'Esikatselu - l�hdekoodi';
$l_navigation['navigation'] = 'Navigaatio';
$l_navigation['group'] = 'Kansio';
$l_navigation['name'] = 'Nimi';
$l_navigation['newFolder'] = 'Uusi kansio';
$l_navigation['save_group_ok'] = 'Kansio tallennettiin.';
$l_navigation['save_ok'] = 'Navigaatio tallennettiin.';

$l_navigation['path_nok'] = 'Polku ei ole kelvollinen!';
$l_navigation['name_empty'] = 'Nimi ei saa olla tyhj�!';
$l_navigation['name_exists'] = 'Nimi on jo k�yt�ss�!';
$l_navigation['wrongtext'] = 'Nimi ei ole kelvollinen!\\nKelvollisia merkkej� ovat kirjaimet v�lill� a ja z (isot ja pienet), numerot, alaviiva (_), viiva (-), piste (.), tyhj� merkki ( ) (v�lily�nti) ja @-merkki.';
$l_navigation['wrongTitleField'] = 'The navigation folder could not be saved, because the given title field doesn\'t� exist. Please correct the title field on the "content" tab and save again.'; // TRANSLATE
$l_navigation['folder_path_exists'] = 'T�m�n niminen merkint�/kansio on jo olemassa.';
$l_navigation['navigation_deleted'] = 'Linkki/Kansio poistettiin onnistuneesti.';
$l_navigation['group_deleted'] = 'Kansio poistetiin onnistuneesti.';

$l_navigation['selection'] = 'Valinta';
$l_navigation['icon'] = 'Kuva';
$l_navigation['presentation'] = 'Esitys';
$l_navigation['text'] = 'Teksti';
$l_navigation['title'] = 'Otsikko';

$l_navigation['dir'] = 'Hakemisto';
$l_navigation['categories'] = 'Kategoriat';
$l_navigation['stat_selection'] = 'Staattinen valinta';
$l_navigation['dyn_selection'] = 'Dynaaminen valinta';
$l_navigation['manual_selection'] = 'Manuaalinen valinta';
$l_navigation['txt_dyn_selection'] = 'Selitysteksti dynaamiselle valinnalle';
$l_navigation['txt_stat_selection'] = 'Selitysteksti staattiselle valinnalle. Linkitetty valittuun dokumenttiin tai objektiin.';

$l_navigation['sort'] = 'Lajittelu';
$l_navigation['ascending'] = 'nouseva';
$l_navigation['descending'] = 'laskeva';

$l_navigation['show_count'] = 'N�ytett�vien merkint�jen m��r�';
$l_navigation['title_field'] = 'Otsikkokentt�';
$l_navigation['select_field_txt'] = 'Valitse kentt�';

$l_navigation['content'] = 'Sis�lt�';
$l_navigation['no_dyn_content'] = '- Ei dynaamista sis�lt�� -';
$l_navigation['dyn_content'] = 'Kansiossa on dynaamista sis�lt��';
$l_navigation['link'] = 'Linkki';
$l_navigation['docLink'] = 'Sis�inen dokumentti';
$l_navigation['objLink'] = 'Objekti';
$l_navigation['catLink'] = 'Kategoria';
$l_navigation['order'] = 'J�rjestys';

$l_navigation['general'] = 'Yleinen';
$l_navigation['entry'] = 'Linkki';
$l_navigation['entries'] = 'Linkit';
$l_navigation['save_populate_question'] = 'Olet m��ritt�nyt dynaamisen sis�ll�n hakemistolle. Tallennuksen j�lkeen sis�lt� rakennetaan uudestaan. Haluatko jatkaa? ';
$l_navigation['depopulate_question'] = 'Dynaaminen sis�lt� poistetaan. Haluatko jatkaa?';
$l_navigation['populate_question'] = 'P�ivitet��n dynaamiset linkit. Haluatko jatkaa?';
$l_navigation['depopulate_msg'] = 'Dynaamiset linkit poistettiin.';
$l_navigation['populate_msg'] = 'Dynaamiset linkit lis�ttiin.';

$l_navigation['documents'] = 'Dokumentit';
$l_navigation['objects'] = 'Objektit';
$l_navigation['workspace'] = 'Ty�tila';
$l_navigation['no_workspace'] = 'Objektilla ei ole m��ritelty� ty�tilaa! T�ten objektia ei voida valita!';

$l_navigation['no_entry'] = '--ei merkityst�--';
$l_navigation['parameter'] = 'Parametri';
$l_navigation['urlLink'] = 'Ulkoinen dokumentti';
$l_navigation['doctype'] = 'Dokumenttityyppi';
$l_navigation['class'] = 'Luokka';

$l_navigation['parameter_text'] = 'Seuraavia navigoinnin muuttujia voidaan k�ytt�� parametrina: $LinkID, FolderID, $DocTypID, $ClassID, $Ordn and $WorkspaceID';

$l_navigation['intern'] = 'Sis�inen linkki';
$l_navigation['extern'] = 'Ulkoinen linkki';
$l_navigation['linkSelection'] = 'Linkin valinta';
$l_navigation['catParameter'] = 'Categoria parametrin nimi';

$l_navigation['rules']['navigation_rules'] = "Navigaatios��nn�t";
$l_navigation['rules']['available_rules'] = "K�yt�ss� olevat s��nn�t";
$l_navigation['rules']['rule_name'] = "S��nn�n nimi";
$l_navigation['rules']['rule_navigation_link'] = "Aktiivinen navigaation osa";
$l_navigation['rules']['rule_applies_for'] = "S��nt� koskee kohdetta";
$l_navigation['rules']['rule_folder'] = "Hakemistossa";
$l_navigation['rules']['rule_doctype'] = "Dokumenttityyppi";
$l_navigation['rules']['rule_categories'] = "Kategoriat";
$l_navigation['rules']['rule_class'] = "Luokkaa";
$l_navigation['rules']['rule_workspace'] = "Ty�tila";
$l_navigation['rules']['invalid_name'] = "Nimi voi koostua vain kirjaimista, numeroista, viivasta ja alaviivasta";
$l_navigation['rules']['name_exists'] = "Nimi \"%s\" on jo olemassa, valitse toinen nimi.";
$l_navigation['rules']['saved_successful'] = "Merkint�: \"%s\" tallennettiin.";

$l_navigation['exit_doc_question'] = 'N�ytt�isi sille ett� olet muokannut navigaatiota.<br>Haluatko tallentaa muutokset?';
$l_navigation['add_navigation'] = 'Lis�� navigaatio';
$l_navigation['begin'] = 'alkuun';
$l_navigation['end'] = 'loppuun';

$l_navigation['del_question'] = 'Merkint� poistetaan. Oletko varma?';
$l_navigation['dellall_question'] = 'Kaikki merkinn�t poistetaan. Oletko varma?';
$l_navigation['charset'] = 'Merkist�koodaus';

$l_navigation['more_attributes'] = 'Lis�� ominaisuuksia';
$l_navigation['less_attributes'] = 'V�hemm�n ominaisuuksia';
$l_navigation['attributes'] = 'Attribuutit';
$l_navigation['title'] = 'Otsikko';
$l_navigation['anchor'] = 'Ankkuri';
$l_navigation['language'] = 'Kieli';
$l_navigation['target'] = 'Kohde';
$l_navigation['link_language'] = 'Linkki';
$l_navigation['href_language'] = 'Linkitetty dokumentti';
$l_navigation['keyboard'] = 'N�pp�imist�';
$l_navigation['accesskey'] = 'Pikan�pp�in';
$l_navigation['tabindex'] = 'Selausj�rjestys (tabindex)';
$l_navigation['relation'] = 'Relaatio';
$l_navigation['link_attribute'] = 'Linkin attribuutit';
$l_navigation['popup'] = 'Popup ikkuna';
$l_navigation['popup_open'] = 'Avaa';
$l_navigation['popup_center'] = 'Keskit�';
$l_navigation['popup_x'] = 'x paikka';
$l_navigation['popup_y'] = 'y paikka';
$l_navigation['popup_width'] = 'Leveys';
$l_navigation['popup_height'] = 'Korkaus';
$l_navigation['popup_status'] = 'Tila';
$l_navigation['popup_scrollbars'] = 'Vierityspalkit';
$l_navigation['popup_menubar'] = 'Valikkopalkki';
$l_navigation['popup_resizable'] = 'Muutettava koko';
$l_navigation['popup_location'] = 'Sijainto';
$l_navigation['popup_toolbar'] = 'Ty�kalupalkki';

$l_navigation['icon_properties'] = 'Kuvan ominaisuudet';
$l_navigation['icon_properties_out'] = 'Piilota kuvan ominaisuudet';
$l_navigation['icon_width'] = 'Leveys';
$l_navigation['icon_height'] = 'Korkeus';
$l_navigation['icon_border'] = 'Reunus';
$l_navigation['icon_align'] = 'Tasaa';
$l_navigation['icon_hspace'] = 'vaakatila';
$l_navigation['icon_vspace'] = 'pystytila';
$l_navigation['icon_alt'] = 'Alt teksti';
$l_navigation['icon_title'] = 'Otsikko';

$l_navigation['linkprops_desc'] = 'T��lt� voit m��ritt�� linkin lis�ominaisuudet. Dynaamisilla merkinn�ill� vain linkki ja popup ikkunan ominaisuudet huomioidaan.';
$l_navigation['charset_desc'] = 'Valittua merkist�koodausta k�ytet��n nykyisell� hakemistolla ja kaikilla kansion sis�isill� merkinn�ill�.';


$l_navigation['customers'] = 'Asiakkaat';
$l_navigation['limit_access'] = 'M��rittele asiakkaan p��sytaso';
$l_navigation['customer_access'] = 'Kaikki asiakkaat sallittu';
$l_navigation['filter'] = 'M��rittele suodatus';
$l_navigation['and'] = 'ja';
$l_navigation['or'] = 'tai';
$l_navigation['selected_customers'] = 'Vain valituilla asiakkailla p��sy';
$l_navigation['useDocumentFilter'] = 'Use filter settings of document/object'; // TRANSLATE
$l_navigation['reset_customer_filter'] = 'Reset all customer filters'; // TRANSLATE
$l_navigation['reset_customerfilter_done_message'] = 'The cusomer filters were successfully reset!'; // TRANSLATE

?>