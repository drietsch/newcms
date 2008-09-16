<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


$l_validation['headline'] = 'Онлайн проверка (диагностика) документа';

//  variables for checking html files.
$l_validation['description'] = 'С целью проверки документа на доступность можно выбрать соответствующую службу в сети.';
$l_validation['available_services'] = 'Имеющиеся в наличие службы';
$l_validation['category'] = 'Категория';
$l_validation['service_name'] = 'Название службы';
$l_validation['service'] = 'Служба';
$l_validation['host'] = 'Хост';
$l_validation['path'] = 'Путь';
$l_validation['ctype'] = 'Тип контента';
$l_validation['desc']['ctype'] = 'Функция целевого сервера по определению типа представляемого файла (text/html oder text/css)';
$l_validation['fileEndings'] = 'Расширения';
$l_validation['desc']['fileEndings'] = 'Следует включить все возможные расширения файлов, предназначенных для проверки данной службой: (.html,.css).';
$l_validation['method'] = 'Метод';
$l_validation['checkvia']  = 'Представить посредством';
$l_validation['checkvia_upload'] = 'загрузки файла';
$l_validation['checkvia_url'] = 'передачи URL';
$l_validation['varname'] = 'имя переменной';
$l_validation['desc']['varname']  = 'Следует вставить имя поля файла или url';
$l_validation['additionalVars'] = 'Дополнительные параметры';
$l_validation['desc']['additionalVars']  = 'выборочно: var1=wert1&var2=wert2&...';
$l_validation['result']  = 'результат';
$l_validation['active'] = 'действительный';
$l_validation['desc']['active']  = 'Здесь можно скрыть временную службу.';
$l_validation['no_services_available'] = 'Для данного типа файла не существует соответствующей службы проверки.';

//  the different predefined services
$l_validation['adjust_service'] = 'Установка службы проверки данных';

$l_validation['art_custom'] = 'Услуги, настраиваемые пользователем ';
$l_validation['art_default'] = 'Услуги по умолчпнию';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Ссылки';
$l_validation['category_css'] = 'Cascading Style Sheets'; // TRANSLATE
$l_validation['category_accessibility'] = 'Доступность';


$l_validation['edit_service']['new'] = 'Новая служба';
$l_validation['edit_service']['saved_success'] = 'Служба успешно сохранена.';
$l_validation['edit_service']['saved_failure'] = 'Не удалось сохранить данную службу.';
$l_validation['edit_service']['delete_success'] = 'Служба успешно удалена.';
$l_validation['edit_service']['delete_failure'] = 'Не удалось удалить данную службу.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML проверка W3C посредством загрузки файла';
$l_validation['service_xhtml_url'] = '(X)HTML проверка W3C посредством передачи url';

//  services for css
$l_validation['service_css_upload'] = 'Проверка CSS посредством загрузки файла';
$l_validation['service_css_url'] = 'Проверка CSS посредством передачи url';

$l_validation['connection_problems'] = '<strong> Ошибка при попытке соединения с данной службой</strong><br /><br />Примите во внимание: опция "передача url" работает только в случае, если система webEdition доступна в сети интернет (то есть за пределами локальной сети). На системы, установленные локально (localhost), данная опция  не распространяется.<br /><br />Кроме того, в случае применения защитных мер (firewalls) и прокси-серверов для систем, доступных в сети интернет, также иногда возникают трудности.<br /><br />HTTP-ответ: %';
?>