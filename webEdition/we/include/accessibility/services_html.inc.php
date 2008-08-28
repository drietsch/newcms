<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

    $i = 0;
    
    //  first xhtml from W3C
    $validationService[] = new validationService(
                            $i++,
                            'default',
                            'xhtml',
                            $l_validation['service_xhtml_upload'],
                            'validator.w3.org',
                            '/check',
                            'post',
                            'uploaded_file',
                            'fileupload',
                            'text/html',
                            '',
                            '.html,.htm,.php',
                            1);
    
    $validationService[] = new validationService(
                            $i++,
                            'default',
                            'xhtml',
                            $l_validation['service_xhtml_url'],
                            'validator.w3.org',
                            '/check',
                            'get',
                            'uri',
                            'url',
                            'text/html',
                            '',
                            '.html,.htm,.php',
                            1);


/*
$service['bobby'] = array(
                        'name'     => $l_validation['service_bobby'],
                        'host'     => 'bobby.watchfire.com',
                        'path'     => '/bobby/bobbyServlet',
                        'method'   => 'get',
                        'varname'  => 'URL',
                        'checkvia' => 'url',
                        'ctype' => 'text/html',
                        'additionalVars' => ''
                    );
*/

?>