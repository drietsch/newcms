<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

class weXMLFileReader {
	
	function readLine($filename,&$data,&$offset,$lines=1,$size=0,$iscompressed=0){
		
		if($filename=='') return false;
		if(!is_readable($filename)) return false;
		
		if($iscompressed==0){
			$open = 'fopen';
			$seek = 'fseek';
			$tell = 'ftell';
			$gets = 'fgets';
			$close = 'fclose';
			$eof = 'feof';
			
		} else {
			$open = 'gzopen';
			$seek = 'gzseek';
			$tell = 'gztell';
			$gets = 'gzgets';
			$close = 'gzclose';
			$eof = 'gzeof';
		
		}
		
		
		$_fp=$open($filename,'rb');
		
		
		if($_fp){
			
			if($seek($_fp,$offset,SEEK_SET)==0){
				
				$i = 0;
				$_condition = false;
				
				do{	
					$_buffer = '';					
					$_count = 0;
					$_rsize = 8192; // read 8KB
					do{

   						$_buffer .= $gets($_fp,$_rsize);
   						
   						$_first = substr($_buffer,0,256);
   						$_end = substr($_buffer,-20,20);
						
   						// chek if line is complite
						$_iswestart = eregi('<webEdition',$_first);
						$_isweend = eregi('</webEdition>',$_end);
						$_isxml = eregi('<\?xml',$_first);
						
						$_isend = eregi('<!-- webackup -->',$_end) || empty($_buffer);

   						if($_isend) {
   							
   							if($this->preParse($_first)) {
   								$_buffer = '';
   								$_isend = $eof($_fp);
   							}
   							
   						}
   												 
						
						if($_iswestart || $_isweend || $_isxml) {
							$_buffer = '';
							$_isend = $eof($_fp);
						}
						// -----------------------------------------------------
						
   						// avoid endless loop
   						$_count++;
   						if($_count>100000){
   							break;
   						}

					} while(!$_isend);
					
					//  check condition
					if($size > 0) {
						if(empty($_buffer)) {
							$_condition = false && !$eof($_fp);
						} else {
							$i = strlen($_buffer);
							if($i < $size){
								$_condition = true && !$eof($_fp);;
							} else {
								$_condition = false && !$eof($_fp);;
							}
							
						}
					}else if($lines > 0) {
						if($i < $lines) {
							$_condition = true && !$eof($_fp);;
						} else {
							$_condition = false && !$eof($_fp);;
						}						
						$i++;
					}
					
					
					$data .= $_buffer;
				

				} while($_condition);

				
				
				
				unset($_buffer);
				
				$offset = $tell($_fp);
				
				$close($_fp);

				if(empty($data)) {
					return false;
				} else {
				return true;
				}
			}
			else{
				$close($_fp);
				return false;
			}
		}
		else {
			return false;
		}
						
	}
	
	function preParse(&$content) {
		return false;
	}
	
	
}


?>