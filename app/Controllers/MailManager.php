<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelInmail;
use CodeIgniter\HTTP\ResponseInterface;

class MailManager extends BaseController
{
    private $modelInmail;

    public function __construct()
    {
        $this->modelInmail = new ModelInmail();
    }

    public function index()
    {
        //get all mail where status =2 and id_user_despo = userid
        $this->modelInmail->where('status_inmail', 2);
        $this->modelInmail->where('id_user_despo', user()->id);
        $data['inmails'] = $this->modelInmail->findAll();
        return view('inmailmanage/show', $data);
    }
}
