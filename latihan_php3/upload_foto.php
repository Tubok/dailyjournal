<?php
function upload_foto($file) {
    // Folder tujuan upload
    $target_dir = "img/";
    
    // Cek apakah folder img sudah ada, jika belum buat folder baru
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Ambil nama file asli
    $nama_file = basename($file["name"]);
    
    // Ambil ekstensi file
    $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    
    // Generate nama file baru agar unik (timestamp + nama file)
    $nama_file_baru = time() . '_' . $nama_file;
    
    // Path lengkap file yang akan diupload
    $target_file = $target_dir . $nama_file_baru;
    
    // Cek apakah file benar-benar gambar
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return array(
            'status' => false,
            'message' => 'File yang diupload bukan gambar!'
        );
    }
    
    // Cek ukuran file (maksimal 5MB)
    if ($file["size"] > 5000000) {
        return array(
            'status' => false,
            'message' => 'Ukuran file terlalu besar! Maksimal 5MB'
        );
    }
    
    // Hanya izinkan format tertentu
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_extensions)) {
        return array(
            'status' => false,
            'message' => 'Hanya file JPG, JPEG, PNG & GIF yang diizinkan!'
        );
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return array(
            'status' => true,
            'message' => $nama_file_baru
        );
    } else {
        return array(
            'status' => false,
            'message' => 'Terjadi kesalahan saat mengupload file!'
        );
    }
}
?>