<?php

class MahasiswaController extends Controller
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
            'sc' => [
                BASE_URL . 'assets/extensions/jquery/jquery.min.js',
                BASE_URL . 'assets/extensions/datatables.net/js/jquery.dataTables.min.js',
                BASE_URL . 'assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                BASE_URL . 'assets/extensions/sweetalert2/sweetalert2.min.js',
                BASE_URL . 'assets/main.js',
                // core script
                BASE_URL . 'assets/static/js/pages/mahasiswa.js'
            ],
            'css' => [
                BASE_URL . 'assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                BASE_URL . 'assets/compiled/css/table-datatable-jquery.css',
                BASE_URL . 'assets/extensions/sweetalert2/sweetalert2.min.css',
                BASE_URL . 'assets/compiled/css/extra-component-sweetalert.css',

            ]
        ];

        $this->view('admin/master/header', $data['css']);
        $this->view('admin/mahasiswa/mahasiswa');
        $this->view('admin/master/footer', $data);
    }

    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Method not allowed"]);
            exit;
        }

        $status = $this->model('users_model')->insert($_POST, $_FILES);
        echo $status;
    }

    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Method not allowed"]);
            exit;
        }
        $status = $this->model('users_model')->delete($_POST['id']);
        if (is_null($status)) {
            echo 'Berhasil Hapus Data';
        } else {
            echo 'Gagal Hapus Data';
        }
    }

    public function show()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Method not allowed"]);
            exit;
        }

        if (!isset($_GET["id"])) {
            echo json_encode(["error" => "Not Found"]);
            exit;
        }

        $status = $this->model('users_model')->getByID($_GET['id']);

        header('Content-Type: application/json');
        echo json_encode($status);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Method not allowed"]);
            exit;
        }
        $status = $this->model('users_model')->update($_POST, $_FILES);
        echo $status;
    }

    public function fetch()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Method not allowed"]);
            exit;
        }

        $data = $this->model('users_model')->show();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function user()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Method not allowed"]);
            exit;
        }

        if (!isset($_GET["username"])) {
            echo json_encode(["error" => "Not Found"]);
            exit;
        }

        $data = $this->model('users_model')->getUser($_GET["username"]);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
