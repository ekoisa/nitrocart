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

class Streams_admin
{
    public $namespace;

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->driver('streams');
    }

    public function form($stream_slug, $namespace_slug, $mode = 'new', $view_override = false, $extra = array(), $skips = array(), $tabs = false, $hidden = array(), $defaults = array())
    {
        $stream = $this->ci->streams->cp->stream_obj($stream_slug, $namespace_slug);
        if ( ! $stream) $this->ci->log_error('invalid_stream', 'form');

        // Load up things we'll need for the form
        $this->ci->load->library(array('form_validation', 'streams_core/Fields'));

        if ($mode == 'edit')
        {
            if( ! $entry = $this->ci->row_m->get_row($entry_id, $stream, false))
            {
                $this->ci->log_error('invalid_row', 'form');
            }
        }
        else
        {
            $entry = null;
        }

        $data = array(
            'fields'    => $fields,
            'tabs'      => $tabs,
            'hidden'    => $hidden,
            'defaults'  => $defaults,
            'stream'    => $stream,
            'entry'     => $entry,
            'mode'      => $mode,
            );

        foreach ($tabs as &$tab)
        {
            // Get our field form elements.
            $tab['fields'] = $this->ci->fields->build_form($stream, $mode, $entry, false, false, $tab['skips'], $extra, $defaults);            
        }

        $data['tabs'] = $tabs;

        // Set title
        if (isset($extra['title']))
        {
            $this->ci->template->title($extra['title']);
        }
        // Set return uri
        if (isset($extra['return']))
        {
            $data['return'] = $extra['return'];
        }

        // Set the no fields mesage. This has a lang default.
        if (isset($extra['no_fields_message']))
        {
            $data['no_fields_message'] = $extra['no_fields_message'];
        }

        $this->ci->template->append_js('streams/entry_form.js');

        if ($data['tabs'] === false)
        {
            $form = $this->ci->load->view('admin/partials/streams/form', $data, true);
        }
        else
        {
            // Make the fields keys the input_slug. This will make it easier to build tabs. Less looping.
            foreach ( $data['fields'] as $k => $v ){
                $data['fields'][$v['input_slug']] = $v;
                unset($data['fields'][$k]);
            }

            $data['tabs']['fields'] = $data['fields'];

            $form = $this->ci->load->view('core/partials/tabbed_form', $data, true);
        }

        if ($view_override === false) return $form;

        $data['content'] = $form;
            //$CI->data->content = $form;

        $this->ci->data = new stdClass;
        $this->ci->data->content = $form;

        $this->ci->template->build('admin/partials/blank_section', $data);
    }

}
/* End of file streams_admin.php */