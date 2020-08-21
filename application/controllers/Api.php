<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('Header.html');
		$this->load->view('Registration.html');
		$this->load->view('Footer.html');
	}
	
	public function add_user()
	{
		$this->load->model('User_model');
		$cnt_data_set = $_POST['data'];
		$tbl_name = $_POST['tbl_name'];
		$cnt_data = array();
		foreach(json_decode($cnt_data_set,true) as $k=>$v)
		{
			$cnt_data[$v['key']] = $v['value'];
		}
		foreach ($cnt_data as $key => $value) {
			if (empty($value)) {
				$msg = "Please Fill all the fields";
				$res = array('msg'=>$msg);
				return $res;
			}
		}
		
		if($tbl_name == '' || (count($_FILES) == 0))
		{
			$res = array('message'=>'invalid fields');
		}
		else{
			
			$filename = $_FILES['file']['name'];
			list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']); 
					$location = $_POST['directory'].$filename;
					$uploadOk = 1;
					$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
					$valid_extensions = array("jpg","jpeg","png");
					
						if( !in_array(strtolower($imageFileType),$valid_extensions) ) 
						{ 	
							$uploadOk = 0;
							$res = array('message'=>'Invalid file type extension');
						}
						else
						{
							$img_src = $_POST['directory'].$filename;
							$data_tb = $this->User_model->select_data('SELECT id FROM '.$tbl_name.'  ORDER by id desc limit 1');					
							$last_image_id = (count($data_tb)>0)?$data_tb[0]['id']+1:1; 
							$img_arr = [
							'profileImage' => $_POST['directory'].'profile_image_'.($last_image_id+1).'.jpg'
							];
							$postdata = array_merge($img_arr,$cnt_data);
							$ress = $this->User_model->insert_data($postdata,$tbl_name);
							if($ress != 'Success!')
							{
								$res = array('message'=>'Problem in insertion');
							}
							else
							{
								move_uploaded_file($_FILES['file']['tmp_name'],$_POST['directory'].'profile_image_'.($last_image_id+1).'.jpg');
								$res = array('message'=>'inserted sucessfully');
							}
						}
		} 
		return json_encode($cnt_data,true);
	}

	public function update_user()
	{
		$this->load->model('User_model');//print_r($_FILES); die;
		$cnt_data_set = $_POST['data'];
		$tbl_name = $_POST['tbl_name'];
		$cnt_data = array();
		foreach(json_decode($cnt_data_set,true) as $k=>$v)
		{
			$cnt_data[$v['key']] = $v['value'];
		}
		foreach ($cnt_data as $key => $value) {
			if (empty($value)) {
				$msg = "Please Fill all the fields";
				$res = array('message'=>$msg);
				return $res;
			}
		}
		
		if($tbl_name == '' || (count($_FILES) == 0))
		{
			$res = array('message'=>'invalid fields');
		}
		else{
			
			$filename = $_FILES['file']['name'];
			list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']); 
					$location = $_POST['directory'].$filename;
					$uploadOk = 1;
					$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
					$valid_extensions = array("jpg","jpeg","png");
					
						if( !in_array(strtolower($imageFileType),$valid_extensions) ) 
						{ 	
							$uploadOk = 0;
							$res = array('message'=>'Invalid file type extension');
						}
						else
						{
							$img_src = $_POST['directory'].$filename;
							//$data_tb = $this->User_model->select_data('SELECT id FROM '.$tbl_name.'  ORDER by id desc limit 1');					
							$last_image_id = $_POST['id']; 
							$img_arr = [
							'profileImage' => $_POST['directory'].'profile_image_'.($last_image_id).'.jpg'
							];
							$postdata = array_merge($img_arr,$cnt_data);
							$ress = $this->User_model->update_data($postdata,$tbl_name,$last_image_id);
							if($ress != 'Success!')
							{
								$res = array('message'=>'Problem in insertion');
							}
							else
							{
								move_uploaded_file($_FILES['file']['tmp_name'],$_POST['directory'].'profile_image_'.($last_image_id).'.jpg');
								$res = array('message'=>'inserted sucessfully');
							}
						}
		} 
		return $res;
	}
	
	public function actions()
	{
		$this->load->model('User_model');
		$arr_data = $_POST;
		$act = ($arr_data['action'])?$arr_data['action']:'NoAction';
		switch($act)
		{			
			case 'view':
				$tbl_name = ($arr_data['tbl'])?$arr_data['tbl']:'tbl_users';
				$id = ($arr_data['id'])?$arr_data['id']:1;
				$res = $this->User_model->select_data('SELECT id, Username, EmailId, Mobile, profileImage, DOB, Address, city, state,Country, status FROM '.$tbl_name.' where id = "'.$id.'"  ORDER by id desc limit 1');
				break;
				
			case 'edit':
				$tbl_name = ($arr_data['tbl'])?$arr_data['tbl']:'tbl_users';
				$id = ($arr_data['id'])?$arr_data['id']:1;
				$res = $this->User_model->select_data('SELECT id, Username, EmailId, Mobile, profileImage, DOB, Address, city, state,Country, status FROM '.$tbl_name.' where id = "'.$id.'"  ORDER by id desc limit 1');
				break;
				
			case 'delete':
				$tbl_name = ($arr_data['tbl'])?$arr_data['tbl']:'tbl_users';
				$id = ($arr_data['id'])?$arr_data['id']:1;
				$res = $this->User_model->delete_data($tbl_name,$id);
				break;
				
			case 'NoAction':
				$res = "no";
				break;
		}
		echo json_encode($res);
		return;
//		$data_tb = $this->User_model->select_data('SELECT id FROM '.$tbl_name.'  ORDER by id desc limit 1');
	}
}
