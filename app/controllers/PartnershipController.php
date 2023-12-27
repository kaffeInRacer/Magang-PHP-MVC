<?php

class PartnershipController extends Controller
{

    public function index()
    {
        $datas = [
            'title' => 'TekkomInterns | Partnership',
            'sc' => [
                BASE_URL . 'assets/js/partnership.js'
            ],
        ];
        $this->view('client/master/header', $datas['title']);
        $this->view('client/partnership/partnership');
        $this->view('client/master/footer', $datas);
    }

    public function fetch($id = 1)
    {
        $page = $id;
        $itemsPerPage = 6;
        $partnershipModel = $this->model('partnership_model');

        $totalItems = $partnershipModel->countTotalItems();
        $totalPages = ceil($totalItems / $itemsPerPage);
        list($magangResults, $request) = $partnershipModel->fetch($page, $itemsPerPage);

        $data = [
            'total'         => $totalItems,
            'request'       => $request,
            'totalPages'    => $totalPages,
            'perPage'       => $itemsPerPage,
            'prev'          => max(1, $page - 1),
            'next'          => min($totalPages, $page + 1),
            'hasNextPage'   => $page < $totalPages,
            'magang'        => $magangResults,
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function search()
    {

        if (isset($_POST['search'])) {
            $data = $this->model('partnership_model')->search($_POST['search']);
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }

        echo json_encode(["error" => "Not Found"]);
        exit;
    }

    public function insert()
    {
        $data = [
            'user_id'   => $_SESSION['user']['id'],
            'type'      => 'partnership',
            'mitra_id'  => $_POST['id'],
        ];
        $res = $this->model('mahasiswa_internship_model')->insert($data);
        if ($res === 'Berhasil Tambah Data') {
            $res = 'Berhasil Mengikuti Magang !';
        }
        echo json_encode($res);
        exit;
    }
}
