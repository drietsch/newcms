
class RpcController extends Zend_Controller_Action
{

	public function indexAction()
	{
		$jsonOutput = we_net_rpc_JsonRpc::getReply('<?php print $TOOLNAME;?>');
		$this->getResponse()->setHeader('Content-Type', 'application/json')->appendBody($jsonOutput);
	}

}
