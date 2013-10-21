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

class module_nitrocart extends Module
{
	public $version = '0.9.0';
    public $name = 'Nitrocart';
	public $namespace = 'nitrocart';
    public $sections;

    public function __construct()
    {
        // Helpers
        $this->load->helper($this->namespace.'/nitrocart');

        // Languages
        $this->load->language($this->namespace.'/nitrocart_details');

        // Libraries
        $this->load->library($this->namespace.'/core/enums');
        $this->load->library($this->namespace.'/core/streams_details');
        $this->streams_details->set_namespace($this->namespace);

        // Models
        $this->load->model($this->namespace.'/core/nitrocart_m');
        $this->load->model($this->namespace.'/core/modules_m');

        //$modules = $this->modules_m->get_enabled_modules();
        $modules = array('dashboard', 'modules', 'settings', 'products', 'categories');
        $this->sections = $modules;
        
    }

	public function info()
	{
		$info =  array(
			'name' => array(
				'en' => 'NitroCart',
				),
			'description' => array(
				'en' => 'Turbo Powered Shopping - for PyroCMS!',
				),
			'skip_xss' => true,
			'frontend' => true,
			'backend' => true,
			'menu' => false,
			'author' => 'NitroCart Dev Team',
			);

        $shortcuts = array(
            'products' => array(
                'create' => array(
                    'name'  => $this->namespace.':label:create_product',
                    'uri'   => 'admin/'.$this->namespace.'/products/create',
                    'class' => 'add',
                    ),
                'custom_fields' => array(
                    'name'  => $this->namespace.':label:custom_fields',
                    'uri'   => 'admin/'.$this->namespace.'/products/custom_fields',
                    ),
                ),
            );

        $info['sections'] = $this->streams_details->create_sections($this->sections, $shortcuts);

        return $info;
    }
    
    public function admin_menu(&$menu)
    {
        $menu[$this->name] = $this->streams_details->create_admin_menu($this->sections, $this->namespace);

        // Place menu on position #
        add_admin_menu_place($this->name, 2);
    }

    public function install()
    {
        $this->uninstall();

        /* custom_data
        -------------------------------------------------- */
        $streams = array('modules', 'settings', 'products');

        $field_assignments = array(
            'modules' => array('name', 'slug', 'description', 'version', 'core', 'installed', 'enabled'),
            'settings' => array('name', 'description', 'module', 'key', 'value', 'default', 'options', 'required', 'gui'),
            'products' => array('name', 'slug', 'description', 'cover', 'short_description', 'keywords', 'visible', 'digital', 'searchable', 'date_deleted'),
            );

        $streams_options = array(
            'modules' => array(
                'view_options' => array('name', 'description', 'version', 'core', 'installed', 'enabled'),
                'title_column' => 'name'
                ),
            'settings' => array(
                'view_options' => array('name'),
                'title_column' => 'name'
                ),
            'products' => array(
                'view_options' => array('name', 'slug', 'description', 'cover'),
                'title_column' => 'name'
                ),
            );

        /* streams
        -------------------------------------------------- */
        $streams_id = $this->streams_details->insert_streams($streams, $streams_options);

        /* folders
        -------------------------------------------------- */
        $array = array('products');
        $folders = $this->streams_details->create_folders($array);

        /* fields
        -------------------------------------------------- */
        $fields = $this->fields($streams_id, $folders);

        /* field_assignments
        -------------------------------------------------- */
        $this->streams_details->insert_field_assignments($streams, $fields, $field_assignments);

        /* default_data
        -------------------------------------------------- */
        $this->default_data();

        return true;
    }

    public function uninstall()
    {
        $this->streams->utilities->remove_namespace($this->namespace);
        $this->streams->utilities->remove_namespace($this->namespace.'_categories');

        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }

    public function help()
    {
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

    protected function fields($streams_id, $folders = array())
    {
        $fields = array();

        $fields['name'] = array('unique' => true);
        $fields['slug'] = array('type' => 'slug', 'extra' => array('slug_field' => 'name', 'space_type' => '-'), 'unique' => true);
        $fields['description'] = array('type' => 'textarea');

        /* fields:modules
        -------------------------------------------------- */
        $fields['version'] = array();
        $fields['core'] = array('type' => 'integer', 'extra' => array('max_length' => 1, 'default_value' => 0));
        $fields['installed'] = array('type' => 'integer', 'extra' => array('max_length' => 1, 'default_value' => 0));
        $fields['enabled'] = array('type' => 'integer', 'extra' => array('max_length' => 1, 'default_value' => 0));

        /* fields:settings
        -------------------------------------------------- */
        $fields['module'] = array('type' => 'relationship',  'extra' => array('choose_stream' => $streams_id['modules']));
        $fields['key'] = array();
        $fields['value'] = array();
        $fields['default'] = array();
        $fields['options'] = array();
        $fields['required'] = array('type' => 'integer', 'extra' => array('max_length' => 1, 'default_value' => 0));
        $fields['gui'] = array('type' => 'integer', 'extra' => array('max_length' => 1, 'default_value' => 0));

        /* fields:products
        -------------------------------------------------- */
        $fields['cover'] = array('type' => 'image', 'extra' => array('folder' => $folders['products']->id, 'allowed_types' => 'jpg|gif|png'));
        $fields['short_description'] = array('type' => 'textarea', 'locked' => false);
        $fields['keywords'] = array('type' => 'keywords', 'locked' => false);
        $array = array('yes', 'no');
        $fields['visible'] = $this->streams_details->build_choice_field($array, 'visible', 'dropdown', 'yes', false);
        $fields['digital'] = $this->streams_details->build_choice_field($array, 'digital', 'dropdown', 'no', false);
        $fields['searchable'] = $this->streams_details->build_choice_field($array, 'searchable', 'dropdown', 'yes', false);
        $fields['date_deleted'] = array('type' => 'datetime', 'extra' => array('use_time' => 'yes', 'storage' => 'datetime'), 'required' => false);

        $this->streams_details->insert_fields($fields);

        return $fields;
    }

    protected function default_data()
    {
        /* core_modules
        -------------------------------------------------- */
        $core_modules = array(
            'modules' => array('core' => 1, 'installed' => 1, 'enabled' => 1),
            'settings' => array('core' => 1, 'installed' => 1, 'enabled' => 1),
            'products' => array('core' => 1, 'installed' => 1, 'enabled' => 1),
            );
        $this->add_modules($core_modules);

        /* addon_modules
        -------------------------------------------------- */
        $addon_modules = array(
            'categories' => array(),
            );
        $this->add_modules($addon_modules);
    }

    protected function add_modules($modules)
    {
        foreach ($modules as $name => $params)
        {
            $entry_data = array(
                'name' => lang($this->namespace.':label:'.$name),
                'slug' => slugify($name),
                'description' => lang($this->namespace.':about:'.$name),
                'version' => (isset($params['version'])) ? $params['version'] : '1.0.0',
                'core' => (isset($params['core'])) ? $params['core'] : '0',
                'installed' => (isset($params['installed'])) ? $params['installed'] : '0',
                'enabled' => (isset($params['enabled'])) ? $params['enabled'] : '0',
                );
            $this->streams->entries->insert_entry($entry_data, 'modules', $this->namespace);
        }
    }
}
/* End of file details.php */