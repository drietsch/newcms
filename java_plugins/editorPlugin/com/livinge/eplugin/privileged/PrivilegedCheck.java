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


public class PrivilegedCheck implements PrivilegedAction {

		String path;
		public long LastChange=0;
		
		public PrivilegedCheck(String file){
			path=file;
		}
		
		
		public Object run(){
			try{
				
				LastChange= (new File(path)).lastModified();

			}
			catch(Exception e){
				e.printStackTrace();
			}
			return null;
		}
	
	
}