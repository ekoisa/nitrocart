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

}