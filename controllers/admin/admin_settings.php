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

class Admin_settings extends Admin_Controller
{
    protected $section = 'settings';
    public $namespace = 'nitrocart';
    public $stream = 'settings';

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('streams');
        $this->load->language('nitrocart_admin');
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

        /**
         * Filters don't work so far
         */
        /*
        $extra['filters'] = array(
            'checked' => array(
                0       => 'Disabled',
                1       => 'Enabled'
                ),
            'title',
            'description'
            );
            */

        $table = $this->streams->cp->entries_table($this->stream, $this->namespace, $this->config->item('pagination:items_per_page'), 4, true, $extra);
    }

    public function create()
    {

        $extra = array(
            'return'          => 'admin/'.$this->namespace.'/'.$this->stream.'/',
            'success_message' => lang($this->namespace.':message:success'),
            'failure_message' => lang($this->namespace.':message:failure'),
            );
        $this->streams->cp->entry_form($this->stream, $this->namespace, 'new', null, true, $extra);
    }

    public function edit($entry_id = null)
    {
        $extra = array(
            'return'          => 'admin/'.$this->namespace.'/'.$this->stream.'/',
            'success_message' => lang($this->namespace.':message:success'),
            'failure_message' => lang($this->namespace.':message:failure'),
            );
        $this->streams->cp->entry_form($this->stream, $this->namespace, 'edit', $entry_id, true, $extra);
    }
    public function delete($entry_id = 0)
    {
        $this->streams->entries->delete_entry($entry_id, $this->stream, $this->namespace);

        $this->session->set_flashdata('error', lang($this->namespace.':message:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream);
    }
}

/* End of file admin_products.php */