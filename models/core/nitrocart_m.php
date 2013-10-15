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

class Nitrocart_m extends MY_Model 
{
	public $namespace = 'nitrocart';
	public $prefix;

	public function __construct()
	{
		parent::__construct();

		$this->prefix = $this->namespace.'_';
	}

	public function global_get($table, $key, $value)
	{
		return $this->db->where($key, $value)->get($this->prefix.$table)->row();
	}

}

/* End of file nitrocart_m.php */