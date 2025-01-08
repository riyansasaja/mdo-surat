<?php

namespace App\Controllers;

use App\Entities\User;
use App\Models\ModelJabatan;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Models\GroupModel;
use PharIo\Version\GreaterThanOrEqualToVersionConstraint;
use Myth\Auth\Password;

class Home extends BaseController
{


    protected $usermodel;

    protected $auth;

    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var Session
     */
    protected $session;

    public function __construct()
    {
        $this->usermodel = new UserModel();
        $this->config = config('Auth');
        $this->auth   = service('authentication');

    }


    public function index()
    {
        if (user()->jabatan == null) {
            return redirect()->to('/profile');
        }
        return view('home/dashboard');
    }

    public function profile(): string
    {
        //ambil auth
        $authorize = $auth = service('authorization');
        $modelJabatan = new ModelJabatan();
        $groupModel = new GroupModel();
       $data['jabatan'] = $modelJabatan->findAll();
        $data['groups'] = $authorize->groups();
        $data['getroles'] = $groupModel->getGroupsForUser(user()->id);
        return view('home/profile', $data);
    }


    public function usersManajemen()
    {

        $usermodel = new UserModel();
        $modaljabatan = new ModelJabatan();

        $data['allusers'] = $usermodel->select('users.id, users.username, users.fullname, tb_jabatan.nama_jabatan')->join('tb_jabatan', 'users.jabatan =  tb_jabatan.id_jabatan','left')->findAll();
        $data['jabatan'] = $modaljabatan->findAll();
        return view('home/users', $data);
    }

    public function userDetil($id)
    {

        $groupModel = new GroupModel();

        //ambil auth
        $authorize = $auth = service('authorization');
        //ambil semua data jabatan
        $modeljabatan = new ModelJabatan(); //inisaasi model jabatan
        $data['jabatan'] = $modeljabatan->findAll();
        // ambil seluruh data user join tb_jabatan;
        $data['user'] = $this->usermodel->select('*')->join('tb_jabatan', 'users.jabatan = tb_jabatan.id_jabatan', 'left')->where('users.id', $id)
            ->first();
        //kirim data  all Groups ke view
        $data['groups'] = $authorize->groups();
        $data['getroles'] = $groupModel->getGroupsForUser($data['user']->id);
        return view('home/userdetil', $data);
    }

    public function addUser()
    {
        //ambil model user
        $users = model(UserModel::class);
        //tentukan rules
        $rules = [
            'email'    => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'fullname'     => 'required',
            'nip'          => 'required',
            'jabatan'      => 'required',
            'no_hp'        => 'required'
        ];

        //cek validasi
        if (! $this->validate($rules)) {
            //kirim kembali dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        //validasi untuk password
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];
        //jika tidak lulus validasi
        if (! $this->validate($rules)) {
            //kirim kembali error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        //simpan dengan Object baru sesuai aturan mythauth
        $user              = new User($this->request->getPost($allowedPostFields));

        //jika activasi email di nonaktifkan (diatur di Confing/Auth)
        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (! empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }
        //jika gagal menyimpan di database
        if (! $users->save($user)) {
            //kembalikan dengan error
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        //jika activasi email diaktifkan
        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent      = $activator->send($user);
            //jika link activasi tidak terkirim
            if (! $sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->route('users')->with('message', 'User Berhasil diaktifkan');
        }

        // Success!
        return redirect()->route('users')->with('message', 'User Berhasil di Tambahkan');
    }


    public function editUser()
    {
        //ambil id
        $id = $this->request->getPost('id');
        //cek user berdasarkan id
        $user = $this->usermodel->find($id);
        //cek jika tombol update di klik
        if (isset($_POST['update'])) {
            #update user
            $userdata = [
                'email' => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
                'fullname' => $this->request->getPost('fullname'),
                'nip' => $this->request->getPost('nip'),
                'jabatan' => $this->request->getPost('jabatan'),
                'no_hp' => $this->request->getPost('no_hp'),
            ];

            $rules  = [
                'email'    => 'required|valid_email',
                'username' => 'required|min_length[3]|max_length[30]',
                'fullname'     => 'required',
                'nip'          => 'required',
                'jabatan'      => 'required',
                'no_hp'      => 'required',
            ];
            if (! $this->validateData($userdata, $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                die;
            }
            //update user data
            $user->email = $userdata['email'];
            $user->username = $userdata['username'];
            $user->fullname = $userdata['fullname'];
            $user->nip = $userdata['nip'];
            $user->jabatan = $userdata['jabatan'];
            $user->no_hp = $userdata['no_hp'];

            if ($this->usermodel->save($user)) {
                return redirect()->back()->with('message', 'User Berhasil di Update');
            } else {
                return redirect()->back()->with('message', 'User Gagal di Update');
            }
        }
        //jika tombol reset password ditekan
        if (isset($_POST['reset_password'])) {
            # code...
            # tentukan password default
            $password = 'persuratan2025';
            //update user password
            $user->password_hash = Password::hash($password);

            if ($this->usermodel->save($user)) {
                return redirect()->route('users')->with('message', 'Password berhasil direset ke "persuratan2025"');
            } else {
                return redirect()->route('users')->with('message', 'Password gagal direset!');
            }
        }

        //jika tombol active di klik
        if (isset($_POST['active'])) {
            # code...
            $user->active = 1;
            if ($this->usermodel->save($user)) {
                return redirect()->route('users')->with('message', 'User Berhasil di Aktivkan');
            } else {
                return redirect()->route('users')->with('message', 'User Gagal di Aktivkan');
            }
        }
        //jika tombol inactive di klik
        if (isset($_POST['inactive'])) {
            # code...
            $user->active = 0;
            if ($this->usermodel->save($user)) {
                return redirect()->route('users')->with('message', 'User Berhasil di Non Aktivkan');
            } else {
                return redirect()->route('users')->with('message', 'User Gagal di Non Aktivkan');
            }
        }
        //jika tombol delete di klik
        if (isset($_POST['delete'])) {
            # code...
            if ($this->usermodel->delete($id)) {
                return redirect()->route('users')->with('message', 'User Berhasil di Delete');
            } else {
                return redirect()->route('users')->with('message', 'User Gagal di Delete');
            }
        }
    }

    public function addusertoGroup()
    {
        $rules = [
            'user_id' => 'required',
            'group_id' => 'required'
        ];
        //jika validasi gagal
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        //jika validasi sukses
        #ambil data tervalidasi
        $data = $this->validator->getValidated();
        // # load model group
        $groupModel = new GroupModel();
        $setgroup = $groupModel->addUserToGroup($data['user_id'], $data['group_id']);
        return redirect()->back()->with('message', 'Role Baru Ditambahkan');
    }

    public function removefromGroup($user_id, $group_id)
    {
        #load model group
        $groupModel = new GroupModel();
        #Remove dari group
        $groupModel->removeUserFromGroup($user_id, $group_id);
        return redirect()->back()->with('message', 'Role Berhasil dihapus');
    }

    public function updatePassword()
    {
        // Validasi input
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data user yang sedang login
        $user = $this->usermodel->find(user()->id);
        $userId = $user->id;

        $authUserModel = service('authentication');
        // Cek apakah password lama benar
        $credential = [
            'username'=> $user->username,
            'password' => $this->request->getPost('old_password')
        ];
        if (!$authUserModel->attempt($credential)) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        // Update password
        $user->password_hash = Password::hash($this->request->getPost('new_password'));
        return redirect()->back()->with('message', 'Password berhasil diubah.');
    }


}
