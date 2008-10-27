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

public class Parameter {

	// parameter
	private String weTagColor = "0000A0";
	private String weAttributeColor = "007FFF";
	private String HTMLTagColor = "7F0056";
	private String HTMLAttributeColor = "FF00AC";
	private String piColor = "FF0000";
	private String commentColor = "AAAAAA";
	private String normalColor = "000000";
	private String fontName = "courier";
	private String contentType = "text/weTmpl";
	private int fontSize = 11;

	private static final class InstanceHolder {
		static final Parameter INSTANCE = new Parameter();
	}
	 
	private Parameter () {}

	public static Parameter getInstance () {
		return InstanceHolder.INSTANCE;
	}

	public String getWeTagColor() {
		return weTagColor;
	}

	protected String fixColor(String color) {
		if (color.length() == 0) {
			return "";
		}
		if (color.substring(0, 1).equals("#")) {
			color = color.substring(1);
		}
		return color;
	}
	public void setWeTagColor(String weTagColor) {
		this.weTagColor = fixColor(weTagColor);
	}

	public String getWeAttributeColor() {
		return weAttributeColor;
	}

	public void setWeAttributeColor(String weAttributeColor) {
		this.weAttributeColor = fixColor(weAttributeColor);
	}

	public String getHTMLTagColor() {
		return HTMLTagColor;
	}

	public void setHTMLTagColor(String tagColor) {
		HTMLTagColor = fixColor(tagColor);
	}

	public String getHTMLAttributeColor() {
		return HTMLAttributeColor;
	}

	public void setHTMLAttributeColor(String attributeColor) {
		HTMLAttributeColor = fixColor(attributeColor);
	}

	public String getPiColor() {
		return piColor;
	}

	public void setPiColor(String piColor) {
		this.piColor = fixColor(piColor);
	}

	public String getCommentColor() {
		return commentColor;
	}

	public void setCommentColor(String commentColor) {
		this.commentColor = fixColor(commentColor);
	}

	public String getNormalColor() {
		return normalColor;
	}

	public void setNormalColor(String normalColor) {
		this.normalColor = fixColor(normalColor);
	}

	public String getFontName() {
		return fontName;
	}

	public void setFontName(String fontName) {
		this.fontName = fontName;
	}

	public int getFontSize() {
		return fontSize;
	}

	public void setFontSize(int fontSize) {
		this.fontSize = fontSize;
	}

	public void setContentType(String contentType) {
		this.contentType = contentType;
	}
	
	public String getContentType() {
		return this.contentType;
	}
}
