<?php
/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_net
 * @subpackage we_net_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

 /*
 * class JsonRpcError
 *
 * This class allows service methods to easily provide error information for
 * return via JSON-RPC.
 */

class we_net_rpc_JsonRpcError {
	
    private		$json;
    private		$data;
    private		$id;
	
	const kErrorOriginServer = 1;
	const kErrorOriginApplication = 2;
	const kErrorOriginTransport = 3;
	const kErrorOriginClient = 4;
	
	const kErrorUnknown = 0;
	const kErrorIllegalService = 1;
	const kErrorServiceNotFound = 2;
	const kErrorClassNotFound = 3;
	const kErrorMethodNotFound = 4;
	const kErrorParameterMismatch = 5;
	const kErrorPermissionDenied = 6;

    
    public function __construct (
									$origin = self::kErrorOriginServer,
									$code = self::kErrorUnknown,
									$message = 'Unknown error'
								) {

		$this->data = array(
			'origin'  => $origin,
			'code'    => $code,
			'message' => $message,
			'type'    => 'error'
		);

    }
	
	public function SetOrigin($origin) {
		$this->data['origin'] = $origin;
	}

	public function SetError($code, $message, $type='error') {
		$this->data['code'] = $code;
		$this->data['message'] = $message;
		$this->data['type'] = $type;
	}
    
	public function SetId($id) {
		$this->id = $id;
	}
        
    public function getError() {
    	$ret = array('error' => $this->data,
                     'id'    => $this->id,
    				 'result' => NULL);
        return Zend_Json::encode($ret);
    }
}
