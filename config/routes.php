<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

/* core
-------------------------------------------------- */
$route['nitrocart/admin/dashboard(:any)?'] = 'admin/admin_modules$1';
$route['nitrocart/admin/modules(:any)?']   = 'admin/admin_modules$1';
$route['nitrocart/admin/settings(:any)?']  = 'admin/admin_settings$1';
$route['nitrocart/admin/products(:any)?']  = 'admin/admin_products$1';

/* addons
-------------------------------------------------- */
$route['nitrocart/admin/categories(:any)?']  = 'admin/admin_categories$1';

/* else
-------------------------------------------------- */
$route['nitrocart/admin(:any)?']           = 'admin/admin_modules$1';

/* End of file routes.php */