<?php

class Home extends Controller {
    public function index()
    {
        $home_data = require_once '../app/config/home_data.php';
        $data['judul'] = 'Beranda ' . $home_data['brand']['name'] . ' Mentorship';
        $data['home'] = $home_data;
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
