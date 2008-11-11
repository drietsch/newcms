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

/**
 * Language file: voting.inc.php
 * Provides language strings.
 * Language: German
 */

$l_voting = array();
$l_voting['no_perms'] = 'Sie haben nicht die Berechtigung, diese Option auszuw�hlen.';
$l_voting['delete_alert'] = 'Aktuelles Voting/Gruppe l�schen.\\n Sind Sie sich sicher?';
$l_voting['result_delete_alert'] = 'Die aktuellen Voting-Ergebnisse werden gel�scht.\\nSind Sie sich sicher?';
$l_voting['nothing_to_delete'] = 'Nichts zu l�schen!';
$l_voting['nothing_to_save'] = 'Nichts zu speichern';
$l_voting['we_filename_notValid'] = 'Kein korrekter Benutzername!\\nZugelassen sind alphanumerische Zeichen, Gro�- und Kleinschreibung, ebenso wie Unterstrich, Bindestrich, Punkt und Leerzeichen (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'Neu';
$l_voting['menu_save'] = 'Speichern';
$l_voting['menu_delete'] = 'L�schen';
$l_voting['menu_exit'] = 'Schlie�en';
$l_voting['menu_info'] = 'Info';
$l_voting['menu_help'] = 'Hilfe';
$l_voting['headline'] = 'Namen und Nachnamen';


$l_voting['headline_name'] = 'Name';
$l_voting['headline_publish_date'] = 'Datum der Einstellung';
$l_voting['headline_data'] = 'Befragungsdaten';

$l_voting['publish_date'] = 'Datum';
$l_voting['publish_format'] = 'Format';

$l_voting['published_on'] = 'Ver�ffentlicht am';
$l_voting['total_voting'] = 'Gesamtstimmen';
$l_voting['reset_scores'] = 'Punktez�hlung zur�cksetzen';

$l_voting['inquiry_question'] = 'Frage';
$l_voting['inquiry_answers'] = 'Antworten';

$l_voting['question_empty'] = 'Das Fragefeld ist leer. Bitte ausf�llen!';
$l_voting['answer_empty'] = 'Eines oder mehrere Antwortfelder sind leer. Bitte Antwort(en) eingeben!';

$l_voting['invalid_score'] = 'Die Wert der Punktez�hlung muss eine Nummer sein; bitte neu eingeben!';

$l_voting['headline_revote'] = 'Neu abstimmen';
$l_voting['headline_help'] = 'Hilfe';

$l_voting['inquiry'] = 'Befragung';

$l_voting['browser_vote'] = 'Dieser Browser kann nicht neu abstimmen vor ablauf von';
$l_voting['one_hour'] = '1 Stunde';
$l_voting['feethteen_minutes'] = '15 Minuten';
$l_voting['thirthty_minutes'] = '30 Minuten';
$l_voting['one_day'] = '1 Tag';
$l_voting['never'] = '--nie--';
$l_voting['always'] = '--immer--';
$l_voting['cookie_method'] = 'Durch Cookie Methode';
$l_voting['ip_method'] = 'Durch IP Methode';
$l_voting['time_after_voting_again'] = 'Zeit bis zur Neuabstimmung';
$l_voting['cookie_method_help'] = 'Nutzen Sie diese Methode, wenn Sie die IP Methode nicht nutzen k�nnen/wollen. Bedenken Sie bitte, dass Benutzer Cookies im Browser deaktivieren k�nnen. Die "Fallback IP-Methode" Option ben�tigt die Nutzung des we:cookie Tags in der Vorlage.';
$l_voting['ip_method_help'] = 'Sollte Ihre Website nur Intranet Zugang haben und Ihre Benutzer verbinden sich nicht �ber einen Proxy, benutzen Sie diese Methode. Bedenken Sie, dass manche Server dynamische IP-Adressen vergeben.';
$l_voting['time_after_voting_again_help'] = 'Um zu vermeiden, dass einundderselbe Benutzer h�ufiger abstimmt, geben Sie hier eine Zeitspanne ein, die vergehen muss, bevor von diesem Computer wieder abgestimmt werden kann. Bei Computern, die f�r mehrere Benutzer zug�nglich sind, ist dies der sinnvollste Weg. Ansonsten w�hlen Sie "nie".';

$l_voting['property'] = 'Eigenschaften';
$l_voting['variant'] = 'Version';
$l_voting['voting'] = 'Voting';
$l_voting['result'] = 'Ergebnis';
$l_voting['group'] = 'Gruppe';
$l_voting['name'] = 'Name';
$l_voting['newFolder'] = 'Neue Gruppe';
$l_voting['save_group_ok'] = 'Gruppe wurde gespeichert.';
$l_voting['save_ok'] = 'Voting wurde gespeichert.';

$l_voting['path_nok'] = 'Der Pfad ist nicht korrekt!';
$l_voting['name_empty'] = 'Der Name darf nicht leer sein!';
$l_voting['name_exists'] = 'Der Name existiert bereits!';
$l_voting['wrongtext'] = 'Der Name ist nicht g�ltig!\\nErlaubte Zeichen sind Buchstaben von a bis z (Gro�- oder Kleinschreibung), Zahlen, Unterstrich (_), Minus (-), Punkt (.), Leerzeichen ( ) und Klammeraffen (@).';
$l_voting['voting_deleted'] = 'Das Voting wurde erfolgreich gel�scht.';
$l_voting['group_deleted'] = 'Die Gruppe wurde erfolgreich gel�scht.';

$l_voting['access'] = 'Zugriff';
$l_voting['limit_access'] = 'Zugriff einschr�nken';
$l_voting['limit_access_text'] = 'Zugriff nur f�r folgende Benutzer';

$l_voting['variant_limit'] = 'Es muss mindestenst eine Version geben!';
$l_voting['answer_limit'] = 'Die Befragung muss mindestens zwei Antworten enthalten!';

$l_voting['valid_txt'] = 'Die Checkbox "Aktiv" muss aktiviert sein, damit das Voting auf Ihrer Seite gespeichert und nach Ablauf der G�ltigkeit "geparkt" wird. Legen Sie mit den Dropdownmen�s das Datum und die Uhrzeit fest, zu welchem das Voting ablaufen soll. Es werden ab diesem Zeitpunkt keine Stimmen mehr angenommen.';
$l_voting['active_till'] = 'Aktiv';
$l_voting['valid'] = 'G�ltigkeit';

$l_voting['export'] = 'Export';
$l_voting['export_txt'] = 'Export von Voting Daten in eine CSV-Datei (Comma Separated Values).';

$l_voting["csv_download"]="CSV-Datei herunterladen";
$l_voting["csv_export"] = "Die Datei '%s' wurde gespeichert.";

$l_voting['fallback'] = 'Fallback IP-Methode';
$l_voting['save_user_agent'] = 'Daten des Benutzer-Agents speichern/verglichen';
$l_voting["save_changed_voting"] = "Das Voting wurde ge�ndert.\\nM�chten Sie Ihre �nderungen speichern?";
$l_voting['voting_log'] = 'Voting protokollieren';
$l_voting['forbid_ip'] = 'Folgende IP-Adresse sperren';
$l_voting['until'] = 'bis';
$l_voting['options'] = 'Optionen';
$l_voting['control'] = 'Kontrolle';
$l_voting['data_deleted_info'] = 'Die Daten wurden gel�scht!';
$l_voting['time'] = 'Zeit';
$l_voting['ip'] = 'IP';
$l_voting['user_agent'] = 'Benutzer-Agent';
$l_voting['cookie'] = 'Cookie';
$l_voting['delete_ipdata_question'] = 'Sie m�chten alle gespeicherten IP-Daten l�chen. Sind Sie sicher?';
$l_voting['delete_log_question'] = 'Sie m�chten alle Eintr�ge des Voting Logbuches l�chen. Sind Sie sicher?';
$l_voting['delete_ipdata_text'] = 'Die gespeicherten IP-Daten belegen %s Bytes des Speichers. Sie k�nnen sie mit dem \'L�schen\' Knopf l�schen. Bitte achten Sie darauf, dass alle gespeichrten IP-Daten des Votings gel�scht wurden und die Voting-Ergebnise werden nicht mehr pr�zise sind, weil wiederholte Abstimmungen m�glich werden.';
$l_voting['status'] = 'Status';
$l_voting['log_success'] = 'Erfolg';
$l_voting['log_error'] = 'Fehler';
$l_voting['log_error_active'] = 'Fehler: nicht aktiv';
$l_voting['log_error_revote'] = 'Fehler: neue Abstimmung';
$l_voting['log_error_blackip'] = 'Fehler: gesperrte IP';
$l_voting['log_is_empty'] = 'Das Logbuch ist leer!';
$l_voting['enabled'] = 'Aktiviert';
$l_voting['disabled'] = 'Deaktiviert';
$l_voting['log_fallback'] = 'Fallback';

$l_voting['new_ip_add'] = 'Bitte geben Sie die neue IP-Adresse ein!';
$l_voting['not_valid_ip'] = 'Die IP-Adresse ist nicht g�ltig';

$l_voting['not_active'] = 'Das eingegebene G�ltigkeitsdatum liegt in der Vergangenheit!';

?>