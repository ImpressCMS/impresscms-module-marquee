<?php
/**
 * ****************************************************************************
 * Marquee - MODULE FOR XOOPS
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

// Script to list recent articles from wfsection 1 & 2
function b_marquee_wfsection($limit, $dateformat, $itemssize)
{
	include_once XOOPS_ROOT_PATH.'/modules/marquee/include/functions.php';
	$block = array();

	$myts =& MyTextSanitizer::getInstance();
	$module_handler = &xoops_gethandler('module');
	$wfsection = $module_handler->getByDirname('wfsection');
	$wfsection_version = intval($wfsection->getInfo('version'));

	if($wfsection_version >= 2) {

	} else {	// wfsection 1
		include_once XOOPS_ROOT_PATH.'/modules/wfsection/include/groupaccess.php';
		global $xoopsDB;
		$sql = "SELECT articleid, title, published, expired, counter, groupid, uid FROM ".$xoopsDB->prefix("wfs_article")." WHERE published < ".time()." AND published > 0 AND (expired = 0 OR expired > ".time().") AND noshowart = 0 AND offline = 0 ORDER BY published DESC";
		$result = $xoopsDB->query($sql,$limit,0);
		while ( $myrow = $xoopsDB->fetchArray($result) ) {
			if(checkAccess($myrow["groupid"])) {
				$wfs = array();
				$title = $myts->htmlSpecialChars($myrow["title"]);
				if ( !XOOPS_USE_MULTIBYTES ) {
					if($itemssize > 0) {
						$title = $myts->htmlSpecialChars(substr($myrow['title'],0,$itemssize));
					} else {
		    			$title = $myts->htmlSpecialChars($myrow['title']);
					}
				}
				$block[]=array(	'date'	=> formatTimestamp($myrow['published'], $dateformat),
								'category' => '',
								'author'=> XoopsUser::getUnameFromId($myrow['uid']),
								'title'=> $title,
								'link' =>"<a href='".XOOPS_URL.'/modules/wfsection/article.php?articleid='.$myrow['articleid']."'>".$title.'</a>');
			}
		}
    }   // wfsection 1 ou 2 ?
    return $block;
}
?>
