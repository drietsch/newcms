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
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "����� ������"; // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "�������� ������!<br>�������� ���������� ��������� ���� ������ ��������� �����";
$GLOBALS["l_global"]["text"] = "�����";
$GLOBALS["l_global"]["yes"] = "��";
$GLOBALS["l_global"]["no"] = "���";
$GLOBALS["l_global"]["checked"] = "� ��������";
$GLOBALS["l_global"]["max_file_size"] = "������������ ������ ����� (� ������)";
$GLOBALS["l_global"]["default"] = "�� ���������";
$GLOBALS["l_global"]["values"] = "��������";
$GLOBALS["l_global"]["name"] = "���";
$GLOBALS["l_global"]["type"] = "���";
$GLOBALS["l_global"]["attributes"] = "��������";
$GLOBALS["l_global"]["formmailerror"] = "����� �� ���������� �� ��������� ��������:";
$GLOBALS["l_global"]["email_notallfields"] = "�� �� ��������� ��� ���� ������������ � ����������!";
$GLOBALS["l_global"]["email_ban"] = "�� �� ������������ ������������ ������ Script!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "����� ���������� ������ �������!";
$GLOBALS["l_global"]["email_no_recipient"] = "������ ���������� �� ����������!";
$GLOBALS["l_global"]["email_invalid"] = "��� ����������� <b>�����</b> ��������������!";
$GLOBALS["l_global"]["question"] = "������";
$GLOBALS["l_global"]["warning"] = "��������";
$GLOBALS["l_global"]["we_alert"] = "������ ������� �� ������ � ����-������ ������� webEdition!";
$GLOBALS["l_global"]["index_table"] = "������� ��������";
$GLOBALS["l_global"]["cannotconnect"] = "��� ���������� � �������� webEdition!";
$GLOBALS["l_global"]["recipients"] = "���������� ����� Formmail";
$GLOBALS["l_global"]["recipients_txt"] = "�������, ����������, ��� ����������� ������ ��� �������� ���� � ������� ������� Formmail (&lt;we:form type=&quot;formmail&quot; ..&gt;). ���� ����� �������� �� ������, ���������� ��������������� �������� �������� Formmail!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "������ ����� ������ %s ������ %s!";
$GLOBALS["l_global"]["std_subject_newObj"] = "����� ������";
$GLOBALS["l_global"]["std_subject_newDoc"] = "����� ��������";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "������ ����� �������� %s!";
$GLOBALS["l_global"]["std_subject_delObj"] = "������ ������";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "������ %s ������!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "�������� ������";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "�������� %s ������!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "����� ���������� ����� ��������";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "������ �� �������!";
$GLOBALS["l_global"]["save_temporaryTable"] = "������������� ��������� ���������";
$GLOBALS["l_global"]["save_mainTable"] = "������������� ������� ������� ���� ������";
$GLOBALS["l_global"]["add_workspace"] = "�������� ������� ������������";
$GLOBALS["l_global"]["folder_not_editable"] = "������ ���������� �� ����� ���� �������!";
$GLOBALS["l_global"]["modules"] = "������";
$GLOBALS["l_global"]["center"] = "���������";
$GLOBALS["l_global"]["jswin"] = "���� Popup";
$GLOBALS["l_global"]["open"] = "�������";
$GLOBALS["l_global"]["posx"] = "��������� x";
$GLOBALS["l_global"]["posy"] = "��������� y";
$GLOBALS["l_global"]["status"] = "Status"; // TRANSLATE
$GLOBALS["l_global"]["scrollbars"] = "Scrollbars";
$GLOBALS["l_global"]["menubar"] = "Menubar";
$GLOBALS["l_global"]["toolbar"] = "Toolbar"; // TRANSLATE
$GLOBALS["l_global"]["resizable"] = "Resizable"; // TRANSLATE
$GLOBALS["l_global"]["location"] = "Location"; // TRANSLATE
$GLOBALS["l_global"]["title"] = "�����/������";
$GLOBALS["l_global"]["description"] = "��������";
$GLOBALS["l_global"]["required_field"] = "������������ � ���������� ����";
$GLOBALS["l_global"]["from"] = "��"; 
$GLOBALS["l_global"]["to"] = "��";
$GLOBALS["l_global"]["search"]="�����";
$GLOBALS["l_global"]["in"]="�";
$GLOBALS["l_global"]["we_rebuild_at_save"] = "����������� (rebuild)";
$GLOBALS["l_global"]["we_publish_at_save"] = "����� ���������� ������������";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "New Document after saving"; // TRANSLATE
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving";
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving";
$GLOBALS["l_global"]["wrapcheck"] = "����� ������ (Wrapping)";
$GLOBALS["l_global"]["static_docs"] = "����������� ���������";
$GLOBALS["l_global"]["save_templates_before"] = "�������������� ������������� �������";
$GLOBALS["l_global"]["specify_docs"] = "��������� �� ���������� ����������:";
$GLOBALS["l_global"]["object_docs"] = "��� �������";
$GLOBALS["l_global"]["all_docs"] = "��� ���������";
$GLOBALS["l_global"]["ask_for_editor"] = "�������������� ��������� ��������";             
$GLOBALS["l_global"]["cockpit"] = "Cockpit"; // TRANSLATE
$GLOBALS["l_global"]["introduction"] = "��������";
$GLOBALS["l_global"]["doctypes"] = "���� ����������";
$GLOBALS["l_global"]["content"] = "����������";
$GLOBALS["l_global"]["site_not_exist"] = "�������� �� ����������!";
$GLOBALS["l_global"]["site_not_published"] = "�������� ��� �� ������������!";
$GLOBALS["l_global"]["required"] = "������� ������";
$GLOBALS["l_global"]["all_rights_reserved"] = "��� ����� ��������";
$GLOBALS["l_global"]["width"] = "������";
$GLOBALS["l_global"]["height"] = "������";
$GLOBALS["l_global"]["new_username"] = "����� ��� ������������";
$GLOBALS["l_global"]["username"] = "��� ������������";
$GLOBALS["l_global"]["password"] = "������";
$GLOBALS["l_global"]["documents"] = "���������";
$GLOBALS["l_global"]["templates"] = "�������";
$GLOBALS["l_global"]["objects"] = "Objects"; // TRANSLATE
$GLOBALS["l_global"]["licensed_to"] = "�������� ��������";
$GLOBALS["l_global"]["left"] = "�� ����� �������";
$GLOBALS["l_global"]["right"] = "�� ������ �������";
$GLOBALS["l_global"]["top"] = "�� ������� �������";
$GLOBALS["l_global"]["bottom"] = "�� ������ �������";
$GLOBALS["l_global"]["topleft"] = "�� ������ �������� ����";
$GLOBALS["l_global"]["topright"] = "�� ������� �������� ����";
$GLOBALS["l_global"]["bottomleft"] = "�� ������ ������� ����";
$GLOBALS["l_global"]["bottomright"] = "�� ������� �������� ����";
$GLOBALS["l_global"]["true"] = "��";
$GLOBALS["l_global"]["false"] = "���";
$GLOBALS["l_global"]["showall"] = "�������� ���";
$GLOBALS["l_global"]["noborder"] = "��� ������";
$GLOBALS["l_global"]["border"] = "�������";
$GLOBALS["l_global"]["align"] = "���������";
$GLOBALS["l_global"]["hspace"] = "�����������";
$GLOBALS["l_global"]["vspace"] = "���������";
$GLOBALS["l_global"]["exactfit"] = "Exactfit";
$GLOBALS["l_global"]["select_color"] = "�������� ����";
$GLOBALS["l_global"]["changeUsername"] = "�������� ��� ������������";
$GLOBALS["l_global"]["changePass"] = "�������� ������";
$GLOBALS["l_global"]["oldPass"] = "������ ������";
$GLOBALS["l_global"]["newPass"] = "����� ������";
$GLOBALS["l_global"]["newPass2"] = "��������� ����� ������";
$GLOBALS["l_global"]["pass_not_confirmed"] = "�������� ��������� ������ �� ������������� ������ ������, ��������� �����!";
$GLOBALS["l_global"]["pass_not_match"] = "������ ������ ������ �������!";
$GLOBALS["l_global"]["passwd_not_match"] = "������ ������ �������!";
$GLOBALS["l_global"]["pass_to_short"] = "������ ������ ��������� �� ����� 4 ��������!";
$GLOBALS["l_global"]["pass_changed"] = "������ ������� �������!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "������ ������ ��������� ������ ����� ���������� �������� � ����� (a-z, A-Z � 0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Username may only contain alpha-numeric characters (a-z, A-Z and 0-9) and '.', '_' or '-'!"; // TRANSLATE
$GLOBALS["l_global"]["all"] = "���";
$GLOBALS["l_global"]["selected"] = "��������";
$GLOBALS["l_global"]["username_to_short"] = "��� ������������ ������ ��������� �� ����� 4 ��������!";
$GLOBALS["l_global"]["username_changed"] = "��� ������������ ������� ��������!";
$GLOBALS["l_global"]["published"] = "������������";
$GLOBALS["l_global"]["help_welcome"] = "����� ���������� � ������ ������ webEdition!";
$GLOBALS["l_global"]["edit_file"] = "������������� ����";
$GLOBALS["l_global"]["docs_saved"] = "��������� ������� ���������!";
$GLOBALS["l_global"]["preview"] = "��������������� ��������";
$GLOBALS["l_global"]["close"] = "������� ����";
$GLOBALS["l_global"]["loginok"] =  "<strong>Login ok! ����������, ���������!</strong><br>webEdition ��������� � ����� ����. � ������, ���� ����� �� ���������, ��������� � ���, ��� �� �� ������������� ���� pop-up � ����� ��������!";
$GLOBALS["l_global"]["apple"] = "&#x2318;"; // TRANSLATE
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "CTRL"; // TRANSLATE
$GLOBALS["l_global"]["required_fields"] = "����, ������������ � ����������";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">�� ������ ������ �������� ��� �� ��������.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "�������/�������";
$GLOBALS["l_global"]["rebuild"] = "�����������";
$GLOBALS["l_global"]["welcome_to_we"] = "����� ���������� � webEdition 3!";
$GLOBALS["l_global"]["tofit"] = "����� ���������� � webEdition 3!";
$GLOBALS["l_global"]["unlocking_document"] = "���� ������ � ���������";
$GLOBALS["l_global"]["variant_field"] = "���� ��������";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Please press the following link, if you are not redirected within the next 30 seconds "; // TRANSLATE
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition login"; // TRANSLATE
?>