<?php

class LoginController extends Controller
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
        $this->view('client/login/login');
        $this->view('client/master/footer');
    }

    public function action_login()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $loginResult = $this->model('client_users_model')->login($email, $password);

        if ($loginResult['status'] === true) {
            $_SESSION['user'] = $loginResult['user'];
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        } else {
            Flasher::setMessage($loginResult['msg'], 'danger');
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
    }
}
