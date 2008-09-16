/*
 * StreamReader.java
 *
 * Created on February 28, 2007, 3:28 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package com.livinge.eplugin.util;

import java.io.IOException;
import java.io.InputStream;
import java.io.StringWriter;

/**
 *
 * @author slavko
 */
public class StreamWrapper  extends Thread {
    
        private InputStream is; 
	    private StringWriter sw;
            
	    public StreamWrapper(InputStream is) { 
	      this.is = is; 
	      sw = new StringWriter(); 
	    }
            
	    public void run() { 
	      try { 
	        int c; 
	        while ((c = is.read()) != -1) 
	          sw.write(c); 
	        } 
	        catch (IOException e) { ; } 
	    }
            
	    public String getResult() { 
	      return sw.toString(); 
	    } 
    
}
