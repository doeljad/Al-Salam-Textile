<?php
include('src/config/koneksi.php');
$success_message = '';
$error_message = '';

// Ambil data toko dari database
$sql = "SELECT id, nama_toko, alamat, telepon, email, deskripsi FROM pengaturan_toko LIMIT 1";
$result = $conn->query($sql);

// Cek apakah query berhasil
if (!$result) {
    $error_message = "Error: " . $conn->error;
    $informasi_toko = null;
} else {
    $informasi_toko = $result->fetch_assoc();
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $deskripsi = $_POST['deskripsi'];

    $sql_update = "UPDATE pengaturan_toko SET nama_toko='$nama_toko', alamat='$alamat', telepon='$telepon', email='$email', deskripsi='$deskripsi' WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        $success_message = "Informasi toko berhasil diperbarui!";
    } else {
        $error_message = "Error: " . $sql_update . "<br>" . $conn->error;
    }

    // Refresh data toko setelah update
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $informasi_toko = $result->fetch_assoc();
    }
}

$conn->close();
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-2">Informasi Toko</h2>
            <p class="card-description"> Home /<code>Informasi Toko</code></p>
            <?php if ($success_message) : ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '<?php echo $success_message; ?>'
                    });
                </script>
            <?php endif; ?>
            <?php if ($error_message) : ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?php echo $error_message; ?>'
                    });
                </script>
            <?php endif; ?>

            <?php if ($informasi_toko) : ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $informasi_toko['id']; ?>">
                    <div class="form-group">
                        <label for="nama_toko">Nama Toko</label>
                        <input type="text" class="form-control" id="nama_toko" name="nama_toko" value="<?php echo $informasi_toko['nama_toko']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $informasi_toko['alamat']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $informasi_toko['telepon']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $informasi_toko['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?php echo $informasi_toko['deskripsi']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            <?php else : ?>
                <p>Tidak ada informasi toko yang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
</div>