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

class Admin_modules extends Admin_Controller
{
    public $namespace = 'nitrocart';
    protected $section = 'modules';
    public $stream = 'modules';

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('streams');
        $this->load->language('nitrocart_admin');
    }

    public function index()
    {
        $params = array(
            'stream' => $this->stream,
            'namespace' => $this->namespace,
            'where' => '`core` = "0"',
            );
        $addon_modules = $this->streams->entries->get_entries($params);

        $params['where'] = '`core` = "1"';
        $core_modules = $this->streams->entries->get_entries($params);

        $this->template->title(ucfirst($this->section))
        ->set('namespace', $this->namespace)
        ->set('addon_modules', $addon_modules)
        ->set('core_modules', $core_modules)
        ->build('core/modules/admin/index');
    }
}

/* End of file admin_modules.php */