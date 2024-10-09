<?php
include('src/config/koneksi.php');
// session_start();  // Pastikan session dimulai

// Inisialisasi pesan jika diperlukan
if (!isset($_SESSION['success_message'])) {
    $_SESSION['success_message'] = '';
}
if (!isset($_SESSION['error_message'])) {
    $_SESSION['error_message'] = '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $nama_kategori = $_POST['nama_kategori'];
        $deskripsi = $_POST['deskripsi'];

        $sql = "INSERT INTO kategori_produk (nama_kategori, deskripsi) VALUES ('$nama_kategori', '$deskripsi')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Kategori baru berhasil ditambahkan!";
        } else {
            $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $nama_kategori = $_POST['nama_kategori'];
        $deskripsi = $_POST['deskripsi'];

        $sql = "UPDATE kategori_produk SET nama_kategori='$nama_kategori', deskripsi='$deskripsi' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Kategori berhasil diperbarui!";
        } else {
            $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM kategori_produk WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Kategori berhasil dihapus!";
        } else {
            $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$sql = "SELECT id, nama_kategori, deskripsi FROM kategori_produk";
$result = $conn->query($sql);

$conn->close();
?>



<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <?php if ($_SESSION['role'] == 1) { ?>
                <button type="button" class="btn btn-success float-end" data-toggle="modal" data-target="#addCategoryModal">
                    Tambah Kategori Produk
                </button>
            <?php } ?>

            <h2 class="mb-2">Kategori Produk</h2>
            <p class="card-description"> Home /<code>Kategori Produk</code></p>

            <div class="table-responsive">
                <table id="kategoriTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th> No. </th>
                            <th> Kategori Produk </th>
                            <th> Deskripsi </th>
                            <?php if ($_SESSION['role'] == 1) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row["nama_kategori"] . "</td>";
                                echo "<td>" . $row["deskripsi"] . "</td>";
                                if ($_SESSION['role'] == 1) {
                                    echo "<td>
                                        <button class='btn btn-warning btn-sm' onclick='editCategory(" . json_encode($row) . ")'>Edit</button>
                                        <button class='btn btn-danger btn-sm' onclick='deleteCategory(" . $row["id"] . ")'>Delete</button>
                                        </td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tidak ada kategori ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="action" value="add" id="modalAction">
                    <input type="hidden" name="id" id="categoryId">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="deleteCategoryForm" action="" method="post" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="deleteCategoryId">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable();

        <?php if (!empty($_SESSION['success_message'])) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo $_SESSION['success_message']; ?>'
            }).then(() => {
                <?php unset($_SESSION['success_message']); ?>
                window.onload = function() {
                    window.location.href = 'index.php?page=kategori-produk';
                };
            });
        <?php } ?>

        <?php if (!empty($_SESSION['error_message'])) { ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $_SESSION['error_message']; ?>'
            }).then(() => {
                <?php unset($_SESSION['error_message']); ?>
                window.onload = function() {
                    window.location.href = 'index.php?page=kategori-produk';
                };
            });
        <?php } ?>
    });

    function editCategory(category) {
        $('#addCategoryModalLabel').text('Edit Kategori Produk');
        $('#modalAction').val('edit');
        $('#categoryId').val(category.id);
        $('#nama_kategori').val(category.nama_kategori);
        $('#deskripsi').val(category.deskripsi);
        $('#addCategoryModal').modal('show');
    }

    function deleteCategory(id) {
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
                $('#deleteCategoryId').val(id);
                $('#deleteCategoryForm').submit();
            }
        });
    }

    $('#addCategoryModal').on('hidden.bs.modal', function() {
        $('#addCategoryModalLabel').text('Tambah Kategori Produk');
        $('#modalAction').val('add');
        $('#categoryId').val('');
        $('#nama_kategori').val('');
        $('#deskripsi').val('');
    });
</script>