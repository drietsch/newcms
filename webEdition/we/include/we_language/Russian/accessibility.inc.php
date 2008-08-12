<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = '������ �������� (�����������) ���������';

//  variables for checking html files.
$l_validation['description'] = '� ����� �������� ��������� �� ����������� ����� ������� ��������������� ������ � ����.';
$l_validation['available_services'] = '��������� � ������� ������';
$l_validation['category'] = '���������';
$l_validation['service_name'] = '�������� ������';
$l_validation['service'] = '������';
$l_validation['host'] = '����';
$l_validation['path'] = '����';
$l_validation['ctype'] = '��� ��������';
$l_validation['desc']['ctype'] = '������� �������� ������� �� ����������� ���� ��������������� ����� (text/html oder text/css)';
$l_validation['fileEndings'] = '����������';
$l_validation['desc']['fileEndings'] = '������� �������� ��� ��������� ���������� ������, ��������������� ��� �������� ������ �������: (.html,.css).';
$l_validation['method'] = '�����';
$l_validation['checkvia']  = '����������� �����������';
$l_validation['checkvia_upload'] = '�������� �����';
$l_validation['checkvia_url'] = '�������� URL';
$l_validation['varname'] = '��� ����������';
$l_validation['desc']['varname']  = '������� �������� ��� ���� ����� ��� url';
$l_validation['additionalVars'] = '�������������� ���������';
$l_validation['desc']['additionalVars']  = '���������: var1=wert1&var2=wert2&...';
$l_validation['result']  = '���������';
$l_validation['active'] = '��������������';
$l_validation['desc']['active']  = '����� ����� ������ ��������� ������.';
$l_validation['no_services_available'] = '��� ������� ���� ����� �� ���������� ��������������� ������ ��������.';

//  the different predefined services
$l_validation['adjust_service'] = '��������� ������ �������� ������';

$l_validation['art_custom'] = '������, ������������� ������������� ';
$l_validation['art_default'] = '������ �� ���������';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = '������';
$l_validation['category_css'] = 'Cascading Style Sheets'; // TRANSLATE
$l_validation['category_accessibility'] = '�����������';


$l_validation['edit_service']['new'] = '����� ������';
$l_validation['edit_service']['saved_success'] = '������ ������� ���������.';
$l_validation['edit_service']['saved_failure'] = '�� ������� ��������� ������ ������.';
$l_validation['edit_service']['delete_success'] = '������ ������� �������.';
$l_validation['edit_service']['delete_failure'] = '�� ������� ������� ������ ������.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML �������� W3C ����������� �������� �����';
$l_validation['service_xhtml_url'] = '(X)HTML �������� W3C ����������� �������� url';

//  services for css
$l_validation['service_css_upload'] = '�������� CSS ����������� �������� �����';
$l_validation['service_css_url'] = '�������� CSS ����������� �������� url';

$l_validation['connection_problems'] = '<strong> ������ ��� ������� ���������� � ������ �������</strong><br /><br />������� �� ��������: ����� "�������� url" �������� ������ � ������, ���� ������� webEdition �������� � ���� �������� (�� ���� �� ��������� ��������� ����). �� �������, ������������� �������� (localhost), ������ �����  �� ����������������.<br /><br />����� ����, � ������ ���������� �������� ��� (firewalls) � ������-�������� ��� ������, ��������� � ���� ��������, ����� ������ ��������� ���������.<br /><br />HTTP-�����: %';
?>