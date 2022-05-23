<?php

$action = $_REQUEST['action'];
if($action == false) {
	//print('Action is false; cannot proceed.');exit(0);
	print('<ul>
<!--li><a href="do.php?action=backup_important_files">Backup Important Files</a></li>
<li><a href="do.php?action=differentially_backup_important_files">Differentially Backup Important Files</a></li>
<li><a href="do.php?action=clean_backup_folders">Clean Backup Folders</a></li>
<li><a href="do.php?action=redistribute_files">Redistribute Files</a></li>
<li><a href="do.php?action=analyze_drives">Analyze Drives</a></li>
<li><a href="do.php?action=navigate_files">Navigate Files</a></li-->
<li><a href="do.php?action=browse&path=https://yandex.com/">Browse Internet</a></li>
</ul>');
} else {
	include('life.php');
	$life = new life();
	$res = call_user_func(array($life, $action));
}



?>