<?php
include('src/config/koneksi.php');
$success_message = '';
$error_message = '';

// Tambah pelanggan baru jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];
        $telepon = $_POST['telepon'];

        $sql = "INSERT INTO pelanggan (nama, alamat, email, telepon) VALUES ('$nama', '$alamat', '$email', '$telepon')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Pelanggan baru berhasil ditambahkan!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Edit pelanggan
    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];
        $telepon = $_POST['telepon'];

        $sql = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', email='$email', telepon='$telepon' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Pelanggan berhasil diperbarui!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Hapus pelanggan
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM pelanggan WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Pelanggan berhasil dihapus!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Ambil data pelanggan dari database
$sql = "SELECT id, nama, alamat, email, telepon FROM pelanggan";
$result = $conn->query($sql);

$conn->close();
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <?php
            if ($_SESSION['role'] == 1) {
                echo '<button type="button" class="btn btn-success float-end" data-toggle="modal" data-target="#addCustomerModal">
                Tambah Pelanggan
            </button>';
            } else {
            }
            ?>

            <h2 class="mb-2">Data Pelanggan</h2>
            <p class="card-description"> Home /<code>Data Pelanggan</code></p>
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
                            <th>No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <?php if ($_SESSION['role'] == 1) {
                                echo '<th>Actions</th>';
                            } else {
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row["nama"] . "</td>";
                                echo "<td>" . $row["alamat"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["telepon"] . "</td>";
                                if ($_SESSION['role'] == 1) {
                                    echo "<td>
                            <button class='btn btn-warning btn-sm' onclick='editCustomer(" . json_encode($row) . ")'>Edit</button>
                            <button class='btn btn-danger btn-sm' onclick='deleteCustomer(" . $row["id"] . ")'>Delete</button>
                            </td>";
                                    echo "</tr>";
                                } else {
                                }
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada pelanggan ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Pelanggan -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="action" value="add" id="modalAction">
                    <input type="hidden" name="id" id="customerId">
                    <div class="form-group">
                        <label for="nama">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="deleteCustomerForm" action="" method="post" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="deleteCustomerId">
</form>

<script>
    $(document).ready(function() {
        $('.table').DataTable();
    });

    function editCustomer(customer) {
        $('#addCustomerModalLabel').text('Edit Pelanggan');
        $('#modalAction').val('edit');
        $('#customerId').val(customer.id);
        $('#nama').val(customer.nama);
        $('#alamat').val(customer.alamat);
        $('#email').val(customer.email);
        $('#telepon').val(customer.telepon);
        $('#addCustomerModal').modal('show');
    }

    function deleteCustomer(id) {
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
                $('#deleteCustomerId').val(id);
                $('#deleteCustomerForm').submit();
            }
        })
    }

    $('#addCustomerModal').on('hidden.bs.modal', function() {
        $('#addCustomerModalLabel').text('Tambah Pelanggan');
        $('#modalAction').val('add');
        $('#customerId').val('');
        $('#nama').val('');
        $('#alamat').val('');
        $('#email').val('');
        $('#telepon').val('');
    });
</script>