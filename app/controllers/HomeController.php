<?php

class HomeController extends Controller
{

    public function index()
    {
        $this->view('client/home/home');
        $this->view('client/master/footer');
    }
}
