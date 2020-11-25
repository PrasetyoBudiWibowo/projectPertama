<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Home | Arkademy'
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'judul' => 'About Me'
        ];
        return view('pages/about', $data);
    }

    //--------------------------------------------------------------------

}
