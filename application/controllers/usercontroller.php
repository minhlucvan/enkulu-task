<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'basecontroller.php';

class UserController extends BaseController {
	public function __construct(){
		parent::__construct();
		$this->load->model('user');
	}
	private function initUpload($id){
		$config['upload_path'] = FCPATH.'public/uploads/avatar/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		$config['file_name'] = 'avatar_'.$id;

		$this->load->library('upload', $config);
	}
	private function initValidation(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'name', 'required|max_length[50]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		$this->form_validation->set_rules('phone', 'phone', 'required|alpha_numeric|max_length[20]');
	}
	private function boundForm($user){
		if(empty($_POST)) {
			$this->response()->error(400, 'bad request');
		}
		$user->name = $this->input->post('name');
		$user->email = $this->input->post('email');
		$user->phone = $this->input->post('phone');
		if(file_exists($_FILES['avatar']['tmp_name'])){
			$this->initUpload($user->id);
			$uploadOk = $this->upload->do_upload('avatar');
			if($uploadOk){
				$upload_data = $this->upload->data(); 
				$file_name = $upload_data['file_name'];
				$user->avatar = $file_name;
				return true;
			} else {
				$data = $this->upload->display_errors();
				$this->response()
					->error($data);
			}
		}
		return true;
	}
	private function checkPost(){
		//$_SERVER['REQUEST_METHOD']
	} 
	public function addUser(){
		$this->checkPost();
		$this->initValidation();
		if(!$this->form_validation->run()){
			$error = $this->form_validation->getErrorsArray();
			$this->response()
				->errorData($error, "there are some validation errors", 400);
			return;
		}
		$user = new User();
		$user->id = $this->user->nextId();
		$boudded = $this->boundForm($user);
		if(!$boudded){
			$this->response()
				->error('something went wrong, can not add user!');
		} else {
			$email = $this->input->post('email');
			if($this->user->checkEmailExits($email)){
				$this->response()
					->errorData(array('email' => 'email already exits'), "this email has exits! ");
			}
			$saved = $user->save();
			if(!$saved){
				$this->response()
				->error('can not add user!');
			} else {
				$this->response()
				->ok($user, 'add user succesfully!');
			}
		}
	}
	
	public function listUser($page = 1){
		$users = $this->user->getList($page);
		$this
			->response()
			->ok($users);
	}
	
	public function updateUser($id) {
		$this->initValidation();
		if(!$this->form_validation->run()){
			$error = $this->form_validation->getErrorsArray();
			$this->response()
				->errorData($error, "there are some validation errors", 400);
			return;
		}
		$user = $this->user->findById($id);
		$boudded = $this->boundForm($user);
		if(!$boudded){
			$this->response()
				->error('something went wrong, can not update user!');
		} else {
			$updated = $this->user->update($user);
			if(!$updated){
				$this->response()
					->error("can not update user!");
			}
			$this->response()
				->ok($user, 'update user succesfully!');
		}
	}
	
	public function deleteUser($id) {
		$deleted = $this->user->deleteById($id);
		if(!$deleted){
			$this->response()
				->error('can not delete user');
		}

		$this->response()
			->okMessage('delete user succesfully');
	}
	
	public function getUserInfo($id) {
		$data = $this->user->findById($id);
		$this
			->response()
			->ok($data);
	}
	
	protected function UserFromInput(){
		//todo
	}
}