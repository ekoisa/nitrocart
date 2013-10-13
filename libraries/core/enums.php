<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * NitroCart
 *
 * Turbo Powered Shopping - for PyroCMS!
 *
 * @package    NitroCart
 * @author     NitroCart Dev Team <contact@nitrocart.net>
 * @license    http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported
 * @link       http://nitrocart.net
 */

/**
 * The Enum Enum holds our generic values
 *
 */
final class Enums
{
	/**
	 * not used - just for the sake of the filename
	 */
}

/**
 * Use this enum to exactly state which
 * NitroCart Mode you wish to specify
 */
final class nitrocart_mode
{
	const showcase = 0;
	const store    = 1;		
}

/**
 *
 *
 */
final class json_status
{
	const success = 'success';
	const error   = 'error';
}

/**
 * All views and JS should use the following strings to match this
 * PHP Enum, We will use Action::Delete which results in "delete"
 * See below example 
 *
 * BAD:
 * siteurl.com/shop/wishlist/del/1
 *
 * Good:
 * siteurl.com/shop/wishlist/delete/1 
 */
final class action
{
	const view   = 'view';
	const add    = 'add';
	const edit   = 'edit';
	const delete = 'delete';
}

/*
 * Everythiong below has not been implemnted and is a WIP
 *
 *
 *
 *
 *
 */

/**
 * NCProductVisibility
 * ProductVisibility 
 * Visibility
 * 
 */
final class product_visibility
{
	const invisible 		= 0;
	const visible 			= 1;
}

/* End of file enums.php */