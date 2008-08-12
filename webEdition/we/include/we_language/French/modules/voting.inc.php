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
$l_voting['delete_alert'] = 'Supprimer le vote/groupe actuel.\\n �tes-vous s�r?';
$l_voting['result_delete_alert'] = 'Delete the current voting results.\\nAre you sure?'; // TRANSLATE
$l_voting['nothing_to_delete'] = 'Rien � supprimer!';
$l_voting['nothing_to_save'] = 'Rien � enregistrer';
$l_voting['we_filename_notValid'] = 'Le nom d&rsquo;utilisateur n&rsquo;est pas valide!\\nPermit sont les signe alpha-numerique, majuscule et minuscule, autant que le soulignage, le trait d&rsquo;union, le point et l&rsquo;�space (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'Nouveau';
$l_voting['menu_save'] = 'Entregistrer';
$l_voting['menu_delete'] = 'Supprimer';
$l_voting['menu_exit'] = 'Fermer';
$l_voting['menu_info'] = 'Info'; // TRANSLATE
$l_voting['menu_help'] = 'Aide';
$l_voting['headline'] = 'Pr�nom et Noms';


$l_voting['headline_name'] = 'Nom';
$l_voting['headline_publish_date'] = 'Date de Cr�ation';
$l_voting['headline_data'] = 'Donn�es d&rsquo;enqu�te';

$l_voting['publish_date'] = 'Date'; // TRANSLATE
$l_voting['publish_format'] = 'Format'; // TRANSLATE

$l_voting['published_on'] = 'Publi� le';
$l_voting['total_voting'] = 'Vote total';
$l_voting['reset_scores'] = 'Remettre le score';

$l_voting['inquiry_question'] = 'Question'; // TRANSLATE
$l_voting['inquiry_answers'] = 'R�ponse';

$l_voting['question_empty'] = 'La question est vide, s&rsquo;il vous pla�t entrez une!';
$l_voting['answer_empty'] = 'Une ou plusieurs r�ponses sont vide, s&rsquo;il vous pla�t entrez les r�ponses!';

$l_voting['invalid_score'] = 'La valeur du score do�t �tre un num�ro, essayez de nouveau s&rsquo;il vous pla�t!';

$l_voting['headline_revote'] = 'Cont�le de revote';
$l_voting['headline_help'] = 'Aide';

$l_voting['inquiry'] = 'Enqu�te';

$l_voting['browser_vote'] = 'Un navigateur ne peut pas voter de nouveau avant';
$l_voting['one_hour'] = '1 heure';
$l_voting['feethteen_minutes'] = '15 min.'; // TRANSLATE
$l_voting['thirthty_minutes'] = '30 min.'; // TRANSLATE
$l_voting['one_day'] = '1 jour';
$l_voting['never'] = '--jamais--';
$l_voting['always'] = '--toujours--';
$l_voting['cookie_method'] = 'Par m�thode Cookie';
$l_voting['ip_method'] = 'Par m�thode IP ';
$l_voting['time_after_voting_again'] = 'Temps avant de voter de nouveau';
$l_voting['cookie_method_help'] = 'Si vous pouvez utiliser la m�thode IP, choisissez-la. Considerez, que quelques utilisateurs, on peut-�tre desactiv�s les cookies dans leurs navigateurs. Cependant, webEdition emp�che la resoumission du m�me formulaire, bienque les cookies soient d�sactiv�s.';
$l_voting['ip_method_help'] = 'Si votre site a seulement un acc�s d&rsquo;Intranet et vos utilisateurs ne connectent pas par un serveur proxy, choisissez cette m�thode. Considerez, que quelques serveurs that some servers assignent des adresses IP addresses dynamiquement.';
$l_voting['time_after_voting_again_help'] = 'Pour emp�cher des votes multiples d&rsquo;un browser sp�cifique/IP dans une succession rapide, choisissez un temps appropri� avant qu&rsquo;un vote peut-�tre �ffectuer par ce navigateur. Si vous voulez qu&rsquo;un vote est �ffectue qu&rsquo;une fois par un navigateur/ordinateur sp�cifi�, choisissez \"jamais\".';

$l_voting['property'] = 'Propriet�s';
$l_voting['variant'] = 'Version'; // TRANSLATE
$l_voting['voting'] = 'Vote';
$l_voting['result'] = 'R�sultat';
$l_voting['group'] = 'Groupe';
$l_voting['name'] = 'Nom';
$l_voting['newFolder'] = 'Nouveau Groupe';
$l_voting['save_group_ok'] = 'Le Groupe a �t� enregistr�.';
$l_voting['save_ok'] = 'Le Vote a �t� enregistr�.';

$l_voting['path_nok'] = 'Le chemin est incorrect!';
$l_voting['name_empty'] = 'Le nom ne doit pas �tre vide!';
$l_voting['name_exists'] = 'Le nom existe d�j�!';
$l_voting['wrongtext'] = 'Le nom n&rsquo;est pas valid!';
$l_voting['voting_deleted'] = 'Le vote a �t� suprrim� avec succ�s.';
$l_voting['group_deleted'] = 'Le groupe a �t� supprim� avec succ�s.';

$l_voting['access'] = 'Acc�s';
$l_voting['limit_access'] = 'Limiter l&rsquo;acc�s';
$l_voting['limit_access_text'] = 'Permettre l&rsquo;access pour les utilisateur suivant';

$l_voting['variant_limit'] = 'Il faut qu&rsquo;il y a au moins une version dans l&rsquo;enqu�te!';
$l_voting['answer_limit'] = 'L&rsquo;enqu�te doit au moins contenir deux reponses!';

$l_voting['valid_txt'] = 'La case � chocher "active" doit �tre coch�, pour que le vote sur votre site est enregistr� et "d�publi�" � la fin de sa validit�. Determinez avec le menu d�roulant la date et le temps dans lequel le module de vote sera active. � partir de ce temps aucun vote sera accept�.';
$l_voting['active_till'] = 'Active jusqu&rsquo;�';
$l_voting['valid'] = 'Validit�';

$l_voting['export'] = 'Export'; // TRANSLATE
$l_voting['export_txt'] = 'Exporter les donn�es du dans un fichier csv( valeurs s�par�es par des virgules).';
$l_voting["csv_download"] = "T�l�charger le fichier CSV";
$l_voting["csv_export"] = "Le fichier '%s' a �t� enregistr�.";

$l_voting['fallback'] = 'M�thode IP Fallback';
$l_voting['save_user_agent'] = 'Enregistrer/Comparer les donn�es du agent-client';
$l_voting["save_changed_voting"] = "Voting has been changed.\\nDo you want to save your changes?"; // TRANSLATE
$l_voting['voting_log'] = 'Journal de Vote';
$l_voting['forbid_ip'] = 'Bloquer l\'adresse IP suivant';
$l_voting['until'] = 'jusqu\'�';
$l_voting['options'] = 'Options'; // TRANSLATE
$l_voting['control'] = 'Contr�le';
$l_voting['data_deleted_info'] = 'Les donn�es ont �t� supprim�es!';
$l_voting['time'] = 'Heure';
$l_voting['ip'] = 'IP'; // TRANSLATE
$l_voting['user_agent'] = 'Agent-Client';
$l_voting['cookie'] = 'Cookie'; // TRANSLATE
$l_voting['delete_ipdata_question'] = 'Vous voulez supprimer tous les donn�es d\'IP enregistr�. �tes-vous s�r?';
$l_voting['delete_log_question'] = 'Vous voulez supprimer tous les entr�es de journal de vote. �tes-vous s�r?';
$l_voting['delete_ipdata_text'] = 'Les donn�es d\'IP occupe %s octets de la m�moire. Supprimer-les, par utilisant le boutton \Supprimer\'. Considerez s\'il vous pla�t, que tous les donn�es d\'IP enregistr�es seront effac�es et pour cela des vote multiple seront possible.';
$l_voting['status'] = '�tat';
$l_voting['log_success'] = 'Succ�s';
$l_voting['log_error'] = 'Erreur';
$l_voting['log_error_active'] = 'Erreur: non active';
$l_voting['log_error_revote'] = 'Erreur: nouveau vote';
$l_voting['log_error_blackip'] = 'Erreur: IP bloqu�';
$l_voting['log_is_empty'] = 'Le journal est vide!';
$l_voting['enabled'] = 'Activ�';
$l_voting['disabled'] = 'Desactiv�';
$l_voting['log_fallback'] = 'Fallback'; // TRANSLATE

$l_voting['new_ip_add'] = 'S\'il vous pla�t saisissez une nouvelle adresse IP!';
$l_voting['not_valid_ip'] = 'Cette adresse IP n\'est pas valide';
$l_voting['not_active'] = 'The entered datum is in the past!'; // TRANSLATE

?>