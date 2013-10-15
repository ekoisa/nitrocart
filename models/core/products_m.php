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

class Products_m extends MY_Model 
{
	public $namespace = 'nitrocart';
	public $stream = 'products';

    public function __construct()
    {
        parent::__construct();

        $this->set_table_name($this->namespace.'_'.$this->stream);
        $this->params = array(
            'namespace' => $this->namespace,
            'stream' => $this->stream,
            );
    }

    public function get_skips()
    {
        $assignments = $this->streams->streams->get_assignments($this->stream, $this->namespace);

        foreach ($assignments as $key => $value)
        {
            if ($value->is_locked == 'yes')
                unset($assignments[$key]);
        }

        $is_empty = count($assignments) == 0 ? true : false;

        $skips = array('date_deleted');
        if(!$is_empty)
        {
            foreach ($assignments as $assigment)
            {
                if(!in_array($assigment->field_slug, unserialize($assigment->stream_view_options)))
                    $skips[] = $assigment->field_slug;
            }
        }

        return $skips;
    }

    public function get_custom_fields()
    {
        $assignments = $this->streams->streams->get_assignments($this->stream, $this->namespace);

        foreach ($assignments as $key => $value)
        {
            if ($value->is_locked == 'yes')
                unset($assignments[$key]);
        }
        foreach ($assignments as $assigment)
        {
            if(in_array($assigment->field_slug, unserialize($assigment->stream_view_options)))
                $assigment->view_options = true;
        }

        return $assignments;
    }

    public function enable_custom_field($field_slug)
    {
        $stream = $this->streams->streams->get_stream($this->stream, $this->namespace);
        $view_options = $stream->view_options;
        $view_options[] = $field_slug;

        $update_data = array(
            'view_options' => $view_options
            );
        $this->streams->streams->update_stream($this->stream, $this->namespace, $update_data);
    }

    public function disable_custom_field($field_slug)
    {
        $stream = $this->streams->streams->get_stream($this->stream, $this->namespace);
        $view_options = $stream->view_options;

        if(($key = array_search($field_slug, $view_options)) !== false)
            unset($view_options[$key]);

        $update_data = array(
            'view_options' => $view_options
            );
        $this->streams->streams->update_stream($this->stream, $this->namespace, $update_data);
    }

}

/* End of file products_m.php */