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

class Categories_m extends MY_Model 
{
	public $namespace = 'nitrocart_categories';
	public $stream = 'categories';

    public function __construct()
    {
        parent::__construct();

        $this->set_table_name($this->namespace.'_'.$this->stream);
        $this->params = array(
            'namespace' => $this->namespace,
            'stream' => $this->stream,
            );
    }

    public function get_fields($skips = array())
    {
        echo 'asdf';
        $assignments = $this->streams->streams->get_assignments($this->stream, $this->namespace);

        $fields = array();
        foreach ($assignments as $assigment)
        {
            if(
                in_array($assigment->field_slug, unserialize($assigment->stream_view_options))
                AND
                !in_array($assigment->field_slug, $skips)
                )
                $fields[] = $assigment->field_slug;
        }

        return $fields;
    }

    public function get_categories()
    {
        $_categories = array();
        if ($categories = $this->order_by('name')->get_all())
        {
            foreach ($categories as $category)
            {
                $_categories[$category->id] = $category->name;
            }
        }

        return $_categories;
    }

}

/* End of file products_m.php */