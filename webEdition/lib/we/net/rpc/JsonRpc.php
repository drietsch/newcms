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

class we_net_rpc_JsonRpc {


	const kAccessibilityPublic 			= "public";
	const kAccessibilityDomain 			= "domain";
	const kAccessibilitySession 		= "session";
	const kAccessibilityFail 			= "fail";

	const kDefaultAccessibility 		= "domain";
	

	public static function getReply($namespace='we') {
		$error = new we_net_rpc_JsonRpcError();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			/*
			 * For POST data, the only acceptable content type is application/json.
			 */
			try {
				$jsonRequest = file_get_contents('php://input');
				$phpObj = Zend_Json::decode($jsonRequest);
			} catch (Zend_Json_Exception $e) {
				exit("JSON-RPC request expected; unexpected data received: " . $e->getMessage());
			}

		} else {
			/*
			* This request was not issued with JSON-RPC so echo the error rather than
			* issuing a JsonRpcError response.
			*/
			exit("Services require JSON-RPC<br>");
		}
		/* Ensure that this was a JSON-RPC service request */
		if (! isset($phpObj) ||
			! isset($phpObj['service']) ||
			! isset($phpObj['method']) ||
			! isset($phpObj['id']) ||
			! isset($phpObj['params'])) {
			/*
			* This request was not issued with JSON-RPC so echo the error rather than
			* issuing a JsonRpcError response.
			*/
			exit("JSON-RPC request expected; id, service, method or params missing<br>");
		}
		
		/*
		* Ok, it looks like JSON-RPC, so we'll return an Error object if we encounter
		* errors from here on out.
		*/
		$error->SetId($phpObj['id']);

		/*
		* Ensure the requested service name is kosher.  A service name should be:
		*
		*   - a dot-separated sequences of strings; no adjacent dots
		*   - first character of each string is in [a-zA-Z]
		*   - other characters are in [_a-zA-Z0-9]
		*/

		/* First check for legal characters */
		if (!preg_match("/^[_.a-zA-Z0-9]+$/", $phpObj['service'])) {
			/* There's some illegal character in the service name */
			$error->SetError(we_net_rpc_JsonRpcError::kErrorIllegalService,
			"Illegal character found in service name.");
			return $error->getError();
			/* never gets here */
		}

		/* Now ensure there are no double dots */
		if (strstr($phpObj['service'], "..") !== false) {
			$error->SetError(we_net_rpc_JsonRpcError::kErrorIllegalService,
			"Illegal use of two consecutive dots in service name");
			return $error->getError();
		}

		/* Explode the service name into its dot-separated parts */
		$serviceComponents = explode(".", $phpObj['service']);

		/* Ensure that each component begins with a letter */
		for ($i = 0; $i < count($serviceComponents); $i++) {
			if (!preg_match("/^[a-zA-Z]/", $serviceComponents[$i])) {
				$error->SetError(we_net_rpc_JsonRpcError::kErrorIllegalService,
				"A service name component does not begin with a letter");
				return $error->getError();
				/* never gets here */
			}
		}
		
		/* Ensure that first component is $namespace */
		if ($serviceComponents[0] !== $namespace) {
			$error->SetError(we_net_rpc_JsonRpcError::kErrorIllegalService,
				"First service name component is not '$namespace'");
				return $error->getError();
				/* never gets here */
		}

		/* Ensure that second component is 'rpc' */
		if ($serviceComponents[1] !== 'service') {
			$error->SetError(we_net_rpc_JsonRpcError::kErrorIllegalService,
				"Second service name component is not 'service'");
				return $error->getError();
				/* never gets here */
		}

		/*
		* Now replace all dots with underscores so we can load the service script.
		*/
		$serviceClass = implode("_", $serviceComponents);

		try {
			/* Load the class */
			Zend_Loader::loadClass($serviceClass);
			/* Instantiate the service */
			$service = new $serviceClass();
		} catch (Zend_Exception $e) {
			/* Couldn't find the requested service */
		    $error->SetError(we_net_rpc_JsonRpcError::kErrorServiceNotFound,
		                     "Service `$serviceClass` not found with message: " . $e->getMessage());
		    return $error->getError();
		    /* never gets here */
		}


		/*
		* Do referer checking.  There is a global default which can be overridden by
		* each service for a specified method.
		*/

		/* Assign the default accessibility */
		$accessibility = self::kDefaultAccessibility;
		
		/*
		* See if there is a "GetAccessibility" method in the class.  If there is, it
		* should take two parameters: the method name and the default accessibility,
		* and return one of the Accessibililty values.
		*/
		if (method_exists($service, "getAccessibility")) {
			/* Get the accessibility for the requested method */
			$accessibility = $service->getAccessibility($phpObj['method'], $accessibility);
		}

		/* Do the accessibility test. */
		switch ($accessibility) {
			case self::kAccessibilityPublic:
			/* Nothing to do.  The method is accessible. */
			break;

			case self::kAccessibilityDomain:
				/* Determine the protocol used for the request */
				$requestUriDomain = isset($_SERVER["SSL_PROTOCOL"]) ? "https://" : "http://";

				// Add the server name
				$requestUriDomain .= $_SERVER["HTTP_HOST"];


				/* Get the Referer, up through the domain part */
				if (!preg_match("@(https?://[^/]*)@", $_SERVER["HTTP_REFERER"], $regs)) {
					/* unrecognized referer */
					$error->SetError(we_net_rpc_JsonRpcError::kErrorPermissionDenied, "Permission Denied ['Accessibility Domain']");
					return $error->getError();
					/* never gets here */
				}

				/* Retrieve the referer component */
				$refererDomain = $regs[1];
				/* Is the method accessible? */
				if ($refererDomain != $requestUriDomain) {
					/* Nope. */
					$error->SetError(we_net_rpc_JsonRpcError::kErrorPermissionDenied, "Permission Denied ['Accessibility Domain']");
					return $error->getError();
					/* never gets here */
				}

				$rpcSession = new Zend_Session_Namespace("we_net_rpc_JsonRpc");

				/* If no referer domain has yet been saved in the session... */
				if (! isset($rpcSession->referer_domain)) {
					/* ... then set it now using this referer domain. */
					$rpcSession->referer_domain = $refererDomain;
				}
			break;

			case self::kAccessibilitySession:
				/* Get the Referer, up through the domain part */
				if (!preg_match("@(https?://[^/]*)@", $_SERVER["HTTP_REFERER"], $regs)) {
					/* unrecognized referer */
					$error->SetError(we_net_rpc_JsonRpcError::kErrorPermissionDenied, "Permission Denied ['Accessibility Session']");
					return $error->getError();
					/* never gets here */
				}

				/* Retrieve the referer component */
				$refererDomain = $regs[1];

				$rpcSession = new Zend_Session_Namespace("we_net_rpc_JsonRpc");

				/* Is the method accessible? */
				if (isset($rpcSession->referer_domain) && $refererDomain != $rpcSession->referer_domain) {
					/* Nope. */
					$error->SetError(we_net_rpc_JsonRpcError::kErrorPermissionDenied, "Permission Denied ['Accessibility Session']");
					return $error->getError();
					/* never gets here */
				} else if (!isset($rpcSession->referer_domain)) {
					/* No referer domain is yet saved in the session.  Save it. */
					$rpcSession->referer_domain = $refererDomain;
				}

			break;

			case self::kAccessibilityFail:
				$error->SetError(we_net_rpc_JsonRpcError::kErrorPermissionDenied,"Permission Denied ['Accessibility Fail']");
				return $error->getError();
				/* never gets here */
			break;

			default:
				/* Service's GetAccessibility() function returned a bogus value */
				$error->SetError(we_net_rpc_JsonRpcError::kErrorPermissionDenied, "Service error: unknown accessibility.");
				return $error->getError();
				/* never gets here */
		}

		$method = $phpObj['method'];
		/* Now that we've instantiated service, we should find the requested method */
		if (!method_exists($service, $method)) {
			$error->SetError(JsonRpcError_MethodNotFound, "Method `" . $phpObj['method'] . "` not found " .
					"in service class `" . $serviceComponents[count($serviceComponents) - 1] . "`.");
			return $error->getError();
			/* never gets here */
		}

		/* Errors from here on out will be Application-generated */
		$error->SetOrigin(we_net_rpc_JsonRpcError::kErrorOriginApplication);
		
		/* Call the requested method passing it the provided params */
		try {
			$output = $service->$method($phpObj['params']);
		} catch (we_service_Exception $e) {			
			$error->SetError($e->getCode(), $e->getMessage(), $e->getType());
			return $error->getError();
		}

		/* See if the result of the function was actually an error */
		if (get_class($output) == "we_net_rpc_JsonRpcError") {
			/* Yup, it was.  Return the error */
			return $error->getError();
			/* never gets here */
		}

		/* Give 'em what they came for! */
		$ret = array("result" => $output, "id" => $phpObj['id'], "error"=>NULL);
		return Zend_Json::encode($ret);

	}
}
