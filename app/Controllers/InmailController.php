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
            ->where(['tb_disposisi.to' => user()->fullname, 'tb_inmail.status_inmail' => 2])
            ->join('tb_disposisi', 'tb_inmail.id_inmail=tb_disposisi.id_inmail')
            ->orderBy('tb_inmail.id_inmail', 'desc')
            ->findAll();

        return view('inmail/show', $data);
        // dd($data);

    }

    public function showDespoted()
    {
        //
        //        $data['inmaildespo'] = (object)$this->inmailModel->select('inmail.*, users.fullname, tb_disposition.disposition_form, tb_disposition.disposition_to, tb_disposition.disposition_log')
        //            ->where(['tb_disposition.disposition_form' => user()->id])
        //            ->join('tb_disposition', 'inmail.inmail_id=tb_disposition.inmail_id')
        //            ->join('users', 'tb_disposition.disposition_to=users.id')
        //            ->findAll();

        $data['inmaildespo'] = (object)$this->inmailModel->select('tb_inmail.*, tb_disposisi.for, tb_disposisi.to')
            ->where(['tb_disposisi.to' => user()->fullname, 'tb_inmail.status_inmail' => 4])
            ->join('tb_disposisi', 'tb_inmail.id_inmail=tb_disposisi.id_inmail')
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
        $data['evidence'] = $this->evidenceModel->where('id_inmail', $id_inmail)->findAll();
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
        $Petunjuk_in = ($petunjuk == null) ? null : implode(",", $petunjuk);
        $catatan = $this->request->getVar('catatan');
        $deadline = $this->request->getVar('deadline');

        //validasi apakah user for sudah pernah disposisi
        //ambil data disposisi dengan id_inmail dan from
        $validasi_disposisi = $this->despositionModel->where(['id_inmail' => $id_inmail, 'for' => $for])->first();
        // dd($validasi_disposisi['to']);
        if ($validasi_disposisi) {
            # pemberitahuan kalau sudah pernah disposisi dalam bentuk return
            session()->setFlashdata('error', 'Mohon maaf, surat ini sudah disposisi kepada ' . $validasi_disposisi['to']);
            return redirect()->back();
        }

        //ambil data desposisi untuk rubah  disposition_status pada 'id_disposisi_parent'
        $data_disposisi = $this->despositionModel->where(['id_inmail' => $id_inmail])->first();
        if ($data_disposisi == null) {
            $id_disposisi_parent = null;
        } else {
            $id_disposisi_parent = $data_disposisi['id_disposisi'];
        }

        //ambil data nomorsurat by id_inmail
        $no_surat = $this->inmailModel->getNomorSurat($id_inmail);
        //ambil nomor Telpon
        $nohp = $this->userModel->getHp($to);
        //ambil fullname
        $to_fullname = $this->userModel->getFullname($to);

        //eksekusi jika data valid
        $inputdb = [
            'id_inmail' => $id_inmail,
            'id_disposisi_parent' => $id_disposisi_parent,
            'for' => $for,
            'to' => $to_fullname,
            'sifat' => $sifat,
            'petunjuk' => $Petunjuk_in,
            'catatan' => $catatan,
            'deadline' => $deadline,
            'disposition_log' => time()
        ];

        //insert db untuk tambah tb_disposition
        $insertdb = $this->despositionModel->insert($inputdb);

        //jika sukses insert db
        if ($insertdb) {
            # code...
            //add ke tb Status
            addStatus($id_inmail, 'Disposisi ke ' . $to_fullname);
            //notifikasi WA
            notifdisposisi($nohp->no_hp, $no_surat);
            session()->setFlashdata('success', 'Desposisi Berhasil');
            return redirect()->back();
        } else {
            # code...
            session()->setFlashdata('error', 'Error input database');
            return redirect()->back();
        }
    }

    public function addEviden()
    {

        $files = $this->request->getFile('file-eviden');
        //validasi rules
        if (!$this->validate([
            'fileEviden' => [
                'label' => 'File eviden',
                'rules' => [
                    'uploaded[file-eviden]',
                    'ext_in[file-eviden,pdf,jpg,jpeg,png]',
                ],
                'errors' => [
                    'uploaded' => 'Pilih file eviden terlebih dahulu',
                    'ext_in' => 'File Harus PDF atau Gambar',
                ]
            ],
        ])) {
            //jika tidak lulus validasi
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back();
        }
        //########jika lulus validasi
        //ambil data inmail id
        $inmail = $this->inmailModel->where('id_inmail', $this->request->getVar('inmail_id'))->first();;
        $nomor_surat = $inmail['no_surat'];
        //rename file
        $new_no_surat = str_replace('/', '-', $nomor_surat);
        $new_no_surat1 = str_replace('.', '', $new_no_surat);
        $newName = date('Ymd_his') . '_' . $new_no_surat1 .   '.' . $files->getClientExtension();
        //pindahkan file ke folder upload/inmailAttach/tahun/evidence
        $files->move('uploads/inmailAttach/' . session()->year . '/' . 'evidence' . '/', $newName);

        //masukkan data dalam database
        $datadb = [
            'id_inmail' => $this->request->getVar('inmail_id'),
            'user'   => user()->fullname,
            'nama_file' => $newName,
            'komentar' => $this->request->getVar('komentar-eviden'),
        ];

        $updateinmail = [
            'status_inmail' => 4,
            'id_user_tl' => user()->id
        ];
        $this->inmailModel->update($this->request->getVar('inmail_id'), $updateinmail);
        $this->evidenceModel->insert($datadb);
        addStatus($this->request->getVar('inmail_id'), 'Tindak Lanjut oleh ' . user()->fullname);
        //return
        session()->setFlashdata('success', 'Data Evidence Berhasil di Upload');
        return redirect()->back();
    } //end function

    //delete evidence
    public function delEvidence($idInmail)
    {
        $delete = $this->evidenceModel->where('id_inmail', $idInmail)->delete();
        $updateinmail = [
            'status_inmail' => 2,
            'id_user_tl' => null
        ];
        $this->inmailModel->update($idInmail, $updateinmail);
        if ($delete) {
            # code...
            session()->setFlashdata('success', 'Data Evidence berhasil dihapus');
            return redirect()->back();
        } else {
            # code...
            session()->setFlashdata('error', 'Data Evidence gagal dihapus! hubungi Admin');
            return redirect()->back();
        }
    }



    public function delDispo($id_disposisi)
    {
        //ambe data login
        $auth = service('authentication');
        $currentuser =  $auth->user()->fullname;
        // cek dulu apakah from dari yg bersangkutan
        $datadispo = $this->despositionModel->where('id_disposisi', $id_disposisi)->first();
        if ($datadispo['for'] == $currentuser) {
            # code...

            $delete = $this->despositionModel->delete($id_disposisi);
            if ($delete) {
                # code...
                session()->setFlashdata('success', 'Data disposisi berhasil dihapus');
                return redirect()->back();
            } else {
                # code...
                session()->setFlashdata('error', 'Data disposisi gagal dihapus! hubungi Admin');
                return redirect()->back();
            }
        } else {

            session()->setFlashdata('error', 'Maaf hanya bisa menghapus yang anda disposisi!');
            return redirect()->back();
        }


        //delete eviden




    }
}
