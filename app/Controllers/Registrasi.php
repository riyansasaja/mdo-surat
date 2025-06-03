<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DespositionModel;
use App\Models\InmailAttachment;
use App\Models\InmailModel;
use App\Models\ModelDisposisi;
use App\Models\ModelInmail;
use App\Models\ModelInmailAttachment;
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
    private $usersModel;

    public function __construct()
    {
        $this->inmailModel = new ModelInmail();
        $this->modelDisposisi = new ModelDisposisi();
        $this->year = session()->year;
        $this->usersModel = new UserModel();
    }

    public function suratMasuk()
    {
        $modelKode = new ModelKodeSurat();
        //ambil semua data
        $data['mails'] = $this->inmailModel->where('YEAR(inmail_log)', $this->year)->findAll();
        $data['suratKodes'] = $modelKode->findAll();
        #mengecek nomor agenda
        $lastMail = $this->inmailModel->orderBy('id_inmail', 'desc')->first();
        ($lastMail) ? $data['lastMail'] = $lastMail['nomor_agenda'] : $data['lastMail'] = 0;
        return view('home/regsm', $data);
    }

    public function detilSuratMasuk($id)
    {
        $modelKode = new ModelKodeSurat();
        //ambe data by id
        $inmailAttachment = new ModelInmailAttachment();
        //ambil data user
        $usermodal = new UserModel();

        $data['dispositions'] = $this->modelDisposisi->getDesposisi($id);

        $data['alluser'] = $usermodal->select('*')->join('tb_jabatan', 'users.jabatan = tb_jabatan.id_jabatan', 'left')->where('tb_jabatan.angker', 1)
            ->findall();
        $data['mail'] = (object)$this->inmailModel->where('id_inmail', $id)->first();
        $data['mailAttachment'] = $inmailAttachment->where('id_inmail', $id)->findAll();
        $data['suratKodes'] = $modelKode->findAll();

        // dd($data);
        return view('home/regsmdetil', $data);
    }

    public function addSM()
    {
        $rules = [
            'nomor_agenda'  =>  'required',
            'tgl_agenda'    =>  'required',
            'no_surat'      =>  'required',
            'tgl_surat'     =>  'required',
            'sifat_surat'   =>  'required',
            'jenis_surat'   =>  'required',
            'kode_surat'    => 'required',
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
            'nomor_agenda'  =>  'required',
            'tgl_agenda'    =>  'required',
            'no_surat'      =>  'required',
            'tgl_surat'     =>  'required',
            'sifat_surat'   =>  'required',
            'jenis_surat'   =>  'required',
            'kode_surat'    => 'required',
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
    public function deleteSuratMasuk($id_inmail)
    {
        //ambil data inmail attachment by inmail id
        //inisiasi inmail model
        $attachmentModel = new ModelInmailAttachment();
        $attachmentcheck = $attachmentModel->where('id_inmail', $id_inmail)->findAll();
        //apabila ada data
        if ($attachmentcheck) {
            //pemberitahuan "Harap menghapus lampiran surat terlebih dahulu"
            session()->setFlashdata('error', 'Harap Menghapus Lampiran Surat terlebih dahulu');
            return redirect()->back();
        } else {
            //jika tidak ada data jalankan proses hapus
            $this->inmailModel->where('id_inmail', $id_inmail)->delete();
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
        $data_inmail = $this->inmailModel->where('id_inmail', $inmail_id)->first();



        //jalankan upload

        //validate rule
        $validationRule = [
            'inmailAttachment' => [
                'label' => 'File',
                'rules' => [
                    'uploaded[inmailAttachment]',
                    'ext_in[inmailAttachment,pdf]',
                    //                     'mime_in[inmailAttachment,image/jpg,image/jpeg,image/gif,image/png,image/webp,application/pdf]',
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
                'id_inmail' => $inmail_id,
                'attachment_file' => $newName
            ];
            //masukkan ke db
            $attachmentModel = new ModelInmailAttachment();
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
        $attachmentModel = new ModelInmailAttachment();
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

        //harusnya di sini buat form validation
        $rules = [
            'id_user_despo' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Silahkan pilih tujuan surat diteruskan',
                    'numeric' => 'Silahkan Pilih Tujuan Surat Diteruskan'
                ]
            ],
            'inmail_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back();
        }

        //ambil data inputan
        $id_user_despo = $this->request->getPost('id_user_despo');
        $inmail_id = $this->request->getPost('inmail_id');


        //ambil nomor telpon berdasarkan id_user_despo
        $hp = $this->usersModel->getHp($id_user_despo);
        //simpan data
        $data = [
            'status_inmail' => 2,
            'id_user_despo' => $id_user_despo
        ];
        //edit database inmail  - status inmail = 2 id_user despo = $id_userdespo
        $this->inmailModel->update($inmail_id, $data);
        //add ke tb_status
        addStatus($inmail_id, 'Diteruskan Oleh Operator');
        //notif WA
        $tes = notifTerusan($hp->no_hp);
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
        //add ke tb_status
        addStatus($inmail_id, 'Operator Batal Teruskan Surat');
        //kembalikan ke regsm detil.
        session()->setFlashdata('success', 'Desposisi Berhasil Dibatalkan');
        return redirect()->to('regsm/regsmdetil' . '/' . $inmail_id);
    }
}
