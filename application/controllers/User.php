<?php
class User extends CI_Controller{
    public function register(){
        //validation
        $this->form_validation->set_rules('username', 'Username',   'required|callback_check_username_exists');
        $this->form_validation->set_rules('email', 'Email',         'required|callback_check_email_exists');
        $this->form_validation->set_rules('username', 'Username',   'required|callback_check_username_exists');
        $this->form_validation->set_rules('password2', 'Password2', 'required|matches[password]');
        $data["title"] = "Register";

        //check if validation correct
        if($this->form_validation->run()===FALSE){
            $this->load->view("templates/header");
            $this->load->view("user/register", $data);
            $this->load->view("templates/footer");
        }else{
            $enc_password = md5($this->input->post("password"));
            $this->user_model->register($enc_password);
            $this->session->set_flashdata('user_registered', 'Registration accomplished, can be login');
            redirect("home");
        }
    }
    public function check_username_exists($username){
        $this->form_validation->set_message('check_username_exists', 'That username is already occupied, take another one!');
        if($this->user_model->check_username_exists($username)){
            return TRUE;
        }else{return FALSE;}
    }
    public function check_email_exists($email){
        $this->form_validation->set_message('check_email_exists', 'That email is already occupied, take another one!');
        if($this->user_model->check_email_exists($email)){
            return TRUE;
        }else{return FALSE;}
    }
    

    public function login(){
        $data['title'] = 'Login';
        $this->form_validation->set_rules('username', 'Username',   'required');
        $this->form_validation->set_rules('username', 'Username',   'required');

        if($this->form_validation->run()===FALSE){
        $this->load->view("templates/header");
        $this->load->view("user/login", $data);
        $this->load->view("templates/footer");  
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user_id = $this->user_model->login($username, $password);

            if($user_id){
                $user_data = array(
                    'user_id' => $user_id,
                    'username' => $username,
                    'logged_in' => true
                );
                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('user_loggedin', 'You are now logged in');
                redirect('home');
            } else {
                $this->session->set_flashdata('login_failed', 'Login is invalid');
                redirect('about');
            }		
        }
        
        
    }


    // public function logout(){
    //     $this->session->unset_userdata('logged_in');
    //     $this->session->unset_userdata('user_id');
    //     $this->session->unset_userdata('username');
    //     $this->session->set_flashdata('user_loggedout', 'You are now logged out');
    //     redirect('user/register');
    // }
}   
