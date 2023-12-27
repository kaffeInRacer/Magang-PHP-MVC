<?php

class DashboardController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        }
    }
    public function index()
    {
        $data = [
            'count' => $this->model('dashboard_model')->dashboard(),
            'sc' => [
                BASE_URL . 'assets/extensions/apexcharts/apexcharts.min.js',
                BASE_URL . 'assets/static/js/pages/dashboard.js',
            ]
        ];
        $this->view('admin/master/header');
        $this->view('admin/dashboard', $data['count']);
        $this->view('admin/master/footer', $data);
    }
}
