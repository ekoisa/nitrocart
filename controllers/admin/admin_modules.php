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
        $this->load->model('core/modules_m');
    }

    public function index()
    {
        $addon_modules = $this->modules_m->get_core_modules();
        $core_modules = $this->modules_m->get_addon_modules();

        $this->template->title(ucfirst($this->section))
        ->set('namespace', $this->namespace)
        ->set('addon_modules', $addon_modules)
        ->set('core_modules', $core_modules)
        ->build('core/modules/admin/index');
    }

    public function install($module_slug)
    {
        $this->load->library('addons/'.$module_slug.'/details');
        $this->details->install();

        $this->session->set_flashdata('success', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream);        
    }

    public function uninstall($module_slug)
    {
        $this->load->library('addons/'.$module_slug.'/details');
        $this->details->uninstall();

        $this->session->set_flashdata('success', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream);        
    }

    public function enable($module_slug)
    {
        $this->modules_m->enabled($module_slug);

        $this->session->set_flashdata('success', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream);        
    }

    public function disable($module_slug)
    {
        $this->modules_m->disabled($module_slug);

        $this->session->set_flashdata('success', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream);        
    }
}

/* End of file admin_modules.php */