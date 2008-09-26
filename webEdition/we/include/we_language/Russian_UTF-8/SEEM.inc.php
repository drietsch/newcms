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
 * Language file: SEEM.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_SEEM["ext_doc_selected"] = "Вы нажали на ссылку, указывающую на документ, который, по-видимому, не управляется системой webEdition. Продолжить?";
$l_we_SEEM["ext_document_on_other_server_selected"] = "Вы нажали на ссылку, которая указывает на документ другого веб-сервера. \\nДокумент откроется в новом окне браузера. Продолжить?";
$l_we_SEEM["ext_form_target_other_server"] = "Вы хотите отправить форму на другой веб-сервер. \\nПри этом откроется новое окно браузера. Продолжить?";
$l_we_SEEM["ext_form_target_we_server"] = "Эта форма отправляет данные документу, который не управляется системой webEdition. \\nПродолжить?";

$l_we_SEEM["ext_doc"] = "Текущий документ: <b>%s</b> <u>не</u> относится к странице, обслуживаемой системой webEdition";
$l_we_SEEM["ext_doc_not_found"] = "Указанная страница <b>%s</b> не найдена";
$l_we_SEEM["ext_doc_tmp"] = "При открытии указанного документа/страницы в системе webEdition произошел сбой. Чтобы выйти на требуемый документ, воспользуйтесь, пожалуйста, привычной навигацией сайта.";

$l_we_SEEM["info_ext_doc"] = "Ссылка не относится к webEdition";
$l_we_SEEM["info_doc_with_parameter"] = "Ссылка с параметром";
$l_we_SEEM["link_does_not_work"] = "Данная ссылка деактивирована в режиме предварительного просмотра. \nДля навигации по странице используйте, пожалуйста, панель главного меню.";
$l_we_SEEM["info_link_does_not_work"] = "Деактивировано";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "Вы собираетесь изменить содержание главного окна webEdition. При этом текущее окно закроется. Продолжить?";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Режим";
$l_we_SEEM["start_mode_normal"] = "стандартный";
$l_we_SEEM["start_mode_seem"] = "суперлегкий";

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Для Вас не задан действующий стартовый документ.\nСтартовый документ задается администратором.";
$l_we_SEEM["only_seem_mode_allowed"] = "У Вас нет полномочий для запуска webEdition в стандартном режиме.\\nЗапускается суперлегкий режим.";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Стартовый документ<br>суперлегкого<br>режима";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Попробуйте еще раз";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "У Вас нет полномочий редактировать данный документ";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "Для Вас не задан действующий стартовый документ.\\nЗадать стартовый документ в диалоге настроек?";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "У Вас нет полномочий редактировать данный документ";

$l_we_SEEM["confirm"]["change_to_preview"] = "Перейти в режим предварительного просмотра?";

$l_we_SEEM["alert"]["changed_include"] = "Вложенный файл был изменен. Перезагружается главное окно.";
$l_we_SEEM["alert"]["close_include"] = "This file is no webEdition document. The include window is closed."; // TRANSLATE
?>