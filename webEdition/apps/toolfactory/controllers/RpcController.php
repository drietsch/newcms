<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class RpcController extends Zend_Controller_Action
{
	/**
	 * The default action
	 */
	public function indexAction()
	{
		$jsonOutput = we_net_rpc_JsonRpc::getReply('toolfactory');
		$this->getResponse()->setHeader('Content-Type', 'application/json')->appendBody($jsonOutput);
	}

}
