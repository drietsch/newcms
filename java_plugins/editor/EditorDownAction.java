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

import java.awt.event.ActionEvent;

import javax.swing.UIManager;
import javax.swing.text.DefaultEditorKit;
import javax.swing.text.JTextComponent;
import javax.swing.text.TextAction;


class EditorDownAction extends TextAction
	{
	

		 /**
	 * 
	 */
	private static final long serialVersionUID = 1L;

		/**
		 * Creates this object with the appropriate identifier.
		 */
		public EditorDownAction()
		{
			super(DefaultEditorKit.downAction);
		}
		
		/**
		 * The operation to perform when this action is triggered.
		 *
		 * @param e the action event
		 */
		public void actionPerformed(ActionEvent e)
		{
			JTextComponent target = getTextComponent(e);
			if (target == null) return;
 
			if ((! target.isEditable()) || (! target.isEnabled()))
			{
				UIManager.getLookAndFeel().provideErrorFeedback(target);
				return;
			}
 
		}

	}
 