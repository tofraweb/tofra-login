<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->view('login_view');
	}

    public function welcome()
    {
        $this->load->view('welcome_message');
    }
/*
    public function processLogin()
    {
        $this->form_validation->set_rules('username','Username', 'min_length[4]|max_length[8]|required');
        $this->form_validation->set_rules('password','Password', 'min_length[4]|max_length[8]|required');

        if($this->form_validation->run() == FALSE){
            $val_errors = array(
                'errors' => validation_errors()
            );
            $this->session->set_flashdata($val_errors);
            redirect('Login');
        }else{
            $user = $this->input->post('username');
            $password = $this->input->post('password');

            $check_user = $this->Login_model->login_info($user,$password);
            if($check_user){
                redirect('Welcome');
            }else{
                redirect('Login');
            }

        }
    }*/

}
