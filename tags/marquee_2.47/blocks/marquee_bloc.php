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

function b_marquee_show($options)
{
	global $xoopsTpl;
	include_once XOOPS_ROOT_PATH.'/modules/marquee/include/functions.php';
	$marquee_handler =& xoops_getmodulehandler('marquee', 'marquee');
	$block = array();
	$marqueeId = intval($options[0]);
	if($marqueeId > 0) {
		$marquee = null;
		$marquee = $marquee_handler->get($marqueeId);
		if(is_object($marquee)) {
			$uniqid = md5(uniqid(rand(), true));
			if(marquee_getmoduleoption('methodtouse') == 'DHTML') {
				$link = '<script type="text/javascript" src="'.XOOPS_URL.'/modules/marquee/js/xbMarquee.js"></script>';
				$link .= "\n<script type=\"text/javascript\">\n";
      			$link .= 'var marquee'.$uniqid .";\n";
				$link .= "var html$uniqid = '';\n";
				$link .= "function init_$uniqid()\n";
      			$link .= "{\n";
				$link .= "\tmarquee$uniqid.start();\n";
				$link .= "}\n";
				$link .= "</script>\n";
				$xoopsTpl->assign("xoops_module_header",$link);
			}
			$block['marqueecode'] = $marquee->constructmarquee($uniqid);
		}
	}
	return $block;
}

function b_marquee_edit($options)
{
	$marquee_handler =& xoops_getmodulehandler('marquee', 'marquee');
	$form = "<table border='0'>";
	$form.= '<tr><td>' . _MB_MARQUEE_SELECT . "</td><td><select name='options[0]'>". $marquee_handler->getHtmlMarqueesList($options[0]). '</select></td></tr>';
	$form.= '</table>';
	return $form;
}

/*
 * Block on the fly
 */
function b_marquee_custom($options)
{
	$options = explode('|',$options);
	$block = &b_marquee_show($options);

	$tpl = new XoopsTpl();
	$tpl->assign('block', $block);
	$tpl->display('db:marquee_block.html');
}
?>
