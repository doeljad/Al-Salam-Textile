<?php
include('src/config/koneksi.php');
$success_message = '';
$error_message = '';

// Jika ada aksi tertentu dilakukan (ubah/hapus/tambah pesanan)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'delete') {
            $id = $_POST['id'];
            $sql = "DELETE FROM pesanan WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                $success_message = "Pesanan berhasil dihapus!";
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($action == 'update') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $sql = "UPDATE pesanan SET status='$status' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                $success_message = "Status pesanan berhasil diperbarui!";
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($action == 'add') {
            $pelanggan_id = $_POST['pelanggan_id'];
            $produk_id = $_POST['produk_id'];
            $jumlah = $_POST['jumlah'];
            $total_harga = $_POST['total_harga'];
            $tanggal_pesanan = date('Y-m-d H:i:s');
            $status = 1; // Status default "Masuk"
            $sql = "INSERT INTO pesanan (produk_id, pelanggan_id, jumlah, tanggal_pesanan, status, total_harga) 
                    VALUES ('$produk_id', '$pelanggan_id', '$jumlah', '$tanggal_pesanan', '$status', '$total_harga')";
            if ($conn->query($sql) === TRUE) {
                $success_message = "Pesanan berhasil ditambahkan!";
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

// Ambil data pesanan dari database dengan INNER JOIN ke tabel pelanggan
$sql_pesanan = "SELECT 
    pesanan.*, 
    pelanggan.nama, 
    pelanggan.alamat, 
    produk.nama_produk
FROM 
    pesanan 
INNER JOIN 
    pelanggan ON pesanan.pelanggan_id = pelanggan.id
INNER JOIN 
    produk ON produk.id = pesanan.produk_id
WHERE 
    pesanan.status = 'selesai';
";
$result_pesanan = $conn->query($sql_pesanan);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <!-- Your existing HTML code -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h2 class="mb-2">Riwayat Pesanan</h2>
                <p class="card-description"> Home /<code>Riwayat Pesanan</code></p>
                <div class="form-group">
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
                        <table id="pesananTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <?php if ($_SESSION['role'] == 1) {
                                        echo '<th>Actions</th>';
                                    } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_pesanan->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result_pesanan->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . $row["nama"] . "</td>";
                                        echo "<td>" . $row["alamat"] . "</td>";
                                        echo "<td>" . $row["nama_produk"] . "</td>";
                                        echo "<td>" . $row["jumlah"] . "</td>";
                                        echo "<td>" . $row["total_harga"] . "</td>";
                                        $status = $row["status"];
                                        if ($status == "masuk") {
                                            echo "<td>Masuk</td>";
                                        } elseif ($status == "diproses") {
                                            echo "<td>Diproses</td>";
                                        } elseif ($status == "dikirim") {
                                            echo "<td>Dikirim</td>";
                                        } elseif ($status == "selesai") {
                                            echo "<td>Selesai</td>";
                                        } else {
                                            echo "<td>Status tidak diketahui</td>";
                                        }

                                        if ($_SESSION['role'] == 1) {
                                            echo "<td>
                                    <button class='btn btn-warning btn-sm' onclick='updateStatus(" . json_encode($row) . ")'>Update Status</button>
                                    <button class='btn btn-danger btn-sm' onclick='deletePesanan(" . $row["id"] . ")'>Delete</button>
                                    </td>";
                                        }
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Tidak ada pesanan ditemukan</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal Tambah Pesanan -->
                <div class="modal fade" id="addPesananModal" tabindex="-1" role="dialog" aria-labelledby="addPesananModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPesananModalLabel">Tambah Pesanan Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addPesananForm" action="" method="post">
                                    <input type="hidden" name="action" value="add">
                                    <div class="form-group">
                                        <label for="pelanggan_id">Pelanggan</label>
                                        <select class="form-control" id="pelanggan_id" name="pelanggan_id" required>
                                            <!-- Option pelanggan akan diisi dengan PHP -->
                                            <?php
                                            include('src/config/koneksi.php');
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }

                                            $sql_pelanggan = "SELECT id, nama FROM pelanggan";
                                            $result_pelanggan = $conn->query($sql_pelanggan);

                                            if ($result_pelanggan === FALSE) {
                                                echo "Error: " . $conn->error;
                                            } elseif ($result_pelanggan->num_rows == 0) {
                                                echo "<option>No pelanggan found.</option>";
                                            } else {
                                                while ($row_pelanggan = $result_pelanggan->fetch_assoc()) {
                                                    echo "<option value='" . $row_pelanggan['id'] . "'>" . $row_pelanggan['nama'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="produk_id">Produk</label>
                                        <select class="form-control" id="produk_id" name="produk_id" required>
                                            <!-- Option produk akan diisi dengan PHP -->
                                            <?php
                                            $sql_produk = "SELECT id, nama_produk FROM produk";
                                            $result_produk = $conn->query($sql_produk);

                                            if ($result_produk === FALSE) {
                                                echo "Error: " . $conn->error;
                                            } elseif ($result_produk->num_rows == 0) {
                                                echo "<option>No produk found.</option>";
                                            } else {
                                                while ($row_produk = $result_produk->fetch_assoc()) {
                                                    echo "<option value='" . $row_produk['id'] . "'>" . $row_produk['nama_produk'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_harga">Total Harga</label>
                                        <input type="number" class="form-control" id="total_harga" name="total_harga" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Update Status -->
                <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateStatusModalLabel">Update Status Pesanan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <input type="hidden" name="action" value="update" id="modalAction">
                                    <input type="hidden" name="id" id="pesananId">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="masuk">Masuk</option>
                                            <option value="diproses">Diproses</option>
                                            <option value="dikirim">Dikirim</option>
                                            <option value="selesai">Selesai</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="deletePesananForm" action="" method="post" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" id="deletePesananId">
    </form>

    <script>
        function updateStatus(pesanan) {
            $('#updateStatusModalLabel').text('Update Status Pesanan');
            $('#modalAction').val('update');
            $('#pesananId').val(pesanan.id);
            $('#status').val(pesanan.status);
            $('#updateStatusModal').modal('show');
        }

        function deletePesanan(id) {
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
                    $('#deletePesananId').val(id);
                    $('#deletePesananForm').submit();
                }
            });
        }

        $('#updateStatusModal').on('hidden.bs.modal', function() {
            $('#updateStatusModalLabel').text('Update Status Pesanan');
            $('#modalAction').val('update');
            $('#pesananId').val('');
            $('#status').val('');
        });
        $(document).ready(function() {
            $('#pesananTable').DataTable();
        });
    </script>
</body>

</html>