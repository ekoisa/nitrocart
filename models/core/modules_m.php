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

class Modules_m extends MY_Model
{
    protected $namespace = 'nitrocart';
    protected $stream = 'modules';
    protected $params = array();

    public function __construct()
    {
        parent::__construct();

        $this->set_table_name($this->namespace.'_'.$this->stream);
        $this->params = array(
            'namespace' => $this->namespace,
            'stream' => $this->stream,
            );
    }

    // Front-end methods

    // Admin methods
    public function get_core_modules()
    {
        $this->params['where'] = '`core` = "0"';
        return $this->streams->entries->get_entries($this->params);
    }

    public function get_addon_modules()
    {
        $this->params['where'] = '`core` = "1"';
        return $this->streams->entries->get_entries($this->params);
    }

    public function get_enabled_modules()
    {
        $this->params['where'] = '`installed` = "1" AND `enabled` = "1"';
        $streams = $this->streams->entries->get_entries($this->params);

        $streams_slug = array();
        foreach ($streams['entries'] as $stream)
            $streams_slug[] = $stream['slug'];

        return $streams_slug;
    }

    public function get_enabled_addons()
    {
        $this->params['where'] = '`core` = "0" AND `installed` = "1" AND `enabled` = "1"';
        $streams = $this->streams->entries->get_entries($this->params);

        $streams_slug = array();
        foreach ($streams['entries'] as $stream)
            $streams_slug[] = $stream['slug'];

        return $streams_slug;
    }

    public function installed($module_slug)
    {
        $this->update_by('slug', $module_slug, array('installed' => 1));
    }

    public function uninstalled($module_slug)
    {
        $this->update_by('slug', $module_slug, array('installed' => 0));
    }

    public function enabled($module_slug)
    {
        $this->update_by('slug', $module_slug, array('enabled' => 1));
    }

    public function disabled($module_slug)
    {
        $this->update_by('slug', $module_slug, array('enabled' => 0));
    }

    public function is_enabled($module_slug)
    {
        $this->params['where'] = '`slug` = "'.$module_slug.'" AND `installed` = "1" AND `enabled` = "1"';
        $entries = $this->streams->entries->get_entries($this->params);
        
        return ($entries['total'] == 0) ? false : true;
    }

}

/* End of file modules_m.php */