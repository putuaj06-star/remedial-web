<?php

require_once "config/database.php";

/* =========================
   TAMBAH DATA
========================= */

if (isset($_POST['tambah'])) {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($nama == "" || $email == "" || $password == "") {

        $error = "Semua data wajib diisi.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid.";

    } elseif (strlen($password) < 6) {

        $error = "Password minimal 6 karakter.";

    } else {

        $password_hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $conn->prepare(
            "INSERT INTO pengguna (nama, email, password)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $nama,
            $email,
            $password_hash
        );

        if ($stmt->execute()) {

            header("Location: pengguna.php");
            exit;

        } else {

            $error = "Email sudah digunakan.";
        }
    }
}


/* =========================
   UPDATE DATA
========================= */

if (isset($_POST['update'])) {

    $id = (int) $_POST['id'];
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);

    if ($nama == "" || $email == "") {

        $error = "Nama dan email wajib diisi.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE pengguna
             SET nama = ?, email = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "ssi",
            $nama,
            $email,
            $id
        );

        if ($stmt->execute()) {

            header("Location: pengguna.php");
            exit;

        } else {

            $error = "Gagal mengubah data.";
        }
    }
}


/* =========================
   HAPUS DATA
========================= */

if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    $stmt = $conn->prepare(
        "DELETE FROM pengguna WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    header("Location: pengguna.php");

    exit;
}


/* =========================
   AMBIL DATA UNTUK EDIT
========================= */

$edit = null;

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    $stmt = $conn->prepare(
        "SELECT id, nama, email
         FROM pengguna
         WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $edit = $result->fetch_assoc();
}


/* =========================
   TAMPILKAN SEMUA DATA
========================= */

$data = $conn->query(
    "SELECT id, nama, email
     FROM pengguna
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Data Pengguna</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container mt-5">

    <h1>Data Pengguna</h1>

    <a href="index.php">
        ← Kembali
    </a>

    <hr>


    <?php if (isset($error)) : ?>

        <div class="alert alert-danger">

            <?= htmlspecialchars($error) ?>

        </div>

    <?php endif; ?>


    <!-- =========================
         FORM TAMBAH / EDIT
    ========================== -->

    <?php if ($edit) : ?>

        <h2>Edit Pengguna</h2>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($edit['id']) ?>"
            >

            <div class="mb-3">

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="<?= htmlspecialchars($edit['nama']) ?>"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="<?= htmlspecialchars($edit['email']) ?>"
                    required
                >

            </div>


            <button
                type="submit"
                name="update"
                class="btn btn-primary"
            >
                Simpan Perubahan
            </button>

            <a
                href="pengguna.php"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </form>


    <?php else : ?>

        <h2>Tambah Pengguna</h2>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >

            </div>


            <button
                type="submit"
                name="tambah"
                class="btn btn-success"
            >
                Tambah
            </button>

        </form>

    <?php endif; ?>


    <hr>


    <!-- =========================
         TABEL DATA
    ========================== -->

    <h2>Daftar Pengguna</h2>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>ID</th>

                <th>Nama</th>

                <th>Email</th>

                <th>Aksi</th>

            </tr>

        </thead>


        <tbody>

        <?php while ($row = $data->fetch_assoc()) : ?>

            <tr>

                <td>
                    <?= htmlspecialchars($row['id']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['nama']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['email']) ?>
                </td>

                <td>

                    <a
                        href="pengguna.php?edit=<?= $row['id'] ?>"
                        class="btn btn-warning btn-sm"
                    >
                        Edit
                    </a>


                    <a
                        href="pengguna.php?hapus=<?= $row['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                    >
                        Hapus
                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>

</html>