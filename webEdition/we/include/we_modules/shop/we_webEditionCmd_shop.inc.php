

    case "edit_shop_ifthere":
    case "edit_shop":
		new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
	break;

	case "help_shop":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		wind.focus();
<?php if($online_help):?>
		if(arguments[1]) url="/webEdition/getHelp.php?hid="+arguments[1];
		else url="/webEdition/getHelp.php";
		new jsWindow(url,"help",-1,-1,800,600,true,false,true,true);
<?php else:?>
		url="/webEdition/noAvailable.php";
		new jsWindow(url,"help_no_available",-1,-1,380,140,true,false,true);
<?php endif?>
		break;
		
		case "pref_shop":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		wind.focus();
		url="<?php print WE_SHOP_MODULE_PATH ?>edit_shop_pref.php";
		new jsWindow(url,"shoppref",-1,-1,470,600,true,true,true,false);
		break;
		
		case "edit_shop_vat_country":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		wind.focus();
		url="<?php print WE_SHOP_MODULE_PATH ?>edit_shop_vat_country.php";
		new jsWindow(url,"edit_shop_vat_country",-1,-1,700,780,true,true,true,false);
		break;
		
		case "edit_shop_vats":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		wind.focus();
		url="<?php print WE_SHOP_MODULE_PATH ?>edit_shop_vats.php";
		new jsWindow(url,"edit_shop_vats",-1,-1,500,450,true,false,true,false);
		break;
		
		case "edit_shop_shipping":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		wind.focus();
		url="<?php print WE_SHOP_MODULE_PATH ?>edit_shop_shipping.php";
		new jsWindow(url,"edit_shop_shipping",-1,-1,700,600,true,false,true,false);
		break;
		
		case "payment_val":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		wind.focus();
		url="<?php print WE_SHOP_MODULE_PATH ?>edit_shop_payment.inc.php";
		new jsWindow(url,"edit_shop_payment",-1,-1,520,720,true,false,true,false);
		break;
				
<?php
    $yearshop = "2002";
   	$z=1;
	while($yearshop <= date("Y")){
       echo ' case "'."year".$yearshop.'":
       ';
	   $yearshop++; $z++;
			         
	}

?>

		case "revenue_view":
        case "new_article":

        case "delete_shop":
 			var fo=false;
			for(var k=jsWindow_count-1;k>-1;k--){
				eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
				if(fo) break;
			}
			wind.focus();
		break;

		case "exit_shop":
			if(jsWindow_count){
				for(i=0;i<jsWindow_count;i++){
					eval("if(jsWindow"+i+"Object.ref=='edit_module') jsWindow"+i+"Object.close()");
				}
			}
        break;

		case "shop_insert_variant":
		case "shop_move_variant_up":
		case "shop_move_variant_down":
		case "shop_remove_variant":
				url += "#f"+(parseInt(arguments[1])-1);
				we_sbmtFrm(top.weEditorFrameController.getActiveDocumentReference().frames["1"],url);
				break;
		case 'shop_preview_variant':
			url += "#f"+(parseInt(arguments[1])-1);
        	var prevWin = new jsWindow(url,"previewVariation",-1,-1,1600,1200,true,true,true,true);
        	we_sbmtFrm(prevWin.wind,url);
		break;
