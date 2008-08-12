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
$l_voting['delete_alert'] = 'Supprimer le vote/groupe actuel.\\n Êtes-vous sûr?';
$l_voting['result_delete_alert'] = 'Delete the current voting results.\\nAre you sure?'; // TRANSLATE
$l_voting['nothing_to_delete'] = 'Rien à supprimer!';
$l_voting['nothing_to_save'] = 'Rien à enregistrer';
$l_voting['we_filename_notValid'] = 'Le nom d&rsquo;utilisateur n&rsquo;est pas valide!\\nPermit sont les signe alpha-numerique, majuscule et minuscule, autant que le soulignage, le trait d&rsquo;union, le point et l&rsquo;éspace (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'Nouveau';
$l_voting['menu_save'] = 'Entregistrer';
$l_voting['menu_delete'] = 'Supprimer';
$l_voting['menu_exit'] = 'Fermer';
$l_voting['menu_info'] = 'Info'; // TRANSLATE
$l_voting['menu_help'] = 'Aide';
$l_voting['headline'] = 'Prénom et Noms';


$l_voting['headline_name'] = 'Nom';
$l_voting['headline_publish_date'] = 'Date de Création';
$l_voting['headline_data'] = 'Données d&rsquo;enquête';

$l_voting['publish_date'] = 'Date'; // TRANSLATE
$l_voting['publish_format'] = 'Format'; // TRANSLATE

$l_voting['published_on'] = 'Publié le';
$l_voting['total_voting'] = 'Vote total';
$l_voting['reset_scores'] = 'Remettre le score';

$l_voting['inquiry_question'] = 'Question'; // TRANSLATE
$l_voting['inquiry_answers'] = 'Réponse';

$l_voting['question_empty'] = 'La question est vide, s&rsquo;il vous plaît entrez une!';
$l_voting['answer_empty'] = 'Une ou plusieurs réponses sont vide, s&rsquo;il vous plaît entrez les réponses!';

$l_voting['invalid_score'] = 'La valeur du score doît être un numéro, essayez de nouveau s&rsquo;il vous plaît!';

$l_voting['headline_revote'] = 'Contôle de revote';
$l_voting['headline_help'] = 'Aide';

$l_voting['inquiry'] = 'Enquête';

$l_voting['browser_vote'] = 'Un navigateur ne peut pas voter de nouveau avant';
$l_voting['one_hour'] = '1 heure';
$l_voting['feethteen_minutes'] = '15 min.'; // TRANSLATE
$l_voting['thirthty_minutes'] = '30 min.'; // TRANSLATE
$l_voting['one_day'] = '1 jour';
$l_voting['never'] = '--jamais--';
$l_voting['always'] = '--toujours--';
$l_voting['cookie_method'] = 'Par méthode Cookie';
$l_voting['ip_method'] = 'Par méthode IP ';
$l_voting['time_after_voting_again'] = 'Temps avant de voter de nouveau';
$l_voting['cookie_method_help'] = 'Si vous pouvez utiliser la méthode IP, choisissez-la. Considerez, que quelques utilisateurs, on peut-être desactivés les cookies dans leurs navigateurs. Cependant, webEdition empêche la resoumission du même formulaire, bienque les cookies soient désactivés.';
$l_voting['ip_method_help'] = 'Si votre site a seulement un accès d&rsquo;Intranet et vos utilisateurs ne connectent pas par un serveur proxy, choisissez cette méthode. Considerez, que quelques serveurs that some servers assignent des adresses IP addresses dynamiquement.';
$l_voting['time_after_voting_again_help'] = 'Pour empêcher des votes multiples d&rsquo;un browser spécifique/IP dans une succession rapide, choisissez un temps approprié avant qu&rsquo;un vote peut-être éffectuer par ce navigateur. Si vous voulez qu&rsquo;un vote est éffectue qu&rsquo;une fois par un navigateur/ordinateur spécifié, choisissez \"jamais\".';

$l_voting['property'] = 'Proprietés';
$l_voting['variant'] = 'Version'; // TRANSLATE
$l_voting['voting'] = 'Vote';
$l_voting['result'] = 'Résultat';
$l_voting['group'] = 'Groupe';
$l_voting['name'] = 'Nom';
$l_voting['newFolder'] = 'Nouveau Groupe';
$l_voting['save_group_ok'] = 'Le Groupe a été enregistré.';
$l_voting['save_ok'] = 'Le Vote a été enregistré.';

$l_voting['path_nok'] = 'Le chemin est incorrect!';
$l_voting['name_empty'] = 'Le nom ne doit pas être vide!';
$l_voting['name_exists'] = 'Le nom existe déjà!';
$l_voting['wrongtext'] = 'Le nom n&rsquo;est pas valid!';
$l_voting['voting_deleted'] = 'Le vote a été suprrimé avec succès.';
$l_voting['group_deleted'] = 'Le groupe a été supprimé avec succès.';

$l_voting['access'] = 'Accès';
$l_voting['limit_access'] = 'Limiter l&rsquo;accès';
$l_voting['limit_access_text'] = 'Permettre l&rsquo;access pour les utilisateur suivant';

$l_voting['variant_limit'] = 'Il faut qu&rsquo;il y a au moins une version dans l&rsquo;enquête!';
$l_voting['answer_limit'] = 'L&rsquo;enquête doit au moins contenir deux reponses!';

$l_voting['valid_txt'] = 'La case à chocher "active" doit être coché, pour que le vote sur votre site est enregistré et "dépublié" à la fin de sa validité. Determinez avec le menu déroulant la date et le temps dans lequel le module de vote sera active. À partir de ce temps aucun vote sera accepté.';
$l_voting['active_till'] = 'Active jusqu&rsquo;à';
$l_voting['valid'] = 'Validité';

$l_voting['export'] = 'Export'; // TRANSLATE
$l_voting['export_txt'] = 'Exporter les données du dans un fichier csv( valeurs séparées par des virgules).';
$l_voting["csv_download"] = "Télécharger le fichier CSV";
$l_voting["csv_export"] = "Le fichier '%s' a été enregistré.";

$l_voting['fallback'] = 'Méthode IP Fallback';
$l_voting['save_user_agent'] = 'Enregistrer/Comparer les données du agent-client';
$l_voting["save_changed_voting"] = "Voting has been changed.\\nDo you want to save your changes?"; // TRANSLATE
$l_voting['voting_log'] = 'Journal de Vote';
$l_voting['forbid_ip'] = 'Bloquer l\'adresse IP suivant';
$l_voting['until'] = 'jusqu\'à';
$l_voting['options'] = 'Options'; // TRANSLATE
$l_voting['control'] = 'Contrôle';
$l_voting['data_deleted_info'] = 'Les données ont été supprimées!';
$l_voting['time'] = 'Heure';
$l_voting['ip'] = 'IP'; // TRANSLATE
$l_voting['user_agent'] = 'Agent-Client';
$l_voting['cookie'] = 'Cookie'; // TRANSLATE
$l_voting['delete_ipdata_question'] = 'Vous voulez supprimer tous les données d\'IP enregistré. Êtes-vous sûr?';
$l_voting['delete_log_question'] = 'Vous voulez supprimer tous les entrées de journal de vote. Êtes-vous sûr?';
$l_voting['delete_ipdata_text'] = 'Les données d\'IP occupe %s octets de la mémoire. Supprimer-les, par utilisant le boutton \Supprimer\'. Considerez s\'il vous plaît, que tous les données d\'IP enregistrées seront effacées et pour cela des vote multiple seront possible.';
$l_voting['status'] = 'État';
$l_voting['log_success'] = 'Succès';
$l_voting['log_error'] = 'Erreur';
$l_voting['log_error_active'] = 'Erreur: non active';
$l_voting['log_error_revote'] = 'Erreur: nouveau vote';
$l_voting['log_error_blackip'] = 'Erreur: IP bloqué';
$l_voting['log_is_empty'] = 'Le journal est vide!';
$l_voting['enabled'] = 'Activé';
$l_voting['disabled'] = 'Desactivé';
$l_voting['log_fallback'] = 'Fallback'; // TRANSLATE

$l_voting['new_ip_add'] = 'S\'il vous plaît saisissez une nouvelle adresse IP!';
$l_voting['not_valid_ip'] = 'Cette adresse IP n\'est pas valide';
$l_voting['not_active'] = 'The entered datum is in the past!'; // TRANSLATE

?>