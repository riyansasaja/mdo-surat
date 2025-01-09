<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SuratKeluar extends BaseController
{
    public function index()
    {
        //
        return view('outmail/show');
    }
}
