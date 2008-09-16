<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class rpcGetSearchResultCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolView.class.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/conf/define.conf.php');
		
		$whichsearch=$_REQUEST['whichsearch'];
		$setView = $_REQUEST['we_cmd']['setView'.$whichsearch.''];

		$_REQUEST['we_cmd']['obj'] = unserialize($_SESSION['weSearch_session']);

		$content = searchtoolView::searchProperties($whichsearch);
						
		$code = searchtoolView::tabListContent($setView,$content,$class="middlefont",$whichsearch);
				
		$resp->setData("data",$code) ;
		
		return $resp;
	}
}

?>