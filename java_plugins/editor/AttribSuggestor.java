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

import javax.swing.JTextPane;

   class AttribSuggestor extends Suggestor {

	private static final long serialVersionUID = 1L;

	public AttribSuggestor(Editor anApplet, JTextPane aPane,
			LineNumberPanel lineNumbers) {
		super(anApplet, aPane, lineNumbers);
	}

	protected void updatePane(String word) {
		pane.replaceSelection(word.substring(suggestedValue.length()) + "=\"\"");
		int selStart = pane.getSelectionStart() - 1;
		pane.setSelectionStart(selStart);
		pane.setSelectionEnd(selStart);
	}

}
