
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/<?php print $TOOLNAME; ?>/we_<?php print $TOOLNAME; ?>DirSelector.class.php');
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tools.inc.php");
protect();
$_SERVER['PHP_SELF'] = '/webEdition/apps/<?php print $TOOLNAME; ?>/we_<?php print $TOOLNAME; ?>DirSelect.php';
$fs = new we_<?php print $TOOLNAME; ?>DirSelector(isset($id) ? $id : (isset($_REQUEST['id']) ? $_REQUEST['id'] : (isset($_REQUEST['we_cmd'][1]) ? $_REQUEST['we_cmd'][1] : '')),
							isset($JSIDName) ? $JSIDName : (isset($_REQUEST['JSIDName']) ? $_REQUEST['JSIDName'] : (isset($_REQUEST['we_cmd'][2]) ? $_REQUEST['we_cmd'][2] : '')),
							isset($JSTextName) ? $JSTextName : (isset($_REQUEST['JSTextName']) ? $_REQUEST['JSTextName'] : (isset($_REQUEST['we_cmd'][3]) ? $_REQUEST['we_cmd'][3] : '')),
							isset($JSCommand) ? $JSCommand : (isset($_REQUEST['JSCommand']) ? $_REQUEST['JSCommand'] : (isset($_REQUEST['we_cmd'][4]) ? $_REQUEST['we_cmd'][4] : '')),
							isset($order) ? $order : (isset($_REQUEST['order']) ? $_REQUEST['order'] : ''),
							isset($we_editDirID) ? $we_editDirID : (isset($_REQUEST['we_editDirID']) ? $_REQUEST['we_editDirID'] : ''),
							isset($we_FolderText) ? $we_FolderText : (isset($_REQUEST['we_FolderText']) ? $_REQUEST['we_FolderText'] : ''));
							
$fs->printHTML(isset($_REQUEST['what']) ? $_REQUEST['what'] : FS_FRAMESET);
