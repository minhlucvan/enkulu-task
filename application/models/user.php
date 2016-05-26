<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {
	public $id;
	public $name;
	public $email;
	public $phone;
	public $avatar;

	private static $myTable = 'user';
	
	public function __construct(){
		$this->load->database();
	}
	public function save(){
		$data = array(
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'phone' => $this->phone,
			'avatar' => $this->avatar
			);
		return $this->db->insert(self::$myTable, $data);
	}
	public function saveWithAvatar() {
		//doto
	}
	public function update($value){
		$data = array(
			'name' => $value->name,
			'email' => $value->email,
			'phone' => $value->phone,
			'avatar' => $value->avatar
		);
		return $this->db->update(self::$myTable, $data, array('id' => $value->id)); 
	}
	public function findById($id){
		$query = $this->db->get_where(self::$myTable, array('id' => $id)); 
		return $query->result()[0];	
	}
	public function deleteById($id){
		$usr = $this->findById($id);
		$avt = $usr->avatar;
		$path = FCPATH.'public/uploads/avatar/'.$avt;
		unlink($path); 
		$this->db->delete(self::$myTable, array('id' => $id))[0];
		return true;	
	}
	public function checkEmailExits($email){
		$query = $this->db->get_where(self::$myTable, array('email' => $email));
		return $query->num_rows() > 0;
	}

	public function getList($page = 1, $qty = 10){
		$query = $this->db->get(self::$myTable, $qty, ($page-1)*$qty);
		return $query->result();
	}
	
	public function nextId(){
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'user'");
		$next = $next->row(0);
		return  $next->Auto_increment;
	}
}