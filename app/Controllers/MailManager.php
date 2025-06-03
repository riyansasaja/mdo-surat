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
        $this->modelInmail->where('id_user_despo', user()->id);
        $this->modelInmail->select('tb_inmail.*, tb_evidence.attachment_log');
        $this->modelInmail->join('tb_evidence', 'tb_evidence.id_inmail = tb_inmail.id_inmail', 'left');
        $data['inmails'] = $this->modelInmail->orderBy('tb_inmail.id_inmail', 'desc')->findAll();
        return view('inmailmanage/show', $data);
    }
}
