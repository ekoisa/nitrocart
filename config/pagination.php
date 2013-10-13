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

$config['pagination:items_per_page'] = 20;
$config['pagination:extra'] = array(
    'full_tag_open' => '<ul>',
    'full_tag_close' => '</ul>',
    'first_link' => '&laquo;',
    'first_tag_open' => '<li>',
    'first_tag_close' => '</li>',
    'last_link' => '&raquo;',
    'last_tag_open' =>'<li>',
    'last_tag_close' => '</li>',
    'next_link' => '&gt;',
    'next_tag_open' => '<li>',
    'next_tag_close' => '</li>',
    'prev_link' => '&lt;',
    'prev_tag_open' => '<li>',
    'prev_tag_close' => '</li>',
    'cur_tag_open' => '<li class=active><span>',
    'cur_tag_close' => '</span></li>',
    'num_tag_open' => '<li>',
    'num_tag_close' => '</li>'
);

/* End of file pagination.php */