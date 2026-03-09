<?php

class Home extends Controller {
    public function index()
    {
        $data['judul'] = 'Beranda PWL Mentorship';
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
