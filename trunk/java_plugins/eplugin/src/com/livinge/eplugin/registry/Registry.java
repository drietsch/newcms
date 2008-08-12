/*
 * Registry.java
 *
 * Created on February 28, 2007, 3:35 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package com.livinge.eplugin.registry;

import java.util.Vector;

/**
 *
 * @author slavko
 */
public interface Registry {
 
    public Vector getAppList(String extension);
    
}
