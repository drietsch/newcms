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

$l_voting = array();
$l_voting['no_perms'] = 'You do not have permission to use this option.';
$l_voting['delete_alert'] = 'Delete the current voting/group.\\nAre you sure?';
$l_voting['result_delete_alert'] = 'Delete the current voting results.\\nAre you sure?';
$l_voting['nothing_to_delete'] = 'There is nothing to delete!';
$l_voting['nothing_to_save'] = 'There is nothing to save';
$l_voting['we_filename_notValid'] = 'Invalid user name!\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen, dot and whitespace (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'New';
$l_voting['menu_save'] = 'Save';
$l_voting['menu_delete'] = 'Delete';
$l_voting['menu_exit'] = 'Close';
$l_voting['menu_info'] = 'Info';
$l_voting['menu_help'] = 'Help';
$l_voting['headline'] = 'Names and Last Names';


$l_voting['headline_name'] = 'Name';
$l_voting['headline_publish_date'] = 'Create Date';
$l_voting['headline_data'] = 'Inquiry Data';

$l_voting['publish_date'] = 'Date';
$l_voting['publish_format'] = 'Format';

$l_voting['published_on'] = 'Published on';
$l_voting['total_voting'] = 'Total voting';
$l_voting['reset_scores'] = 'Reset score';

$l_voting['inquiry_question'] = 'Question';
$l_voting['inquiry_answers'] = 'Answers';

$l_voting['question_empty'] = 'The question is empty, please enter one!';
$l_voting['answer_empty'] = 'One or more answers are empty, please enter answer(s)!';

$l_voting['invalid_score'] = 'The score value must be a number, please try again!';

$l_voting['headline_revote'] = 'Re-vote Control';
$l_voting['headline_help'] = 'Help';

$l_voting['inquiry'] = 'Inquiry';

$l_voting['browser_vote'] = 'A browser can not vote again before';
$l_voting['one_hour'] = '1 hour';
$l_voting['feethteen_minutes'] = '15 min.';
$l_voting['thirthty_minutes'] = '30 min.';
$l_voting['one_day'] = '1 day';
$l_voting['never'] = '--never--';
$l_voting['always'] = '--always--';
$l_voting['cookie_method'] = 'By Cookie Method';
$l_voting['ip_method'] = 'By IP Method';
$l_voting['time_after_voting_again'] = 'Time before voting again';
$l_voting['cookie_method_help'] = 'Use this method, if you do not want/are not able to use the IP method. Please keep in mind, that users might deactivate coockies in their browsers. The "Fallback IP method" option requires the use of the <we:cookie> tag in the template.';
$l_voting['ip_method_help'] = 'If your web site is part of an Intranet and your users do not connect through a proxy then select this method. Consider that some servers assign IP addresses dynamically.';
$l_voting['time_after_voting_again_help'] = 'To prevent multiple votes from one specific browser/IP in fast succession, choose an appropriate time before a vote can be made from that browser. If you want a vote to be cast from a specific browser/computer only once, then select \"never\".';

$l_voting['property'] = 'Properties';
$l_voting['variant'] = 'Version';
$l_voting['voting'] = 'Voting';
$l_voting['result'] = 'Result';
$l_voting['group'] = 'Group';
$l_voting['name'] = 'Name';
$l_voting['newFolder'] = 'New Group';
$l_voting['save_group_ok'] = 'Group has been saved.';
$l_voting['save_ok'] = 'Voting has been saved.';

$l_voting['path_nok'] = 'The path is incorrect!';
$l_voting['name_empty'] = 'The name may not be empty!';
$l_voting['name_exists'] = 'Name already exists!';
$l_voting['wrongtext'] = 'Name is not valid!';
$l_voting['voting_deleted'] = 'Voting has been successfully deleted.';
$l_voting['group_deleted'] = 'Group has been successfully deleted.';

$l_voting['access'] = 'Access';
$l_voting['limit_access'] = 'Limit access';
$l_voting['limit_access_text'] = 'Allow access for following users';

$l_voting['variant_limit'] = 'It must exist at least one version in the inquiry!';
$l_voting['answer_limit'] = 'The inquiry must consist of at least two answers!';

$l_voting['valid_txt'] = 'The checkbox "Active Until" must be checked, so that the voting on your page is saved and "parked" at the end of its validity. Select with the dropdown menu the date and time to which the voting should run. No more votes are accepted after this time.';
$l_voting['active_till'] = 'Active Until';
$l_voting['valid'] = 'Validity';

$l_voting['export'] = 'Export';
$l_voting['export_txt'] = 'Export voting data to a CSV file (comma separated values).';
$l_voting["csv_download"] = "Download CSV file";
$l_voting["csv_export"] = "File '%s' has been saved.";

$l_voting['fallback'] = 'Fallback IP method';
$l_voting['save_user_agent'] = 'Save/Compare data of the user-agent';
$l_voting["save_changed_voting"] = "Voting has been changed.\\nDo you want to save your changes?";
$l_voting['voting_log'] = 'Protocol Vote';
$l_voting['forbid_ip'] = 'Suspend following IP address';
$l_voting['until'] = 'until';
$l_voting['options'] = 'Options';
$l_voting['control'] = 'Control';
$l_voting['data_deleted_info'] = 'The data has been deleted!';
$l_voting['time'] = 'Time';
$l_voting['ip'] = 'IP';
$l_voting['user_agent'] = 'User-agent';
$l_voting['cookie'] = 'Cookie';
$l_voting['delete_ipdata_question'] = 'You want to delete all saved IP data. Are you sure?';
$l_voting['delete_log_question'] = 'You want to delete all Voting Log entries.  Are you sure?';
$l_voting['delete_ipdata_text'] = 'The saved  IP data occupy %s Bytes of the memory. Delete them by using the \Delete\' button. Please consider, that all saved IP data will be ereased and therefore iterate votings will be possible.';
$l_voting['status'] = 'Status';
$l_voting['log_success'] = 'Success';
$l_voting['log_error'] = 'Error';
$l_voting['log_error_active'] = 'Error: not active';
$l_voting['log_error_revote'] = 'Error: new vote';
$l_voting['log_error_blackip'] = 'Error: suspended IP';
$l_voting['log_is_empty'] = 'The log is empty!';
$l_voting['enabled'] = 'Activated';
$l_voting['disabled'] = 'Deactivated';
$l_voting['log_fallback'] = 'Fallback';

$l_voting['new_ip_add'] = 'Please enter the new IP address!';
$l_voting['not_valid_ip'] = 'The IP address is not valid';
$l_voting['not_active'] = 'The entered datum is in the past!';

?>