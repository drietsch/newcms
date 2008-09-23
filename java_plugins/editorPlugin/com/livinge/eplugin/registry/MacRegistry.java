/*
 * MacRegistry.java
 *
 * Created on February 28, 2007, 3:24 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package com.livinge.eplugin.registry;

/**
 *
 * @author Slavko Tomcic
 */

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
