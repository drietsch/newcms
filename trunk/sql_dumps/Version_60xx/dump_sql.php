<?php
/**
 * reads all sql files of the current directory and writes them into one single file
 * for easier import into a database server
 * 
 * @author Alexander Lindenstruth
 */

if(!defined("BASEPATH")) define("BASEPATH",dirname(__FILE__));
if(!defined("OUTDIR")) define("OUTDIR",'dump');
if(!defined("OUTFILE")) define("OUTFILE",'complete.sql');
if(!defined("OUTPATH")) define("OUTPATH",dirname(__FILE__).'/'.OUTDIR);

function getfiles() {
	$dir = scandir(BASEPATH);
	$files = array();
	foreach($dir as $entry) {
		if(is_readable(BASEPATH.'/'.$entry) && substr($entry,-4) == ".sql") {
			$files[] = $entry;
		}
	}
	return $files;
}

function dieWithError($text = "") {
	die('<font class="error"><b>FEHLER:</b> '.$text.'</font></body></html>');
}

function dieWithWarning($text = "") {
	die('<font class="warning"><b>WARNUNG:</b> '.$text.'</font></body></html>');
}

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>webEdition sql dump</title>
	<style type="text/css" media="all">
	body {
		font-family:sans-serif;
		font-size:8pt;
	}
	a {
		color:blue;
	}
	font.error {
		color:red;
		display:block;
		padding:3px;
		border:1px solid red;
	}
	font.warning {
		color:orange;
		display:block;
		padding:3px;
		border:1px solid orange;
	}
	div.list {
		margin-left:20px;
	}
	</style>
</head>

<body>
<h2>dump webEdition sql files into <a href="./<?php echo OUTDIR.'/'.OUTFILE; ?>">one single sql file</a></h2>
<?php

$files = getfiles();
if(empty($files)) {
	dieWithError('Keine Quelldateien gefunden im Verzeichnis <pre>'.BASEPATH.'</pre>');
}

$outfile = OUTPATH.'/'.OUTFILE;

if(file_exists($outfile) && (!isset($_REQUEST["verified"]) ||  $_REQUEST["verified"] != "yes")) {
	dieWithWarning('Die Zieldatei <pre>'.$outfile.'</pre> existiert bereits. <a href="?verified=yes">Hier klicken</a>, um die Datei neu zu erstellen ...');
}

if(is_file($outfile) && !is_writable($outfile)) {
	dieWithError('Die Zieldatei <pre>'.$outfile.'</pre> ist nicht beschreibbar.');
}

if(file_exists($outfile) && $_REQUEST["verified"] == "yes") {
	@unlink($outfile);
}

echo '<div class="list">';
foreach($files as $entry) {
	$tmpcontent = file_get_contents(BASEPATH."/".$entry);
	if(!file_put_contents($outfile,$tmpcontent,FILE_APPEND)) {
		echo('<font class="error">'.$entry.'</font> FAILED.<br />');
	} else {
		echo(''.$entry.' written.<br />');
	}
	$tmpcontent = "";
}
echo '</div>';
?>
</body>
</html>