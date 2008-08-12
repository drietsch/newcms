<?php

/**
* not used at the moment! used from the delete-checkboxes in the version tab!
*/


class rpcDeleteVersionsWizardView extends rpcView {
	
	
	function getResponse($response) {

		return $response->getData("data");
		
	}
	
}


?>