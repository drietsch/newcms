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

package com.livinge.eplugin.editor;
import java.io.File;
import java.io.IOException;
import java.io.Serializable;
import java.util.Vector;



/*
 * Created on Oct 20, 2004
 *
 * TODO To change the template for this generated file go to
 * Window - Preferences - Java - Code Style - Code Templates
 */

/**
 * @author Slavko Tomcic
 *
 * TODO To change the template for this generated type comment go to
 * Window - Preferences - Java - Code Style - Code Templates
 */
public class WeEditor extends BaseElement implements Serializable{

	static final long serialVersionUID = -1611200117062004002L;
	public String Name;
	public String Path;
	public String Args="";
	public String ContentType;
	public String DefaultFor;	
	public String Encoding;
	
	public WeEditor(){
		persistents = new Vector();
		persistents.add("Name");
		persistents.add("Path");
		persistents.add("Args");
		persistents.add("ContentType");
		persistents.add("DefaultFor");
		persistents.add("Encoding");
	}
	
	public void init(String name, String path, String args, String ct, String defaultfor,String enc){
		Name=name;
		Path=path;
		Args=args;
		ContentType=ct;
		DefaultFor=defaultfor;
		Encoding=enc;
	}
	
	
	public int start(EPDocument doc) {
		if(doc.isText()) {
			doc.setEncoding(Encoding);
    		doc.saveSource();
    	}

		if(new File(Path).exists()) {
			doc.setCheck(true);
			return start(doc.getCacheFilename());
		} else {
			return -1;
		}
	}
	
	 public int start(String cache){
	 	try{
	 		if(!Path.equals("")){
	 			if(System.getProperty("os.name").matches("Mac OS X")) {				
	 					String cmd;
	 					String opt;
	 					cmd="/usr/bin/open";
	 					opt="-a";
	 					String[] exe = {cmd,opt,Path,Args,cache};
	 					Runtime.getRuntime().exec(exe);
	 			}
	 			else{
					String[] exe = {Path,Args,cache};
					Runtime.getRuntime().exec(exe);
				}

	 			return 0;
	 		}
		} catch (IOException e1) {
			System.err.println(e1);
		}
		return -1;
	 }
	 
	 
}
