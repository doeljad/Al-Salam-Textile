<?php
include('src/config/koneksi.php');
$success_message = '';
$error_message = '';

// Tambah, edit, atau hapus produk jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $kategori_id = $_POST['kategori_id'];

        $sql = "INSERT INTO produk (nama_produk, deskripsi, harga, stok, kategori_id) VALUES ('$nama_produk', '$deskripsi', '$harga', '$stok', '$kategori_id')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Produk baru berhasil ditambahkan!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $kategori_id = $_POST['kategori_id'];

        $sql = "UPDATE produk SET nama_produk='$nama_produk', deskripsi='$deskripsi', harga='$harga', stok='$stok', kategori_id='$kategori_id' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Produk berhasil diperbarui!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM produk WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Produk berhasil dihapus!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : '';

// Ambil data produk dari database
$sql_produk = "SELECT p.*, k.nama_kategori 
               FROM produk p
               LEFT JOIN kategori_produk k ON p.kategori_id = k.id";

if ($kategori_id) {
    $sql_produk .= " WHERE p.kategori_id = '$kategori_id'";
}

$result_produk = $conn->query($sql_produk);
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <?php if ($_SESSION['role'] == 1) { ?>
                <button type="button" class="btn btn-success float-end" data-toggle="modal" data-target="#addProductModal">
                    Tambah Produk
                </button>
            <?php } ?>

            <h2 class="mb-2">Stok Produk</h2>
            <p class="card-description"> Home /<code>Stok Produk</code></p>
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> No. </th>
                            <th> Nama Produk </th>
                            <th> Deskripsi </th>
                            <th> Stok </th>
                            <th> Harga </th>
                            <th> Kategori </th>
                            <?php if ($_SESSION['role'] == 1) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_produk->num_rows > 0) {
                            $no = 1;
                            while ($row_produk = $result_produk->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row_produk["nama_produk"] . "</td>";
                                echo "<td>" . $row_produk["deskripsi"] . "</td>";
                                echo "<td>" . $row_produk["stok"] . "</td>";
                                echo "<td>" . $row_produk["harga"] . "</td>";
                                echo "<td>" . $row_produk["nama_kategori"] . "</td>";
                                if ($_SESSION['role'] == 1) {
                                    echo "<td>
                                        <button class='btn btn-warning btn-sm' onclick='editProduct(" . json_encode($row_produk) . ")'>Edit</button>
                                        <button class='btn btn-danger btn-sm' onclick='deleteProduct(" . $row_produk["id"] . ")'>Delete</button>
                                        </td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada produk ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="action" value="add" id="modalAction">
                    <input type="hidden" name="id" id="productId">
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            // Ambil data kategori produk dari database
                            $sql_kategori = "SELECT id, nama_kategori FROM kategori_produk";
                            $result_kategori = $conn->query($sql_kategori);
                            if ($result_kategori->num_rows > 0) {
                                while ($row_kategori = $result_kategori->fetch_assoc()) {
                                    echo "<option value='" . $row_kategori['id'] . "'>" . $row_kategori['nama_kategori'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="deleteProductForm" action="" method="post" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="deleteProductId">
</form>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
<script>
    $(document).ready(function() {
        $('.table').DataTable();

        <?php if ($success_message) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo $success_message; ?>'
            });
        <?php endif; ?>
        <?php if ($error_message) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $error_message; ?>'
            });
        <?php endif; ?>
    });

    function editProduct(product) {
        $('#addProductModalLabel').text('Edit Produk');
        $('#modalAction').val('edit');
        $('#productId').val(product.id);
        $('#nama_produk').val(product.nama_produk);
        $('#deskripsi').val(product.deskripsi);
        $('#harga').val(product.harga);
        $('#stok').val(product.stok);
        $('#kategori').val(product.kategori_id);
        $('#addProductModal').modal('show');
    }

    function deleteProduct(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteProductId').val(id);
                $('#deleteProductForm').submit();
            }
        });
    }
</script>