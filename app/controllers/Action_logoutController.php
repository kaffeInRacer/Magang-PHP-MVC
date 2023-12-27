<?php

class Action_logoutController extends Controller
{

    public function __construct()
    {
        session_start();
        session_destroy();
        header('location: ' . BASE_URL . 'login');
    }
}
