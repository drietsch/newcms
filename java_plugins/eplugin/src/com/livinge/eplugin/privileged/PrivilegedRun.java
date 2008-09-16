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