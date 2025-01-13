<?php

function notifDisposisi($target, $no_surat)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,

        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => '*Notif App Persuratan*
            telah Masuk Desposisi untuk Surat Nomor ${no_surat}, Untuk lebih lengkapnya silahkan Buka Aplikasi Persuratan melalui link berikut ini https://persuratan.pta-manado.go.id"
            ',
            'delay' => '2',
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: sAZJpFT7ntDM4+!gJ+h-"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
function notifTerusan($target)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,

        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => '*Notif App Persuratan*
            -- Operator telah meneruskan surat Baru untuk ditindak lanjuti, lebih lengkapnya silahkan Buka Aplikasi Persuratan melalui link berikut ini _https://persuratan.pta-manado.go.id_
            ',
            'delay' => '2',
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: sAZJpFT7ntDM4+!gJ+h-"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function notifDelTerusan($target)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,

        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => '*Notif App Persuratan*
            -- Karena sesuatu dan lain hal, operator membatalkan surat yang diteruskan, lebih lengkapnya silahkan Buka Aplikasi Persuratan melalui link berikut ini _https://persuratan.pta-manado.go.id_
            ',
            'delay' => '2',
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: sAZJpFT7ntDM4+!gJ+h-"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function notifTindaklanjut($target, $no_surat)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,

        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => '*Notif App Persuratan*
            -- surat Nomor ${no_surat}, telah ditindaklanjuti, Untuk lebih lengkapnya silahkan Buka Aplikasi Persuratan melalui link berikut ini _https://persuratan.pta-manado.go.id_
            ',
            'delay' => '2',
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: sAZJpFT7ntDM4+!gJ+h-"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response; //fdfdf
}
