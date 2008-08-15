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
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: English
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["noRightsToDelete"] = "\\'%s\\' cannot be deleted! You do not have permission to perform this action!";
$l_alert["noRightsToMove"] = "\\'%s\\' cannot be moved! You do not have permission to perform this action!"; // TRANSLATE
$l_alert[FILE_TABLE]["in_wf_warning"] = "Перед передачей данного документа в поток, его нужно сохранить!\\nСохранить документ?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Перед передачей данного объекта в поток, его нужно сохранить!\\nСохранить объект?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "Перед передачей данного класса в поток его нужно сохранить!\\nСохранить класс?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Перед передачей данного шаблона в поток его нужно сохранить!\\nСохранить шаблон?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Данный файл не из Вашего рабочего пространства!";
$l_alert["folder"]["not_im_ws"] = "Данная директория не из Вашего рабочего пространства!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Данный шаблон не из Вашего рабочего пространства!";
$l_alert["delete_recipient"] = "Вы уверены, что хотите удалить выбранный электронный адрес?";
$l_alert["recipient_exists"] = "Электронный адрес уже существует!";
$l_alert["input_name"] = "Введите новый электронный адрес!";
$l_alert['input_file_name'] = "Enter a filename."; // TRANSLATE
$l_alert["max_name_recipient"] = "Электронный адрес должен содержать не более 255 символов!";
$l_alert["not_entered_recipient"] = "Не введен электронный адрес!";
$l_alert["recipient_new_name"] = "Изменить электронный адрес!";
$l_alert["no_new"]["objectFile"] = "Вы не уполномочены создавать новые объекты!<br>У Вас либо нет соответствующего  полномочия,  либо отсутствует класс, в котором действительны Ваши рабочие пространства!";
$l_alert["required_field_alert"] = "Данное поле '%s' обязательно к заполнению!";
$l_alert["phpError"] = "Невозможно запустить систему webEdition";
$l_alert["3timesLoginError"] = "LogIn был введен %s раз неверно! Пожалуйста, подождите %s минут(ы) и попробуйте вновь!";
$l_alert["popupLoginError"] = "Невозможно открыть окно webEdition!\\n\\nСистема webEdition может быть запущена только при условии, если Ваш браузер не блокирует окна pop-up.";
$l_alert['publish_when_not_saved_message'] = "Документ еще не сохранен! Вы все же хотите его опубликовать?";
$l_alert["template_in_use"] = "Данный шаблон в работе и не может быть удален!";
$l_alert["no_cookies"] = "Вы не активировали cookies. Активируйте, пожалуйста, cookies в Вашем браузере!";
$l_alert["doctype_hochkomma"] = "Имя неверно! Имя типа документа не должно содержать апострофов ' и запятых , !";
$l_alert["thumbnail_hochkomma"] = "Недопустимое имя иконки! Такие символы как апостроф ' и запятая , являются недействительными!";
$l_alert["can_not_open_file"] = "Файл %s невозможно открыть!";
$l_alert["no_perms_title"] = "Нет полномочий!";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "В доступе отказано!";
$l_alert["no_perms"] = "Для получения доступа обратитесь, пожалуйста, к владельцу лицензии (%s)<br> или к администратору! <br>";
$l_alert["temporaere_no_access"] = "Доступ невозможен";
$l_alert["temporaere_no_access_text"] = "В настоящий момент файл \"%s\" редактирует \"%s\".";
$l_alert["file_locked_footer"] = "В настоящий момент данный документ редактирует \"%s\".";
$l_alert["file_no_save_footer"] = "У Вас нет полномочий на сохранение данного файла.";
$l_alert["login_failed"] = "Неверное имя пользователя и/или пароль!";
$l_alert["login_failed_security"] = "Старт системы webEdition отменен!\\n\\nПревышены временные рамки, отведенные для входа в систему, и, по соображениям безопасности, процесс входа в систему был прерван.\\n\\nОсуществите новый вход в систему.";
$l_alert["perms_no_permissions"] = "У Вас нет разрешения на эту операцию!";
$l_alert["no_image"] = "Выбранный Вами файл не относится к графике!";
$l_alert["delete_ok"] = "Файлы или директории успешно удалены!";
$l_alert["nothing_to_delete"] = "Ничего не выделено для удаления!";
$l_alert["delete"] = "Удалить выбранные данные.\\nВы уверены?";
$l_alert["delete_folder"] = "Удалить выбранную директорию?\\nВнимание: при удалении директории все ее содержимое (документы и поддиректории) будут автоматически удалены!";
$l_alert["delete_nok_error"] = "Файл '%s' не может быть удален.";
$l_alert["delete_nok_file"] = "Файл '%s' не может быть удален.\\nВероятно, он защищен.";
$l_alert["delete_nok_folder"] = "Директория '%s' не может быть удалена.\\nВероятно, она защищена.";
$l_alert["delete_nok_noexist"] = "Файл '%s' не существует!";
$l_alert["noResourceTitle"] = "No Item!";
$l_alert["noResource"] = "The document or directory does not exist!";
$l_alert["move"] = "Move selected entries?\\nDo you want to continue?"; // TRANSLATE
$l_alert["move_ok"] = "Files successfully moved!"; // TRANSLATE
$l_alert["move_duplicate"] = "There are files with the same name in the target directory!\\nThe files cannot be moved."; // TRANSLATE
$l_alert["move_nofolder"] = "The selected files cannot be moved.\\nIt isn't possible to move directories."; // TRANSLATE
$l_alert["move_onlysametype"] = "The selected objects cannnot be moved.\\nObjects can only be moved in there own classdirectory."; // TRANSLATE
$l_alert["move_no_dir"] = "Please choose a target directory!"; // TRANSLATE
$l_alert["nothing_to_move"] = "There is nothing marked to move!"; // TRANSLATE
$l_alert["move_of_files_failed"] = "One or more files couldn't moved! Please move these files manually.\\nThe following files are affected:\\n%s"; // TRANSLATE
$l_alert["template_save_warning"] = "This template is used by %s published documents. Should they be resaved? Attention: This procedure may take some time if you have many documents!"; // TRANSLATE
$l_alert["template_save_warning1"] = "This template is used by one published document. Should it be resaved?"; // TRANSLATE
$l_alert["template_save_warning2"] = "This template is used by other templates and documents, should they be resaved?"; // TRANSLATE
$l_alert["thumbnail_exists"] = 'Данная иконка уже существует!';
$l_alert["thumbnail_not_exists"] = 'Данная иконка отсутствует!';
$l_alert["doctype_exists"] = "Данный тип документов уже существует!";
$l_alert["doctype_empty"] = "Введите имя для нового типа документов!";
$l_alert["delete_cat"] = "Вы уверены, что хотите удалить выбранную категорию?";
$l_alert["delete_cat_used"] = "Данная категория - действующая и не может быть удалена!";
$l_alert["cat_exists"] = "Категория уже существует!";
$l_alert["cat_changed"] = "Категория в действии! Пересохраните документы, использующие эту категорию!\\nИзменить данную категорию?";
$l_alert["max_name_cat"] = "Имя категории должно содержать не более 32 символов!";
$l_alert["not_entered_cat"] = "Не введено имя категории!";
$l_alert["cat_new_name"] = "Введите новое имя категории!";
$l_alert["we_backup_import_upload_err"] = "Ошибка при загрузке резервного файла! Максимально допустимый размер файла для загрузки составляет %s. Если размер Вашего резервного файла превышает этот предел, загрузите его в директорию webEdition/we_Backup при помощи FTP и выберите '".$l_backup["import_from_server"]."'";
$l_alert["rebuild_nodocs"] = "Не существует документов, соответствующих выбранным критериям.";
$l_alert["we_name_not_allowed"] = "Имена 'we' и 'webEdition' зарезервированы для использования самой системой и не могут употребляться для других целей!";
$l_alert["we_filename_empty"] = "Не введено имя для этого документа или директории!";
$l_alert["exit_doc_question_".FILE_TABLE] = "Данный документ, по-видимому, был изменен. Сохранить Ваши изменения? <BR>";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Данный шаблон, по-видимому, был изменен. Сохранить Ваши изменения?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "Данный класс, по-видимому, был изменен. Сохранить Ваши изменения?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Данный объект, по-видимому, был изменен. Сохранить Ваши изменения?";
}
$l_alert["deleteTempl_notok_used"] = "Один или несколько шаблонов находятся в обработке и не могут быть удалены!";
$l_alert["delete_notok"] = "Ошибка при удалении!";
$l_alert["nothing_to_save"] = "Функция сохранения в данный момент не действует!";
$l_alert["we_filename_notValid"] = "Недопустимое имя файла\\nДопустимые символы латинского алфавита от а до z, большие и малые, цифры, нижняя черта _, дефис -, точка . (a-z, A-Z, 0-9, _, -, .).";
$l_alert["empty_image_to_save"] = "Выбранное графическое изображение отсутствует.\\n Продолжить?";
$l_alert["path_exists"] = "Данный файл или документ %s не сохранен, так как другой документ уже существует в том же месте!";
$l_alert["folder_not_empty"] = "В связи с тем, что одна или несколько директорий не полностью очищены от содержимого, их нельзя было полностью удалить! Удалите следующие файлы вручную: \\n%s";
$l_alert["name_nok"] = "Имена не должны содержать символов '<' и '>'!";
$l_alert["found_in_workflow"] = "Выбранные к удалению данные находятся в потоке! Удалить их из потока?";
$l_alert["import_we_dirs"] = "Попытка импортировать данные одной из системных директорий webEdition!\\n Эти директории защищены для использования системой webEdition, поэтому они не могут быть импортированы!";
$l_alert["wrong_file"]["image/*"] = "Невозможно сохранить файл. Он либо не относится к графическим файлам, либо недостаточно пространства в сети!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Невозможно сохранить файл.  Он либо не относится к Flash фильмам, либо недостаточно места на диске!";
$l_alert["wrong_file"]["video/quicktime"] = "Невозможно сохранить файл. Он либо не относится к фильмам Quicktime, либо не хватает места на диске!";
$l_alert["no_file_selected"] = "Не выбраны файлы к загрузке!";
$l_alert["browser_crashed"] = "Невозможно открыть окно: ошибка, вызванная браузером! Сохраните, пожалуйста, Ваши документы/страницы и перезапустите браузер";
$l_alert["copy_folders_no_id"] = "Вначале сохраните, пожалуйста, текущую директорию!";
$l_alert["copy_folder_not_valid"] =  "Нельзя копировать одну и ту же директорию или родительскую директорию!";
$l_alert['no_views']['headline'] = 'Attention'; // TRANSLATE
$l_alert['no_views']['description'] = 'Нельзя просмотреть данный документ в режиме "вид".';
$l_alert['navigation']['last_document'] = 'You edit the last document.'; // TRANSLATE
$l_alert['navigation']['first_document'] = 'Вы редактируете первый документ.';
$l_alert['navigation']['doc_not_found'] = 'Could not find matching document.'; // TRANSLATE
$l_alert['navigation']['no_entry'] = 'No entry found in history.'; // TRANSLATE
$l_alert['delete_single']['confirm_delete'] = 'Удалить данный документ?';
$l_alert['delete_single']['no_delete'] = 'This document could not be deleted.'; // TRANSLATE
$l_alert['delete_single']['return_to_start'] = 'Документ успешно удален.\\nНазад к главному документу режима супер (seeMode).';
$l_alert['move_single']['return_to_start'] = 'The document was moved. \\nBack to seeMode startdocument.'; // TRANSLATE
$l_alert['move_single']['no_delete'] = 'This document could not be moved'; // TRANSLATE
$l_alert['cockpit_not_activated'] = 'The action could not be performed because the cockpit is not activated.'; //TRANSLATE
$l_alert['cockpit_reset_settings'] = 'Are you sure to delete the current Cockpit settings and reset the default settings?'; //TRANSLATE
$l_alert['no_cockpit_mode'] = 'Please, switch to the cockpit to add a new widget.'; // TRANSLATE
$l_alert['error_fields_value_not_valid'] = 'Invalid entries in input fields!';
?>