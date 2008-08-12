<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_codeConvertor.inc.php");
	
define("EOF",-999999);

class we_rtf2html{        
    var $current=-1;
    var $fileContent="";
    var $htmlOut="";
    var $stack=array();
    var $align=array();
    
    var $skip=false;

    var $group=0;
    var $skip_group=0;
    var $first_control=0;
    
    var $dflFont=true;
    var $dflSize=true;
    var $dflColor=true;

    var $dflFontIndex=0;

    var $rtf_cons=array();
    var $fontTable=array();
    var $colorTable=array();
    var $codepage="";
    var $standard="ansi";

    var $prevFont=array();
    var $prevSize=array();
    var $prevColor=array();

    var $applyNames=true;
    var $applySize=true;
    var $applyColor=true;
    var $bulletPara=false;
    
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------        
    
    function we_rtf2html($fileName,$applyFontNames=true,$applyFontSize=true,$applyFontColor=true){
	  $tempName = TMP_DIR."/".md5(uniqid(rand(),1));
	  move_uploaded_file($fileName,$tempName);
	  $fileName = $tempName;
      $this->fName=$fileName;
      $this->applyNames=$applyFontNames;
      $this->applySize=$applyFontSize;
      $this->applyColor=$applyFontColor;
                 
      $fp=fopen($fileName,"rb");
      if ($fp) {
        $this->fileContent = @fread ($fp, @filesize ($fileName));
      }
      fclose($fp);
      
      $this->initControlTable();
      $this->colectInfo();

      $this->current=-1;
      if(substr($this->fileContent,0,5) == "{\\rtf"){ //##TODO## have to check if this clause is correct!!!
      	$this->parseRtf();
      	$this->correctLists();
      }else{
      	//$this->htmlOut = eregi_replace('^.*<body[^>]*>(.*)</body>.*$','\1',$this->fileContent);
		   $this->htmlOut = eregi_replace('<\?[^>]+>','',$this->fileContent);
      }

    }    
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
	function correctLists(){
		$this->htmlOut = eregi_replace("</li><br>(\r?\n)<li>",'</li>\1<li>',$this->htmlOut);
		$this->htmlOut = eregi_replace("<br>(\r?\n)<li>",'<ul>\1<li>',$this->htmlOut);
		$this->htmlOut = str_replace('</li><br>','</li></ul>',$this->htmlOut);
	}
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
    function initControlTable(){      
     $this->rtf_cons[0]=array("b",          "property",    "<b>","</b>");
     $this->rtf_cons[1]=array("ul",          "property",    "<u>","</u>");
     $this->rtf_cons[2]=array("i",          "property",    "<i>","</i>");          
     $this->rtf_cons[3]=array("fs",        "property",     "<font style=\"{font-size=%spt}\">","</font>");
     $this->rtf_cons[4]=array("tab",       "property",     "	","");                         
     $this->rtf_cons[6]=array("cols",       "property",    "","");
     $this->rtf_cons[7]=array("sbknone",    "property",    "","");
     $this->rtf_cons[8]=array("sbkcol",     "property",    "","");
     $this->rtf_cons[9]=array("sbkeven",    "property",    "","");
     $this->rtf_cons[10]=array("sbkodd",    "property",    "","");
     $this->rtf_cons[11]=array("sbkpage",   "property",    "","");
     $this->rtf_cons[12]=array("pgnx",      "property",    "","");
     $this->rtf_cons[13]=array("pgny",      "property",    "","");
     $this->rtf_cons[14]=array("pgndec",    "property",    "","");
     $this->rtf_cons[15]=array("pgnucrm",   "property",    "","");
     $this->rtf_cons[16]=array("pgnlcrm",   "property",    "","");
     $this->rtf_cons[17]=array("pgnucltr",  "property",    "","");
     $this->rtf_cons[18]=array("pgnlcltr",  "property",    "","");
     $this->rtf_cons[19]=array("qc",        "property",    '<div align="center">',"</div>");
     $this->rtf_cons[20]=array("ql",        "property",    '<div align="left">',"</div>");
     $this->rtf_cons[21]=array("qr",        "property",    '<div align="right">',"</div>");
     $this->rtf_cons[22]=array("qj",        "property",    '<div align="justify">',"</div>");
     $this->rtf_cons[23]=array("paperw",    "property",    "","");
     $this->rtf_cons[24]=array("paperh",    "property",    "","");
     $this->rtf_cons[25]=array("margl",     "property",    "","");
     $this->rtf_cons[26]=array("margr",     "property",    "","");
     $this->rtf_cons[27]=array("margt",     "property",    "","");
     $this->rtf_cons[28]=array("margb",     "property",    "","");
     $this->rtf_cons[29]=array("pgnstart",  "property",    "","");
     $this->rtf_cons[30]=array("facingp",   "property",    "","");
     $this->rtf_cons[41]=array("landscape", "property",    "","");
     $this->rtf_cons[42]=array("par",       "property",    "<br>\n");
     $this->rtf_cons[43]=array("\0x0a",     "spec_char",    "\n");
     $this->rtf_cons[44]=array("\0x0d",     "spec_char",    "\r");
     $this->rtf_cons[45]=array("tab",       "spec_char",    "\t");
     $this->rtf_cons[46]=array("ldblquote", "spec_char",    '"');
     $this->rtf_cons[47]=array("rdblquote", "spec_char",    '"');
     $this->rtf_cons[48]=array("bin",       "special",    "","");
     $this->rtf_cons[49]=array("*",         "special",    "","");
     $this->rtf_cons[50]=array("'",         "special",    "","");
     $this->rtf_cons[51]=array("author",    "jump",    "","");
     $this->rtf_cons[52]=array("buptim",    "jump",    "","");
     $this->rtf_cons[53]=array("colortbl",  "jump",    "","");
     $this->rtf_cons[54]=array("comment",   "jump",    "","");
     $this->rtf_cons[55]=array("creatim",   "jump",    "","");
     $this->rtf_cons[56]=array("doccomm",   "jump",    "","");
     $this->rtf_cons[57]=array("fonttbl",   "jump",    "","");
     $this->rtf_cons[58]=array("footer",    "jump",    "","");
     $this->rtf_cons[59]=array("footerf",   "jump",    "","");
     $this->rtf_cons[60]=array("footerl",   "jump",    "","");
     $this->rtf_cons[61]=array("footerr",   "jump",    "","");
     $this->rtf_cons[62]=array("footnote",  "jump",    "","");
     $this->rtf_cons[63]=array("ftncn",     "jump",    "","");
     $this->rtf_cons[64]=array("ftnsep",    "jump",    "","");
     $this->rtf_cons[65]=array("ftnsepc",   "jump",    "","");
     $this->rtf_cons[66]=array("header",    "jump",    "","");
     $this->rtf_cons[67]=array("headerf",   "jump",    "","");
     $this->rtf_cons[68]=array("headerl",   "jump",    "","");
     $this->rtf_cons[69]=array("headerr",   "jump",    "","");
     $this->rtf_cons[70]=array("info",      "jump",    "","");
     $this->rtf_cons[71]=array("keywords",  "jump",    "","");
     $this->rtf_cons[72]=array("operator",  "jump",    "","");
     $this->rtf_cons[73]=array("pict",      "jump",    "","");
     $this->rtf_cons[74]=array("printim",   "jump",    "","");
     $this->rtf_cons[75]=array("private1",  "jump",    "","");
     $this->rtf_cons[76]=array("revtim",    "jump",    "","");
     $this->rtf_cons[77]=array("rxe",       "jump",    "","");
     $this->rtf_cons[78]=array("stylesheet","jump",    "","");
     $this->rtf_cons[79]=array("subject",   "jump",    "","");
     $this->rtf_cons[80]=array("tc",        "jump",    "","");
     $this->rtf_cons[81]=array("title",     "jump",    "","");
     $this->rtf_cons[82]=array("txe",       "jump",    "","");
     $this->rtf_cons[83]=array("xe",        "jump",    "","");
     $this->rtf_cons[84]=array("{",         "spec_char",    '{'); 
     $this->rtf_cons[85]=array("}",         "spec_char",    '}'); 
     $this->rtf_cons[86]=array("\\",        "spec_char",    '\\');
     $this->rtf_cons[87]=array("f",         "property",    "<font face=\"%s\">","</font>");
     $this->rtf_cons[88]=array("pntext",    "property",    "<li>","</li>");
     $this->rtf_cons[89]=array("line",      "property",     "<br>","");
     $this->rtf_cons[90]=array("pict",      "jump",     "","");
     $this->rtf_cons[91]=array("ulnone",    "property",    "</u>","");
     $this->rtf_cons[92]=array("pntxta",    "jump",    "","");
     $this->rtf_cons[93]=array("pntxtb",    "jump",    "","");
     $this->rtf_cons[94]=array("cf",        "property",    "<font color=\"%s\">","</font>");
     $this->rtf_cons[95]=array("pard",      "property",    "","");
     $this->rtf_cons[96]=array("<",			  "spec_char",    '&lt;');
     $this->rtf_cons[97]=array(">",         "spec_char",    '&gt;');
     $this->rtf_cons[98]=array("'c",        "special",    "Ä","");
     $this->rtf_cons[99]=array("'d",        "special",    "","");
     $this->rtf_cons[100]=array("'e",       "special",    "","");
     $this->rtf_cons[101]=array("'f",       "special",    "","");
     $this->rtf_cons[104]=array("u",        "special",    "","");
     $this->rtf_cons[105]=array("\r",       "spec_char",    "<br>\n","");
     $this->rtf_cons[106]=array("\n",       "spec_char",    "<br>\n","");
	 $this->rtf_cons[107]=array("panose",   "special",    "","");
    }    
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------
	function colectInfo(){ 
     
		$ch="";
		$infocon="";
		$kind=0; //1-font table; 2-color table;
		$fonttbl="";
		$colortbl="";
     
		$tableproc=false; 
		$g=1;
     
		$font_fin=false;
		$color_fin=false;
     
     
		$ch=$this->getNextCh();   
		while($ch!=EOF){
			switch ($ch){
				case '{':
					if(substr($infocon,0,7)=="fonttbl"){ $kind=1; $g=1; $tableproc=true;$infocon="";}
					if(substr($infocon,0,8)=="colortbl"){ $kind=2; $g=1; $tableproc=true;$infocon="";} 
					if($tableproc) $g++; 
				break;
				case '}':               
					if($tableproc) {                 
						$g--; 
						if($g==0){
							$g=1;                  
							$tableproc=false;
							if($kind==1) {$fonttbl=$infocon;$kind=0;$infocon="";$font_fin=true;}
							if($kind==2) {$colortbl=$infocon;$kind=0;$infocon="";$color_fin=true;}                  
						} 
					}  
				break;
				case '\\':
					if(substr($infocon,0,7)=="fonttbl"){ $kind=1; $g=1; $tableproc=true;$infocon="";}
					if(substr($infocon,0,8)=="colortbl"){ $kind=2; $g=1; $tableproc=true;$infocon="";}               
					if(substr($infocon,0,7)=="ansicpg"){ $this->codepage=substr($infocon,7);$infocon="";}
					if($infocon=="mac"){ $this->standard=$infocon;$infocon="";}
					if($kind==0) $infocon=""; else if($g<3) $infocon.="\\"; else $infocon.=" ";
				break;
				case "\r":
				case "\n":
				break;
				default:          
					if($g<3) $infocon.=$ch;
				break;
			} 
			$ch=$this->getNextCh();  
			if($font_fin && $color_fin) break;			
		}
		$this->parseFontTable($fonttbl);
		$this->parseColorTable($colortbl);
   }
   
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
   function hexColor($red,$green,$blue){
     $hex="0123456789abcdef";
     $h1=substr($hex,floor($red/16),1);     
     $h2=substr($hex,$red%16,1);     
     $h3=substr($hex,floor($green/16),1);    
     $h4=substr($hex,$green%16,1);
     $h5=substr($hex,floor($blue/16),1);
     $h6=substr($hex,$blue%16,1);    
     return "#".$h1.$h2.$h3.$h4.$h5.$h6;
   }
    
#-------------------------------------------------------------------------------------------
#-------------------------------------------------------------------------------------------    

  function parseFontTable($fonttbl){

    $a=array();
    $b=array();
	 $ident=0;

    $a=explode(";",$fonttbl);
    foreach($a as $k=>$v){
      $b=explode(" ",$v);       
		$name="";
      $m=array();
		if(preg_match("/f([0-9]+)/",$b[0],$m)){        			
			$ident=$m[1];
		}		
		if($k==0) $this->dflFontIndex=$ident;
      for($i=1;$i<count($b);$i++) $name.=$b[$i]." ";
      $name=trim($name);
      if($name!="") $this->fontTable[$ident]=$name;
		$ident++;
    }
  }

#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    

  function parseColorTable($colortbl){	
    $a=array();
    $b=array();
	 array_push($this->colorTable,$this->hexColor(0,0,0));
    $a=explode(";",$colortbl);
    foreach($a as $k=>$v){       		
		if($v!=""){
			$m=array();
			if(preg_match("/red([0-9]+)/",$v,$m)) $red=$m[1];		
			$m=array();
			if(preg_match("/green([0-9]+)/",$v,$m)) $green=$m[1];	
			$m=array();
			if(preg_match("/blue([0-9]+)/",$v,$m)) $blue=$m[1];		
			array_push($this->colorTable,$this->hexColor($red,$green,$blue));
		}
	 }
 } 
 
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
  function parseRtf()
  {

    $ch="";
    $cNibble = 2;
    $b = 0;
        
    $ch=$this->getNextCh();   
    while($ch!=EOF)
     {        
        switch ($ch)
            {
            case '{': 
					$this->pushGroup();
            break;
            case '}': 
					$this->popGroup();
            break;
            case '\\': 
					if(($this->skip_group>$this->group)||($this->skip_group==0)) $this->parseControl();                    
            break;
            case "\r":
            case "\n":
            break;
            default:
					if(($this->skip_group>$this->group)||($this->skip_group==0)) $this->pasteChars($ch);              
            break;
        } 
		$ch=$this->getNextCh();  
     }    
     
     if ($this->group < 0)return false;
     
     return true;
  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
  function pushGroup(){

    if($this->first_control==0) $this->first_control=1;
    $this->group++;
    
	 $this->stack[$this->group]=array();
    $this->prevFont[$this->group]=array();
    $this->prevSize[$this->group]=array();            
    $this->prevColor[$this->group]=array();            

  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------      
  function popGroup(){        
    while(count($this->stack[$this->group])!=0){
     $key=$this->popStack();
     if($key==-1) break;
     if($this->rtf_cons[$key][3]!="") $this->pasteChars($this->rtf_cons[$key][3]);          
     if($key==87) $this->prevFont[$this->group]["index"]=$this->dflFontIndex;
     if($key==3) $this->prevSize[$this->group]["index"]=0;          
     if($key==94) $this->prevColor[$this->group]["index"]=0;          
    }   
    if($this->group==$this->skip_group) $this->skip_group=0;
    $this->group--;

  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
  function getCurrentCh(){
  	if(isset($this->fileContent[$this->current]))
    	return $this->fileContent[$this->current];
    else
    	return null;
  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------      
  function getPrevCh(){
    if($this->current>0){
     $this->current--;     
     return $this->getCurrentCh();
    }

    else{return false;}
  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------      
  function getNextCh(){
    if($this->current<strlen($this->fileContent))
    {
      $this->current++;
      return $this->getCurrentCh();
    }
    else{
      return EOF;
    }

  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
  function parseControl(){
    $ch="";
    $neg = false;

    $control="";
    $para="";

    $ch=$this->getNextCh();
    
    if($ch == "\r" || $ch == "\n"){
    	return $this->analyzeControl($ch,$para);
    }

    if ((!$this->isletter($ch))&&($ch!="'"))
    {
        $control =  $ch;
        return $this->analyzeControl($control,$para);
    }

    if($ch=="'") $sfch=true;
    else $sfch=false;

    while(($this->isletter($ch))||($ch=="'")||($ch=="B")) {
        $control.=$ch;
        $ch = $this->getNextCh();
	if($sfch){ $control.=$ch; $ch =$this->getNextCh(); break;}
    }

    $neg=false;

    if ($ch == '-') {
        $neg=true;
        $ch=$this->getNextCh();
    }

    if ($this->isnumber($ch))
    {
        while($this->isnumber($ch)) {
         $para.=$ch;
         $ch = $this->getNextCh();
        }
    }
    else if($this->isletter($ch)){
		$para=$ch;
		$ch = $this->getNextCh();
    }

    if($ch=="?") $para.=$ch; #exceptions for the unicode chars which are coded like "\uN?"
    if ($neg) $para = "-".$para;
    if ($ch != ' ' && $ch != "?") $ch=$this->getPrevCh();
    if ($sfch && $ch == ' '){
		 $ch=$this->getPrevCh();
	 }
	 
	 if (substr($control,0,1)=="'"){				 
		 $para=substr($control,1).$para;
		 $control="'";
	 }
    
	 return $this->analyzeControl($control,$para);
  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
  function isletter($ch){
   if((ord($ch)>96)&&(ord($ch)<123)) return true;
   else return false;
  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
  function isnumber($ch){
   if((ord($ch)>47)&&(ord($ch)<58)) return true;
   else return false;
  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------
  function analyzeControl($control,$para=""){

    $last=0;

    foreach($this->rtf_cons as $key=>$value){
      if($value[0]==$control) break;
      $last++;
    }

    if($last==count($this->rtf_cons))
    {
        return false;
    }

    switch ($value[1])
    {
     case "property": $this->propParse($key, $para); break;
     case "spec_char": $this->pasteChars($this->rtf_cons[$key][2]);break;
     case "jump":
     case "special":
     default:$this->specialParse($key,$para);break;
    }

    $this->first_control++;
    if($this->first_control>1) $this->first_control=0;
    
    return true;

     
  }
  
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
 function propParse($key,$para="") {
      
	   if(($key==19)||($key==20)||($key==21)){
       array_push($this->align,$key);      
      }
      
      if($key==95){
      	$pp=array_pop($this->align);
       if($pp) $this->pasteChars($this->rtf_cons[$pp][3]);
               		
       $ret=$this->popStack(0); while ($ret>-1){ $this->pasteChars($this->rtf_cons[$ret][3]);$ret=$this->popStack(0);}
		 $ret=$this->popStack(1); while ($ret>-1){ $this->pasteChars($this->rtf_cons[$ret][3]);$ret=$this->popStack(1);}
		 $ret=$this->popStack(2); while ($ret>-1){ $this->pasteChars($this->rtf_cons[$ret][3]);$ret=$this->popStack(2);}		 
      }
      
      if($key==42 && $this->bulletPara){                    
       $this->pasteChars($this->rtf_cons[88][3]);        
       $this->bulletPara=false;
      }

      
      switch ($key){
                  
      case 87:
         if($this->applyNames){

          if($this->dflFont){
				 $this->pasteChars(sprintf($this->rtf_cons[$key][2],$this->fontTable[$para]));
				 $this->putOnStack($key);$this->dflFont=false;
			 }
          else {
             $this->pasteChars(sprintf($this->rtf_cons[$key][2],$this->fontTable[$para]));                
             $this->putOnStack($key); 
             $this->prevFont[$this->group]["index"]=$para;             
          }
         }             
      break;
      case 94:          
            if($this->applyColor){
             if($this->dflColor){ 
                     $this->pasteChars(sprintf($this->rtf_cons[$key][2],$this->colorTable[$para]));
                     $this->putOnStack($key);
                     $this->dflColor=false;
                     $this->prevColor[$this->group]["index"]=$para;
             }
             else {
               $this->pasteChars(sprintf($this->rtf_cons[$key][2],$this->colorTable[$para]));
               $this->putOnStack($key); 
               $this->prevColor[$this->group]["index"]=$para;                           
             }
          }
          

          
      break;  
      case 4:
         $this->pasteChars($this->rtf_cons[$key][2]);                        
      break;
      case 88:
         $this->pasteChars($this->rtf_cons[$key][2]);
         $this->bulletPara=true;
         $this->skip_group=$this->group;
      break;        
      case 91:
          if($this->htmlOut!="") $this->pasteChars($this->rtf_cons[$key][2]);
      break;     
      case 42:
      case 89:
          $this->pasteChars($this->rtf_cons[$key][2]);
      break;  
      case 3:         
         if($this->applySize){
                if($this->dflSize){ 
                        $this->pasteChars(sprintf($this->rtf_cons[$key][2],$para/2));
                        $this->putOnStack($key);
                        $this->dflSize=false;
                        $this->prevSize[$this->group]["index"]=$para;                           
                }
                else if($para<$this->prevSize[$this->group]["index"]) {                                    
                  $this->pasteChars($this->rtf_cons[$key][3]);                              
                  
                  $this->popStack($key);
                  $this->prevSize[$this->group]["index"]=$para;   
                  
                }
                else {
                  $this->pasteChars(sprintf($this->rtf_cons[$key][2],$para/2));                                                                           
                  $this->putOnStack($key);
                  $this->prevSize[$this->group]["index"]=$para;
                }
          }                                                
      break;           
         default:
            if($para=="0"){
             if($this->rtf_cons[$key][3]!="") {     
              $this->pasteChars($this->rtf_cons[$key][3]);        
              $this->popStack($key);
              
             }
            }  
            else{               
             if($this->rtf_cons[$key][2]!=""){
              $this->pasteChars($this->rtf_cons[$key][2]);                         
              $this->putOnStack($key);
             }
              
            }
         break;        
      }

 }
#-------------------------------------------------------------------------------------------
#-------------------------------------------------------------------------------------------
  function specialParse($key,$para) {
	
	$go=true;    
	switch($key){
		case 98: if($para=="4") $this->pasteChars("Ä"); # AE
				 $go=false;
		break;
		case 99: if($para=="6") $this->pasteChars("Ö"); 
				 if($para=="c") $this->pasteChars("Ü"); 
				 if($para=="f") $this->pasteChars("ß"); # OE and UE
				 $go=false;
      break;
		case 100: if($para=="4") $this->pasteChars("ä"); # ae
				  $go=false;
		break;
		case 101: if($para=="6") $this->pasteChars("ö"); if($para=="c") $this->pasteChars("ü"); #  oe and ue
			$go=false;
		break;
		case 104:
				$this->pasteChars("&#".$para);
				$go=false;
		break;	 
		case 50:
			if($this->codepage=="1251" || $this->codepage=="1252" || $this->codepage=="10000" ){				
				$this->pasteChars("&#x".we_codeConvertor::toUnicode($this->codepage,strtoupper($para)).";");				
			} 
			else{
				if($this->standard=="mac")
					$this->pasteChars("&#x".we_codeConvertor::toUnicode("10000",strtoupper($para)).";");
				else
					$this->pasteChars("&#x".we_codeConvertor::toUnicode("1252",strtoupper($para)).";");
			}
			$go=false;			
		break;
   } 
    
   if($go)
    if((($this->skip_group>$this->group)||($this->skip_group==0))&&($this->first_control==1)) {   
        $this->skip_group=$this->group;        
   }
        
                        
  }
 

   
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------     
  function pasteChars($chars) {	 
    $this->htmlOut.=$chars;
  }

#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------    
  function putOnStack($key){
   $this->stack[$this->group][count($this->stack[$this->group])]=$key;	  
  }
#-------------------------------------------------------------------------------------------    
#-------------------------------------------------------------------------------------------      
 function popStack($key=-1){
  $ret=-1;
  if(is_array($this->stack[$this->group])){
   if($key==-1){       
       $ret=array_pop($this->stack[$this->group]);  
       return $ret;     
    }
   else{      
      $count=count($this->stack[$this->group])-1;
      for($i=$count;$i>-1;$i--){   
       if(($key!=-1)&&($this->stack[$this->group][$i]==$key)){                     
        $ret=$this->stack[$this->group][$i];
        array_splice($this->stack[$this->group],$i,1);                    
        return $ret;
       }                 
      }   
   }
  }   
  return $ret;
 }
    
}


?>