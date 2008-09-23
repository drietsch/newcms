package com.livinge.eplugin.privileged;

import java.io.File;
import java.net.URL;
import java.security.PrivilegedAction;

import com.livinge.eplugin.util.CopyUtility;

public class PrivilegedPrepareEditFile implements PrivilegedAction {
	private URL SourceUrl;
	private String DestinationFilename;
	
	public PrivilegedPrepareEditFile(URL url,String filename) {
		SourceUrl = url;
		DestinationFilename = filename;
	}
	
	public Object run() {
		
		 String out="";
		  
		 try { 
		     
			 File d = new File(DestinationFilename).getParentFile();
			 if (!d.exists()){
			    	d.mkdirs();
			 }
			 
			 CopyUtility.copy(SourceUrl,DestinationFilename);
			 
			 return DestinationFilename;
			  
		 } catch (Exception e) { 
		      
		 }
		  
		  return out;		

	}
}
