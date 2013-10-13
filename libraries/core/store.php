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

class Upgraded_showcase
{
    public $namespace = 'nitrocart';
    public $sections = array('prices', 'taxes');

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function info()
    {
        $shortcuts = array(
            'taxes' => array(
                'name'  => $this->namespace.':label:create_tax',
                'uri'   => 'admin/'.$this->namespace.'/taxes/create',
                'class' => 'add'
                ),
            );

        $sections = $this->ci->streams_details->create_sections($this->sections, $shortcuts);

        return $sections;
    }

    public function admin_menu()
    {
        return $this->ci->streams_details->create_admin_menu($this->sections, $this->namespace);
    }

    public function install()
    {
        $this->uninstall();

        /* custom_data
        -------------------------------------------------- */
        $streams = array('prices', 'taxes');

        $field_assignments = array(
            'prices' => array('product', 'code', 'price_base', 'price_bt', 'price_at', 'rrp', 'tax'),
            'taxes' => array('name', 'rate'),
            );

        $streams_options = array(
            'prices' => array(
                'view_options' => array('code'),
                'title_column' => 'code'
                ),
            'taxes' => array(
                'view_options' => array('name'),
                'title_column' => 'name'
                ),
            );

        /* streams
        -------------------------------------------------- */
        $this->ci->streams_details->insert_streams($streams, $streams_options);

        /* folders
        -------------------------------------------------- */
        $array = array();
        $folders = $this->ci->streams_details->create_folders($array);

        /* fields
        -------------------------------------------------- */
        $fields = $this->fields($folders);

        /* field_assignments
        -------------------------------------------------- */
        $this->ci->streams_details->insert_field_assignments($streams, $fields, $field_assignments, $instructions);

        /* default_data
        -------------------------------------------------- */
        $this->default_data();

        return true;
    }

    public function uninstall()
    {
        $this->ci->streams->utilities->remove_namespace($this->namespace);

        return true;
    }

    public function fields($folders)
    {
        $fields = array();

        /* fields:prices
        -------------------------------------------------- */
        $products = $this->ci->streams_details->get_stream('products');
        $fields['product'] = array('type' => 'relationship',  'extra' => array('choose_stream' => $products->id));
        $fields['code'] = array('required' => false);
        $fields['price_base'] = array('type' => 'decimal', 'extra' => array('decimal_places' => 2, 'min_value' => 0, 'default_value' => 0));
        $fields['price_bt'] = array('type' => 'decimal', 'extra' => array('decimal_places' => 2, 'min_value' => 0, 'default_value' => 0));
        $fields['price_at'] = array('type' => 'decimal', 'extra' => array('decimal_places' => 2, 'min_value' => 0, 'default_value' => 0));
        $fields['rrp'] = array('type' => 'decimal', 'extra' => array('decimal_places' => 2, 'min_value' => 0, 'default_value' => 0), 'required' => false);
        $taxes = $this->ci->streams_details->get_stream('taxes');
        $fields['tax'] = array('type' => 'relationship',  'extra' => array('choose_stream' => $taxes->id));

        /* fields:taxes
        -------------------------------------------------- */
        $fields['rate'] = array('type' => 'decimal', 'extra' => array('decimal_places' => 2, 'min_value' => 0, 'default_value' => 0), 'unique' => true);

        $this->ci->streams_details->insert_fields($fields);

        return $fields;
    }

    public function default_data()
    {
        $modules = array('prices', 'taxes');

        foreach ($modules as $module)
        {
            $entry_data = array(
                'name' => $this->ci->streams_details->lang($module),
                'slug' => slugify($module),
                'description' => $this->ci->streams_details->lang($module, 'about'),
                'core' => 1,
                'installed' => 1,
                'enabled' => 1,
                );
            $this->ci->streams->entries->insert_entry($entry_data, 'modules', $this->namespace);
        }

        $this->ci->nitrocart_m->update_mode('upgraded_showcase');        
    }

}
/* End of file upgraded_showcase.php */