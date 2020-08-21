<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$this->load->model('User_model');
		//$data_tb = $this->User_model->select_data('SELECT Username, EmailId, Mobile, profileImage, DOB, Address, city, state,Country, status FROM tbl_users  ORDER by id asc');
		$data_tb = $this->User_model->select_data('SELECT id,Username, Mobile, profileImage, status FROM tbl_users  ORDER by id asc');
		$load_data = array('data'=>json_encode($data_tb,true));
		$this->load->view('Header.html');
		$this->load->view('Dashboard.html',$load_data);
		$this->load->view('Footer.html');
	}
}
