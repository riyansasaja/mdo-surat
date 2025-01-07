<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DespositionModel;
use App\Models\EvidenceModel;
use App\Models\InmailAttachment;
use App\Models\InmailModel;
use App\Models\ModelDisposisi;
use App\Models\ModelEvidence;
use App\Models\ModelInmail;
use App\Models\ModelInmailAttachment;
use App\Models\ModelKodeSurat;
use App\Models\ModelRefPetunjuk;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class InmailController extends BaseController
{

    private $inmailModel;
    private $despositionModel;
    private $inmailAttachmentModel;
    private $userModel;

    private $evidenceModel;

    public function __construct()
    {
        $this->inmailModel = new ModelInmail();
        $this->despositionModel = new ModelDisposisi();
        $this->inmailAttachmentModel = new ModelInmailAttachment();
        $this->userModel = new UserModel();
        $this->evidenceModel = new ModelEvidence();
    }

    public function index()
    {
        //
        $data['inmaildespo'] = (object)$this->inmailModel->select('tb_inmail.*, tb_disposisi.for, tb_disposisi.to')
            ->where(['tb_disposisi.to' => user()->fullname])
            ->join('tb_disposisi', 'tb_inmail.id_inmail=tb_disposisi.id_inmail')
            ->findAll();

        return view('inmail/show', $data);
        // dd($data);

    }

    public function showDespoted()
    {
        //
        $data['inmaildespo'] = (object)$this->inmailModel->select('inmail.*, users.fullname, tb_disposition.disposition_form, tb_disposition.disposition_to, tb_disposition.disposition_log')
            ->where(['tb_disposition.disposition_form' => user()->id])
            ->join('tb_disposition', 'inmail.inmail_id=tb_disposition.inmail_id')
            ->join('users', 'tb_disposition.disposition_to=users.id')
            ->findAll();

        return view('inmail/showdespoted', $data);
    }

    public function getbyid($id_inmail)
    {

        //ambil model ref petunjuk
        $refpetunjukModel = new ModelRefPetunjuk();

        $data['mail'] = (object)$this->inmailModel->where('id_inmail', $id_inmail)->first();
        $data['mailAttachment'] = $this->inmailAttachmentModel->where('id_inmail', $id_inmail)->findAll();
        $data['alluser'] = $this->userModel->select('*')->join('tb_jabatan', 'users.jabatan = tb_jabatan.id_jabatan', 'left')
            ->findall();
        $data['refPetunjuk'] = (object) $refpetunjukModel->findAll();
        $data['dispositions'] = $this->despositionModel->getDesposisi($id_inmail);
        $data['evidence']= $this->evidenceModel->where('id_inmail', $id_inmail)->findAll();
        // dd($data['dispositions']);
        return view('inmail/detilmail', $data);
    }

    public function despoted()
    {

        //bikin rules
        if (!$this->validate([
            'disposition_to' => 'required'
        ])) {
            $validation = \Config\Services::validation();
            $errors = $validation->getErrors();
            foreach ($errors as $error) {
                # code...
                session()->setFlashdata('error', $error);
            }
            return redirect()->back();
        }

        //ambil Hasil Post
        $id_inmail = $this->request->getVar('inmail_id');
        $for = $this->request->getVar('disposition_form');
        $to = $this->request->getVar('disposition_to');
        $sifat = $this->request->getVar('sifat');
        $petunjuk = $this->request->getVar('petunjuk');
        $Petunjuk_in = ($petunjuk==null)? null: implode(",", $petunjuk);
        $catatan = $this->request->getVar('catatan');
        $deadline = $this->request->getVar('deadline');

        //ambil data desposisi untuk rubah  disposition_status
        $data_disposisi = $this->despositionModel->where(['id_inmail' => $id_inmail])->first();
        if ($data_disposisi == null) {
            $id_disposisi_parent = null;
        } else {
            $id_disposisi_parent = $data_disposisi['id_disposisi'];
        }

        //eksekusi jika data valid
        $inputdb = [
            'id_inmail' => $id_inmail,
            'id_disposisi_parent' => $id_disposisi_parent,
            'for' => $for,
            'to' => $to,
            'sifat' => $sifat,
            'petunjuk' => $Petunjuk_in,
            'catatan' => $catatan,
            'deadline' => $deadline,
            'disposition_log' => time()
        ];

        //insert db untuk tambah tb_disposition
        $insertdb = $this->despositionModel->insert($inputdb);

        if ($insertdb) {
            # code...
            session()->setFlashdata('success', 'Desposisi Berhasil');
            return redirect()->back();
        } else {
            # code...
            session()->setFlashdata('error', 'Error input database');
            return redirect()->back();
        }

    }

    public function addEviden() {

        //validasi rules
        if (!$this->validate([
            'fileEviden' => [
                'label' => 'File eviden',
                'rules' =>[
                    'uploaded[file-eviden]',
                    'ext_in[file-eviden,pdf,jpg,jpeg,png]',
                ],
                'errors' => [
                    'uploaded' => 'Pilih file eviden terlebih dahulu',
                    'ext_in' => 'File Harus PDF atau Gambar',
                ]
            ],
        ])){
            //jika tidak lulus validasi
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back();
        }
        //jika lulus validasi
        //ambil data inmail id
        $inmail_id = $this->request->getVar('inmail_id');

        //rename file
        //retrun
                //tapi perlu dipikirkan nanti seperti apa di database untuk inmail yang ditindak lanjut
        session()->setFlashdata('success', 'File Lolos Validasi, untuk Masuk database masih mo pikir dulu depe database pe Model deng relasi so pusing!!!!');
        return redirect()->back();

    } //end function



}
