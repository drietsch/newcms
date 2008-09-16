package com.livinge.eplugin.editor;
/*
 * Created on Oct 20, 2004
 *
 * TODO To change the template for this generated file go to
 * Window - Preferences - Java - Code Style - Code Templates
 */

/**
 * @author slavko
 *
 * TODO To change the template for this generated type comment go to
 * Window - Preferences - Java - Code Style - Code Templates
 */
import java.lang.reflect.*;
import java.util.Vector;

abstract class BaseElement{
		
	protected Vector persistents;
	
	public BaseElement(){
		//System.out.println("enter base element");
		persistents = new Vector(); 
	}
	
	public String object2xml(){

		Class c = this.getClass();
		//System.out.println(c.getName());
		//String out="\t<we:"+c.getName()+">"+ System.getProperty("line.separator");
		
		String elname = "Editor";
		
		String out="\t<"+elname+">"+ System.getProperty("line.separator");
				
		Field[] Fields = c.getFields();
	      //System.out.println(publicFields.length);
		for (int i = 0; i < Fields.length; i++) {
			
			String fieldName = Fields[i].getName();
			
			if(persistents.indexOf(fieldName)!=-1){
				//Class typeClass = Fields[i].getType();
				//String fieldType = typeClass.getName();
				try {
					out+="\t\t<"+Fields[i].getName()+">"+Fields[i].get(this)+"</"+Fields[i].getName()+">"+ System.getProperty("line.separator");
					//System.out.println("Name: " + fieldName +", Type: " + fieldType);
				} catch (SecurityException e) {
					System.out.println(e);
				} catch (IllegalAccessException e) {
					System.out.println(e);
				}
			}
		}
	      		
		out+="\t</"+elname+">"+ System.getProperty("line.separator");
		
		return out;
		
	}
	
	public String initObject(){
		return "";
	
		
	}
	
}
