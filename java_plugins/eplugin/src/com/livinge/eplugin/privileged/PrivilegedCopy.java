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