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

import java.security.PrivilegedAction;

import com.livinge.eplugin.util.StreamWrapper;

public class PrivilegedRun implements PrivilegedAction {

	
	private String Command;
	
	public PrivilegedRun(String cmd){
		
		Command = cmd;
		
	}
	
	
	public Object run() {
		
		 String out = new String();
		  
		 try { 
		      Process process = Runtime.getRuntime().exec(Command);
		      StreamWrapper reader = new StreamWrapper(process.getInputStream()); 
		      reader.start(); 
		      process.waitFor(); 
		      reader.join(); 
		      out = reader.getResult(); 
			  
		 } 
		    catch (Exception e) { 
		      //return null; 
		 }
		  
		  return out;		

	}

}