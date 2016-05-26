<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'basecontroller.php';
class MainController extends BaseController {
	protected $myLayout;

	public function __construct(){
		parent::__construct();
		$this->myLayout = 'layout/main';
	}

	public function index(){
		$this->layout();
	}
	
	public function error(){
		$this->layout();
	}

	protected function layout($data = null){
		if(!$this->myLayout) exit('');
		$this->load->view($this->myLayout, $data);
	}
}