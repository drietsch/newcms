<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Online Validation of this document';

//  variables for checking html files.
$l_validation['description'] = 'You can select a service from the web to check this document for validity/accessibility.';
$l_validation['available_services'] = 'Existing services';
$l_validation['category'] = 'Category';
$l_validation['service_name'] = 'Name of the service';
$l_validation['service'] = 'Service';
$l_validation['host'] = 'Host';
$l_validation['path'] = 'Path';
$l_validation['ctype'] = 'Content type';
$l_validation['desc']['ctype'] = 'Feature for the target server to determine the type of the submited file (text/html or text/css)';
$l_validation['fileEndings'] = 'Extensions';
$l_validation['desc']['fileEndings'] = 'Insert all extensions which should be available for this service. (.html,.css)';
$l_validation['method'] = 'Method';
$l_validation['checkvia']  = 'Submit via';
$l_validation['checkvia_upload'] = 'File upload';
$l_validation['checkvia_url'] = 'URL transfer';
$l_validation['varname'] = 'Name of variable';
$l_validation['desc']['varname']  = 'Insert name of fieldname of file/url';
$l_validation['additionalVars'] = 'Additional Parameters';
$l_validation['desc']['additionalVars']  = 'optional: var1=wert1&var2=wert2&...';
$l_validation['result']  = 'Result';
$l_validation['active'] = 'Aktive';
$l_validation['desc']['active']  = 'Here you can hide a service temporary.';
$l_validation['no_services_available'] = 'There are no services available for this filetype yet.';

//  the different predefined services
$l_validation['adjust_service'] = 'Adjust validation service';

$l_validation['art_custom'] = 'Custom services';
$l_validation['art_default'] = 'Predefined services';

$l_validation['category_xhtml'] = '(X)HTML';
$l_validation['category_links'] = 'Links';
$l_validation['category_css'] = 'Cascading Style Sheets';
$l_validation['category_accessibility'] = 'Accessibility';


$l_validation['edit_service']['new'] = 'New service';
$l_validation['edit_service']['saved_success'] = 'The service was saved.';
$l_validation['edit_service']['saved_failure'] = 'The service could not be saved.';
$l_validation['edit_service']['delete_success'] = 'The service was deleted.';
$l_validation['edit_service']['delete_failure'] = 'The service could not be deleted.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.';

//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML validation of W3C via file upload';
$l_validation['service_xhtml_url'] = '(X)HTML valdiation of W3C via url transfer';

//  services for css
$l_validation['service_css_upload'] = 'CSS Validation via file-upload';
$l_validation['service_css_url'] = 'CSS Validation via url transfer';

$l_validation['connection_problems'] = '<strong>An error occured while connecting to this service</strong><br /><br />Please note: The option "url transfer" is only available if your webEdition installation is also accessible from the internet (outside your local network). This is not possible if webEdition is locally installed (localhost).<br /><br />Also, some problems can occure when using firewalls and proxy-servers. Please check your configuration in such cases.<br /><br />HTTP-Response: %s';
?>