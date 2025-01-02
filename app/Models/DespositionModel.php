<?php

namespace App\Models;

use CodeIgniter\Model;

class DespositionModel extends Model
{
    protected $table            = 'tb_disposition';
    protected $primaryKey       = 'disposition_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['inmail_id', 'disposition_form', 'disposition_to', 'sifat', 'petunjuk', 'catatan', 'disposition_status', 'disposition_log'];

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
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getDesposition($inmail_id)
    {
        return $this->db->table('tb_disposition')
            ->select('tb_disposition.petunjuk, tb_disposition.catatan, tb_disposition.disposition_status, tb_disposition.disposition_log, users.fullname as from')
            ->join('users', 'tb_disposition.disposition_form = users.id')
            ->where('inmail_id', $inmail_id)
            ->get()->getResultArray();
    }
}
