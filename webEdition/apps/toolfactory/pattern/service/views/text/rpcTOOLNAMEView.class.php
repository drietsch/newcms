
class rpc<?php print $TOOLNAME;?>View extends rpcView 
{
	function getResponse($response) 
	{
		$html = 'Hello World! My name is <?php print $TOOLNAME;?> and I am a webEdition-Application.';
		
		return $html;
		
	}
}