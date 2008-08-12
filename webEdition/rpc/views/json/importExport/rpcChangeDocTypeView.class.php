<?php
class rpcChangeDocTypeView extends rpcView {
	
	function getResponse($response) {

		$_elems = ""; 
		$_i=0;

		foreach ($response->getData("elements") as $_element => $_property) {
			$_elems .=($_i>0?", ":"")."
		".$_i.':{ 
			elem: '.$_element.', 
			props: {';
				$_loop = 0;
				foreach ($_property as $_propertyName => $_propertyValue) {
					$_elems .= ($_loop>0?", ":"") . "
				".$_loop .':{
					prop:"' . $_propertyName.'", 
					val: "'.$_propertyValue.'"
				}';
					$_loop++; 
				}
				$_elems .= '
			}
		}';
			$_i++;
		}				
		
		$json = <<<HTS1
{ 
	elems: { $_elems
	} 
}
HTS1;
		return $json;		
	}
}
?>