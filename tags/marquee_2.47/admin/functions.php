<?php
/**
 * ****************************************************************************
 * marquee - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         marquee
 * @author 			Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

function marquee_adminmenu($currentoption = 0, $breadcrumb = '')
{
	include_once XOOPS_ROOT_PATH.'/modules/marquee/include/functions.php';

	/* Nice buttons styles */
	echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/marquee/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/marquee/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/marquee/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";
 	global $xoopsModule, $xoopsConfig;

	$tblColors = array('','','','','');
	if($currentoption >= 0) {
		$tblColors[$currentoption] = 'current';
	}

	if (file_exists(XOOPS_ROOT_PATH . '/modules/marquee/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH. '/modules/marquee/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/marquee/language/english/modinfo.php';
	}

	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid')."\">" . _AM_MARQUEE_GENERALSET . "</a></td>";
	echo "<td style=\"width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $xoopsModule->name() . "  " . _AM_MARQUEE_MODULEADMIN . "</b> " . $breadcrumb . "</td>";
	echo "</tr></table>";
	echo "</div>";

	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "<li id='" . $tblColors[0] . "'><a href=\"index.php\"\"><span>"._MI_MARQUEE_MENU_01 ."</span></a></li>\n";
	echo "</ul></div>";
	echo "<br /><br /><pre>&nbsp;</pre><pre>&nbsp;</pre><br />";
}


/**
 * Returns the files in a folder according to a pattern
 *
 * Some hosts have disabled the Php glob() function, that's why this function exists
 *
 * @package Marquee
 * @author Instant Zero (http://www.instant-zero.com)
 * @copyright	(c) Instant Zero
 *
 * @param string $folder	Folder where you want to grab files from (terminated with a slash)
 * @param string $pattern	Pattern used to filter files
 * @return array Files that match the pattern in the selected folder
 */
function myglob($folder = '', $pattern = 'php')
{
	$result = array();
	if ($dir = @opendir($folder)) {
		while (($file = readdir($dir)) !== false) {
  			if(!is_dir($file)) {
				$ext = basename($file);
				$ext = explode('.', $ext);
				$extension = strtolower($ext[count($ext)-1]);
				if($extension == $pattern) {
					$result[] = $file;
				}
   			}
		}
		closedir($dir);
	} else {
		echo "Error, impossible to open the folder ".$folder;
	}
	return $result;
}
?>