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
* @author    Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
*
* Version : $Id$
* ****************************************************************************
*/
 
// Script to list recent articles from the News module (version >=1.21)
function b_marquee_news($limit, $dateformat, $itemssize)
{
	include_once ICMS_ROOT_PATH.'/modules/marquee/include/functions.php';
	include_once ICMS_ROOT_PATH.'/modules/news/class/class.newsstory.php';
	$block = $stories = array();
	$story = new NewsStory();
	$restricted = marquee_getmoduleoption('restrictindex', 'news');
	$stories = $story->getAllPublished($limit, 0, $restricted, 0, 1, true, 'published');
	if (count($stories) > 0)
	{
		foreach($stories as $onestory)
		{
			if ($itemssize > 0)
			{
				$title = xoops_substr($onestory->title(), 0, $itemssize+3);
			}
			else
			{
				$title = $onestory->title();
			}
			 
			$block[] = array('date' => formatTimestamp($onestory->published(), $dateformat),
				'category' => $onestory->topic_title(),
				'author' => $onestory->uid(),
				'title' => $title,
				'link' => "<a href='".ICMS_URL.'/modules/news/article.php?storyid='.$onestory->storyid()."'>".$title.'</a>');
		}
	}
	return $block;
}
?>