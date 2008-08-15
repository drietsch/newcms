<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2005 living-e AG                   |
// +----------------------------------------------------------------------+
//

$l_voting = array();
$l_voting['no_perms'] = 'You do not have permission to use this option.';
$l_voting['delete_alert'] = 'Verwijder de huidige peiling/groep.\\n Weet u het zeker?';
$l_voting['result_delete_alert'] = 'Delete the current voting results.\\nAre you sure?'; // TRANSLATE
$l_voting['nothing_to_delete'] = 'Er is niks om te verwijderen!';
$l_voting['nothing_to_save'] = 'Er is niks om te bewaren';
$l_voting['we_filename_notValid'] = 'Ongeldige gebruikersnaam!\\nGeldige karakters zijn alfa numeriek, boven- en onderkast, evenals de underscore, koppelteken, punt en spatie (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'Nieuw';
$l_voting['menu_save'] = 'Bewaar';
$l_voting['menu_delete'] = 'Verwijder';
$l_voting['menu_exit'] = 'Sluit';
$l_voting['menu_info'] = 'Info'; 
$l_voting['menu_help'] = 'Help'; 
$l_voting['headline'] = 'Namen en achternamen';


$l_voting['headline_name'] = 'Naam';
$l_voting['headline_publish_date'] = 'Creëer Datum';
$l_voting['headline_data'] = 'Onderzoeksgegevens';

$l_voting['publish_date'] = 'Datum';
$l_voting['publish_format'] = 'Formaat';

$l_voting['published_on'] = 'Gepubliceerd op';
$l_voting['total_voting'] = 'Totaal peiling';
$l_voting['reset_scores'] = 'Herstel uitslag';

$l_voting['inquiry_question'] = 'Vraag';
$l_voting['inquiry_answers'] = 'Antwoord';

$l_voting['question_empty'] = 'De vraag is leeg, voer a.u.b. een vraag in!';
$l_voting['answer_empty'] = 'Eén of meer antwoorden zijn leeg, voer a.u.b een antwoord in!';

$l_voting['invalid_score'] = 'De uitslag moet een nummer zijn, probeer het a.u.b opnieuw!';

$l_voting['headline_revote'] = 'Controle over herstemming';
$l_voting['headline_help'] = 'Help'; 

$l_voting['inquiry'] = 'Onderzoek';

$l_voting['browser_vote'] = 'Browser kan niet opnieuw stemmen voor';
$l_voting['one_hour'] = '1 uur';
$l_voting['feethteen_minutes'] = '15 min.'; 
$l_voting['thirthty_minutes'] = '30 min.'; 
$l_voting['one_day'] = '1 dag';
$l_voting['never'] = '--nooit--';
$l_voting['always'] = '--altijd--';
$l_voting['cookie_method'] = 'Door middel van cookie methode';
$l_voting['ip_method'] = 'Door middel van IP methode';
$l_voting['time_after_voting_again'] = 'Tijd tot opnieuw stemmen';
$l_voting['cookie_method_help'] = 'Als u niet de IP methode kunt gebruiken, selecteer deze. Onthou dat sommige gebruikers cookies uitgeschakeld hebben in hun browser.';
$l_voting['ip_method_help'] = 'Indien uw website alleen intranet toegang heeft, en uw gebruikers niet verbinden via een proxy, selecteer dan deze methode. Onthou dat sommige servers dynamisch een IP toekennen.';
$l_voting['time_after_voting_again_help'] = 'Om meerdere stemmen te verkomen van één specifiek browser/IP, kies een aangewezen tijdstip waarna gestemd kan worden vanaf die browser. Als u wilt dat er vanaf een specifieke browser/computer slechts één keer gestemd kan worden, selecteer dan \"nooit\".';

$l_voting['property'] = 'Eigenschappen';
$l_voting['variant'] = 'Versie';
$l_voting['voting'] = 'Peiling';
$l_voting['result'] = 'Resultaat';
$l_voting['group'] = 'Groep';
$l_voting['name'] = 'Naam';
$l_voting['newFolder'] = 'Nieuwe groep';
$l_voting['save_group_ok'] = 'De groep is bewaard.';
$l_voting['save_ok'] = 'De peiling is bewaard.';

$l_voting['path_nok'] = 'Het pad is niet correct!';
$l_voting['name_empty'] = 'De naam mag niet leeg zijn!';
$l_voting['name_exists'] = 'De naam bestaat al!';
$l_voting['wrongtext'] = 'De naam is niet geldig!';
$l_voting['voting_deleted'] = 'De peiling is succesvol verwijderd.';
$l_voting['group_deleted'] = 'De groep is succesvol verwijderd.';

$l_voting['access'] = 'Toegang';
$l_voting['limit_access'] = 'Beperk toegang';
$l_voting['limit_access_text'] = 'Verleen toegang voor de volgende gebruikers';

$l_voting['variant_limit'] = 'Er moet minstens één versie aanwezig zijn in het onderzoek!';
$l_voting['answer_limit'] = 'Het onderzoek moet uit minstens twee antwoorden bestaan!';

$l_voting['valid_txt'] = 'De checkbox "actief" moet geactiveerd worden, zodat de peiling op uw pagina bewaard wordt en wordt "geparkeerd" aan het eind van de geldigheid. Bepaal met de dropdown menus de datum en de tijd waarin de peiling zou moeten lopen. Na deze datum worden er geen stemmingen meer geaccepteerd.';
$l_voting['active_till'] = 'Actief tot';
$l_voting['valid'] = 'Geldigheid';

$l_voting['export'] = 'Exporteer';
$l_voting['export_txt'] = 'Exporteer peilings gegevens naar een CSV bestand (komma gescheiden waardes).';
$l_voting["csv_download"] = "Download CSV bestand";
$l_voting["csv_export"] = "Bestand '%s' is bewaard.";

$l_voting['fallback'] = 'Terugval IP methode';
$l_voting['save_user_agent'] = 'Bewaar/Vergelijk gegevens van de user-agent';
$l_voting["save_changed_voting"] = "Voting has been changed.\\nDo you want to save your changes?"; // TRANSLATE
$l_voting['voting_log'] = 'Protocol Stemmen';
$l_voting['forbid_ip'] = 'Blokkeer de volgende IP adressen';
$l_voting['until'] = 'tot';
$l_voting['options'] = 'Opties';
$l_voting['control'] = 'Controleer';
$l_voting['data_deleted_info'] = 'De gegevens zijn verwijderd!';
$l_voting['time'] = 'Tijd';
$l_voting['ip'] = 'IP'; 
$l_voting['user_agent'] = 'User-agent'; 
$l_voting['cookie'] = 'Cookie'; 
$l_voting['delete_ipdata_question'] = 'U wilt alle opgeslagen IP gegevens verwijderen. Weet u dit zeker?';
$l_voting['delete_log_question'] = 'U wilt alle Stemmings Log Invoeren verwijderen.  Weet u dit zeker?';
$l_voting['delete_ipdata_text'] = 'De opgeslagen gegevens beslaan %s Bytes van het geheugen. Verwijder deze d.m.v. de knop \Verwijder\'. Neem in overweging dat alle opgeslagen IP gegevens verwijderd worden waardoor de stemming herhaald kan worden.';
$l_voting['status'] = 'Status';
$l_voting['log_success'] = 'Gelukt';
$l_voting['log_error'] = 'Fout';
$l_voting['log_error_active'] = 'Fout: niet actief';
$l_voting['log_error_revote'] = 'Fout: nieuwe stemming';
$l_voting['log_error_blackip'] = 'Fout: Geblokkeerde IP';
$l_voting['log_is_empty'] = 'De log is leeg!';
$l_voting['enabled'] = 'Geactivateerd';
$l_voting['disabled'] = 'Gedeactiveerd';
$l_voting['log_fallback'] = 'Terugvallen';

$l_voting['new_ip_add'] = 'Voer a.u.b. het nieuwe IP adres in!';
$l_voting['not_valid_ip'] = 'Het IP adres is niet geldig';
$l_voting['not_active'] = 'The entered datum is in the past!'; // TRANSLATE

?>