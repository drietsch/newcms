<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Image.php,v 1.5 2008/06/27 14:52:47 thomas.kneip Exp $
 */

/**
 * static class with utility image functions   
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_layout_Image
{
	/**
	 * path of tree icon audio
	 */
	const kTreeIconAudio = '/webEdition/images/tree/icons/audio.gif';
	
	/**
	 * path of tree icon banner
	 */
	const kTreeIconBanner = '/webEdition/images/tree/icons/banner.gif';
	
	/**
	 * path of tree icon banner folder
	 */
	const kTreeIconBannerFolder = '/webEdition/images/tree/icons/banner_folder.gif';
	
	/**
	 * path of tree icon banner folder open
	 */
	const kTreeIconBannerFolderOpen = '/webEdition/images/tree/icons/banner_folderopen.gif';
	
	/**
	 * path of tree icon edit
	 */
	const kTreeIconEdit = '/webEdition/images/tree/icons/bearbeiten.gif';
	
	/**
	 * path of tree icon browser
	 */
	const kTreeIconBrowser = '/webEdition/images/tree/icons/browser.gif';
	
	/**
	 * path of tree icon category
	 */
	const kTreeIconCat = '/webEdition/images/tree/icons/cat.gif';
	
	/**
	 * path of tree icon class folder
	 */
	const kTreeIconClassFolder = '/webEdition/images/tree/icons/class_folder.gif';
	
	/**
	 * path of tree icon class folder disabled
	 */
	const kTreeIconClassFolderDisabled = '/webEdition/images/tree/icons/class_folder_disabled.gif';
	
	/**
	 * path of tree icon class folder open
	 */
	const kTreeIconClassFolderOpen = '/webEdition/images/tree/icons/class_folderopen.gif';
	
	/**
	 * path of tree icon class folder open disabled
	 */
	const kTreeIconClassFolderOpenDisabled = '/webEdition/images/tree/icons/class_folderopen_disabled.gif';
	
	/**
	 * path of tree icon css
	 */
	const kTreeIconCss = '/webEdition/images/tree/icons/css.gif';
	
	/**
	 * path of tree icon customer
	 */
	const kTreeIconCustomer = '/webEdition/images/tree/icons/customer.gif';
	
	/**
	 * path of tree icon excel
	 */
	const kTreeIconExcel = '/webEdition/images/tree/icons/excel.gif';
	
	/**
	 * path of tree icon film
	 */
	const kTreeIconFilm = '/webEdition/images/tree/icons/film.gif';
	
	/**
	 * path of tree icon flashmovie
	 */
	const kTreeIconFlashmovie = '/webEdition/images/tree/icons/flashmovie.gif';
	
	/**
	 * path of tree icon folder
	 */
	const kTreeIconFolder = '/webEdition/images/tree/icons/folder.gif';
	
	/**
	 * path of tree icon folder disabled
	 */
	const kTreeIconFolderDisabled = '/webEdition/images/tree/icons/folder_disabled.gif';
	
	/**
	 * path of tree icon folder open
	 */
	const kTreeIconFolderOpen = '/webEdition/images/tree/icons/folderopen.gif';
	
	/**
	 * path of tree icon folder open disabled
	 */
	const kTreeIconFolderOpenDisabled = '/webEdition/images/tree/icons/folderopen_disabled.gif';
	
	/**
	 * path of tree icon html
	 */
	const kTreeIconHtml = '/webEdition/images/tree/icons/html.gif';
	
	/**
	 * path of tree icon cockpit
	 */
	const kTreeIconCockpit = '/webEdition/images/tree/icons/icon_cockpit.gif';
	
	/**
	 * path of tree icon image
	 */
	const kTreeIconImage = '/webEdition/images/tree/icons/image.gif';
	
	/**
	 * path of tree icon javascript
	 */
	const kTreeIconJavascript = '/webEdition/images/tree/icons/javascript.gif';
	
	/**
	 * path of tree icon link
	 */
	const kTreeIconLink = '/webEdition/images/tree/icons/link.gif';
	
	/**
	 * path of tree icon message draft folder
	 */
	const kTreeIconMsgDraftFolder = '/webEdition/images/tree/icons/msg_draft_folder.gif';
	
	/**
	 * path of tree icon message draft folder open
	 */
	const kTreeIconMsgDraftFolderOpen = '/webEdition/images/tree/icons/msg_draft_folder_open.gif';
	
	/**
	 * path of tree icon message folder
	 */
	const kTreeIconMsgFolder = '/webEdition/images/tree/icons/msg_folder.gif';
	
	/**
	 * path of tree icon message folder open
	 */
	const kTreeIconMsgFolderOpen = '/webEdition/images/tree/icons/msg_folder_open.gif';
	
	/**
	 * path of tree icon message in folder
	 */
	const kTreeIconMsgInFolder = '/webEdition/images/tree/icons/msg_in_folder.gif';
	
	/**
	 * path of tree icon message in folder open
	 */
	const kTreeIconMsgInFolderOpen = '/webEdition/images/tree/icons/msg_in_folder_open.gif';
	
	/**
	 * path of tree icon message sent folder
	 */
	const kTreeIconMsgSentFolder = '/webEdition/images/tree/icons/msg_sent_folder.gif';
	
	/**
	 * path of tree icon message sent folder open
	 */
	const kTreeIconMsgSentFolderOpen = '/webEdition/images/tree/icons/msg_sent_folder_open.gif';
	
	/**
	 * path of tree icon newsletter
	 */
	const kTreeIconNewsletter = '/webEdition/images/tree/icons/newsletter.gif';
	
	/**
	 * path of tree icon none webedition
	 */
	const kTreeIconNoneWebedition = '/webEdition/images/tree/icons/none_webedition.gif';
	
	/**
	 * path of tree icon object
	 */
	const kTreeIconObject = '/webEdition/images/tree/icons/object.gif';
	
	/**
	 * path of tree icon object file
	 */
	const kTreeIconObjectFile = '/webEdition/images/tree/icons/objectFile.gif';
	
	/**
	 * path of tree icon pdf
	 */
	const kTreeIconPdf = '/webEdition/images/tree/icons/pdf.gif';
	
	/**
	 * path of tree icon powerpoint
	 */
	const kTreeIconPowerpoint = '/webEdition/images/tree/icons/powerpoint.gif';
	
	/**
	 * path of tree icon prog
	 */
	const kTreeIconProg = '/webEdition/images/tree/icons/prog.gif';
	
	/**
	 * path of tree icon quicktime
	 */
	const kTreeIconQuicktime = '/webEdition/images/tree/icons/quicktime.gif';
	
	/**
	 * path of tree icon todo done folder
	 */
	const kTreeIconTodoDoneFolder = '/webEdition/images/tree/icons/todo_done_folder.gif';
	
	/**
	 * path of tree icon todo done folder open
	 */
	const kTreeIconTodoDoneFolderOpen = '/webEdition/images/tree/icons/todo_done_folder_open.gif';
	
	/**
	 * path of tree icon todo folder
	 */
	const kTreeIconTodoFolder = '/webEdition/images/tree/icons/todo_folder.gif';
	
	/**
	 * path of tree icon todo folder open
	 */
	const kTreeIconTodoFolderOpen = '/webEdition/images/tree/icons/todo_folder_open.gif';
	
	/**
	 * path of tree icon todo in folder
	 */
	const kTreeIconTodoInFolder = '/webEdition/images/tree/icons/todo_in_folder.gif';
	
	/**
	 * path of tree icon todo in folder open
	 */
	const kTreeIconTodoInFolderOpen = '/webEdition/images/tree/icons/todo_in_folder_open.gif';
	
	/**
	 * path of tree icon todo reject folder
	 */
	const kTreeIconTodoRejectFolder = '/webEdition/images/tree/icons/todo_reject_folder.gif';
	
	/**
	 * path of tree icon todo reject folder open
	 */
	const kTreeIconTodoRejectFolderOpen = '/webEdition/images/tree/icons/todo_reject_folder_open.gif';
	
	/**
	 * path of tree icon user
	 */
	const kTreeIconUser = '/webEdition/images/tree/icons/user.gif';
	
	/**
	 * path of tree icon user alias
	 */
	const kTreeIconUserAlias = '/webEdition/images/tree/icons/user_alias.gif';
	
	/**
	 * path of tree icon user group
	 */
	const kTreeIconUsergroup = '/webEdition/images/tree/icons/usergroup.gif';
	
	/**
	 * path of tree icon user group open
	 */
	const kTreeIconUsergroupOpen = '/webEdition/images/tree/icons/usergroupopen.gif';
	
	/**
	 * path of tree icon webedition document
	 */
	const kTreeIconWeDocument = '/webEdition/images/tree/icons/we_dokument.gif';
	
	/**
	 * path of tree icon webedition template
	 */
	const kTreeIconWeTemplate = '/webEdition/images/tree/icons/we_template.gif';
	
	/**
	 * path of tree icon word
	 */
	const kTreeIconWord = '/webEdition/images/tree/icons/word.gif';
	
	/**
	 * path of tree icon workflow folder
	 */
	const kTreeIconWorkflowFolder = '/webEdition/images/tree/icons/workflow_folder.gif';
	
	/**
	 * path of tree icon workflow folder open
	 */
	const kTreeIconWorkflowFolderOpen = '/webEdition/images/tree/icons/workflow_folderopen.gif';
	
	/**
	 * path of tree zip
	 */
	const kTreeIconZip = '/webEdition/images/tree/icons/zip.gif';
	
	/**
	 * Returns HTML img tag which points to a transparent image
	 * 
	 * @param integer $w with of the image
	 * @param integer $h height of the image
	 * @return string
	 */
	static function getPixel($w=1, $h=1) 
	{
		return '<img src="/webEdition/lib/we/ui/layout/img/pixel.gif" width="'.abs($w).'" height="'.abs($h).'" alt=""/>';
	}
	
	/**
	 * Maps the contentType to its css class name to display specific icons
	 * 
	 * @param string $contentType
	 * @param string $extension
	 * @return string
	 */
	public static function getIconClass($contentType,$extension='')  
	{
		switch($contentType) {
			case "image/*":
				return "image";
			break;
			case "text/webedition":
				return "we_document";
			break;
			case "text/html":
				return "text_html";
			break;
			case "folder":
				return "folder";
			break;
			case "folderOpen":
				return "folderOpen";
			break;
			case "text/css":
				return "text_css";
			break;
			case "text/weTmpl":
				return "text_weTmpl";
			break;
			case "text/js":
				return "text_js";
			break;
			case "text/plain":
				return "text_plain";
			break;
			case "text/xml":
				return "text_xml";
			break;
			case "application/x-shockwave-flash":
				return "flash";
			break;
			case "video/quicktime":
				return "quicktime";
			break;
			case "object":
				return "object";
			break;
			case "objectFile":
				return "objectFile";
			break;
			case "application/*":
				switch($extension){
						case ".pdf":
							return "pdf";
						case ".zip":
						case ".sit":
						case ".hqx":
						case ".bin":
							return "zip";
						case ".doc":
							return "word";
						case ".xls":
							return "excel";
						case ".ppt":
							return "powerpoint";
					}
					return "text_plain";
			break;
			default:
				return "text_plain";
		}
	}
}
