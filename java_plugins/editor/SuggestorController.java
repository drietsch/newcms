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

import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;
import java.util.Enumeration;
import java.util.Hashtable;
import java.util.Vector;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.swing.DefaultListModel;
import javax.swing.JTextPane;
import javax.swing.text.BadLocationException;
import javax.swing.text.Document;
import javax.swing.text.Element;

public class SuggestorController{
	
	private JTextPane pane;
	private int caretPos=0;
	private String lineText="";
	private int weStartTagStartPos = -1;
	private int weEndTagStartPos = -1;
	private String tagName = "";
	private String selectTag = "";
	private String attribName = "";
	private Editor applet;
	
	private TagSuggestor tSuggestor;
	private AttribSuggestor aSuggestor;
	private LineNumberPanel lineNumbers;

	private DefaultListModel suggestedTags;
	private DefaultListModel attribsForTag;

	public SuggestorController(JTextPane aPane, Editor anApplet, LineNumberPanel someLineNumbers) {
		this.pane = aPane;
		this.applet = anApplet;
		this.lineNumbers = someLineNumbers;
		this.suggestedTags = new DefaultListModel();
		this.attribsForTag = new DefaultListModel();
		
		tSuggestor = new TagSuggestor(applet, pane, this.lineNumbers);
		
		tSuggestor.addSuggestorListener(new SuggestorListener() {

			public void entrySelected(SuggestorEvent e) {
				tagName = e.getValue();
			}
			
			
		});
		
		aSuggestor = new AttribSuggestor(applet, pane, this.lineNumbers);

		Parameter parameter = Parameter.getInstance();
		String contentType = parameter.getContentType();
		
		if (contentType.equals("text/weTmpl")) {
			pane.addKeyListener(new KeyAdapter() {
				
	            public void keyReleased(KeyEvent e) {
	               	update();
	           }
	            
	            public void keyTyped(KeyEvent e) {
	            }
	 
	            public void keyPressed(KeyEvent e) {
	               	if (suggestorsVisible()) {
		            	switch (e.getKeyCode()){
		            		
		           			case KeyEvent.VK_ESCAPE:
		           				hideSuggestors();
		           				return;
		        			
		           			case KeyEvent.VK_DOWN:
			        			handleArrowKeyDown(true);		        			
			        			return;
		            			
		            	}
	            	}
	           }
	            
			});
		}
	}
	
	public boolean suggestorsVisible() {
		return tSuggestor.isVisible() || aSuggestor.isVisible();
	}
	
	public TagSuggestor getTagSuggestor() {
		return tSuggestor;
	}
	
	public AttribSuggestor getAttribSuggestor() {
		return aSuggestor;
	}
	
	public void update() {
		
		Document doc = pane.getDocument();
		Element rootElement = doc.getDefaultRootElement();
		
		int selectionStart = pane.getSelectionStart();
		int line = rootElement.getElementIndex(selectionStart);


		int start = rootElement.getElement(line).getStartOffset();
		int end = rootElement.getElement(line).getEndOffset();
		caretPos = pane.getCaretPosition() - start;
		int length = end - start;
		
		try {
			lineText = doc.getText(start, length);
		} catch (BadLocationException e1) {
			lineText = "";
			return;
		}
		
		if (shouldShowTagSuggestor()) {
			tSuggestor.setSuggestedValue(tagName);
			Vector<String> tags = applet.getTags();
			suggestedTags.clear();
			
			for (int i=0; i<tags.size(); i++) {
				String weTag = tags.get(i);
				String parts[] = weTag.split("/");
				if (tagName.length() == 0 || (parts[0].length() >= tagName.length() && parts[0].substring(0, tagName.length()).equals(tagName))) {
					boolean isEndTag = cursorIsInWeEndTag();
					if ( (isEndTag && parts[1].equals("true")) || !isEndTag) suggestedTags.addElement(parts[0]);
				}
			}
			if (suggestedTags.size() > 0) {
				if (pane.getSelectedText() == null) {
					tSuggestor.showSuggestor(suggestedTags);
					if (selectTag != null && selectTag.length() > 0) {
						tSuggestor.selectEntry(selectTag);
						handleArrowKeyDown(false);
					}
				}
			} else {
				hideSuggestors();
			}
		} else if (tSuggestor.isVisible()) {
			tSuggestor.hideSuggestor();
		} 
		
		if (shouldShowAttribSuggestor()) {
			aSuggestor.setSuggestedValue(attribName);
						
			Vector<String> attribs = applet.getAttribsForTag(tagName);
			attribsForTag.clear();
			for (int i=0; i<attribs.size(); i++) {
				String weAttrib = attribs.get(i);
				String parts[] = weAttrib.split("/");
				if (attribName.length() == 0 || (parts[0].length() >= attribName.length() && parts[0].substring(0,attribName.length()).equals(attribName))) {
					attribsForTag.addElement(parts[0]);
				}
			}
			if (attribsForTag.size() >0) {
				aSuggestor.showSuggestor(attribsForTag);
			} else {
				hideSuggestors();
			}
		} else if (aSuggestor.isVisible()) {
			aSuggestor.hideSuggestor();
		} 
	} 
	
	private boolean shouldShowTagSuggestor(){
		if (cursorIsInWeStartTag() && lineText.lastIndexOf(" ", caretPos-1) <= weStartTagStartPos) {
			tagName = lineText.substring(weStartTagStartPos+4, caretPos);
			selectTag = "";
			return true;
		} else if (cursorIsInWeEndTag() && lineText.lastIndexOf(" ", caretPos-1) <= weEndTagStartPos) {
			tagName = lineText.substring(weEndTagStartPos+5, caretPos);
			if (tagName.length() == 0) {
				selectTag = findLastOpenStartTag();
			} else {
				selectTag = "";
			}
			return true;
		}
		return false;
	}
	
	private String findLastOpenStartTag() {
		String content = "";
		Document doc = pane.getDocument();
		try {
			content = doc.getText(0, doc.getLength()).substring(0, pane.getCaretPosition());
			Pattern p = Pattern.compile("</?we:([^ >]+)");
			Matcher m = p.matcher(content);
			
			Hashtable<String, Integer> h = new Hashtable<String, Integer>();
			
			int count;
			
			while (m.find()) {
				String tagName = m.group(1);
				System.out.println("tagName:" + tagName);
				if (h.containsKey(tagName)) {
					count = h.get(tagName);
				} else {
					count = 0;
				}
				if (m.group(0).substring(1,2).equals("/")) {
					count--;
				} else {
					count++;
				}
				h.put(tagName, count);
			}
			
			Enumeration<String> e = h.keys();
		    while (e.hasMoreElements()) {
		         String key = e.nextElement();
		         if (h.get(key) > 0 && needsEndtag(key)) {
		        	 return key;
		         }
		    }			
			
		} catch (BadLocationException e) {
			e.printStackTrace();
		}
		return null;
	}
	
	private boolean needsEndtag(String tagName) {
		Vector<String> tags = applet.getTags();		
		for (int i=0; i<tags.size(); i++) {
			String weTag = tags.get(i);
			String[] parts = weTag.split("/");
			if (parts[0].equals(tagName)){
				return parts[1].equals("true");
			}
		}
		return false;
	}

	private boolean shouldShowAttribSuggestor(){
		int spacePos = lineText.lastIndexOf(" ", caretPos-1);
		
		
		int numQuotesBetweenStartTagAndCaret = 0;
		
		int quotPos = lineText.lastIndexOf("\"", caretPos-1);

		while (quotPos > weStartTagStartPos) {
			numQuotesBetweenStartTagAndCaret++;
			quotPos = lineText.lastIndexOf("\"", quotPos-1);
		}
		
		boolean isOpenQuot = ( (numQuotesBetweenStartTagAndCaret % 2 ) != 0 );
			
		if (cursorIsInWeStartTag() && spacePos > weStartTagStartPos && !isOpenQuot) {
			attribName = lineText.substring(spacePos + 1, caretPos);
			return true;
		}
		attribName = "";
		return false;
	}
	
	private boolean cursorIsInWeStartTag() {
		int firstWeTagStartPosBeforeCursor = lineText.lastIndexOf("<we:", caretPos-4);
		int firstEndTagPosBeforeCursor = lineText.lastIndexOf(">", caretPos-1);
		if (firstWeTagStartPosBeforeCursor != -1 && (firstEndTagPosBeforeCursor ==-1 || (firstEndTagPosBeforeCursor < firstWeTagStartPosBeforeCursor)))  {
			weStartTagStartPos = firstWeTagStartPosBeforeCursor;
			return true;
		}
		weStartTagStartPos = -1;
		return false;
	}

	private boolean cursorIsInWeEndTag() {
		int firstWeTagStartPosBeforeCursor = lineText.lastIndexOf("</we:", caretPos-5);
		int firstEndTagPosBeforeCursor = lineText.lastIndexOf(">", caretPos-1);
		if (firstWeTagStartPosBeforeCursor != -1 && (firstEndTagPosBeforeCursor ==-1 || (firstEndTagPosBeforeCursor < firstWeTagStartPosBeforeCursor)))  {
			weEndTagStartPos = firstWeTagStartPosBeforeCursor;
			return true;
		}
		weEndTagStartPos = -1;
		return false;
	}

	public void debug(){
		System.out.println("this.caretPos:" + this.caretPos);
		System.out.println("this.lineText:" + this.lineText);
	}

	public void hideSuggestors() {
		tSuggestor.hideSuggestor();
		aSuggestor.hideSuggestor();
	}

	public void handleArrowKeyDown(boolean doSelectFirst) {
		pane.setFocusable(false);
		if (tSuggestor.isVisible()) {
			tSuggestor.list.setFocusable(true);
			tSuggestor.list.requestFocus();
			if (doSelectFirst) tSuggestor.list.setSelectedIndex(0);
			tSuggestor.list.repaint();
		} else if (aSuggestor.isVisible()) {
			aSuggestor.list.setFocusable(true);
			aSuggestor.list.requestFocus();
			if (doSelectFirst) aSuggestor.list.setSelectedIndex(0);
			aSuggestor.list.repaint();
		}
	}

}
