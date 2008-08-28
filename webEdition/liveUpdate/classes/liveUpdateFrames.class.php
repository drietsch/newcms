<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * This class deals with the frames for the liveUpdate
 * Not much functionality here, just show the requested frame
 */
class liveUpdateFrames {
	
	var $Section;
	var $Data;
	
	function liveUpdateFrames() {
		
		if (!isset($_REQUEST['section'])) {
			$_REQUEST['section'] = 'frameset';
		}
		
		// depending on section variables execute different stuff to gather
		// data for the frame
		if (isset($_REQUEST['section'])) {
			
			$this->Section = $_REQUEST['section'];
			
			switch ($_REQUEST['section']) {
				
				case 'frameset':
					// open frameset
					if (isset($_REQUEST['active'])) {
						$this->Data['activeTab'] = $this->getValidTab($_REQUEST['active']);
					} else {
						$this->Data['activeTab'] = $this->getValidTab();
					}
				break;
				
				case 'tabs':
					// frame with tabs
					$this->Data['activeTab'] = $_REQUEST['active'];
					$this->Data['allTabs'] = $this->getAllTabs();
				break;
				
				case 'update':
					$this->processUpdateVariables();
				break;
				
				case 'updatelog':
					$this->processUpdateLogVariables();
				break;
				
				case 'languages':
					$this->processDeleteLanguages();
				break;
			}
			
		}
	}
	
	function getFrame() {
		
		switch ($this->Section) {
			
			case 'tabs':
				return $this->htmlTabs();
			break;
			case 'frameset':
				return $this->htmlFrameset();
			break;
			
			case 'upgrade':
				return $this->htmlUpgrade();
			break;
			
			case 'update':
				return $this->htmlUpdate();
			break;
			case 'modules':
				return $this->htmlModules();
			break;
			case 'languages':
				return $this->htmlLanguages();
			break;
			
			case 'register':
				return $this->htmlRegister();
			break;
			
			
			case 'updatelog':
				return $this->htmlUpdatelog();
			break;
			case 'connect':
				return $this->htmlConnect();
			break;
			
			
			case 'nextVersion':
				return $this->htmlNextVersion();
			break;
			
			
			default:
				print "Frame $this->Section is not known!";
			break;
				
		}
	}
	
	function getData($name) {
		
		if (isset($this->Data[$name])) {
			return $this->Data[$name];
		}
	}
	
	function processUpdateVariables() {
		
		global $DB_WE;
		$this->Data['lastUpdate'] = $GLOBALS['l_liveUpdate']['update']['neverUpdated'];
		
		$query = "
			SELECT DATE_FORMAT(datum, \"%d.%m.%y - %T \") AS date
			FROM " . UPDATE_LOG_TABLE . "
			WHERE error=0
			ORDER BY ID DESC
			LIMIT 0,1
		";
		$DB_WE->query($query);
		$DB_WE->next_record();
		
		if ($date = $DB_WE->f('date')) {
			$this->Data['lastUpdate'] = $date;
		}
	}
	
	function processDeleteLanguages() {
		
		$deletedLngs = array();
		$notDeletedLngs = array();
		
		if (isset($_REQUEST['deleteLanguages']) && sizeof($_REQUEST['deleteLanguages'])) {
			
			// update prefs_table
			$cond = '';
			
			foreach ($_REQUEST['deleteLanguages'] as $lng) {
				$cond .= ' OR Language="' . addslashes($lng) . '"';
			}
			
			$query = "
				UPDATE " . PREFS_TABLE . "
				SET Language = '" . WE_LANGUAGE . "'
				WHERE ( 0 $cond )
			";
			$GLOBALS['DB_WE']->query($query);
			
			
			
			$liveUpdateFunc = new liveUpdateFunctions();
			// delete folders
			foreach ($_REQUEST['deleteLanguages'] as $lng) {
				
				if ( strpos($lng, "..") === false && $lng != "" ) {
					if ($liveUpdateFunc->deleteDir(LIVEUPDATE_SOFTWARE_DIR . '/webEdition/we/include/we_language/' . $lng)) {
						$deletedLngs[] = $lng;
					} else {
						$notDeletedLngs[] = $lng;
					}
				}
			}
		}
		$this->Data['deletedLngs'] = $deletedLngs;
		$this->Data['notDeletedLngs'] = $notDeletedLngs;
	}
	
	function processUpdateLogVariables() {
		
		global $DB_WE;
		
		if ( !isset($_REQUEST['start']) ) {
			
			$_REQUEST['messages'] = true;
			$_REQUEST['notices'] = true;
			$_REQUEST['errors'] = true;
		}
		
		$_REQUEST['start'] = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
		$this->Data['amountPerPage'] = 5;
		
		$condition = " WHERE 1 ";
		
		if ( isset($_REQUEST['messages']) ) {
			
		} else {
			$condition .= " AND error != 0";
		}
		if ( isset($_REQUEST['notices']) ) {
			
		} else {
			$condition .= " AND error != 2";
		}
		if ( isset($_REQUEST['errors']) ) {
			
		} else {
			$condition .= " AND error != 1";
		}
		
		/*
		 * process update_cmd
		 */
		if (isset($_REQUEST['log_cmd'])) {
			
			switch ($_REQUEST['log_cmd']) {
				
				case "deleteEntries":
					
					$delQuery = "
						DELETE FROM " . UPDATE_LOG_TABLE . "
						$condition
					";
					
					$DB_WE->query($delQuery);
					
					$_REQUEST['start'] = 0;
					
				break;
				case "nextEntries":
					$_REQUEST['start'] += $this->Data['amountPerPage'];
				break;
				case "lastEntries":
					$_REQUEST['start'] -= $this->Data['amountPerPage'];
				break;
				default:
					$_REQUEST['start'] = 0;
				break;
			}
		}
		
		if ($_REQUEST['start'] < 0) {
			$_REQUEST['start'] = 0;
		}
		
		/*
		 * Check if there are Log-Entries
		 */
			// complete amount
			$queryAmount = "
				SELECT COUNT(ID) as amount, error
				FROM " . UPDATE_LOG_TABLE . "
				GROUP BY error
			";
			
			$this->Data['amountMessages'] = 0;
			$this->Data['amountNotices'] = 0;
			$this->Data['amountErrors'] = 0;
			
			$this->Data['allEntries'] = 0;
			
			$this->Data['amountEntries'] = 0;
			
			$DB_WE->query($queryAmount);
			while ( $DB_WE->next_record() ) {
				
				$this->Data['allEntries'] += $DB_WE->f('amount');
				
				if ($DB_WE->f('error') == 0) {
					$this->Data['amountMessages'] = $DB_WE->f('amount');
					if (isset($_REQUEST['messages'])) {
						$this->Data['amountEntries'] += $DB_WE->f('amount');
					}
				}
				if ($DB_WE->f('error') == 1) {
					$this->Data['amountErrors'] = $DB_WE->f('amount');
					if (isset($_REQUEST['errors'])) {
						$this->Data['amountEntries'] += $DB_WE->f('amount');
					}
				}
				if ($DB_WE->f('error') == 2) {
					$this->Data['amountNotices'] = $DB_WE->f('amount');
					if (isset($_REQUEST['notices'])) {
						$this->Data['amountEntries'] += $DB_WE->f('amount');
					}
				}
			}
		
		
		if ($this->Data['allEntries']) {
			
			/*
			 * There are entries available, get them
			 */
			$query = "
				SELECT DATE_FORMAT(datum, '%d.%m.%y&nbsp/&nbsp;%H:%i') AS date, aktion, versionsnummer, error
				FROM " . UPDATE_LOG_TABLE . "
				$condition
				ORDER BY datum DESC
				LIMIT " . $_REQUEST['start'] . ", " . $this->Data['amountPerPage'];
			
			$this->Data['logEntries'] = array();
			
			$DB_WE->query($query);
			while ($row = $DB_WE->next_record()) {
				
				$this->Data['logEntries'][] = array(
					'date' => $DB_WE->f('date'),
					'action' => $DB_WE->f('aktion'),
					'version' => $DB_WE->f('versionsnummer'),
					'state' => $DB_WE->f('error'),
				);
			}
		}
	}
	
	
	/**
	 * @return string
	 */
	function htmlFrameset() {
		
		$activeTab = liveUpdateFrames::getValidTab($this->Data['activeTab']);
		
		$show = "?section=$activeTab";
		$active = "&active=$activeTab";
		
		return '<html>
<head>
	<title>webEdition Update</title>
</head>
<frameset rows="30, *, 0" border="0" framespacing="0" frameborder="no">
	<frame name="updatetabs" src="' . $_SERVER['PHP_SELF'] . '?section=tabs' . $active . '"  noresize scrolling="no" />
	<frame name="updatecontent" src="' . $_SERVER['PHP_SELF'] . $show . '"  noresize scrolling="no" />
	<frame name="updateload" src="about:blank" />
</frameset>
</html>';
	}
	
	function htmlTabs() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'tabs.inc.php');
	}
	
	function htmlUpgrade() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'upgrade.inc.php');
	}
	
	function htmlUpdate() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'update.inc.php');
	}
	
	
	function htmlNextVersion() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'nextVersion.inc.php');
	}
	
	
	function htmlModules() {
		include(LIVEUPDATE_TEMPLATE_DIR . 'modules.inc.php');
	}
	
	
	function htmlLanguages() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'languages.inc.php');
	}
	
	
	function htmlRegister() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'register.inc.php');
	}
	
	
	function htmlConnect() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'connect.inc.php');
	}
	function htmlConnectionSuccess($errorMessage='') {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'connectSuccess.inc.php');
	}
	function htmlConnectionError() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'connectError.inc.php');
	}
	
	function htmlStateMessage() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'stateMessage.inc.php');
	}
	
	function htmlUpdatelog() {
		
		include(LIVEUPDATE_TEMPLATE_DIR . 'updatelog.inc.php');
	}
	
	
	
	function getValidTab($showTab='') {
		
		global $updatecmds;
		
		if (in_array($showTab, $updatecmds)) {
			return $showTab;
		}
		return $updatecmds[0];
	}
	
	function getAllTabs() {
		
		return $GLOBALS['updatecmds'];
	}
}

?>