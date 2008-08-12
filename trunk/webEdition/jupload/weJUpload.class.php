<?php

	class weJUpload {
		
		var $Params = array();
		
		var $Buttons = array();
		
		function weJUpload($params,$language=''){
			
			$this->Params = $params;
			
			if(!empty($language)) {
				switch ($language) {
					case 'Deutsch':
						$this->Params['localeCountry']='DE';
						$this->Params['localeLanguage']='de';
					break;
					case 'Dutch':
						$this->Params['localeCountry']='DE';
						$this->Params['localeLanguage']='de';
					break;
					case 'English':
						$this->Params['localeCountry']='en';
						$this->Params['localeLanguage']='GB';
					break;
					case 'Finnish':
						$this->Params['localeCountry']='en';
						$this->Params['localeLanguage']='GB';
					break;
					case 'French':
						$this->Params['localeCountry']='FR';
						$this->Params['localeLanguage']='fr';
					break;
					case 'Polish':
						$this->Params['localeCountry']='PL';
						$this->Params['localeLanguage']='pl';
					break;
					case 'Russian':
						$this->Params['localeCountry']='RU';
						$this->Params['localeLanguage']='ru';
					break;
					case 'Spanish':
						$this->Params['localeCountry']='MX';
						$this->Params['localeLanguage']='es';
					break;
				}
			}
			
		}
		
		function addParam($name,$value){
			$this->Params[$name] = $value;			
		}
		
		function getAppletTag($content='',$w=300,$h=300) {
			
			$_params = '';
			
			foreach ($this->Params as $name=>$value) {
				$_params .= '<param name="'.$name.'" value="'.$value.'">
				';
			}

			 return '
			<applet	name="JUpload" code="JUpload/startup.class" archive="/webEdition/jupload/jupload.jar" width="'.$w.'" height="'.$h.'" mayscript scriptable>
				'.$_params.'
				'.$content.'
			</applet>  
			';

		}
		
		function getJS(){
			
			return '';
			
		}
		
		function getButtons($buttons,$order='h',$space=5){
						
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_button.inc.php');
			$we_button = new we_button();
						
			$_buttons = array();
			
			foreach ($buttons as $button) {
				switch ($button) {
					case 'add':
						$_buttons[] = $we_button->create_button("add", "javascript:if(document.JUpload.jsIsReady()) document.JUpload.jsClickAdd();");
					break;
					case 'remove':
						$_buttons[] = $we_button->create_button("delete", "javascript:if(document.JUpload.jsIsReady()) document.JUpload.jsClickRemove();");
					break;
					case 'upload':
						$_buttons[] = $we_button->create_button("upload", "javascript:if(document.JUpload.jsIsReady()) document.JUpload.jsClickUpload();");
					break;
				}
			}
			
			if($order=='h'){
				return $we_button->create_button_table($_buttons,$space);
			} else {				
				return '<div style="margin-bottom: '.$space.'px;">' . implode('</div><div style="margin-bottom: '.$space.'px;">',$_buttons) . '</div>';
			}
		}
		
	}


?>