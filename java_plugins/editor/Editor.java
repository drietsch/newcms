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

import java.awt.*;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.StringReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import java.util.Vector;

import javax.swing.*;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;

//
public class Editor extends JApplet
 {
	
	private static final long serialVersionUID = 1L;
	
	private EditorPanel editor;
	private Vector<String> tags = new Vector<String>();
	
	private String php_ext;
	
	public URL codeBase;
	public String SERVER_NAME;
	public int port;
	public String protocol;
	public String cmpCode = "";
	
	protected boolean isHot = false;
	
	private Parameter parameter;
	
	public boolean isCodeSet = false;
	
	private Map<String, Vector<String>> attribs = new HashMap<String, Vector<String>>();
		
	public void init() {
		
		codeBase = getCodeBase();
		SERVER_NAME = codeBase.getHost();

		port=(getDocumentBase()).getPort();
		protocol=(getDocumentBase()).getProtocol();
		String url;

		if (SERVER_NAME.length() > 0) {
			if(port!=-1) {
				url = protocol+"://"+SERVER_NAME+":"+port+"/webEdition/editor/initEditor.html";
			} else {
				url = protocol+"://"+SERVER_NAME+"/webEdition/editor/initEditor.html";
			}
			showUrl(url);
		}
		
		parameter = Parameter.getInstance();

		String p = getParameter("weTagColor");
		if (p != null && p.length() > 0) {
			parameter.setWeTagColor(p);
		}

		p = getParameter("weAttributeColor");
		if (p != null && p.length() > 0) {
			parameter.setWeAttributeColor(p);
		}

		p = getParameter("HTMLTagColor");
		if (p != null && p.length() > 0) {
			parameter.setHTMLTagColor(p);
		}

		p = getParameter("HTMLAttributeColor");
		if (p != null && p.length() > 0) {
			parameter.setHTMLAttributeColor(p);
		}

		p = getParameter("piColor");
		if (p != null && p.length() > 0) {
			parameter.setPiColor(p);
		}

		p = getParameter("commentColor");
		if (p != null && p.length() > 0) {
			parameter.setCommentColor(p);
		}

		p = getParameter("normalColor");
		if (p != null && p.length() > 0) {
			parameter.setNormalColor(p);
		}
				
		p = getParameter("fontName");
		if (p != null && p.length() > 0) {
			parameter.setFontName(p);
		}
				
		p = getParameter("fontSize");
		if (p != null && p.length() > 0) {
			parameter.setFontSize(Integer.valueOf(p));
		}
		
		p = getParameter("contentType");
		if (p != null && p.length() > 0) {
			parameter.setContentType(p);
		}
		
		php_ext=getParameter("phpext");
		if(php_ext==null) php_ext=".php";
		
		if (SERVER_NAME.length() > 0) {
			if(port!=-1) {
				url = protocol + "://" + SERVER_NAME + ":" + port + "/webEdition/editor/getAllTags" + php_ext;
			} else {
				url = protocol + "://" + SERVER_NAME + "/webEdition/editor/getAllTags" + php_ext;
			}
		} else {
			url = "http://wetrunk.holeg.hq.living-e.zz/webEdition/editor/getAllTags.php";
		}
		tags = getFromServer(url, "tag");
		
		editor = new EditorPanel(this);
		getContentPane().add(editor, BorderLayout.CENTER);
	}

	private Vector<String> getFromServer(String urlString, String nodeName) {
		URL url = null;
		
		Vector<String> out = new Vector<String>();
		
		try {
			url = new URL(urlString);
		} catch (MalformedURLException e1) {
			System.out.println("Error creating URL " + urlString);
		}
		HttpURLConnection con = null;
		try {
			con = (HttpURLConnection) url.openConnection();
			BufferedReader URLinput = new BufferedReader(new InputStreamReader(con.getInputStream()));
			  String line = "";
			  String xmlContent ="";
			  while ((line = URLinput.readLine()) != null) {
				  xmlContent += (line + "\n");
			  }
		
			DocumentBuilder parser = null;
			try {
				parser = DocumentBuilderFactory.newInstance().newDocumentBuilder();
			} catch (ParserConfigurationException e) {
				System.out.println("Error initializing XML parser");
			}
		      try {
				Document doc = parser.parse(new InputSource(new StringReader(xmlContent)));
				NodeList nodes = doc.getElementsByTagName(nodeName);
			    for (int i = 0; i < nodes.getLength(); i++) {
			       Element element = (Element) nodes.item(i);
			       out.addElement(element.getAttribute("name")+"/"+element.getAttribute("needsEndtag"));
			    }
			    
			} catch (SAXException e) {
				System.out.println("Error parsing XML");
			}

		} catch (IOException e1) {
			System.out.println("Error connecting to url: " + urlString);
		}
		
		return out;	
	}
	
 
  	public Vector<String> getTags(){
		return tags;
 	}

	public Vector<String> getAttribsForTag(String tagName) {
		if (!attribs.containsKey(tagName)) {
			String url;
			if (SERVER_NAME.length() > 0) {
				if(port!=-1) {
					url = protocol + "://" + SERVER_NAME + ":" + port + "/webEdition/editor/getAttribsForTag" + php_ext + "?tagName="+tagName;
				} else {
					url = protocol + "://" + SERVER_NAME + "/webEdition/editor/getAttribsForTag" + php_ext + "?tagName="+tagName;
				}
			} else {
				url = "http://wetrunk.holeg.intra/webEdition/editor/getAttribsForTag.php?tagName="+tagName;
			}
			Vector<String> attr = getFromServer(url, "attribute");
			attribs.put(tagName, attr);
		}
		return attribs.get(tagName);
	}
	
	public void setCode(String code) {
		editor.setCode(code);
		cmpCode = code;
		isCodeSet = true;
	}
	
	public void initUndoManager() {
		editor.initUndoManager();
	}
	
	public String getCode() {
		return editor.getCode();
	}
	
	public void setSize(int width, int height) {
	   super.setSize(width,height);
	   validate();
	}

	public void sendCtrlS() {
		
		if (SERVER_NAME.length() > 0) {
			String url;
			if(port!=-1) {
				url = protocol + "://" + SERVER_NAME + ":" + port + "/webEdition/we_lcmd" + php_ext + "?wecmd0=trigger_save_document";
			} else {
				url = protocol + "://" + SERVER_NAME + "/webEdition/we_lcmd" + php_ext + "?wecmd0=trigger_save_document"; 
			}
			showUrl(url);
		}
	}
	
	public void showUrl(String url) {
		try {
			this.getAppletContext().showDocument (new URL(url),"load");
		} catch (MalformedURLException e1) {
			System.out.println("Error connecting to URL " + url);
		}
	}

	public EditorPanel getEditor() {
		return editor;
	}


	public boolean isHot() {
		return isHot;
	}
	
	public void setHot(boolean isHot) {
		this.isHot = isHot;
	}
	
	public void replaceSelection(String txt) {
		editor.pane.replaceSelection(txt);
	}
	
	public void insertAtStart(String txt) {
		editor.pane.setCaretPosition(0);
		editor.pane.replaceSelection(txt);
	}
	
	public void insertAtEnd(String txt) {
		editor.pane.setCaretPosition(editor.pane.getDocument().getEndPosition().getOffset()-1);
		editor.pane.replaceSelection(txt);
	}

}

