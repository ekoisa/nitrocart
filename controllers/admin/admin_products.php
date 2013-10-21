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

class Admin_products extends Admin_Controller
{
    public $namespace = 'nitrocart';
    protected $section = 'products';
    public $stream = 'products';

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('streams');
        $this->load->library('core/streams_admin');
        $this->load->language('nitrocart_admin');
        $this->load->model('core/modules_m');
        $this->load->model('core/products_m');
    }

    public function index()
    {
        $this->config->load('pagination');

        $extra['title'] = lang($this->namespace.':label:'.$this->stream);

        $extra['buttons'] = array(
            array(
                'label'     => lang($this->namespace.':label:edit'),
                'url'       => 'admin/'.$this->namespace.'/'.$this->stream.'/edit/-entry_id-'
                ),
            array(
                'label'     => lang($this->namespace.':label:delete'),
                'url'       => 'admin/'.$this->namespace.'/'.$this->stream.'/delete/-entry_id-',
                'confirm'   => true
                ),
            );

        $table = $this->streams->cp->entries_table($this->stream, $this->namespace, $this->config->item('pagination:items_per_page'), 4, true, $extra);
    }

    public function create()
    {
        $extra = array(
            'return'          => 'admin/'.$this->namespace.'/'.$this->stream.'/',
            'success_message' => lang($this->namespace.':message:success'),
            'failure_message' => lang($this->namespace.':message:failure'),
            );

        $skips = $this->products_m->get_skips();

        $this->streams->cp->entry_form($this->stream, $this->namespace, 'new', null, true, $extra, $skips);
    }

    public function edit($entry_id = null)
    {
        $extra = array(
            'return'          => 'admin/'.$this->namespace.'/'.$this->stream.'/',
            'success_message' => lang($this->namespace.':message:success'),
            'failure_message' => lang($this->namespace.':message:failure'),
            );

        $skips = $this->products_m->get_skips();

        $this->streams->cp->entry_form($this->stream, $this->namespace, 'edit', $entry_id, true, $extra, $skips);
    }

    public function delete($entry_id = 0)
    {
        $this->streams->entries->delete_entry($entry_id, $this->stream, $this->namespace);

        $this->session->set_flashdata('error', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream);
    }

    public function custom_fields()
    {
        $custom_fields = $this->products_m->get_custom_fields();

        $is_empty = count($custom_fields) == 0 ? true : false;

        $this->template->title(ucfirst($this->section))
        ->set('namespace', $this->namespace)
        ->set('stream', $this->stream)
        ->set('custom_fields', $custom_fields)
        ->set('is_empty', $is_empty)
        ->build('core/products/admin/custom_fields');        
    }

    public function enable_custom_field($field_slug)
    {
        $this->products_m->enable_custom_field($field_slug);

        $this->session->set_flashdata('success', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream.'/custom_fields');        
    }

    public function disable_custom_field($field_slug)
    {
        $this->products_m->disable_custom_field($field_slug);

        $this->session->set_flashdata('success', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream.'/custom_fields');        
    }
}

/* End of file admin_products.php */