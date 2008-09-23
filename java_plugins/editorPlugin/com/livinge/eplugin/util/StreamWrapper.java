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

package com.livinge.eplugin.util;

import java.io.IOException;
import java.io.InputStream;
import java.io.StringWriter;

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
