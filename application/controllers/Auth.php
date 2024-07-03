<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['title'] = 'PT.DOA Login';
		$this->load->view('templates/auth_header',$data);
		$this->load->view('auth/login');
		$this->load->view('templates/auth_footer');
	}
	public function registration()
	{
		$data ['title'] = 	'PT.DOA Registration';
		$this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[pengguna.Nama_pengguna]',[
			'is_unique' => 'Nama Pengguna Telah Digunakan!!'
		]
		);
		$this->form_validation->set_rules('passwrod1', 'Password', 'required|trim|<min_length[8]|matches[password2]',[
			'matches' => 'Password tidak sama!',
			'min_length' => 'Password Minimal 8 Karakter'
		]);
		$this->form_validation->set_rules('passwrod2', 'Password', 'required|trim|<min_length[8]|matches[password1]');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data );
			$this->load->view('auth/registration',);
			$this->load->view('templates/auth_footer');
		} else {
			$data = [
				'Nama_Pengguna' =>	 $this->input->post('name'),	
				'Kata_Sandi' =>	password_hash($this->input->post('password'),PASSWORD_DEFAULT),	
				'Peran' => Klien,
			];
			$this->db->insert('pengguna',$data);
			$this->session->set_flashdata('massage','<div class="alert alert-success" role="alert">Akun Telah Dibuat. Silahkan Login 	</div>');
			redirect('auth');
		}
	}
}
