
class rpc<?php print $TOOLNAME;?>View extends rpcView {
	
	
	function getResponse($response) {
		
		$html = '
			Hallo World! My name is <?php print $TOOLNAME;?> and I am a webEdition-Tool	
		';
		
		return $html;
	}
}