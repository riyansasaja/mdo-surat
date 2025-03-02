<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelInmail extends Model
{
    protected $table            = 'tb_inmail';
    protected $primaryKey       = 'id_inmail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_agenda',
        'tgl_agenda',
        'no_surat',
        'tgl_surat',
        'sifat_surat',
        'jenis_surat',
        'kode_surat',
        'asal_surat',
        'perihal',
        'isi_surat',
        'status_inmail',
        'id_user_despo'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ['insertToStatus'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function insertToStatus($id) {
        $db      = \Config\Database::connect();
        $builder = $db->table('tb_status_mail');
        $data = [
            'id_inmail' => $id['id'],
            'user' => user()->fullname,
            'status' => 'Diinput oleh Operator'
        ];
        $builder->insert($data);
    }

    public function getNomorSurat($id_inmail): object|array|null
    {
       return $this->select('no_surat')->where('id_inmail', $id_inmail)->first();
    }

    public function getMonthRecap(): array
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('countview');
        return $builder->get()->getResultObject();
    }


}


