<?php

class KegiatanController extends Controller
{

    public function index()
    {


        $data = [
            'data' => $this->model('client_kegiatan_model')->show(),
            'title' => 'TekkomInterns | Partnership'
        ];

        $this->view('client/master/header', $data['title']);
        $this->view('client/kegiatan/kegiatan', $data['data']);
        $this->view('client/master/footer');
    }
}
