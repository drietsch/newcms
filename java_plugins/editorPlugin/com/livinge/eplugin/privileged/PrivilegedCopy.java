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

import java.net.URL;
import java.security.PrivilegedAction;

import com.livinge.eplugin.util.CopyUtility;

public class PrivilegedCopy implements PrivilegedAction {
	
	private URL SourceUrl;
	private String DestinationFilename;
	
	public PrivilegedCopy(URL url,String filename) {
		
		SourceUrl = url;
		DestinationFilename = filename;
		
	}
	
	
	public Object run() {
		
		 String out="";
		  
		 try { 
		    
			 CopyUtility.copy(SourceUrl,DestinationFilename);
			 
			 return DestinationFilename;
			  
		 } catch (Exception e) { 
		      
		 }
		  
		  return out;		

	}

}