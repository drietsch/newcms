package com.livinge.eplugin.privileged;

import java.security.PrivilegedAction;

public class PrivilegedSystemProperties implements PrivilegedAction{

	public String Property = "";
	public String Value = "";
	
	public PrivilegedSystemProperties(String prop) {
		
		Property = prop;
		
	}
	
	public Object run(){
		try{

			Value =  System.getProperty(Property);

		}
		catch(Exception e){
			e.printStackTrace();
		}
		return null;
	}
	
}
