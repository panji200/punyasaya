<?php

require_once "../config.php";
require_once "../helpers/response.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // url: [GET] /mahasiswa.php?id={id}
        if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $q = "SELECT 
            m.id,
            m.nama,
            m.nim,
            j.nama_jurusan AS jurusan
          FROM mahasiswa m
          LEFT JOIN jurusan j ON m.jurusan_id = j.id
          WHERE m.id = '$id'";

    $r = mysqli_query($koneksi, $q);
        echo "ini method GET";
        break;
    case 'POST':
        echo "ini method POST";
        break;
    default:
        sendResponse(false, "method tidak diizinkan", null, 405);
}
}

die;

// GET BY ID
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $q = "SELECT 
            m.id,
            m.nama,
            m.nim,
            j.nama_jurusan AS jurusan
          FROM mahasiswa m
          LEFT JOIN jurusan j ON m.jurusan_id = j.id
          WHERE m.id = '$id'";

    $r = mysqli_query($koneksi, $q);

    if (!$r) {
        sendResponse(false, "query gagal: " . mysqli_error($koneksi), null, 500);
    }

    $data = mysqli_fetch_assoc($r);

    if (!$data) {
        sendResponse(false, "data tidak ditemukan", null, 404);
    }

    sendResponse(true, "berhasil", $data, 200);
}


// GET ALL
$q = "SELECT 
        m.id,
        m.nama,
        m.nim,
        j.nama_jurusan AS jurusan
      FROM mahasiswa m
      LEFT JOIN jurusan j ON m.jurusan_id = j.id
      ORDER BY m.id DESC";

$r = mysqli_query($koneksi, $q);

if (!$r) {
    sendResponse(false, "query gagal: " . mysqli_error($koneksi), null, 500);
}

$data = [];

while ($row = mysqli_fetch_assoc($r)) {
    $data[] = $row;
}

sendResponse(true, "berhasil", $data, 200);