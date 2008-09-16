<?php
	
	protect();
	$variantName = $_REQUEST['we_cmd']['2'];

	weShopVariants::useVariant($we_doc, $variantName);
        
	$content = $we_doc->getDocument();
    print $content;
?>