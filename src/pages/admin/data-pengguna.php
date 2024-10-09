<?php
include('src/config/koneksi.php');
$success_message = '';
$error_message = '';

// Tambah pengguna baru jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security
        $nama_lengkap = $_POST['nama_lengkap'];
        $role = $_POST['role'];

        $sql = "INSERT INTO pengguna (username, password, nama_lengkap, role) VALUES ('$username', '$password', '$nama_lengkap', '$role')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Pengguna baru berhasil ditambahkan!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Edit pengguna
    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
        $nama_lengkap = $_POST['nama_lengkap'];
        $role = $_POST['role'];

        if ($password) {
            $sql = "UPDATE pengguna SET username='$username', password='$password', nama_lengkap='$nama_lengkap', role='$role' WHERE id=$id";
        } else {
            $sql = "UPDATE pengguna SET username='$username', nama_lengkap='$nama_lengkap', role='$role' WHERE id=$id";
        }

        if ($conn->query($sql) === TRUE) {
            $success_message = "Pengguna berhasil diperbarui!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Hapus pengguna
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM pengguna WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Pengguna berhasil dihapus!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Ambil data pengguna dari database
$sql = "SELECT id, username, nama_lengkap, role FROM pengguna WHERE role NOT IN ('pelanggan', 'supplier')";
$result = $conn->query($sql);

$conn->close();
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-success float-end" data-toggle="modal" data-target="#addUserModal">
                Tambah Pengguna
            </button>
            <h2 class="mb-2">Data Pengguna</h2>
            <p class="card-description"> Home /<code>Data Pengguna</code></p>
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
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["nama_lengkap"] . "</td>";
                                echo "<td>" . $row["role"] . "</td>";
                                echo "<td>
                            <button class='btn btn-warning btn-sm' onclick='editUser(" . json_encode($row) . ")'>Edit</button>
                            <button class='btn btn-danger btn-sm' onclick='deleteUser(" . $row["id"] . ")'>Delete</button>
                            </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada pengguna ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="action" value="add" id="modalAction">
                    <input type="hidden" name="id" id="userId">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <!-- <option value="3">Staff</option> -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="deleteUserForm" action="" method="post" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="deleteUserId">
</form>

<script>
    $(document).ready(function() {
        $('.table').DataTable();
    });

    function editUser(user) {
        $('#addUserModalLabel').text('Edit Pengguna');
        $('#modalAction').val('edit');
        $('#userId').val(user.id);
        $('#username').val(user.username);
        $('#nama_lengkap').val(user.nama_lengkap);
        $('#role').val(user.role);
        $('#password').val(''); // Clear the password field for security
        $('#addUserModal').modal('show');
    }

    function deleteUser(id) {
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
                $('#deleteUserId').val(id);
                $('#deleteUserForm').submit();
            }
        })
    }

    $('#addUserModal').on('hidden.bs.modal', function() {
        $('#addUserModalLabel').text('Tambah Pengguna');
        $('#modalAction').val('add');
        $('#userId').val('');
        $('#username').val('');
        $('#nama_lengkap').val('');
        $('#role').val('');
        $('#password').val('');
    });
</script>