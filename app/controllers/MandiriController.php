<?php

class MandiriController extends Controller
{

    public function index()
    {
        $title = 'TekkomInterns | Mandiri';
        $this->view('client/master/header', $title);
        $this->view('client/mandiri/mandiri');
        $this->view('client/master/footer');
    }

    public function insert()
    {
        if (!isset($_POST['mitra'])) {
            header('Location: ' . BASE_URL . 'mandiri');
            exit();
        }
        $datas = [
            'mitra' => $_POST['mitra'],
            'job' => $_POST['posisi'],
            'pic' => $_POST['pic'],
            'number_pic' => $_POST['kontak'],
            'user_id' => $_SESSION['user']['id']
        ];

        $this->model('mandiri_model')->insert($datas);
        header('Location: ' . BASE_URL . 'mandiri/success_mandiri');
        exit();
    }

    public function success_mandiri()
    {
        $this->view('client/mandiri/success');
    }
}
