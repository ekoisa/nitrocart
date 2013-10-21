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
    public $namespace = 'nitrocart_categories';

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->library('core/streams_details');
        $this->ci->streams_details->set_namespace($this->namespace);
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

        /* third_party
        -------------------------------------------------- */
        $this->third_party();

        /* default_data
        -------------------------------------------------- */
        $this->default_data();

        return true;
    }

    public function uninstall()
    {
        $this->ci->modules_m->uninstalled('categories');
        $this->ci->modules_m->disabled('categories');

        $this->ci->streams->utilities->remove_namespace($this->namespace);

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
        $fields['name'] = array('type' => 'text', 'unique' => true);
        $fields['slug'] = array('type' => 'slug', 'extra' => array('slug_field' => 'name', 'space_type' => '-'), 'unique' => true);
        $fields['description'] = array('type' => 'textarea');
        $fields['parent'] = array('type' => 'relationship',  'extra' => array('choose_stream' => $streams_id['categories']));

        $this->ci->streams_details->insert_fields($fields);

        return $fields;
    }

    public function third_party()
    {
        /* fields:products
        -------------------------------------------------- */
        $fields['category'] = array('type' => 'relationship',  'extra' => array('choose_stream' => $streams_id['categories']), 'locked' => false);
    }

    protected function default_data()
    {
        $this->ci->load->model('core/modules_m');
        $this->ci->modules_m->installed('categories');
        $this->ci->modules_m->enabled('categories');
    }

}
/* End of file details.php */