<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupUtil.class.php');

	class weBackupImport {

		function import($filename,&$offset,$lines=1,$iscompressed=0,$encoding='ISO-8859-1',$log=0) {

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLExImConf.inc.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weBackupFileReader.class.php');

			$data = $GLOBALS['weXmlExImHeader'];

			if($log){
				weBackupUtil::addLog(sprintf('Reading offset %s',$offset));
			}

			$_fileReader = new weBackupFileReader();
			$_fileReader->readLine($filename,$data,$offset,$lines,0,$iscompressed);

			$data .= $GLOBALS['weXmlExImFooter'];

			weBackupImport::transfer($data,$encoding,$log);

		}

		function transfer(&$data,$charset='ISO-8859-1',$log=0) {

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLParser.class.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weContentProvider.class.php');

			$nFactor = 5;

			if($log){
				weBackupUtil::addLog('Parsing data');
			}
			
			if($charset=='UTF-8') {
				$data = utf8_encode($data);
			}

			$parser = new weXMLParser();
			$parser->parse($data);

			// free some memory
			unset($parser->Indexes);
			unset($data);

			$parser->normalize();
			// set parser on the first child node
			$parser->seek(1);

			do {

				$entity = $parser->getNodeName();
				$attributes = $parser->getNodeAttributes();

				$classname = '';
				$object = '';

				if(weBackupImport::getObject($entity,$attributes,$object,$classname)){


					$parser->addMark('first');
					$parser->next();
					do {


						$name = $parser->getNodeName();

						//import elements
						if($name == 'we:content') {

							$parser->addMark('second');
							$parser->next();

							do {

								$element_value=$parser->getNodeName();
								if($element_value=='Field') {
									$element_name=$parser->getNodeData();
								}
								if($element_name) {
									$object->elements[$element_name][$element_value]=$parser->getNodeData();
								}

							} while($parser->nextSibling());

							unset($element_name);
							unset($element_value);

							$parser->gotoMark('second');
						} else {
						// import field
							if(weContentProvider::needCoding($classname,$name)){
								$object->$name = weContentProvider::decode($parser->getNodeData());
							} else {
								$object->$name = $parser->getNodeData();
							}
							if(isset($object->persistent_slots) && !in_array($name,$object->persistent_slots)) {
								$object->persistent_slots[]=$name;
							}
						}

					} while($parser->nextSibling());


					if($log){
						$_prefix = 'Saving object ';
						if($classname=='weTable') {
							weBackupUtil::addLog($_prefix . $classname . ':' . $object->table );
						} else if($classname=='weTableItem'){
							$_id_val = '';
							foreach ($object->keys as $_key) {
								$_id_val .= ':' . $object->$_key;
							}
							weBackupUtil::addLog($_prefix . $classname . ':' . $object->table . $_id_val);

						} else if($classname=='weBinary'){
							weBackupUtil::addLog($_prefix . $classname . ':' . $object->ID . ':' .  $object->Path);
						}
					}

					if(isset($object->Path) && $object->Path == '/webEdition/we/include/conf/we_conf_global.inc.php'){
						weBackupImport::handlePrefs($object);
					} else if(defined('SPELLCHECKER') && isset($object->Path) && (strpos($object->Path,'/webEdition/we/include/we_modules/spellchecker/')===0) && !$_SESSION['weBackupVars']['handle_options']['spellchecker']){
						// do nothing
					} else {
						$object->save();
					}

					//sppedup for some tables
					if(isset($object->table) && ($object->table == LINK_TABLE || $object->table == CONTENT_TABLE)) {
						$_SESSION['weBackupVars']['backup_steps'] = BACKUP_STEPS * $nFactor;
					} else {
						$_SESSION['weBackupVars']['backup_steps'] = BACKUP_STEPS;
					}

					$parser->gotoMark('first');

				}

				if(isset($object)){
					unset($object);
				}

			} while($parser->nextSibling());

		}


		function getObject($tagname,$attribs,&$object,&$classname) {

			switch($tagname) {

				case 'we:table':
					include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weTable.class.php');
					$table = weBackupUtil::getRealTableName($attribs['name']);
					if($table !== false) {
						weBackupUtil::setBackupVar('current_table',$table);
						$object = new weTable($table);
						$classname = 'weTable';
						return true;
					}
				break;

				case 'we:tableitem':
					include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weTableItem.class.php');
					$table = weBackupUtil::getRealTableName($attribs['table']);
					if($table !== false) {
						weBackupUtil::setBackupVar('current_table',$table);
						$object = new weTableItem($table);
						$classname = 'weTableItem';
						return true;
					}
				break;

				case 'we:binary':
					include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weBinary.class.php');
					$object = new weBinary();
					$classname = 'weBinary';
					return true;
				break;
				
				case 'we:version':
					include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weVersion.class.php');
					$object = new weVersion();
					$classname = 'weVersion';
					return true;
				break;

			}

			return false;

		}

		function handlePrefs(&$object){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weConfParser.class.php");
			$file="/webEdition/we/tmp/we_conf_global.inc.php";
			$object->Path=$file;
			$object->save(true);
			$parser = weConfParser::getConfParserByFile($_SERVER["DOCUMENT_ROOT"] . $file);

			$newglobals = $parser->getData();

			foreach ($newglobals as $k=>$v){
				if($k != 'BACKUP_STEPS' && $v != ''){
				 	weConfParser::setGlobalPref($k,$v);
				}
			}
			@unlink($_SERVER["DOCUMENT_ROOT"].$file);

		}


}




?>