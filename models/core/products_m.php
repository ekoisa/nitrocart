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
	public $prefix;
	public $table;

    public function __construct()
    {
        parent::__construct();

    	$this->prefix = $this->namespace.'_';
    	$this->table = $this->namespace.'_'.$this->stream;
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

}