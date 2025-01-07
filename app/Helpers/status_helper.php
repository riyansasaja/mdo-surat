<?php
function addStatus($id_inmail, $status){
    $db      = \Config\Database::connect();
    $builder = $db->table('tb_status_mail');
    $data = [
        'id_inmail' => $id_inmail,
        'user' => user()->fullname,
        'status' => $status
    ];
    $builder->insert($data);
}

function getStatus($id_inmail){
    $db      = \Config\Database::connect();
    $builder = $db->table('tb_status_mail');
    $builder->where('id_inmail', $id_inmail);
    return $builder->get()->getResultArray();
}