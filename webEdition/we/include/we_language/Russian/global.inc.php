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

$GLOBALS["l_global"]["new_link"] = "Новая ссылка"; // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "Загрузка данных!<br>Загрузка нескольких элементов меню займет некоторое время";
$GLOBALS["l_global"]["text"] = "Текст";
$GLOBALS["l_global"]["yes"] = "да";
$GLOBALS["l_global"]["no"] = "нет";
$GLOBALS["l_global"]["checked"] = "В действии";
$GLOBALS["l_global"]["max_file_size"] = "Максимальный размер файла (в байтах)";
$GLOBALS["l_global"]["default"] = "По умолчанию";
$GLOBALS["l_global"]["values"] = "Значения";
$GLOBALS["l_global"]["name"] = "Имя";
$GLOBALS["l_global"]["type"] = "Тип";
$GLOBALS["l_global"]["attributes"] = "Атрибуты";
$GLOBALS["l_global"]["formmailerror"] = "Форма не отправлена по следующим причинам:";
$GLOBALS["l_global"]["email_notallfields"] = "Вы не заполнили все поля обязательные к заполнению!";
$GLOBALS["l_global"]["email_ban"] = "Вы не уполномочены использовать данный Script!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "Адрес получателя введен неверно!";
$GLOBALS["l_global"]["email_no_recipient"] = "Адреса получателя не существует!";
$GLOBALS["l_global"]["email_invalid"] = "Ваш электронный <b>адрес</b> недействителен!";
$GLOBALS["l_global"]["question"] = "Вопрос";
$GLOBALS["l_global"]["warning"] = "Внимание";
$GLOBALS["l_global"]["we_alert"] = "Данная функция не входит в демо-версию системы webEdition!";
$GLOBALS["l_global"]["index_table"] = "Таблица индексов";
$GLOBALS["l_global"]["cannotconnect"] = "Нет соединения с сервером webEdition!";
$GLOBALS["l_global"]["recipients"] = "Получатели писем Formmail";
$GLOBALS["l_global"]["recipients_txt"] = "Введите, пожалуйста, все электронные адреса для рассылки форм с помощью функции Formmail (&lt;we:form type=&quot;formmail&quot; ..&gt;). Если адрес рассылки не введен, невозможно воспользоваться функцией рассылки Formmail!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Создан новый объект %s класса %s!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Новый объект";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Новый документ";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Создан новый документ %s!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Объект удален";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "Объект %s удален!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Документ удален";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "Документ %s удален!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "После сохранения новая страница";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "Данные не найдены!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Пересохранить временные документы";
$GLOBALS["l_global"]["save_mainTable"] = "Пересохранить главную таблицу базы данных";
$GLOBALS["l_global"]["add_workspace"] = "Добавить рабочее пространство";
$GLOBALS["l_global"]["folder_not_editable"] = "Данная директория не может быть выбрана!";
$GLOBALS["l_global"]["modules"] = "Модули";
$GLOBALS["l_global"]["center"] = "Центровка";
$GLOBALS["l_global"]["jswin"] = "Окно Popup";
$GLOBALS["l_global"]["open"] = "Открыть";
$GLOBALS["l_global"]["posx"] = "Положение x";
$GLOBALS["l_global"]["posy"] = "Положение y";
$GLOBALS["l_global"]["status"] = "Status"; // TRANSLATE
$GLOBALS["l_global"]["scrollbars"] = "Scrollbars";
$GLOBALS["l_global"]["menubar"] = "Menubar";
$GLOBALS["l_global"]["toolbar"] = "Toolbar"; // TRANSLATE
$GLOBALS["l_global"]["resizable"] = "Resizable"; // TRANSLATE
$GLOBALS["l_global"]["location"] = "Location"; // TRANSLATE
$GLOBALS["l_global"]["title"] = "Титул/звание";
$GLOBALS["l_global"]["description"] = "Описание";
$GLOBALS["l_global"]["required_field"] = "Обязательное к заполнению поле";
$GLOBALS["l_global"]["from"] = "из"; 
$GLOBALS["l_global"]["to"] = "до";
$GLOBALS["l_global"]["search"]="Поиск";
$GLOBALS["l_global"]["in"]="в";
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Перестроить (rebuild)";
$GLOBALS["l_global"]["we_publish_at_save"] = "После сохранения опубликовать";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "New Document after saving"; // TRANSLATE
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving";
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving";
$GLOBALS["l_global"]["wrapcheck"] = "Обрыв строки (Wrapping)";
$GLOBALS["l_global"]["static_docs"] = "Статические документы";
$GLOBALS["l_global"]["save_templates_before"] = "Предварительно пересохранить шаблоны";
$GLOBALS["l_global"]["specify_docs"] = "Документы со следующими критериями:";
$GLOBALS["l_global"]["object_docs"] = "Все объекты";
$GLOBALS["l_global"]["all_docs"] = "Все документы";
$GLOBALS["l_global"]["ask_for_editor"] = "Предварительно запросить редактор";             
$GLOBALS["l_global"]["cockpit"] = "Cockpit"; // TRANSLATE
$GLOBALS["l_global"]["introduction"] = "Введение";
$GLOBALS["l_global"]["doctypes"] = "Типы документов";
$GLOBALS["l_global"]["content"] = "Содержимое";
$GLOBALS["l_global"]["site_not_exist"] = "Страница не существует!";
$GLOBALS["l_global"]["site_not_published"] = "Страница еще не опубликована!";
$GLOBALS["l_global"]["required"] = "Введите данные";
$GLOBALS["l_global"]["all_rights_reserved"] = "Все права защищены";
$GLOBALS["l_global"]["width"] = "Ширина";
$GLOBALS["l_global"]["height"] = "Высота";
$GLOBALS["l_global"]["new_username"] = "Новое имя пользователя";
$GLOBALS["l_global"]["username"] = "Имя пользователя";
$GLOBALS["l_global"]["password"] = "Пароль";
$GLOBALS["l_global"]["documents"] = "Документы";
$GLOBALS["l_global"]["templates"] = "Шаблоны";
$GLOBALS["l_global"]["objects"] = "Objects"; // TRANSLATE
$GLOBALS["l_global"]["licensed_to"] = "Владелец лицензии";
$GLOBALS["l_global"]["left"] = "по левой стороне";
$GLOBALS["l_global"]["right"] = "по правой стороне";
$GLOBALS["l_global"]["top"] = "по верхней стороне";
$GLOBALS["l_global"]["bottom"] = "по нижней стороне";
$GLOBALS["l_global"]["topleft"] = "по левому верхнему углу";
$GLOBALS["l_global"]["topright"] = "по правому верхнему углу";
$GLOBALS["l_global"]["bottomleft"] = "по левому нижнему углу";
$GLOBALS["l_global"]["bottomright"] = "по правому верхнему углу";
$GLOBALS["l_global"]["true"] = "Да";
$GLOBALS["l_global"]["false"] = "Нет";
$GLOBALS["l_global"]["showall"] = "Показать все";
$GLOBALS["l_global"]["noborder"] = "Без границ";
$GLOBALS["l_global"]["border"] = "Граница";
$GLOBALS["l_global"]["align"] = "Центровка";
$GLOBALS["l_global"]["hspace"] = "Горизонталь";
$GLOBALS["l_global"]["vspace"] = "Вертикаль";
$GLOBALS["l_global"]["exactfit"] = "Exactfit";
$GLOBALS["l_global"]["select_color"] = "Выберите цвет";
$GLOBALS["l_global"]["changeUsername"] = "Изменить имя пользователя";
$GLOBALS["l_global"]["changePass"] = "Изменить пароль";
$GLOBALS["l_global"]["oldPass"] = "Старый пароль";
$GLOBALS["l_global"]["newPass"] = "Новый пароль";
$GLOBALS["l_global"]["newPass2"] = "Повторите новый пароль";
$GLOBALS["l_global"]["pass_not_confirmed"] = "Повторно введенный пароль не соответствует новому паролю, веденному ранее!";
$GLOBALS["l_global"]["pass_not_match"] = "Старый пароль введен неверно!";
$GLOBALS["l_global"]["passwd_not_match"] = "Пароль введен неверно!";
$GLOBALS["l_global"]["pass_to_short"] = "Пароль должен содержать не менее 4 символов!";
$GLOBALS["l_global"]["pass_changed"] = "Пароль успешно изменен!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Пароли должны содержать только буквы латинского алфавита и цифры (a-z, A-Z и 0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Username may only contain alpha-numeric characters (a-z, A-Z and 0-9) and '.', '_' or '-'!"; // TRANSLATE
$GLOBALS["l_global"]["all"] = "Все";
$GLOBALS["l_global"]["selected"] = "выделены";
$GLOBALS["l_global"]["username_to_short"] = "Имя пользователя должно содержать не менее 4 символов!";
$GLOBALS["l_global"]["username_changed"] = "Имя пользователя успешно изменено!";
$GLOBALS["l_global"]["published"] = "Опубликовано";
$GLOBALS["l_global"]["help_welcome"] = "Добро пожаловать в службу помощи webEdition!";
$GLOBALS["l_global"]["edit_file"] = "Редактировать файл";
$GLOBALS["l_global"]["docs_saved"] = "Документы успешно сохранены!";
$GLOBALS["l_global"]["preview"] = "Предварительный просмотр";
$GLOBALS["l_global"]["close"] = "Закрыть окно";
$GLOBALS["l_global"]["loginok"] =  "<strong>Login ok! Пожалуйста, подождите!</strong><br>webEdition откроется в новом окне. В случае, если этого не произошло, убедитесь в том, что Вы не заблокировали окна pop-up в Вашем браузере!";
$GLOBALS["l_global"]["apple"] = "&#x2318;"; // TRANSLATE
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "CTRL"; // TRANSLATE
$GLOBALS["l_global"]["required_fields"] = "Поля, обязательные к заполнению";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">На данный момент документ еще не загружен.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Открыть/Закрыть";
$GLOBALS["l_global"]["rebuild"] = "Перестроить";
$GLOBALS["l_global"]["welcome_to_we"] = "Добро пожаловать в webEdition 3!";
$GLOBALS["l_global"]["tofit"] = "Добро пожаловать в webEdition 3!";
$GLOBALS["l_global"]["unlocking_document"] = "дать доступ к документу";
$GLOBALS["l_global"]["variant_field"] = "Поле варианта";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Please press the following link, if you are not redirected within the next 30 seconds "; // TRANSLATE
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition login"; // TRANSLATE
?>