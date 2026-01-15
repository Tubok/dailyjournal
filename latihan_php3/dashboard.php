<?php
//query untuk mengambil data article
$sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil1 = $conn->query($sql1);

//menghitung jumlah baris data article
$jumlah_article = $hasil1->num_rows; 

//query untuk mengambil data gallery
$sql2 = "SELECT * FROM gallery ORDER BY tanggal DESC";
$hasil2 = $conn->query($sql2);

//menghitung jumlah baris data gallery
$jumlah_gallery = $hasil2->num_rows;

//query untuk mengambil data user yang sedang login
$username_login = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username_login);
$stmt->execute();
$result_user = $stmt->get_result();
$data_user = $result_user->fetch_assoc();
?>

<!-- Welcome Section dengan Foto Profil -->
<div class="row justify-content-center mb-4">
    <div class="col-md-8 text-center">
        <h5 class="text-muted mb-3">Selamat Datang,</h5>
        <h2 class="text-danger fw-bold mb-4"><?= htmlspecialchars($data_user['username']) ?></h2>
        
        <!-- Foto Profil User -->
        <div class="mb-4">
            <?php if (!empty($data_user['foto']) && file_exists('img/' . $data_user['foto'])) { ?>
                <img src="img/<?= $data_user['foto'] ?>" class="rounded-circle border border-danger shadow" 
                     width="200" height="200" style="object-fit: cover;" alt="Foto Profil">
            <?php } else { ?>
                <img src="https://via.placeholder.com/200/dee2e6/6c757d?text=<?= strtoupper(substr($data_user['username'], 0, 1)) ?>" 
                     class="rounded-circle border border-danger shadow" width="200" height="200" alt="No Photo">
            <?php } ?>
        </div>
    </div>
</div>

<!-- Cards Article dan Gallery -->
<div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center pt-4">
    <div class="col">
        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_article; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
    <div class="col">
        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_gallery; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
</div>