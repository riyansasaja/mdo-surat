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