<?php
// Ambil data user yang sedang login
$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Profile Saya</h5>
                </div>
                <div class="card-body">
                    <!-- Tampilkan foto profil saat ini -->
                    <div class="text-center mb-4">
                        <?php if (!empty($user_data['foto']) && file_exists('img/' . $user_data['foto'])) { ?>
                            <img src="img/<?= $user_data['foto'] ?>" class="rounded-circle border border-danger shadow" width="150" height="150" style="object-fit: cover;" alt="Foto Profil">
                        <?php } else { ?>
                            <img src="https://via.placeholder.com/150/dee2e6/6c757d?text=No+Photo" class="rounded-circle border border-danger shadow" width="150" height="150" alt="No Photo">
                        <?php } ?>
                        <p class="mt-2 text-muted">Foto Profil Saat Ini</p>
                    </div>

                    <form method="post" action="" enctype="multipart/form-data">
                        <!-- Username (Readonly) -->
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="bi bi-person"></i> Username
                            </label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= htmlspecialchars($user_data['username']) ?>" readonly>
                            <div class="form-text">Username tidak dapat diubah</div>
                        </div>

                        <!-- Ganti Password -->
                        <div class="mb-3">
                            <label for="password_baru" class="form-label">Ganti Password</label>
                            <input type="password" class="form-control" id="password_baru" name="password_baru" 
                                   placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
                        </div>

                        <!-- Foto Profil -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Ganti Foto Profil</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>

                        <!-- Foto Profil Saat Ini -->
                        <div class="mb-3">
                            <label class="form-label">Foto Profil Saat Ini</label>
                            <div>
                                <?php if (!empty($user_data['foto']) && file_exists('img/' . $user_data['foto'])) { ?>
                                    <img src="img/<?= $user_data['foto'] ?>" class="img-thumbnail" width="200" style="object-fit: cover;" alt="Foto Profil">
                                <?php } else { ?>
                                    <p class="text-muted">Belum ada foto profil</p>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="mb-3">
                            <button type="submit" name="update_profile" class="btn btn-primary">
                                simpan
                            </button>
                        </div>

                        <!-- Hidden field untuk foto lama -->
                        <input type="hidden" name="foto_lama" value="<?= $user_data['foto'] ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "upload_foto.php";

// Proses update profile
if (isset($_POST['update_profile'])) {
    $username = $_SESSION['username'];
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $foto_lama = $_POST['foto_lama'];
    $hapus_foto = isset($_POST['hapus_foto']) ? true : false;
    
    $update_password = false;
    $update_foto = false;
    $new_password = '';
    $new_foto = $foto_lama;
    
    // ===== PROSES PASSWORD =====
    if (!empty($password_lama) || !empty($password_baru) || !empty($konfirmasi_password)) {
        // Validasi: semua field password harus diisi
        if (empty($password_lama)) {
            echo "<script>
                alert('Password lama harus diisi!');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
        
        if (empty($password_baru)) {
            echo "<script>
                alert('Password baru harus diisi!');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
        
        if (empty($konfirmasi_password)) {
            echo "<script>
                alert('Konfirmasi password harus diisi!');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
        
        // Cek password lama cocok atau tidak
        $password_lama_md5 = md5($password_lama);
        if ($password_lama_md5 != $user_data['password']) {
            echo "<script>
                alert('Password lama tidak sesuai!');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
        
        // Cek password baru dan konfirmasi cocok
        if ($password_baru != $konfirmasi_password) {
            echo "<script>
                alert('Password baru dan konfirmasi password tidak cocok!');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
        
        // Validasi panjang password minimal 4 karakter
        if (strlen($password_baru) < 4) {
            echo "<script>
                alert('Password minimal 4 karakter!');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
        
        $new_password = md5($password_baru);
        $update_password = true;
    }
    
    // ===== PROSES FOTO =====
    if ($hapus_foto) {
        // Hapus foto lama jika ada
        if (!empty($foto_lama) && file_exists('img/' . $foto_lama)) {
            unlink('img/' . $foto_lama);
        }
        $new_foto = '';
        $update_foto = true;
    } elseif (!empty($_FILES['foto']['name'])) {
        // Upload foto baru
        $cek_upload = upload_foto($_FILES["foto"]);
        
        if ($cek_upload['status']) {
            // Hapus foto lama jika ada
            if (!empty($foto_lama) && file_exists('img/' . $foto_lama)) {
                unlink('img/' . $foto_lama);
            }
            $new_foto = $cek_upload['message'];
            $update_foto = true;
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
    }
    
    // ===== UPDATE DATABASE =====
    if ($update_password && $update_foto) {
        // Update password dan foto
        $stmt = $conn->prepare("UPDATE user SET password = ?, foto = ? WHERE username = ?");
        $stmt->bind_param("sss", $new_password, $new_foto, $username);
    } elseif ($update_password) {
        // Update password saja
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_password, $username);
    } elseif ($update_foto) {
        // Update foto saja
        $stmt = $conn->prepare("UPDATE user SET foto = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_foto, $username);
    } else {
        echo "<script>
            alert('Tidak ada perubahan yang dilakukan!');
            window.location='admin.php?page=profile';
        </script>";
        exit;
    }
    
    $update = $stmt->execute();
    
    if ($update) {
        echo "<script>
            alert('Profile berhasil diupdate!');
            window.location='admin.php?page=profile';
        </script>";
    } else {
        echo "<script>
            alert('Gagal update profile!');
            window.location='admin.php?page=profile';
        </script>";
    }
    
    $stmt->close();
}
?>