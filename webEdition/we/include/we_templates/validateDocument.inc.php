<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');

    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/validation/validationService.class.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/validation/validation.class.php');

    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/accessibility.inc.php');


    //  This page gives the possibility to check a document via a known web-Service
    //  supports w3c (xhtml) and css validation via fileupload.
    //  There is also the possibility to check a file via url, this is only possible,
    //  when the server is accessible via web

    protect();
    htmlTop();

    //  for predefined services include properties file, depending on content-Type
    //  and depending on fileending.

    if($we_doc->ContentType == 'text/css' || $we_doc->Extension == '.css'){
        include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/accessibility/services_css.inc.php');
    } else {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/accessibility/services_html.inc.php');
    }

    $services = array();
    $js = '';

    foreach($validationService AS $_service){
        $services[$_service->art][$_service->category][] = $_service;
    }

    //  get custom services from database ..
    $customServices = validation::getValidationServices('use');

    if(sizeof($customServices) > 0){
        foreach($customServices as $_cService){
            $services['custom'][$_cService->category][] = $_cService;
        }
    }

    //  Generate Select-Men� with optgroups
    krsort($services);

    $_select = '';
    $_lastArt = '';
    $_lastCat = '';
    $_hiddens = '';
    $_js = '';
    if(sizeof($services) > 0){
        $_select  = '<select name="service" class="weSelect" style="width:350px;" onchange="switchPredefinedService(this.options[this.selectedIndex].value);">';
        foreach($services as $art => $arr){
            foreach($arr as $cat => $arrServices){
                foreach($arrServices as $service){

                    if($_lastArt != $art){
                        if($_lastArt != ''){
                            $_select .= "</optgroup>\n";
                            $_lastCat = '1';
                        }
                        $_lastArt = $art;
                        $_select .= "<optgroup class='lvl1' label='" . $l_validation['art_' . $art] . "'>\n";
                    }
                    if($_lastCat != $cat){
                        if($_lastCat != ''){
                            $_select .= "</optgroup>\n";
                        }
                        $_lastCat = $cat;

                        $_select .= "<optgroup class='lvl2' label='-- " . $l_validation['category_' . $cat] . "'>\n";
                    }
                    $_select .= "<option value='" . $service->getName() . "'>" . htmlentities($service->name) . "</option>\n";
                    $js .= '
                        host["' . $service->getName() . '"] = "' . htmlentities($service->host) . '";
                        path["' . $service->getName() . '"] = "' . htmlentities($service->path) . '";
                        s_method["' . $service->getName() . '"] = "' . $service->method . '";
                        varname["' . $service->getName() . '"] = "' . htmlentities($service->varname) . '";
                        checkvia["' . $service->getName() . '"] = "' . $service->checkvia . '";
                        ctype["' . $service->getName() . '"] = "' . htmlentities($service->ctype) . '";
                        additionalVars["' . $service->getName() . '"] = "' . htmlentities($service->additionalVars) . '";
                        ';
                }
            }
        }
        $_select .= '</optgroup></optgroup></select>';
        $selectedService = $validationService[0];
        $_hiddens = hidden('host', $selectedService->host) .
                    hidden('path', $selectedService->path) .
                    hidden('ctype', $selectedService->ctype) .
                    hidden('s_method', $selectedService->method) .
                    hidden('checkvia', $selectedService->checkvia) .
                    hidden('varname', $selectedService->varname) .
                    hidden('additionalVars',$selectedService->additionalVars);
    } else {
        $_select = $l_validation['no_services_available'];
    }

    //  css for webSite
    print STYLESHEET;

    //  js-functions for the select-men�
    ?>
    <script language="JavaScript" type="text/javascript">


        function we_submitForm(target,url){
        	var f = self.document.we_form;
        	f.target = target;
        	f.action = url;
        	f.method = "post";

        	f.submit();
        }

        function we_cmd(){

            var args = "";
    	    var url = "/webEdition/we_cmd.php?";

    	    for(var i = 0; i < arguments.length; i++){
    	        url += "we_cmd["+i+"]="+escape(arguments[i]);
    	        if(i < (arguments.length - 1)){
    	            url += "&";
    	        }
    	    }
    	    switch(arguments[0]){
    	        case 'checkDocument':
                    if(top.weEditorFrameController.getActiveDocumentReference().frames["1"].we_submitForm){
                        top.weEditorFrameController.getActiveDocumentReference().frames["1"].we_submitForm("validation",url);
                    }
                    break;
                default:
                    for(var i = 0; i < arguments.length; i++){
                        args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
                    }
                    eval('parent.we_cmd('+args+')');
                    break;
    	    }
        }

        host = new Array();
        path = new Array();
        varname = new Array();
        checkvia = new Array();
        ctype = new Array();
        s_method = new Array();
        additionalVars = new Array();

        <?php print $js; ?>

        function switchPredefinedService(name){

            var f = self.document.we_form;

            f.host.value = host[name];
            f.path.value = path[name];
            f.ctype.value = ctype[name];
            f.varname.value = varname[name];
            f.additionalVars.value = additionalVars[name];
            f.checkvia.value = checkvia[name];
            f.s_method.value = s_method[name];


        }
        function setIFrameSize(){
			var h = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
			var w = window.innerWidth ? window.innerWidth : document.body.offsetWidth;
			w = Math.max(w,680);
			var iframeWidth = w - 52;    
			var validiframe = document.getElementById("validation");
			validiframe.style.width=iframeWidth;    
			if (h) { // h must be set (h!=0), if several documents are opened very fast -> editors are not loaded then => h = 0
				validiframe.style.height=h - 185;
			}
        }

    </script>
    <?php
    print '</head>';

    $button = new we_button();
    //  generate Body of page
    $parts = array();
    array_push($parts,array('html'=>$l_validation['description'],'space'=>0));
    array_push($parts,array('headline'=>$l_validation['service'],
                            'html'=>
                                '<table border="0" cellpadding="0" cellspacing="0">
                                 <tr>
                                    <td class="defaultfont">' .
                                    $_select .
                                    $_hiddens .
                                    '</td><td>' . getPixel(20,5). '</td><td>' .
                                    $button->create_button('edit','javascript:we_cmd(\'customValidationService\')', true, 100, 22, "", "", !we_hasPerm("CAN_EDIT_VALIDATION"))
                                    . '</td><td>' . getPixel(20,5). '</td><td>' .
                                    $button->create_button('ok','javascript:we_cmd(\'checkDocument\')',true,100,22,'','',(!sizeof($services) > 0))
                                    . '</td></tr></table>'
                            ,'space'=>95));

    array_push($parts,array('html'=>$l_validation['result'], 'noline'=>1,'space'=>0) );
    array_push($parts,array('html'=>'<iframe name="validation" id="validation" src="' . WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=checkDocument" width="680" height="400"></iframe>', 'space'=> 5) );

    $body = '
        <form name="we_form">'
        . hidden('we_transaction',$_REQUEST['we_transaction'])
        . we_multiIconBox::getHTML('weDocValidation',"100%",$parts,20,'',-1,'','',false) .
        '</form>'
        ;

    print we_htmlElement::htmlBody(array('class'=>'weEditorBody', 'onload'=>'setIFrameSize()', 'onresize'=>'setIFrameSize()'),
                    $body);
    print '</html>';

?>