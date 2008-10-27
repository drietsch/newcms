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
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.swing.text.*;

class SyntaxDocument extends DefaultStyledDocument
{
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private DefaultStyledDocument doc;
	private Element rootElement;
	
	private int commentPos = -1;
	private int processingInstructionPos = -1;
	private int weTagPos = -1;
	private int defaultTagPos = -1;
	private int scriptTagPos = -1;
	
	private MutableAttributeSet piAttributeSet;
	private MutableAttributeSet normalAttributeSet;
	private MutableAttributeSet commentAttributeSet;
	private MutableAttributeSet weAttributeSet;
	private MutableAttributeSet defaultAttributeSet;
	private MutableAttributeSet weAttributeAttributeSet;
	private MutableAttributeSet defaultAttributeAttributeSet;
	
	public static final int TAG_PI = 1;
	public static final int TAG_WE = 2;
	public static final int TAG_COMMENT = 3;
	public static final int TAG_DEFAULT = 4;
	public static final int TAG_SCRIPT = 5;
	
	private Editor applet;
		
	private Pattern attribDelimiter;
	
	private EditorPanel panel;
	
	private Parameter parameter;
		
	public SyntaxDocument(Editor applet, EditorPanel panel)
	{
		parameter = Parameter.getInstance();
		
		this.panel = panel;
		this.applet = applet;
		
		doc = this;
		rootElement = doc.getDefaultRootElement();
		putProperty( DefaultEditorKit.EndOfLineStringProperty, "\n" );

		piAttributeSet = new SimpleAttributeSet();
		StyleConstants.setForeground(piAttributeSet, new Color( Integer.parseInt( parameter.getPiColor(), 16 ) ));

		normalAttributeSet = new SimpleAttributeSet();
		StyleConstants.setForeground(normalAttributeSet, new Color( Integer.parseInt( parameter.getNormalColor(), 16 ) ));
		
		commentAttributeSet = new SimpleAttributeSet();
		StyleConstants.setForeground(commentAttributeSet, new Color( Integer.parseInt( parameter.getCommentColor(), 16 ) ));
		
		weAttributeSet = new SimpleAttributeSet();
		StyleConstants.setForeground(weAttributeSet, new Color( Integer.parseInt( parameter.getWeTagColor(), 16 ) ));
		
		defaultAttributeSet = new SimpleAttributeSet();
		StyleConstants.setForeground(defaultAttributeSet, new Color( Integer.parseInt( parameter.getHTMLTagColor(), 16 ) ));

		weAttributeAttributeSet = new SimpleAttributeSet();
		StyleConstants.setForeground(weAttributeAttributeSet, new Color( Integer.parseInt( parameter.getWeAttributeColor(), 16 ) ));
		
		defaultAttributeAttributeSet = new SimpleAttributeSet();
		StyleConstants.setForeground(defaultAttributeAttributeSet, new Color( Integer.parseInt( parameter.getHTMLAttributeColor(), 16 ) ));
		
		attribDelimiter = Pattern.compile(" [^ >]+");
		
	}

   
 	/*
	 *  Override to apply syntax highlighting after the document has been updated
	 */
	public void insertString(int offset, String str, AttributeSet a) throws BadLocationException
	{
//		if (str.equals("{"))
//			str = addMatchingBrace(offset);

		super.insertString(offset, str, a);
		// highlight
		processChangedLines(offset, str.length());
	}


	/*
	 *  Override to apply syntax highlighting after the document has been updated
	 */
	public void remove(int offset, int length) throws BadLocationException
	{
		super.remove(offset, length);
		processChangedLines(offset, 0);
	}

	/*
	 *  Determine how many lines have been changed,
	 *  then apply highlighting to each line
	 */
	public void processChangedLines(int offset, int length)
		throws BadLocationException
	{
		panel.repaint();
		String content = doc.getText(0, doc.getLength());
		if (applet.isCodeSet && !applet.isHot() && !applet.cmpCode.equals(content)) {
			applet.setHot(true);
		}

		//  The lines affected by the latest document update

		int startLine = rootElement.getElementIndex( offset );
		int endLine = rootElement.getElementIndex( offset + length );
		
		
		//  process all lines before the actual lines
		processLinesBefore( content, startLine);

		// do highlighting for actual lines
		for (int i = startLine; i <= endLine; i++)
		{
			processLine(content, i);
		}

		// process all lines after the actual lines
		processLinesAfter( content, endLine);

	}

	private void processLinesBefore(String content, int line) {
		int offset = rootElement.getElement( line ).getStartOffset() - 1;
		
		int piStart = getLastPiStart(content, offset);
		int piEnd = getLastPiEnd(content, offset);
		int commentStart = getLastCommentStart(content, offset);
		int commentEnd = getLastCommentEnd(content, offset);
		int defaultStart = getLastDefaultStart(content, offset);
		int defaultEnd = getLastDefaultEnd(content, offset);
		
		int scriptStart = getLastScriptStartTag(content, offset);
		int scriptEnd = getLastScriptEndTag(content, offset);

		setWeTagPos(-1);
		setProcessingInstructionPos(piStart > piEnd ? piStart : -1);
		setCommentPos(commentStart > commentEnd ? commentStart : -1);
		setScriptTagPos(scriptStart > scriptEnd ? scriptStart : -1);
		setDefaultTagPos(defaultStart > defaultEnd ? defaultStart : -1);
	}

	/*
	 *  Parse the line to determine the appropriate highlighting
	 */
	private void processLine(String content, int line)
		throws BadLocationException
	{
		int startOffset = rootElement.getElement( line ).getStartOffset();
		int endOffset = rootElement.getElement( line ).getEndOffset() - 1;
		while (startOffset <= endOffset)
		{
			startOffset = highlightTokkens(content, startOffset, endOffset);
		}
	}

	private void processLinesAfter(String content, int endLine) 
		throws BadLocationException
	{
		
		// process lines to the end of document or if highlighting fits it returns;
		int numLines = rootElement.getElementCount();
		for (int _line = endLine+1; _line < numLines; _line++) {
			Element branch = rootElement.getElement(_line);
			//get first character of line
			Element leaf = doc.getCharacterElement( branch.getStartOffset() );
			//clone attribute set
			AttributeSet as = leaf.getAttributes().copyAttributes();
			// process line
			processLine(content, _line);
			// compare attributes of first character of processed line with attributes of cloned attribute set 
			if (_line+1 < numLines) {
				//if the same then return
				if (as.equals(leaf.getAttributes())) {
					return;
				}
			}
		}		
	}


	private int highlightTokkens(String content, int startOffset, int endOffset) {
		int [] startTag = getNextStartTag(content, startOffset);
		
		if (startTag[0] > startOffset && startTag[0] < endOffset) {
			// highlight with last state until startTag Tag
			highlightTokken(content, startOffset, startTag[0]);
			return startTag[0];
		} else if (startTag[0] == -1 || startTag[0] >= endOffset) {
			// highlight to end
			return highlightTokken(content, startOffset, endOffset);
		} else if (startTag[0] == startOffset){
			switch (startTag[1]) {
			case TAG_PI:
				setProcessingInstructionPos(startTag[0]);
				return highlightTokken(content, startOffset, endOffset);				
			case TAG_WE:
				setWeTagPos(startTag[0]);
				return highlightTokken(content, startOffset, endOffset);				
			case TAG_COMMENT:
				setCommentPos(startTag[0]);
				return highlightTokken(content, startOffset, endOffset);				
			case TAG_SCRIPT:
				setScriptTagPos(startTag[0]);
				return highlightTokken(content, startOffset, endOffset);				
			default:
				setDefaultTagPos(startTag[0]);
				return highlightTokken(content, startOffset, endOffset);
					
			}
		}
		
		return endOffset + 1;
	}

	private int highlightTokken(String content, int startTokken, int endTokken) {
		if (getProcessingInstructionPos() > -1) {
			int _pos = getNextPiEnd(content, startTokken);
			if (_pos == -1 || _pos > endTokken) {
				doc.setCharacterAttributes(startTokken, endTokken - startTokken, piAttributeSet, false);
			} else {
				setProcessingInstructionPos(-1);
				doc.setCharacterAttributes(startTokken, _pos - startTokken, piAttributeSet, false);
				return _pos;
			}
		} else if (getWeTagPos() > -1) {
			int _pos = getNextDefaultEnd(content, startTokken);
			if (_pos == -1 || _pos > endTokken) {
				doc.setCharacterAttributes(startTokken, endTokken - startTokken, weAttributeSet, false);
				highlightAttributes(content, startTokken, endTokken, weAttributeAttributeSet);
			} else {
				setWeTagPos(-1);
				doc.setCharacterAttributes(startTokken, _pos - startTokken, weAttributeSet, false);
				highlightAttributes(content, startTokken, _pos, weAttributeAttributeSet);
				return _pos;
			}
		} else if (getCommentPos() > -1) {
			int _pos = getNextCommentEnd(content, startTokken);
			if (_pos == -1 || _pos > endTokken) {
				doc.setCharacterAttributes(startTokken, endTokken - startTokken, commentAttributeSet, false);
			} else {
				setCommentPos(-1);
				doc.setCharacterAttributes(startTokken, _pos - startTokken, commentAttributeSet, false);
				return _pos;
			}
		} else if (getScriptTagPos() > -1) {
			int _pos = getLastScriptEndTag(content, startTokken);
			if (_pos == -1 || _pos > endTokken) {
				doc.setCharacterAttributes(startTokken, endTokken - startTokken, normalAttributeSet, false);
			} else {
				setScriptTagPos(-1);
				doc.setCharacterAttributes(startTokken, _pos - startTokken, normalAttributeSet, false);
				return _pos;
			}
		} else if (getDefaultTagPos() > -1) {
			int [] _nextStartTag = getNextStartTag(content, startTokken+1);
			int _nextEndpos = getNextDefaultEnd(content, startTokken);
			if (_nextStartTag[0] > -1 && (_nextStartTag[1] == TAG_PI || _nextStartTag[1] == TAG_WE) && (_nextStartTag[0] < _nextEndpos || _nextEndpos == -1) ) {
				doc.setCharacterAttributes(startTokken, _nextStartTag[0] - startTokken, defaultAttributeSet, false);
				highlightAttributes(content, startTokken, _nextStartTag[0], defaultAttributeAttributeSet);
				return _nextStartTag[0];
			}
			if (_nextEndpos == -1 || _nextEndpos > endTokken) {
				doc.setCharacterAttributes(startTokken, endTokken - startTokken, defaultAttributeSet, false);
				highlightAttributes(content, startTokken, endTokken, defaultAttributeAttributeSet);
			} else {
				setDefaultTagPos(-1);
				doc.setCharacterAttributes(startTokken, _nextEndpos - startTokken, defaultAttributeSet, false);
				highlightAttributes(content, startTokken, _nextEndpos, defaultAttributeAttributeSet);
				return _nextEndpos;
			}
			doc.setCharacterAttributes(startTokken, endTokken - startTokken, defaultAttributeSet, false);
		} else {
			doc.setCharacterAttributes(startTokken, endTokken - startTokken, normalAttributeSet, false);
			setProcessingInstructionPos(-1);
			setDefaultTagPos(-1);
			setCommentPos(-1);
			setWeTagPos(-1);
		}
		return endTokken +1;
	}

	private void highlightAttributes(String content, int startTokken, int endTokken, MutableAttributeSet attribSet) {
		
		String tokken = content.substring(startTokken, endTokken);
		Matcher quote = attribDelimiter.matcher(tokken);

		while(quote.find()) {
			int start=quote.start();
			int end=quote.end();
			doc.setCharacterAttributes(startTokken+start, end-start, attribSet, false);
		}

	}

	/*
	 *
	 */
	protected String addMatchingBrace(int offset) throws BadLocationException
	{
		StringBuffer whiteSpace = new StringBuffer();
		int line = rootElement.getElementIndex( offset );
		int i = rootElement.getElement(line).getStartOffset();

		while (true)
		{
			String temp = doc.getText(i, 1);

			if (temp.equals(" ") || temp.equals("\t"))
			{
				whiteSpace.append(temp);
				i++;
			}
			else
				break;
		}

		return "{\n" + whiteSpace.toString() + "\t\n" + whiteSpace.toString() + "}";
	}

	private int [] getNextStartTag(String content, int startOffset) {
		int [] out = {-1,0};
		
		int pos = content.indexOf("<", startOffset);
		if (pos > -1) {
			out[0] = pos;
			try {
				if (content.substring(pos,pos+2).equals("<?")) {
					out[1] = TAG_PI;
				} else if (content.substring(pos,pos+4).equals("<!--")) {
					out[1] = TAG_COMMENT;
				} else if (content.substring(pos,pos+4).equals("<we:") || content.substring(pos,pos+5).equals("</we:")) {
					out[1] = TAG_WE;
				} else {
					out[1] = TAG_DEFAULT;
				}
			} catch (StringIndexOutOfBoundsException e) {
				out[1] = TAG_DEFAULT;
			}
		}
		return out;
	}


	private int getLastDefaultEnd(String content, int offset) {
		int i = content.lastIndexOf(">", offset);
		while (i > -1) {
			if (content.substring(Math.max(0,i-1),i).equals("?>") || content.substring(Math.max(0,i-3), i).equals("-->")) {
				i = content.lastIndexOf(">", i-1);
			} else {
				return i+1;
			}
		}
		return -1;
	}

	private int getLastDefaultStart(String content, int offset) {
		int i = content.lastIndexOf("<", offset);
		while (i > -1) {
			if (
					content.substring(i,Math.min(i+2, content.length())).equals("<?") || 
					content.substring(i,Math.min(i+4, content.length())).equals("<we:") || 
					content.substring(i,Math.min(i+5, content.length())).equals("</we:") || 
					content.substring(i,Math.min(i+4, content.length())).equals("<!--")
			) {
				i = content.lastIndexOf("<", i-1);
			} else {
				return i;
			}
		}
		return -1;
	}

	private int getLastPiEnd(String content, int offset) {
		int _pos = content.lastIndexOf("?>", offset);
		if (_pos > -1) {
			return _pos + 2;
		}
		return -1;
	}

	private int getLastPiStart(String content, int offset) {
		return content.lastIndexOf("<?", offset);
	}
	
	private int getLastScriptStartTag(String content, int offset) {
		return content.toLowerCase().lastIndexOf("<script");
	}

	private int getLastScriptEndTag(String content, int offset) {
		int _pos = content.toLowerCase().lastIndexOf("</script>", offset);
		if (_pos > -1) {
			return _pos + 9;
		}
		return -1;
	}

	private int getLastCommentEnd(String content, int offset) {
		int _pos = content.lastIndexOf("-->", offset);
		if (_pos > -1) {
			return _pos + 3;
		}
		return -1;
	}

	private int getLastCommentStart(String content, int offset) {
		return content.lastIndexOf("<!--", offset);
	}

	private int getNextDefaultEnd(String content, int offset) {
		int i = content.indexOf(">", offset);
		while (i > -1) {
			if (content.substring(Math.max(0,i-1),i).equals("?>") || content.substring(Math.max(0,i-3), i).equals("-->")) {
				i = content.indexOf(">", i+1);
			} else {
				return i+1;
			}
		}
		return -1;
	}

	private int getNextCommentEnd(String content, int offset) {
		int _pos = content.indexOf("-->", offset);
		if (_pos > -1) {
			return _pos + 3;
		}
		return -1;
	}
	
	private int getNextPiEnd(String content, int offset) {
		int _pos = content.indexOf("?>", offset);
		if (_pos > -1) {
			return _pos + 2;
		}
		return -1;
	}

	public int getProcessingInstructionPos() {
		return processingInstructionPos;
	}

	public void setProcessingInstructionPos(int processingInstructionPos) {
		this.processingInstructionPos = processingInstructionPos;
	}

	public int getWeTagPos() {
		return weTagPos;
	}

	public void setWeTagPos(int weTagPos) {
		this.weTagPos = weTagPos;
	}

	public int getDefaultTagPos() {
		return defaultTagPos;
	}

	public void setDefaultTagPos(int defaultTagPos) {
		this.defaultTagPos = defaultTagPos;
	}

	public int getCommentPos() {
		return commentPos;
	}

	public void setCommentPos(int commentPos) {
		this.commentPos = commentPos;
	}

	public void setScriptTagPos(int scriptTagPos) {
		this.scriptTagPos = scriptTagPos;
	}

	public int getScriptTagPos() {
		return this.scriptTagPos;
	}

	public void debugSelf() {
		System.out.println("we: " + getWeTagPos() + "; pi: " + getProcessingInstructionPos() + "; cm: " + getCommentPos() + "; def: " + getDefaultTagPos());
	}	
}