/**
 * Base Rpc Controller
 * 
 * @category   app
 * @package    app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class RpcController extends Zend_Controller_Action
{
	/**
	 * The default action
	 */
	public function indexAction()
	{
		$jsonOutput = we_net_rpc_JsonRpc::getReply('<?php print $TOOLNAME;?>');
		$this->getResponse()->setHeader('Content-Type', 'application/json')->appendBody($jsonOutput);
	}

}
