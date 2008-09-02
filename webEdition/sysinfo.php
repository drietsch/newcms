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

		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

		protect();
		
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/sysinfo.inc.php");


		function getInfoTable($_infoArr) {
			
			$_table = new we_htmlTable(array("width" => "500", "style" => "width: 500px;", "spellspacing"=>"2"), 1, 2);	
			$_i = 0;
			
			foreach ($_infoArr as $_k=>$_v) {
				
				if ($_i % 2) { 
					$_style =  "";
				} else {
					$_style =  "background: #D4DBFA;";
				}
				$_table->addRow(1);
				$_table->setRow($_i,array("class"=>"defaultfont","style" =>$_style));
				$_table->setCol($_i,0,array("style" => "width: 200px; height: 20px;font-weight: bold; padding-left: 10px;"),$_k);		
				$_table->setCol($_i,1,array("style" => "width: 250px; height: 20px; padding-left: 10px;"),parseValue($_k,$_v));		
				$_i++;
				
			}
			
			return $_table->getHtmlCode();
		}
		
		
		function parseValue($name,$value) {
			global $_types;
			
			if(in_array($name,array_keys($_types))) {
				if($_types[$name]=='bytes' && $value) {
					$value = we_convertIniSizes($value);
					return convertToMb($value) . ' (' . $value . ' Bytes)';
				}
				
			}
			
			return $value;
			
		}
		
		function convertToMb($value) {
			return round($value / (1024*1024),3) . ' MB';
		}
		
		function getConnectionTypes() {
			$_connectionTypes = array();
			if(ini_get("allow_url_fopen") == "1") {
				$_connectionTypes[] = "fopen";
				$_connectionTypeUsed = "fopen";
			}
			if(is_callable("curl_exec")) {
				$_connectionTypes[] = "curl";
				if(sizeof($_connectionTypes) == "1") {
					$_connectionTypeUsed = "curl";
				}
			}
			for($i=0;$i<sizeof($_connectionTypes);$i++) {
				if($_connectionTypes[$i] == $_connectionTypeUsed) {
					$_connectionTypes[$i] = "<u>".$_connectionTypes[$i]."</u>";
				}
			}
			return $_connectionTypes;
		}
		

		$_install_dir = $_SERVER['DOCUMENT_ROOT']. WEBEDITION_DIR;
		
		if(strlen($_install_dir)>35){
			$_install_dir = substr($_install_dir,0,25) . '<acronym title="' . $_install_dir . '">...</acronym>' . substr($_install_dir,-10);
		}
		
		$weVersion  = WE_VERSION;
		
		// GD_VERSION is mor precise but only available in PHP 5.2.4 or newer
		if(is_callable("gd_info")) {
			if(defined("GD_VERSION")) {
				$gdVersion = GD_VERSION;
			} else {
				$gdinfoArray = gd_info();
				$gdVersion = $gdinfoArray["GD Version"];
				unset($gdinfoArray);
			}
		} else {
			$gdVersion = "";
		}
		
		$_info = array(
			'webEdition' => array (
				$_sysinfo['we_version'] => $weVersion,
				$_sysinfo['server_name'] => SERVER_NAME,
				$_sysinfo['port'] => defined("HTTP_PORT") ? HTTP_PORT : 80,
				$_sysinfo['protocol'] => getServerProtocol(),
				$_sysinfo['installation_folder'] => $_install_dir,
				$_sysinfo['we_max_upload_size'] => getUploadMaxFilesize()
			),

			'PHP' => array(
				$_sysinfo['php_version'] => phpversion(),
				'max_execution_time' => ini_get('max_execution_time'),
				'memory_limit'  => we_convertIniSizes(ini_get('memory_limit')),
				'allow_url_fopen' => ini_get('allow_url_fopen'),
				'open_basedir' => ini_get('open_basedir'),
				'safe_mode' => ini_get('safe_mode'),
				'safe_mode_exec_dir' => ini_get('safe_mode_exec_dir'),
				'safe_mode_gid' => ini_get('safe_mode_gid'),
				'safe_mode_include_dir' => ini_get('safe_mode_include_dir'),
				'upload_max_filesize' => we_convertIniSizes(ini_get('upload_max_filesize'))
			),

			'MySql' => array (
				$_sysinfo['mysql_version'] => getMysqlVer(false),
				'max_allowed_packet' => getMaxAllowedPacket()
			),
			
			'System' => array (
				$_sysinfo['connection_types'] => implode(", ", getConnectionTypes()),
				$_sysinfo['mbstring'] => (is_callable("mb_get_info") ? $_sysinfo['available'] : "-"),
				$_sysinfo['gdlib'] => (!empty($gdVersion) ? $_sysinfo['version']." ".$gdVersion : "-"),
			),
				
		);
		
		
		$_types = array(
			'upload_max_filesize'=>'bytes',
			'memory_limit'=>'bytes',
			'max_allowed_packet'=>'bytes',
			$_sysinfo['we_max_upload_size']=>'bytes'
		);

		$we_button = new we_button();

		$buttons = $we_button->position_yes_no_cancel(
				$we_button->create_button("close", "javascript:self.close()"),
				'',
				''
		);


		$_space_size = 150;
		$_parts = array();
			foreach ($_info as $_k=>$_v) {
				$_parts[] = array(
					'headline'=> $_k,
					'html'=> getInfoTable($_v),
					'space'=>$_space_size
			);
		}

		$_parts[] = array(
					'headline'=> '',
					'html'=> '<a href="javascript:showPhpInfo();">'.$_sysinfo['more_info'].'...</a>',
					'space'=>10
		);
		
		
?>
<html>
<head>
 
<title><?php print $_sysinfo['sysinfo']?></title>
<script type="text/javascript" src="<?php print JS_DIR; ?>attachKeyListener.js"></script>
<script type="text/javascript" src="<?php print JS_DIR; ?>keyListener.js"></script>
<script type="text/javascript">
	function closeOnEscape() {
		return true;
	}
	
	function showPhpInfo() {
		document.getElementById("info").style.display="none";
		document.getElementById("more").style.display="block";
		document.getElementById("phpinfo").src = "phpinfo.php";
	}
	
	function showInfoTable() {
		document.getElementById("info").style.display="block";
		document.getElementById("more").style.display="none";
	}

</script>

<?php
		print STYLESHEET;
?>

</head>

<body class="weDialogBody" style="overflow:hidden;" onload="self.focus();">
<div id="info" style="display: block;">
<?php		
		print we_multiIconBox::getJS();
		print we_multiIconBox::getHTML('',700, $_parts,30,$buttons,-1,'','',false);
		
?>
</div>
<div id="more" style="display:none;">
<?php

		$_parts = array();
		
		$_parts[] = array(
					'headline'=> '',
					'html'=> '<iframe id="phpinfo" style="width:660px;height:530px;">'.$_sysinfo['more_info'].'...</iframe>',
					'space'=>$_space_size
		);
		
		$_parts[] = array(
					'headline'=> '',
					'html'=> '<a href="javascript:showInfoTable();">'.$_sysinfo['back'].'</a>',
					'space'=>10
		);
		
		print we_multiIconBox::getHTML('','100%', $_parts,30,$buttons,-1,'','',false);
		
?>
</div>
</body>
</html>