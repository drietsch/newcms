/*
 * CmdProxy.java
 *
 * Created on February 28, 2007, 3:26 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package com.livinge.eplugin.util;

import java.security.AccessController;

import com.livinge.eplugin.privileged.PrivilegedRun;


/**
 *
 * @author slavko
 */
public class CmdProxy {
    
   private CmdProxy() {
		
	}
	
	public static String executeCmd(String cmd) {
		  
		  String out = new String();
		  
		  PrivilegedRun pr = new PrivilegedRun(cmd);
		  out = (AccessController.doPrivileged(pr)).toString();
		  
		  return out;
		  
	}
    
}
