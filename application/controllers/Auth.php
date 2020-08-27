<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("Karyawan_m");
        // login();
    }

    public function index()
    {
        login();
        $data = array(
            "title" => "Login",
            "page" => "auth/login"
        );
        $this->load->view('template/mainLogin', $data);
    }

    public function login()
    {

        $username = $this->input->post('userName');
        $password = $this->input->post('password');

        $user = $this->Karyawan_m->getUser($username);
        //jika user ada
        if ($user) {
            //jika user aktif
            if ($user['is_active'] == 1) {
                //cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'user_name' => $user['user_name'],
                        'level' => $user['level'],
                        'karyawan_id' => $user['id_karyawan'],
                        'nama' => $user['nama_karyawan']
                    ];
                    $this->session->set_userdata($data);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Kata sandi salah!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Karyawan Tidak Aktif!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Karyawan Tidak Terdaftar!</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('level');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Anda telah keluar dari akun!</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/error404');
    }
}
