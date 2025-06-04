<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedTbTemplateSurat extends Seeder
{
    public function run()
    {
        //
        $template_data =
            [
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
                [
                    'nama_template' => '',
                    'icon_template' => '',
                    'ref_link' => ''
                ],
            ];

        foreach ($template_data as $data) {
            # code...
            $this->db->table('tb_template_surat')->insert($data);
        }
    }
}
