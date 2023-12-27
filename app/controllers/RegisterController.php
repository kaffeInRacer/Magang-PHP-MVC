<?php

class RegisterController extends Controller
{
    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            header('location: ' . BASE_URL . 'dashboard');
            exit;
        }
    }

    public function index()
    {
        $this->view('client/register/register');
        $this->view('client/master/footer');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASE_URL . 'register');
            exit();
        }

        $insertResult = $this->model('client_users_model')->insert($_POST);

        if (is_array($insertResult) && $insertResult['status'] === false) {
            Flasher::setMessage($insertResult['msg'], 'danger');
            header('Location: ' . BASE_URL . 'register');
            exit();
        } elseif ($insertResult === false) {
            Flasher::setMessage('Gagal menyimpan data', 'danger');
            header('Location: ' . BASE_URL . 'register');
            exit();
        }

        header('Location: ' . BASE_URL . 'login');
        exit();
    }
}
