<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelJabatan;
use App\Models\ModelKodeSurat;
use CodeIgniter\HTTP\ResponseInterface;

class Manajemen extends BaseController
{

    private $kodesuratModel;
    private $jabatanModel;

    public function __construct()
{
    $this->kodesuratModel = new ModelKodeSurat();
    $this->jabatanModel = new ModelJabatan();
}

    public function kodesurat()
    {
        //
        $data['kodesurat'] = $this->kodesuratModel->findAll();

        return view('manajemen/kodesurat', $data);

    }

    public function addKodesurat()
    {
        //buat rules
        $rules = [
            'kodesurat' => ['label' => 'Kode Surat', 'rules' => 'required'],
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }
        $this->kodesuratModel->insert([
            'kode' => $this->request->getVar('kodesurat'),
        ]);
        session()->setFlashdata('success', 'Kode Surat Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function deleteKodesurat($id)
    {
        $this->kodesuratModel->delete($id);
        session()->setFlashdata('success', 'Kode Surat Berhasil Dihapus');
        return redirect()->back();
    }

    public function showjabatan()
    {
        $data['jabatans'] = $this->jabatanModel->findAll();
        return view('manajemen/jabatan', $data);
    }
    public function addJabatan()
    {
        $rules = [
            'nama_jabatan' => ['label' => 'Nama Jabatan', 'rules' => 'required'],
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }
        $this->jabatanModel->insert([
            'nama_jabatan' => $this->request->getVar('nama_jabatan'),
        ]);
        session()->setFlashdata('success', 'Jabatan Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function deleteJabatan($id)
    {
        $this->jabatanModel->delete($id);
        session()->setFlashdata('success', 'Jabatan Berhasil Dihapus');
        return redirect()->back();
    }


}
