<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");    
	define("PROGRESS_H_IMAGE",IMAGE_DIR.'balken.gif');
	define("PROGRESS_H_IMAGE_BG",IMAGE_DIR.'balken_bg.gif');

	define("PROGRESS_V_IMAGE",IMAGE_DIR.'balken_v.gif');
	define("PROGRESS_V_IMAGE_BG",IMAGE_DIR.'balken_bg_v.gif');
	
	class we_progressBar{
		
		var $progress=0;
      
		var $texts=array();
      var $orientation=0;

		var $progress_image=PROGRESS_H_IMAGE;
		var $progress_image_bg=PROGRESS_H_IMAGE_BG;
		
		var $stud_width=10;
		var $stud_len=100;

		var $showProgressText=true;
		var $progressTextPlace=1;
		var $showBack=true;
		var $callback_code="";
		var $callback_timeout="";
      
		var $name="";
		
      function we_progressBar($progress=0,$orientation=0,$showProgressText=true){
         $this->setProgress($progress);
			$this->setOrientation($orientation);
         $this->showProgressText=$showProgressText;
		}

		function getJS(){
			print $this->getJSCode();
			/*
			?>
				<script language="JavaScript" type="text/javascript">					
					function setProgressText(name,text){						
						if(document.getElementById){
							var div = document.getElementById(name);
							div.innerHTML = text;
						}else if(document.all){
							var div = document.all[name];
							div.innerHTML = text;
						}
					}					
				
					function setProgress(progress){						
						var koef=<?php print ($this->stud_len/100)?>;
                  <?php if($this->orientation==1):?>
							document.images["progress_image"].height=koef*progress;
							<?php if($this->showBack):?>document.images["progress_image_bg"].height=(koef*100)-(koef*progress);<?php endif?>                     
						<?php else:?>
							document.images["progress_image"].width=koef*progress;
							<?php if($this->showBack):?>document.images["progress_image_bg"].width=(koef*100)-(koef*progress);<?php endif?>
						<?php endif?>

							if (progress==100) {
								document.images["progress_image"].style.display="none";
							}

						<?php if($this->showProgressText):?>setProgressText("progress_text",progress+"%")<?php endif?>						
						<?php if($this->callback_code!=""):?>
							if(progress<100) to=setTimeout('<?php print $this->callback_code;?>',<?php print $this->callback_timeout;?>); 
							else var to=clearTimeout(to);?>
						<?endif?>
					}
					<?php if($this->callback_code!=""):?>var to=setTimeout('<?php print $this->callback_code;?>',<?php print $this->callback_timeout;?>); <?php endif?>
				</script>

			<?php */
			
		}
		
		function getJSCode(){
				$out = '<script language="JavaScript" type="text/javascript">					
					function setProgressText'.$this->name.'(name,text){						
						if(document.getElementById){
							var div = document.getElementById(name);
							div.innerHTML = text;
						}else if(document.all){
							var div = document.all[name];
							div.innerHTML = text;
						}
					}					
				
					function setProgress'.$this->name.'(progress){						
						var koef='.($this->stud_len/100).';
				';
                if($this->orientation==1){
					$out .=	'document.images["progress_image'.$this->name.'"].height=koef*progress;
					';
					if($this->showBack){
						$out .= 'document.images["progress_image_bg'.$this->name.'"].height=(koef*100)-(koef*progress);
						';
					}
                }else{                     
					$out .= 'document.images["progress_image'.$this->name.'"].width=koef*progress;
					';
					if($this->showBack){
						$out .= 'document.images["progress_image_bg'.$this->name.'"].width=(koef*100)-(koef*progress);
						';
					}
                }
                				
				if($this->showProgressText){
					$out .= 'setProgressText'.$this->name.'("progress_text'.$this->name.'",progress+"%");
					';
				}						
				if($this->callback_code!=""){
					$out .= 'if(progress<100) to=setTimeout(\''.$this->callback_code.'\','.$this->callback_timeout.'); 
							else var to=clearTimeout(to);
					';
				}
				$out .= '}
				';
				if($this->callback_code!=""){
					$out .= 'var to=setTimeout(\''.$this->callback_code.'\','.$this->callback_timeout.');
					';
				}
				$out .= '</script>
				';
				return $out;

		}

		function addText($text="",$place=0,$id="",$class="small",$color="#006699",$height=10, $bold=1){			
			$this->texts[]=array("name"=>$id,"text"=>$text,"class"=>$class,"color"=>$color,"bold"=>$bold,"italic"=>0,"place"=>$place,"height"=>$height);
		}
	
		function setProgress($progress=0){         			
			if($this->progress>100) $this->progress=100;
			$this->progress=$progress;			
		}
		function setName($name){
			$this->name = $name;
		}
		
		function setOrientation($ort=0){
			$this->orientation=$ort;
			if($ort==1) $this->setProgresImages(PROGRESS_V_IMAGE,PROGRESS_V_IMAGE_BG);
			else $this->setProgresImages(PROGRESS_H_IMAGE,PROGRESS_H_IMAGE_BG);
		}

		function setProgresImages($image="",$image_bg=""){
			if($image!="") $this->progress_image=$image;
			if($image_bg!="") $this->progress_image_bg=$image_bg;
		}

		function setCallback($code,$timeout){         			
			$this->callback_code=$code;
			$this->callback_timeout=$code;

			$this->callback='var to=setTimeout("'.$code.'",'.$timeout.');';
		}

		function setStudWidth($stud_width=10){
			$this->stud_width=$stud_width;
		}
		
		function setStudLen($stud_len=100){
			$this->stud_len=$stud_len;
		}

		function setProgressTextPlace($place=0){
			$this->progressTextPlace=$place;
		}

		function setProgressLen($len=100){
			$this->stud_len=$len;
		}

		function setBackVisible($visible=true){
			$this->showBack=$visible;
		}

		function setProgressTextVisible($visible=true){
			$this->showProgressText=$visible;
		}
		
		function emptyTexts(){
			 $this->texts=array();
		}

      function getHTML(){
			$out="";
			
			$left="";
			$right="";
			$top="";
			$bottom="";
			$temp="";
			
			if($this->showProgressText) $this->addText('<div id="progress_text'.$this->name.'">'.$this->progress."%</div>",$this->progressTextPlace);

         foreach($this->texts as $text){				
				switch ($text["place"]) {
				case 0: 					
					$top.='<td '.($text["name"]!="" ? 'id="'.$text["name"].$this->name.'" ' : "").'class="'.$text["class"].'" style="color:' . $text["color"] . ';' . ($text["bold"] ? "font-weight:bold" : "" ) . '">'.$text["text"].'</td>'; 
					$top.='<td>'.getPixel(5,$text["height"]).'</td>'; 
					break;
				case 1: 
               $right.='<td '.($text["name"]!="" ? 'id="'.$text["name"].$this->name.'" ' : "").'class="'.$text["class"].'" style="color:' . $text["color"] . ';' . ($text["bold"] ? "font-weight:bold" : "" ) . '">'.$text["text"].'</td>'; 
               break;					
				case 2:
					$bottom.='<td '.($text["name"]!="" ? 'id="'.$text["name"].$this->name.'" ' : "").'class="'.$text["class"].'" style="color:' . $text["color"] . ';' . ($text["bold"] ? "font-weight:bold" : "" ) . '">'.$text["text"].'</td>'; 
					$bottom.='<td>'.getPixel(5,$text["height"]).'</td>';
					break;					
				case 3:
					$left.='<td '.($text["name"]!="" ? 'id="'.$text["name"].$this->name.'" ' : "").'class="'.$text["class"].'" style="color:' . $text["color"] . ';' . ($text["bold"] ? "font-weight:bold" : "" ) . '">'.$text["text"].'</td>'; 
					break;

				}				
			}
			
         
			$progress_len=($this->stud_len/100)*$this->progress;
			$rest_len=$this->stud_len-$progress_len;
			
			if($top!=""){			
				$out.='<table border="0" cellpadding="0" cellspacing="0">'."\r\n";
				$out.='<tr>'.$top."</tr>\r\n";
				$out.="</table>";
			}

			$out.='<table border="0" cellpadding="0" cellspacing="0">'."\r\n";
         	$out.='<tr>'.($left!="" ? $left."<td>".getPixel(5,1)."</td>" : "");

			if($this->orientation==1){				
				$out.='<td><table border="0" cellpadding="0" cellspacing="0">'.($this->showBack ? '<tr><td><img name="progress_image_bg" src="'.$this->progress_image_bg.'" height="'.$rest_len.'" width="'.$this->stud_width.'"></td></tr>' : "").'<tr><td><img  name="progress_image" src="'.$this->progress_image.'" height="'.$progress_len.'" width="'.$this->stud_width.'"></td></tr></table></td>';
			}				
			else{
				$out.='<td><img name="progress_image'.$this->name.'" src="'.$this->progress_image.'" width="'.$progress_len.'" height="'.$this->stud_width.'"></td>'.($this->showBack ? '<td><img  name="progress_image_bg'.$this->name.'" src="'.$this->progress_image_bg.'" width="'.$rest_len.'" height="'.$this->stud_width.'"></td>' : "");
			}
			
         $out.=($right!="" ? "<td>".getPixel(5,1)."</td>".$right : "")."</tr>";
			$out.="</table>";

			if($bottom!=""){
				$out.='<table border="0" cellpadding="0" cellspacing="0">'."\r\n";
				$out.='<tr>'.$bottom."</tr>\r\n";
				$out.="</table>";
			}

			return $out;
			
		}

}
