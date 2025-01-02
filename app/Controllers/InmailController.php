<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DespositionModel;
use App\Models\EvidenceModel;
use App\Models\InmailAttachment;
use App\Models\InmailModel;
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
        $this->inmailModel = new InmailModel();
        $this->despositionModel = new DespositionModel();
        $this->inmailAttachmentModel = new InmailAttachment();
        $this->userModel = new UserModel();
        $this->evidenceModel = new EvidenceModel();
    }

    public function index()
    {
        //
        $data['inmaildespo'] = (object)$this->inmailModel->select('inmail.*, tb_disposition.disposition_form, tb_disposition.disposition_to')
            ->where(['tb_disposition.disposition_to' => user()->id, 'tb_disposition.disposition_status' => 1])
            ->join('tb_disposition', 'inmail.inmail_id=tb_disposition.inmail_id')
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

    public function getbyid($id)
    {
        //ambil model ref petunjuk
        $refpetunjukModel = new ModelRefPetunjuk();

        $data['mail'] = (object)$this->inmailModel->where('inmail_id', $id)->first();
        $data['mailAttachment'] = $this->inmailAttachmentModel->where('inmail_id', $id)->findAll();
        $data['alluser'] = $this->userModel->select('*')->join('tb_jabatan', 'users.jabatan = tb_jabatan.id_jabatan', 'left')
            ->findall();
        $data['refPetunjuk'] = (object) $refpetunjukModel->findAll();
        $data['dispositions'] = $this->despositionModel->getDesposition($id);
        $data['evidence']= $this->evidenceModel->where('inmail_id', $id)->findAll();
        // dd($data['dispositions']);
        return view('inmail/detilmail', $data);
    }

    public function despoted()
    {

        //bikin rules
        if (!$this->validate([
            'sifat' =>  'required',
            'disposition_to' => 'required',
            'petunjuk' => 'required',
            'catatan' => 'required'
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
        $inmail_id = $this->request->getVar('inmail_id');
        $disposition_form = $this->request->getVar('disposition_form');
        $disposition_to = $this->request->getVar('disposition_to');
        $sifat = $this->request->getVar('sifat');
        $petunjuk = $this->request->getVar('petunjuk');
        $Petunjuk_in = implode(",", $petunjuk);
        $catatan = $this->request->getVar('catatan');


        //ambil data desposisi untuk rubah  disposition_status
        $id_disposition = $this->despositionModel->where(['inmail_id' => $inmail_id, 'disposition_to' => user()->id])->first();

        //eksekusi jika data valid
        $inputdb = [
            'inmail_id' => $inmail_id,
            'disposition_form' => $disposition_form,
            'disposition_to' => $disposition_to,
            'sifat' => $sifat,
            'petunjuk' => $Petunjuk_in,
            'catatan' => $catatan,
            'disposition_status' => 1,
            'disposition_log' => time()

        ];
        $dataedit = [
            'disposition_status' => 2,
        ];
        //edit dbe rubah desposition_status dari 1 menjadi 2
        $this->despositionModel->update($id_disposition['disposition_id'], $dataedit);
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

        //return

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
