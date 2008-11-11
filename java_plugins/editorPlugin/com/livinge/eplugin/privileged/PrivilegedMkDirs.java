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
 * A copy is found in the textfile license.txt
 *
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

package com.livinge.eplugin.privileged;

import java.io.File;
import java.security.PrivilegedAction;

public class PrivilegedMkDirs implements PrivilegedAction {

	
	private String Path;
	
	public PrivilegedMkDirs(String p){
		
		Path = p;
		
	}
	
	
	public Object run() {
		
		 String out="";
		  
		 try { 
		    
			 File d = new File(Path);
			 if (!d.exists()){
			    	d.mkdirs();
			 }
			 return d.getPath();
			  
		 } catch (Exception e) { 
		      
		 }
		  
		  return out;		

	}

}