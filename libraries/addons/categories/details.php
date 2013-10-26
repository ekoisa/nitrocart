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

class Details
{
    public $namespace = 'nitrocart';

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->library('core/streams/streams_details');
        $this->ci->streams_details->set_namespace($this->namespace);

        $this->ci->load->language($this->namespace.'/categories_details');
    }

    public function info()
    {
        $shortcuts = array(
            'create' => array(
                'name'  => $this->namespace.':label:create_category',
                'uri'   => 'admin/'.$this->namespace.'/categories/create',
                'class' => 'add',
                ),
            );

        return $shortcuts;
    }

    public function install()
    {
        $this->uninstall();

        /* custom_data
        -------------------------------------------------- */
        $streams = array('categories');

        $field_assignments = array(
            'categories' => array('name', 'slug', 'description', 'parent'),
            );

        $streams_options = array(
            'categories' => array(
                'view_options' => array('name', 'description', 'parent'),
                'title_column' => 'name'
                ),
            );

        /* streams
        -------------------------------------------------- */
        $streams_id = $this->ci->streams_details->insert_streams($streams, $streams_options);

        /* folders
        -------------------------------------------------- */
        //$array = array('');
        //$folders = $this->streams_details->create_folders($array);

        /* fields
        -------------------------------------------------- */
        $fields = $this->fields($streams_id);

        /* field_assignments
        -------------------------------------------------- */
        $this->ci->streams_details->insert_field_assignments($streams, $fields, $field_assignments);

        /* append_fields
        -------------------------------------------------- */
        $this->append_fields();

        /* default_data
        -------------------------------------------------- */
        $this->default_data();

        return true;
    }

    public function uninstall()
    {
        $streams = array('categories');
        $this->ci->streams_details->delete_streams($streams);

        $fields = array('parent', 'category');
        $this->ci->streams_details->delete_fields($fields);

        $this->ci->modules_m->disabled('categories');
        $this->ci->modules_m->uninstalled('categories');

        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }

    protected function fields($streams_id, $folders = array())
    {
        $fields = array();

        /* fields:categories
        -------------------------------------------------- */
        $fields['parent'] = array('type' => 'relationship',  'extra' => array('choose_stream' => $streams_id['categories']), 'required' => false);

        $this->ci->streams_details->insert_fields($fields);

        return $fields;
    }

    public function append_fields()
    {
        $streams = array('products');

        $streams_id = $this->ci->streams_details->get_streams_id(array('products', 'categories'));

        $field_assignments = array(
            'products' => array('category')
            );

        /* stream:products
        -------------------------------------------------- */
        $fields['category'] = array('type' => 'relationship',  'extra' => array('choose_stream' => $streams_id['categories']), 'locked' => true);

        $this->ci->streams_details->insert_fields($fields);

        $this->ci->streams_details->insert_field_assignments($streams, $fields, $field_assignments);
    }

    protected function default_data()
    {
        $this->ci->load->model('core/modules_m');
        $this->ci->modules_m->installed('categories');
        $this->ci->modules_m->enabled('categories');
    }

}
/* End of file details.php */