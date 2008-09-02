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

class ImportOptions extends leWizardStepBase
{

	var $EnabledButtons = array(
		'next'
	);

	function execute(&$Template)
	{
		
		$this->setContent("<input type=\"hidden\" name=\"startImport\" value=\"1\">");
		
		return LE_WIZARDSTEP_NEXT;
	
	}

	function check(&$Template)
	{
		
		if (isset($_REQUEST['startImport']) && $_REQUEST['startImport'] == 1) {
			$_REQUEST['cid'] = -2;
			$_REQUEST['v'] = array(
				
					'mode' => 1,  // dont change this
					'cid' => -2,  // dont change this
					'type' => 'WXMLImport',  // dont change this
					'fserver' => '/',  // dont change this
					'rdofloc' => 'lLocal',  // dont change this
					'import_from' => '/webEdition/liveUpdate/tmp/files/Import.xml', 
					'collision' => 'replace', 
					'import_owners' => 0, 
					'owners_overwrite' => 0, 
					'owners_overwrite_id' => 0, 
					'import_docs' => 1,  // should documents be imported
					'doc_dir_id' => 0, 
					'doc_dir' => '/', 
					'restore_doc_path' => 1, 
					'import_templ' => 1,  // should templates be imported
					'tpl_dir_id' => 0, 
					'tpl_dir' => '/', 
					'restore_tpl_path' => 1, 
					'import_thumbnails' => 1, 
					'import_objs' => 0, 
					'import_classes' => 0, 
					'import_dt' => 1, 
					'import_ct' => 1, 
					'import_navigation' => 1,  // should navigation be imported
					'navigation_dir_id' => 0, 
					'navigation_dir' => '/', 
					'import_binarys' => 1, 
					'rebuild' => 0
			);
			$_REQUEST['mode'] = '';
			$_REQUEST['type'] = '';
		
		}
		
		return true;
	
	}

}

?>