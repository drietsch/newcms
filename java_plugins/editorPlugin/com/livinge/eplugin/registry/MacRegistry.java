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

package com.livinge.eplugin.registry;


import java.io.File;
import java.net.URL;
import java.util.Vector;

import com.livinge.eplugin.editor.WeSettings;
import com.livinge.eplugin.util.CmdProxy;
import com.livinge.eplugin.util.CopyUtility;


public class MacRegistry implements Registry {

	String registryTool = "";

	String editorOnly = "true";
	
	public MacRegistry(WeSettings ws){
		
		URL url;
		registryTool = ws.registryDir + "gal";
		File rt = new File(registryTool);
	
		String sUrl = ws.getHost() + "/" + ws.getAppDir() + "/eplugin/gal";
		
		if(!rt.exists()) {

			try {
				
				url = new URL(sUrl);
				CopyUtility.copy(url, registryTool);
				CmdProxy.executeCmd("chmod +x " + registryTool);
				
			} catch (Exception e) {
				e.printStackTrace();
			}
			
		}
		
		
		
	}
	
	public Vector getAppList(String extension) {
	
		Vector out = new Vector();
		
		String stout = CmdProxy.executeCmd(registryTool + " " + extension + " " + editorOnly );
				
		if(!stout.equals("Bus error")) {
			String[] arr = stout.split("\n");
			if(arr.length>0) {
				for(int i = 0; i<arr.length;i++) {
					if((arr[i].trim()).length()>0) {
						out.add(arr[i]);
					}
				}
			}
		}
		
		return out;
		
		
	 }
	
}
