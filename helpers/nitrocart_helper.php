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

if( ! function_exists('is_installed'))
{
    function is_installed($module_name)
    {
        if (module_exists($module_name)) {
            $ci =& get_instance();

            $installed = $ci->db->where('installed', 1)
            ->where('slug', $module_name)
            ->count_all_results('modules');

            if ($installed)
                return true;
            else
                return false;
        }
    }
}

if( ! function_exists('create_alt_pagination'))
{

    /**
     * The Pagination helper cuts out some of the bumf of normal pagination
     *
     * @param string $uri The current URI.
     * @param int $total_rows The total of the items to paginate.
     * @param int|null $limit How many to show at a time.
     * @param int $uri_segment The current page.
     * @param boolean $full_tag_wrap Option for the Pagination::create_links()
     * @return array The pagination array. 
     * @see Pagination::create_links()
     */
    function create_alt_pagination($uri, $total_rows, $limit = null, $uri_segment = 4, $full_tag_wrap = true, $extra = null)
    {
        $ci = & get_instance();
        $ci->load->library('pagination');

        $current_page = $ci->uri->segment($uri_segment, 0);
        $suffix = $ci->config->item('url_suffix');

        $limit = $limit === null ? Settings::get('records_per_page') : $limit;

        $config = array(
            'suffix'                => $suffix,
            'base_url'              => ( ! $suffix) ? rtrim(site_url($uri), $suffix) : site_url($uri),
            'total_rows'            => $total_rows,
            'per_page'              => $limit,
            'uri_segment'           => $uri_segment,
            'use_page_numbers'      => true,
            'reuse_query_string'    => true,
            );

        // Adding extra values
        foreach($extra as $key => $val)
            $config[$key] = $val;

        // Initialize pagination
        $ci->pagination->initialize($config);

        $offset = $limit * ($current_page - 1);
        
        //avoid having a negative offset
        if ($offset < 0) $offset = 0;

        return array(
            'current_page' => $current_page,
            'per_page' => $limit,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $ci->pagination->create_links($full_tag_wrap)
            );
    }
}

/* End of file nitrocart_helper.php */