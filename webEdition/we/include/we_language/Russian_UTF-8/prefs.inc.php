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
 * Language file: prefs.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_prefs["preload"] = "Загружаются настройки, подождите, пожалуйста";
$l_prefs["preload_wait"] = "Загрузка настроек";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "Сохраняются настройки, подождите, пожалуйста";
$l_prefs["save_wait"] = "Сохранение настроек";

$l_prefs["saved"] = "Сохранение настроек прошло успешно";
$l_prefs["saved_successfully"] = "Настройки сохранены";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "Пользовательский интерфейс";
$l_prefs["tab_extensions"] = "Расширения файлов";
$l_prefs["tab_editor"] = 'Редактор';
$l_prefs["tab_formmail"] = 'Formmail';
$l_prefs["formmail_recipients"] = 'Получатели Formmail';
$l_prefs["tab_proxy"] = 'Proxy-сервер';
$l_prefs["tab_advanced"] = 'Специальные настройки';
$l_prefs["tab_system"] = 'Система';
$l_prefs["tab_error_handling"] = 'Ошибки';
$l_prefs["tab_cockpit"] = 'Cockpit'; // TRANSLATE
$l_prefs["tab_modules"] = 'Модули';

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Язык";
	$l_prefs["language_notice"] = "The language change will only take effect everywhere after restarting webEdition.";

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "Суперлегкий режим";
	$l_prefs["seem_deactivate"] = "Деактивировать режим";
	$l_prefs["seem_startdocument"] = "Стартовый документ режима";
	$l_prefs["question_change_to_seem_start"] = "Перейти к выбранному документу?";

	/**
	 * WINDOW DIMENSION
	 */

	$l_prefs["dimension"] = "Размер окна";
	$l_prefs["maximize"] = "Максимизировать";
	$l_prefs["specify"] = "Установить";
	$l_prefs["width"] = "Ширина";
	$l_prefs["height"] = "Высота";
	$l_prefs["predefined"] = "Заданные размеры";
	$l_prefs["show_predefined"] = "Показать заданные размеры";
	$l_prefs["hide_predefined"] = "Скрыть заданные размеры";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Меню дерева";
	$l_prefs["all"] = "Все";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */

	$l_prefs["we_extensions"] = "Расширения webEdition";
	$l_prefs["static"] = "Статические страницы";
	$l_prefs["dynamic"] = "Динамические страницы";
	$l_prefs["html_extensions"] = "Расширения HTML";
	$l_prefs["html"] = "Страницы HTML";

/*****************************************************************************
 * COCKPIT
 *****************************************************************************/

	/**
	 * Cockpit
	 */

	$l_prefs["cockpit_amount_columns"] = "Columns in the cockpit "; // TRANSLATE

/*****************************************************************************
 * EDITOR
 *****************************************************************************/

	/**
	 * EDITOR PLUGIN
	 */

	$l_prefs["editor_plugin"] = 'Редактор-плагин';
	$l_prefs["use_it"] = "Применить";
	$l_prefs["start_automatic"] = "Автоматический запуск";
	$l_prefs["ask_at_start"] = 'При запуске спрашивать<br>какой редактор применить';
	$l_prefs["must_register"] = 'Должен быть зарегистрирован';
	$l_prefs["change_only_in_ie"] = 'Данные настройки нельзя изменить. Редактор-плагин работает с Internet Explorer только версии Windows.';
	$l_prefs["install_plugin"] = 'Использование редактора-плагин в Вашем браузере зависит от наличия установленного плагина Mozilla ActiveX.';
	$l_prefs["confirm_install_plugin"] = 'Плагин Mozilla ActiveX позволяет интеграцию ActiveX Controls в браузере Mozilla. После инсталляции плагина нужно заново запустить браузер.\\n\\nПримите во внимание: ActiveX может представлять угрозу безопасности!\\n\\nПродолжить инсталляцию?';

	$l_prefs["install_editor_plugin"] = 'Вначале нужно инсталлировать модуль редактора-плагин webEdition.';
	$l_prefs["install_editor_plugin_text"]= 'Редактор-плагин в процессе инсталляции...';

	/**
	 * TEMPLATE EDITOR
	 */

	$l_prefs["editor_font"] = 'Шрифт в редакторе';
	$l_prefs["editor_fontname"] = 'Название шрифта';
	$l_prefs["editor_fontsize"] = 'Размер шрифта';
	$l_prefs["editor_dimension"] = 'Размер редактора';
	$l_prefs["editor_dimension_normal"] = 'По умолчанию';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Введите, пожалуйста, адреса электронной почты всех получателей форм, рассылаемых с помощью функции formmail (&lt;we:form&nbsp;type=\"formmail\"&nbsp;..&gt;).<br><br>Если адрес email не введен, рассылкой форм с использованием функции formmail воспользоваться нельзя!";

	$l_prefs["formmail_log"] = "Formmail log"; // TRANSLATE
	$l_prefs['log_is_empty'] = "The log is empty!"; // TRANSLATE
	$l_prefs['ip_address'] = "IP address"; // TRANSLATE
	$l_prefs['blocked_until'] = "Blocked until"; // TRANSLATE
	$l_prefs['unblock'] = "Unblock"; // TRANSLATE
	$l_prefs['clear_log_question'] = "Do you really want to clear the log?"; // TRANSLATE
	$l_prefs['clear_block_entry_question'] = "Do you really want to unblock the IP %s ?"; // TRANSLATE
	$l_prefs["forever"] = "Always"; // TRANSLATE
	$l_prefs["yes"] = "yes"; // TRANSLATE
	$l_prefs["no"] = "no"; // TRANSLATE
	$l_prefs["on"] = "on"; // TRANSLATE
	$l_prefs["off"] = "off"; // TRANSLATE
	$l_prefs["formmailConfirm"] = "Formmail confirmation function"; // TRANSLATE
	$l_prefs["logFormmailRequests"] = "Log formmail requests"; // TRANSLATE
	$l_prefs["deleteEntriesOlder"] = "Delete entries older than"; // TRANSLATE
	$l_prefs["blockFormmail"] = "Limit formmail requests"; // TRANSLATE
	$l_prefs["formmailSpan"] = "Within the span of time"; // TRANSLATE
	$l_prefs["formmailTrials"] = "Requests allowed"; // TRANSLATE
	$l_prefs["blockFor"] = "Block for"; // TRANSLATE
	$l_prefs["never"] = "never"; // TRANSLATE
	$l_prefs["1_day"] = "1 day"; // TRANSLATE
	$l_prefs["more_days"] = "%s days"; // TRANSLATE
	$l_prefs["1_week"] = "1 week"; // TRANSLATE
	$l_prefs["more_weeks"] = "%s weeks"; // TRANSLATE
	$l_prefs["1_minute"] = "1 minute"; // TRANSLATE
	$l_prefs["more_minutes"] = "%s minutes"; // TRANSLATE
	$l_prefs["1_hour"] = "1 hour"; // TRANSLATE
	$l_prefs["more_hours"] = "%s hours"; // TRANSLATE
	$l_prefs["ever"] = "always"; // TRANSLATE

/*****************************************************************************
 * PROXY SERVER
 *****************************************************************************/

	/**
	 * PROXY SERVER
	 */

	$l_prefs["useproxy"] = "Для онлайн обновления<br>использовать proxy-сервер";
	$l_prefs["proxyaddr"] = "Адрес";
	$l_prefs["proxyport"] = "Порт";
	$l_prefs["proxyuser"] = "Имя пользователя";
	$l_prefs["proxypass"] = "Пароль";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "Настройки по умолчанию для<br><em>php</em>-атрибута в we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "Значение по умолчанию <br><em>inlineedit</em> атрибута в<br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "Редактировать текстовые поля в документе (<em>true</em>) или в новом окне<br/>браузера (<em>false</em>)";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "Воспользуйтесь редактором<br>Wysiwyg (beta-версии) Safari";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "Значение по умолчанию <br><em>showinputs</em> атрибута в<br>&lt;we:img&gt;";

	/**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "Тип соединений<br>базы данных";

	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "Аутентификация HTTP";
	$l_prefs["useauth"] = "Сервер использует<br>аутентификацию HTTP<br>в директории webEdition";
	$l_prefs["authuser"] = "Имя пользователя";
	$l_prefs["authpass"] = "Пароль";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Thumbnail directory"; // TRANSLATE

	$l_prefs["pagelogger_dir"] = "директория pageLogger";

/*****************************************************************************
 * ERROR HANDLING
 *****************************************************************************/


	$l_prefs['error_no_object_found'] = 'Errorpage for not existing objects'; // TRANSLATE
	/**
	 * ERROR HANDLER
	 */

	$l_prefs["error_use_handler"] = "Активация устранения ошибок";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "Ошибки для устранения";
	$l_prefs["error_notices"] = "Примечания";
	$l_prefs["error_warnings"] = "Предостережения";
	$l_prefs["error_errors"] = "Ошибки";

	$l_prefs["error_notices_warning"] = 'Option for developers! Do not activate on live-systems.'; // TRANSLATE

	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "Вывод ошибок на экран";
	$l_prefs["error_display"] = "Показывать ошибки";
	$l_prefs["error_log"] = "Сделать запись об ошибках";
	$l_prefs["error_mail"] = "Отправить сообщение";
	$l_prefs["error_mail_address"] = "Адрес";
	$l_prefs["error_mail_not_saved"] = 'Адрес введен неправильно: ошибки не будут отправлены по этому адресу!\n\nОстальные настройки успешно сохранены.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "Показывать профессиональные настройки";
	$l_prefs["hide_expert"] = "Скрыть профессиональные настройки";
	$l_prefs["show_debug_frame"] = "Показывать debug frame";
	$l_prefs["debug_normal"] = "В обычном режиме";
	$l_prefs["debug_seem"] = "Суперлегкое редактирование";
	$l_prefs["debug_restart"] = "При изменениях: перезапуск";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "База данных/объект";
	$l_prefs["tree_count"] = "Количество выводимых на экран объектов";
	$l_prefs["tree_count_description"] = "Данная величина задает максимальное количество объектов, выводимых на экран в  навигации слева";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"] = "Backup"; // TRANSLATE
	$l_prefs["backup_slow"] = "Slow"; // TRANSLATE
	$l_prefs["backup_fast"] = "Fast"; // TRANSLATE
	$l_prefs["performance"] = "Here you can set an appropriate performance level. The performance level should be adequate to the server system. If the system has limited resources (memory, timeout etc.) choose a slow level, otherwise choose a fast level."; // TRANSLATE
	$l_prefs["backup_auto"]="автоматический";

/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='Проверка';
	$l_prefs['xhtml_default'] = 'Значение по умолчанию для данного атрибута <em>xml</em> в тегах we:Tags';
	$l_prefs['xhtml_debug_explanation'] = 'Приложение по удалению неисправностей для xhtml помогает в разработке веб-сайта, который должен характеризоваться как «xhtml valid». Теги we:Tag проверяются на действительность, неверные атрибуты при этом высвечиваются или удаляются. Примите во внимание: операция по удалению неисправностей занимает некоторое время. Рекомендуется активировать данное приложение по удалению неисправностей только при разработке веб-сайта.';
	$l_prefs['xhtml_debug_headline'] = 'Удаление неисправностей XHTML';
	$l_prefs['xhtml_debug_html'] = 'Активировать удаление неисправностей XHTML';
	$l_prefs['xhtml_remove_wrong'] = 'Удалить неверные атрибуты';
	$l_prefs['xhtml_show_wrong_headline'] = 'Оповещение при наличии неверных атрибутов';
	$l_prefs['xhtml_show_wrong_html'] = 'Активировать';
	$l_prefs['xhtml_show_wrong_text_html'] = 'Как текст';
	$l_prefs['xhtml_show_wrong_js_html'] = 'Как JavaScript-Alert';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'Запись ошибок (PHP)';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="Максимально возможный объем <br>отображаемый в подсказке";
	$l_prefs["we_max_upload_size_hint"]="(в MByte, 0=automatic)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Права доступа к<br>новым директориям";
	$l_prefs["we_new_folder_mod_hint"]="(по умолчанию 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "Директория по умолчанию данного типа документа должна быть расположена в рабочей области пользователя, для предоставления ему возможности выбора соответствующего типа документа.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "Рабочая область данного пользователя должна быть расположена в директории по умолчанию, заданной в типе документа пользователя, имеющего право выбора типа документа.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "инверсное ";
   $l_prefs["we_doctype_workspace_behavior_0"] = "стандартное";
   $l_prefs["we_doctype_workspace_behavior"] = "Поведение выбранного типа документа";


/*****************************************************************************
 * jupload
 *****************************************************************************/

	$l_prefs['use_jupload'] = 'Use java upload'; // TRANSLATE

/*****************************************************************************
 * message_reporting
 *****************************************************************************/
	$l_prefs["message_reporting"]["information"] = "You can decide on the respective check boxes whether you like to receive a notice for webEdition operations as for example saving, publishing or deleting."; // TRANSLATE
	
	$l_prefs["message_reporting"]["headline"] = "Notifications"; // TRANSLATE
	$l_prefs["message_reporting"]["show_notices"] = "Show Notices"; // TRANSLATE
	$l_prefs["message_reporting"]["show_warnings"] = "Show Warnings"; // TRANSLATE
	$l_prefs["message_reporting"]["show_errors"] = "Show Errors"; // TRANSLATE


/*****************************************************************************
 * Module Activation
 *****************************************************************************/
	$l_prefs["module_activation"]["information"] = "Here you can activate or deactivate your modules if you do not need them.<br /><br />Deactivated modules improve the overall performance of webEdition."; // TRANSLATE
	
	$l_prefs["module_activation"]["headline"] = "Module activation"; // TRANSLATE

/*****************************************************************************
 * Email settings
 *****************************************************************************/
	
	$l_prefs["mailer_information"] = "Adjust whether webEditionin should dispatch emails via the integrated PHP function or a seperate SMTP server should be used.<br /><br />When using a SMTP mail server, the risk that messages are classified by the receiver as a \"Spam\" is lowered."; // TRANSLATE
	
	$l_prefs["mailer_type"] = "Mailer type"; // TRANSLATE
	$l_prefs["mailer_php"] = "Use php mail() function"; // TRANSLATE
	$l_prefs["mailer_smtp"] = "Use SMTP server"; // TRANSLATE
	$l_prefs["email"] = "E-Mail"; // TRANSLATE
	$l_prefs["tab_email"] = "E-Mail"; // TRANSLATE
	$l_prefs["smtp_auth"] = "Authentication"; // TRANSLATE
	$l_prefs["smtp_server"] = "SMTP server"; // TRANSLATE
	$l_prefs["smtp_port"] = "SMTP port"; // TRANSLATE
	$l_prefs["smtp_username"] = "User name"; // TRANSLATE
	$l_prefs["smtp_password"] = "Password"; // TRANSLATE
	$l_prefs["smtp_halo"] = "SMTP halo"; // TRANSLATE
	$l_prefs["smtp_timeout"] = "SMTP timeout"; // TRANSLATE

/*****************************************************************************
 * Versions settings
 *****************************************************************************/

	$l_prefs["versioning"] = "Versioning"; //TRANSLATE
	$l_prefs["version_all"] = "all"; //TRANSLATE
	$l_prefs["versioning_activate_text"] = "Activate versioning for some or all content types."; //TRANSLATE
	$l_prefs["versioning_time_text"] = "If you specify a time period, only versions are saved which are created in this time until today. Older versions will be deleted."; //TRANSLATE
	$l_prefs["versioning_time"] = "Time period"; //TRANSLATE
	$l_prefs["versioning_anzahl_text"] = "Number of versions which will be created for each document or object."; //TRANSLATE
	$l_prefs["versioning_anzahl"] = "Number"; //TRANSLATE
	$l_prefs["versioning_wizard_text"] = "Open the Version-Wizard to delete or reset versions."; //TRANSLATE
	$l_prefs["versioning_wizard"] = "Open Versions-Wizard"; //TRANSLATE
	$l_prefs["ContentType"] = "Content Type"; //TRANSLATE
	$l_prefs["versioning_create_text"] = "Determine which actions provoke new versions. Either if you publish or if you save, unpublish, delete or import files, too."; //TRANSLATE
	$l_prefs["versioning_create"] = "Create Version"; //TRANSLATE
	$l_prefs["versions_create_publishing"] = "only when publishing"; //TRANSLATE
	$l_prefs["versions_create_always"] = "always"; //TRANSLATE

	$l_prefs['use_jeditor'] = "Use"; //TRANSLATE
	$l_prefs["editor_font_colors"] = 'Specify font colors'; //TRANSLATE
	$l_prefs["editor_normal_font_color"] = 'Default'; //TRANSLATE
	$l_prefs["editor_we_tag_font_color"] = 'webEdition tags'; //TRANSLATE
	$l_prefs["editor_we_attribute_font_color"] = 'webEdition attributes'; //TRANSLATE
	$l_prefs["editor_html_tag_font_color"] = 'HTML tags'; //TRANSLATE
	$l_prefs["editor_html_attribute_font_color"] = 'HTML attributes'; //TRANSLATE
	$l_prefs["editor_pi_tag_font_color"] = 'PHP code'; //TRANSLATE
	$l_prefs["editor_comment_font_color"] = 'Comments'; //TRANSLATE
	$l_prefs["jeditor"] = 'Java source editor'; //TRANSLATE
	
	$l_prefs["juplod_not_installed"] = 'JUpload is not installed!'; //TRANSLATE
?>