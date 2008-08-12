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