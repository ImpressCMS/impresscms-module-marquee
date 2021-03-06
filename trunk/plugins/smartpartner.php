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
 
// Script to list recent partners from the smartpartner module (tested with smartparnter 1.2)
function b_marquee_smartpartner($limit, $dateformat, $itemssize)
{
	$block = array();
	if (!defined("SMARTPARTNER_DIRNAME") )
	{
		define("SMARTPARTNER_DIRNAME", 'smartpartner');
	}
	include_once(ICMS_ROOT_PATH."/modules/" . SMARTPARTNER_DIRNAME . "/include/common.php");
	 
	 
	// Creating the partner handler object
	$smartpartner_partner_handler = & smartpartner_gethandler('partner');
	$smartpartner_category_handler = & smartpartner_gethandler('category');
	 
	// Randomize
	$partnersObj = & $smartpartner_partner_handler->getPartners(0, 0, _SPARTNER_STATUS_ACTIVE);
	If (count($partnersObj) > 1)
	{
		$key_arr = array_keys($partnersObj);
		$key_rand = array_rand($key_arr, count($key_arr));
		for ($i = 0 ; (($i < count ($partnersObj)) && ($i < $limit)) ; $i++)
		{
			$newObjs[$i] = $partnersObj[$key_rand[$i]];
		}
		$partnersObj = $newObjs;
	}
	$cat_id = array();
	foreach($partnersObj as $partnerObj)
	{
		if (!in_array($partnerObj->categoryid(), $cat_id))
		{
			$cat_id[] = $partnerObj->categoryid();
		}
	}
	 
	If ($partnersObj)
	{
		for ($j = 0; $j < count($cat_id); $j++ )
		{
			$categoryObj = $smartpartner_category_handler->get($cat_id[$j]);
			for ($i = 0; $i < count($partnersObj); $i++ )
			{
				if ($partnersObj[$i]->categoryid() == $cat_id[$j])
				{
					$smartConfig = & smartpartner_getModuleConfig();
					if ($itemssize > 0)
					{
						$title = xoops_substr($partnersObj[$i]->title(), 0, $itemssize+3);
					}
					else
					{
						$title = $partnersObj[$i]->title();
					}
					 
					$block[] = array('date' => '',
						'category' => '',
						'author' => '',
						'title' => $title,
						'link' => "<a href='".ICMS_URL.'/modules/smartpartner/partner.php?id='.$partnersObj[$i]->id()."'>".$title.'</a>' );
				}
			}
		}
	}
	return $block;
}
?>