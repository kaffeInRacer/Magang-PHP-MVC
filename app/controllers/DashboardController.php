<?php

class DashboardController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
    }

    public function index()
    {
        $title = 'TekkomInterns | Dashboard';
        $this->view('client/master/header', $title);
        $this->view('client/dashboard/dashboard');
        $this->view('client/master/footer');
    }
}
