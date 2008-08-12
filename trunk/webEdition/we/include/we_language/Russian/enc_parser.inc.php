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
 * Language file: enc_parser.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_parser"]["wrong_type"] = "�������� &quot;type&quot; �����������!";
$GLOBALS["l_parser"]["error_in_template"] = "������ �������";
$GLOBALS["l_parser"]["start_endtag_missing"] = "��� ������ �� ����� <code>&lt;we:%s&gt;</code> �� ����� ��������� ��� �������� ���!";
$GLOBALS["l_parser"]["tag_not_known"] = "��� <code>'&lt;we:%s&gt;'</code> ����������!";
$GLOBALS["l_parser"]["else_start"] = "��� ���� <code>&lt;we:else/&gt;</code> �� ����� ��������� ��� <code>&lt;we:if...&gt;</code>!";
$GLOBALS["l_parser"]["else_end"] = "��� ���� <code>&lt;we:else/&gt;</code> �� ����� �������� ��� <code>&lt;we:if...&gt;</code>!";
$GLOBALS["l_parser"]["attrib_missing"] = "������� '%s' ���� <code>&lt;we:%s&gt;</code> �� ������ ���� �������������!";
$GLOBALS["l_parser"]["attrib_missing2"] = "������� '%s' ���� <code>&lt;we:%s&gt;</code> �� ������ �������������!";
$GLOBALS["l_parser"]["name_empty"] = "��� ���� <code>&lt;we:%s&gt;</code> �� ���������!";
$GLOBALS["l_parser"]["invalid_chars"] =  "��� ���� <code>&lt;we:%s&gt;</code> �������� ������������ �������. ����������� ��������� �������� ����� ���������� ��������, �����, �������: '-' � '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "��� ���� <code>&lt;we:%s&gt;</code> ������� �������! ��� �� ������ ��������� 255 ��������!";
$GLOBALS["l_parser"]["name_with_space"] =  "��� ���� <code>&lt;we:%s&gt;</code> �� ������ �������� �������!";
$GLOBALS["l_parser"]["client_version"] = "��������� �������� 'version' ����  <code>&lt;we:ifClient&gt;</code> �������!";
$GLOBALS["l_parser"]["html_tags"] = "������ ������ ��������� ���� ��� ������������� ���� HTML <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> ���� �� ������ �� ���. � ��������� ������ �� �������������� ���������� ������ �������!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "��� <code&gt;</code>&lt;we:field&gt;</code> ������ ���������� ����� ��������� � �������� �����  <code>&lt;we:listview&gt;</code> ��� <code>&lt;we:object&gt;</code>!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "��� <code>&lt;we:setVar from=\"listview\" ... &gt;</code> ������������ � ������� ���������� � ��������� ����� <code>&lt;we:listview&gt;</code>!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "������� jsIncludePath ����  <code>&lt;we:checkForm&gt;</code> ����� � ���� ����������� ������ (ID). ��������� � ����� ���������� ������� �� ����������!";
$GLOBALS["l_parser"]["checkForm_password"] = "������ �������� ���� <code>&lt;we:checkForm&gt;</code> ������ �������� �� 3 ������, ����������� ��������!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>."; // TRANSLATE
?>