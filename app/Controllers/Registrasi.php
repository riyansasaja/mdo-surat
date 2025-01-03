<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DespositionModel;
use App\Models\InmailAttachment;
use App\Models\InmailModel;
use App\Models\ModelDisposisi;
use App\Models\ModelInmail;
use App\Models\ModelKodeSurat;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpParser\Node\Stmt\Echo_;

class Registrasi extends BaseController
{
    //deklarasi model untuk dipakai di semua method
    private $inmailModel;
    private $modelDisposisi;
    private $year;

    public function __construct()
    {
        $this->inmailModel = new ModelInmail();
        $this->modelDisposisi = new ModelDisposisi();
        $this->year = session()->year;
    }

    public function suratMasuk()
    {
        $modelKode = new ModelKodeSurat();
        //ambil semua data
        $data['mails'] = $this->inmailModel->where('YEAR(inmail_log)', $this->year)->findAll();
        $data['suratKodes'] = $modelKode->findAll();
        #mengecek nomor agenda
        $lastMail = $this->inmailModel->first();
        $data['lastMail'] = $lastMail['nomor_agenda'];
        return view('home/regsm', $data);
    }

    public function detilSuratMasuk($id)
    {
        $modelKode = new ModelKodeSurat();
        //ambe data by id
        $inmailAttachment = new InmailAttachment();
        //ambil data user
        $usermodal = new UserModel();

        $data['dispositions'] = $this->modelDisposisi->getDesposition($id);

        $data['alluser'] = $usermodal->select('*')->join('tb_jabatan', 'users.jabatan = tb_jabatan.id_jabatan', 'left')->where('angker', 1)
            ->findall();

        // $data['alluser'] = $usermodal->where('angker', 1)->findAll();
        $data['mail'] = (object)$this->inmailModel->where('inmail_id', $id)->first();
        $data['mailAttachment'] = $inmailAttachment->where('inmail_id', $id)->findAll();
        $data['suratKodes'] = $modelKode->findAll();

        // dd($data);
        return view('home/regsmdetil', $data);
    }

    public function addSM()
    {
        $rules = [
            'username'    =>  'required',
            'sifat_surat'   =>  'required',
            'jenis_surat'   =>  'required',
            'kode_surat'    => 'required',
            'nomor_agenda'  =>  'required',
            'tgl_agenda'    =>  'required',
            'no_surat'      =>  'required',
            'tgl_surat'     =>  'required',
            'asal_surat'    =>  'required',
            'perihal'       =>  'required',
            'isi_surat'     =>  'required',
            'status_inmail' =>  'required',
        ];

        $data = $this->request->getPost(array_keys($rules));


        if (! $this->validateData($data, $rules)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back();
        }
        $this->inmailModel->insert($this->validator->getValidated());
        session()->setFlashdata('success', 'Registrasi surat masuk berhasil diinput');
        return redirect()->to('/regsm');
        // dd($this->validator->getValidated());
    }

    //edit surat masuk
    public function editSuratMasuk()
    {

        //ambil data inputan
        $rules = [
            'username'    =>  'required',
            'sifat_surat'   =>  'required',
            'jenis_surat'   =>  'required',
            'kode_surat'    => 'required',
            'nomor_agenda'  =>  'required',
            'tgl_agenda'    =>  'required',
            'no_surat'      =>  'required',
            'tgl_surat'     =>  'required',
            'asal_surat'    =>  'required',
            'perihal'       =>  'required',
            'isi_surat'     =>  'required',
            'status_inmail' =>  'required',
        ];

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back();
        }
        //ambil inmailid
        $inmail_id = $this->request->getPost('inmail_id');
        //update data
        $this->inmailModel->update($inmail_id, $this->validator->getValidated());
        //beri pemberitahuan sukses update
        session()->setFlashdata('success', 'Surat masuk berhasil di Update');
        //kembalikan ke tampilan detil
        return redirect()->to('regsm/regsmdetil/' . $inmail_id);
    }

    //deleteSurat Masuk
    public function deleteSuratMasuk($id)
    {
        //ambil data inmail attachment by inmail id
        //inisiasi inmail model
        $attachmentModel = new InmailAttachment();
        $attachmentcheck = $attachmentModel->where('inmail_id', $id)->findAll();
        //apabila ada data
        if ($attachmentcheck) {
            //pemberitahuan "Harap menghapus lampiran surat terlebih dahulu"
            session()->setFlashdata('error', 'Harap Menghapus Lampiran Surat terlebih dahulu');
            return redirect()->back();
        } else {
            //jika tidak ada data jalankan proses hapus
            $this->inmailModel->where('inmail_id', $id)->delete();
            //beri pemberitahuan berhasil delete
            session()->setFlashdata('success', 'Surat masuk berhasil dihapus');
            //kembalikan ke tampilan regsm
            return redirect()->to('regsm');
        }
    }

    public function addinmailAttachment()
    {
        $inmail_id = $this->request->getPost('inmail_id');
        $files = $this->request->getFile('inmailAttachment');

        //ambil data di inmail
        $data_inmail = $this->inmailModel->where('inmail_id', $inmail_id)->first();



        //jalankan upload

        //validate rule
        $validationRule = [
            'inmailAttachment' => [
                'label' => 'File',
                'rules' => [
                    'uploaded[inmailAttachment]',
                    'ext_in[inmailAttachment,pdf]',
                    // 'mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    // 'max_size[inmailAttachmet, 2048]',
                    // 'max_dims[userfile,1024,768]',
                ],
            ],
        ];

        if (!$this->validateData([], $validationRule)) {
            $data = ['errors' => $this->validator->getErrors()];
            session()->setFlashdata('error', $data);
            return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
        }
        //ganti nomor surat "/" ke "-"
        $new_no_surat = str_replace('/', '-', $data_inmail['no_surat']);
        // hapus string "."
        $new_no_surat1 = str_replace('.', '', $new_no_surat);
        // rubah nama file
        $newName = date('Ymd_his') . '_' . $new_no_surat1 .   '.' . $files->getClientExtension();
        // Pindahke folder inmailAttach, dengan nama yang baru $newName
        $files->move('uploads/inmailAttach/' . session()->year . '/' . $data_inmail['kode_surat'] . '/', $newName);

        if ($files->hasMoved()) {
            # ambil data 
            $datadb = [
                'inmail_id' => $inmail_id,
                'attachment_file' => $newName
            ];
            //masukkan ke db
            $attachmentModel = new InmailAttachment();
            $insertdb = $attachmentModel->insert($datadb);
            if (!$insertdb) {
                # kembalikan info gagal
                $data = ['uploaded_fileinfo' => 'Gagal Input Database'];
                session()->setFlashdata('error', $data);
                return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
            }
            $data = ['uploaded_fileinfo' => 'Lampiran Berhasil di Upload'];
            session()->setFlashdata('success', $data);
            return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
        }

        //jika file gagal dipindahkan
        $data = ['errors' => 'The file has already been moved.'];
        session()->setFlashdata('error', $data);
        return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
    }

    public function delinmailAttachment($kode, $name, $inmail_id)
    {
        $attachmentModel = new InmailAttachment();
        $file = new \CodeIgniter\Files\File('uploads/inmailAttach/' . session()->year . '/' .  $kode . '/' . $name);
        $delete = $attachmentModel->where('attachment_file', $name)->delete();
        if ($delete) {
            # code...
            $file->move('uploads/delete/');
        }
        session()->setFlashdata('success', 'Data Berhasil dihapus');
        return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
    }

    public function despoted()
    {

        //ambil data
        $id_user_despo = $this->request->getPost('id_user_despo');
        $inmail_id = $this->request->getPost('inmail_id');
        $data = [
            'status_inmail' => 2,
            'id_user_despo' => $id_user_despo
        ];

        //edit database inmail  - status inmail = 2 id_user despo = $id_userdespo
        $this->inmailModel->update($inmail_id, $data);

        //add data to database tb disposition
        $toaddTbDesposition = [
            'inmail_id' => $inmail_id,
            'disposition_form' => user()->id,
            'disposition_to' => $id_user_despo,
            'petunjuk' => null,
            'catatan' => 'Dari Admin',
            'disposition_status' => 1,
            'disposition_log' => time()
        ];

        // dd($toaddTbDesposition);
        //masukkan ke dalam database
        $this->modelDisposisi->insert($toaddTbDesposition, false);
        //buat session untuk pemberitahun Sukses
        session()->setFlashdata('success', 'Surat Berhasil Diteruskan');
        //kembalikan ke view
        return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
    }

    public function redespoted($inmail_id)
    {
        $data = [
            'status_inmail' => 1,
            'id_user_despo' => null
        ];
        $this->inmailModel->update($inmail_id, $data);

        //delete database tb disposition
        $this->modelDisposisi->where('inmail_id', $inmail_id)->delete();
        session()->setFlashdata('success', 'Desposisi Berhasil Dibatalkan');
        return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
    }
}
