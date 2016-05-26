<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'/core/AjaxResponse.php';

class BaseController extends CI_Controller {
	protected $myRespone;
	public function __construct(){
		parent::__construct();
		$this->myRespone = new AjaxResponse();
	}
	protected function response(){
		return $this->myRespone;
	}
	public function index()
	{
		$this->response()->ok('cc');
	}
}
