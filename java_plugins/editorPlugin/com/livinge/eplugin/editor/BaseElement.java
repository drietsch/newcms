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
