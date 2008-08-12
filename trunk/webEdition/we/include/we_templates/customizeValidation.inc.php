<?php
    // +----------------------------------------------------------------------+
    // | webEdition                                                           |
    // +----------------------------------------------------------------------+
    // | PHP version 4.1.0 or greater                                         |
    // +----------------------------------------------------------------------+
    // | Copyright (c) 2000 - 2007 living-e AG                                |
    // +----------------------------------------------------------------------+

    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');

    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/accessibility.inc.php');

    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/validation/validationService.class.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/validation/validation.class.php');

    protect();
    htmlTop();

    //  css for webSite
    print STYLESHEET;

    ?>
    <script language="JavaScript" type="text/javascript">

        function we_cmd(){

            var args = "";
            var url = "/webEdition/we_cmd.php?";
            for(var i = 0; i < arguments.length; i++){
                url += "we_cmd["+i+"]="+escape(arguments[i]);
                if(i < (arguments.length - 1)){
                    url += "&";
                }
            }

            switch (arguments[0]){

                case "customValidationService":
                    self.we_submitForm(url);
                    we_cmd("reload_editpage");
                    break;
                case "reload_editpage":
                    if(top.opener.top.weEditorFrameController.getActiveDocumentReference().frames["1"].we_cmd){
                        top.opener.top.weEditorFrameController.getActiveDocumentReference().frames["1"].we_cmd("reload_editpage");
                    }
                    window.focus();
                    break;
                case "close":
                    window.close();
                    break;
                default :
                    for(var i = 0; i < arguments.length; i++){
        				args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
        			}
        			eval('top.opener.we_cmd('+args+')');
                    break;
            }
        }

        function we_submitForm(url){

            var f = self.document.we_form;

        	f.action = url;
        	f.method = "post";

        	f.submit();
        }

    </script>
    </head>
    <body class="weDialogBody">
    <?php
    //  deal with action
    $services = array();

    if(isset($_REQUEST['we_cmd'][1])){

        switch ($_REQUEST['we_cmd'][1]){

            case 'saveService':
                $_service = new validationService($_REQUEST['id'],'custom',$_REQUEST['category'],$_REQUEST['name'],$_REQUEST['host'],$_REQUEST['path'],$_REQUEST['s_method'],$_REQUEST['varname'],$_REQUEST['checkvia'], $_REQUEST['ctype'],$_REQUEST['additionalVars'],$_REQUEST['fileEndings'],$_REQUEST['active']);
                if($selectedService = validation::saveService($_service)){
                    print we_htmlElement::jsElement(
                    	we_message_reporting::getShowMessageCall($l_validation['edit_service']['saved_success'], WE_MESSAGE_NOTICE)
                    );
                } else {
                	$selectedService = $_service;
                    print we_htmlElement::jsElement(
                    	we_message_reporting::getShowMessageCall($l_validation['edit_service']['saved_failure'] . (isset($GLOBALS['errorMessage']) ? '\n' . $GLOBALS['errorMessage'] : ''), WE_MESSAGE_ERROR)
                    );
                }
                break;
            case 'deleteService':
                $_service = new validationService($_REQUEST['id'],'custom',$_REQUEST['category'],$_REQUEST['name'],$_REQUEST['host'],$_REQUEST['path'],$_REQUEST['s_method'],$_REQUEST['varname'],$_REQUEST['checkvia'], $_REQUEST['ctype'],$_REQUEST['additionalVars'],$_REQUEST['fileEndings'],$_REQUEST['active']);
                if(validation::deleteService($_service)){
                    print we_htmlElement::jsElement(
                    	we_message_reporting::getShowMessageCall($l_validation['edit_service']['delete_success'], WE_MESSAGE_NOTICE)
                    );
                } else {
                    print we_htmlElement::jsElement(
                    	we_message_reporting::getShowMessageCall($l_validation['edit_service']['delete_failure'], WE_MESSAGE_ERR
                    	)
                    );
                }
                break;
            case 'selectService';
                $selectedName = $_REQUEST['validationService'];
                break;
            case 'newService':
                $selectedService = new validationService(0,'custom','accessible',$l_validation['edit_service']['new'],'example.com','/path', 'get', 'varname','url','text/html','','.html',1);
                break;
        }
    }

    //  get all custom services from the database - new service select it
    $services = validation::getValidationServices('edit');
    if(isset($_REQUEST['we_cmd'][1]) && $_REQUEST['we_cmd'][1] == 'newService' && $selectedService){
        $services[] = $selectedService;
    }

    if(sizeof($services) > 0){
        foreach($services as $service){

            $selectArr[$service->getName()] = htmlentities($service->name);

            if(!isset($selectedService)){
                $selectedService = $service;
            }

            if(isset($selectedName) && $service->getName() == $selectedName){
                $selectedService = $service;
            }
        }
        $hiddenFields = hidden('id',$selectedService->id) .
                        hidden('art','custom');
    } else {
        $hiddenFields = hidden('art','custom');
        $selectArr = array();
    }




    $button = new we_button();
    //  generate Body of page
    $parts = array();

    //  table with new and delete
    $_table = '<table>
    <tr><td>' . htmlSelect('validationService',$selectArr, 5, (isset($selectedService) ? $selectedService->getName() : ''), false, 'onchange=we_cmd(\'customValidationService\',\'selectService\');',"value",320) . '</td>
        <td>' . getPixel(10,2) . '</td>
        <td valign="top">' . $button->create_button('new_service', 'javascript:we_cmd(\'customValidationService\',\'newService\');')
    					   . '<div style="height:10px;"></div>'
                           . $button->create_button('delete', 'javascript:we_cmd(\'customValidationService\',\'deleteService\');',true,100,22,'','',!(sizeof($services) > 0)) .'
        </td>
    </tr>
    </table>';

    $_table .=  $hiddenFields;

    array_push($parts,array('headline'=>$l_validation['available_services'], 'html'=>$_table, 'space'=> 150) );

    if(sizeof($services) > 0){
        array_push($parts,array('headline'=>$l_validation['category'],'html'=>htmlSelect('category', validation::getAllCategories(),1,$selectedService->category), 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['service_name'],'html'=>htmlTextInput('name',50,$selectedService->name), 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['host'],'html'=>htmlTextInput('host',50,$selectedService->host), 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['path'],'html'=>htmlTextInput('path',50,$selectedService->path), 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['ctype'],'html'=>htmlTextInput('ctype',50,$selectedService->ctype) . '<br /><span class="small">' . $l_validation['desc']['ctype'] . '</span>', 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['fileEndings'],'html'=>htmlTextInput('fileEndings',50,$selectedService->fileEndings) . '<br /><span class="small">' . $l_validation['desc']['fileEndings'] . '</span>', 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['method'],'html'=>htmlSelect('s_method', array('post'=>'post','get'=>'get'),1,$selectedService->method,false), 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['checkvia'],'html'=>htmlSelect('checkvia',array('url'=>$l_validation['checkvia_url'],'fileupload'=>$l_validation['checkvia_upload']),1,$selectedService->checkvia,false), 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['varname'],'html'=>htmlTextInput('varname',50,$selectedService->varname) . '<br /><span class="small">' . $l_validation['desc']['varname'] . '</span>', 'space'=> 150,'noline'=>1) );
        array_push($parts,array('headline'=>$l_validation['additionalVars'],'html'=>htmlTextInput('additionalVars',50,$selectedService->additionalVars) . '<br /><span class="small">' . $l_validation['desc']['additionalVars'] . '</span>', 'space'=> 150) );
        array_push($parts,array('headline'=>$l_validation['active'],'html'=>htmlSelect('active',array(0=>'false',1=>'true'), 1,$selectedService->active) . '<br /><span class="small">' . $l_validation['desc']['active'] . '</span>', 'space'=> 150) );
    }

    $body = '<form name="we_form" onsubmit="return false;">' . we_multiIconBox::getHTML('weDocValidation','100%',$parts, 30, $button->position_yes_no_cancel($button->create_button('save','javascript:we_cmd(\'customValidationService\',\'saveService\');',true,100,22,'','',!(sizeof($services) > 0)),$button->create_button('cancel','javascript:we_cmd(\'close\');')),-1,'','',false, $l_validation['adjust_service'], "", 660)
            . '</form>';

    print $body;
    print '</body></html>';

?>