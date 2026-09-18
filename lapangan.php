<?php

require_once "config/database.php";

/* =========================
   TAMBAH DATA
========================= */

if (isset($_POST['tambah'])) {

    $nama_lapangan = trim($_POST['nama_lapangan']);
    $jenis_olahraga = trim($_POST['jenis_olahraga']);
    $lokasi = trim($_POST['lokasi']);
    $harga = (int) $_POST['harga'];
    $pengguna_id = (int) $_POST['pengguna_id'];

    if (
        $nama_lapangan == "" ||
        $jenis_olahraga == "" ||
        $lokasi == "" ||
        $harga <= 0 ||
        $pengguna_id <= 0
    ) {

        $error = "Semua data wajib diisi dengan benar.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO lapangan
            (nama_lapangan, jenis_olahraga, lokasi, harga, pengguna_id)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssii",
            $nama_lapangan,
            $jenis_olahraga,
            $lokasi,
            $harga,
            $pengguna_id
        );

        if ($stmt->execute()) {

            header("Location: lapangan.php");
            exit;

        } else {

            $error = "Gagal menambahkan data.";
        }
    }
}


/* =========================
   UPDATE DATA
========================= */

if (isset($_POST['update'])) {

    $id = (int) $_POST['id'];
    $nama_lapangan = trim($_POST['nama_lapangan']);
    $jenis_olahraga = trim($_POST['jenis_olahraga']);
    $lokasi = trim($_POST['lokasi']);
    $harga = (int) $_POST['harga'];
    $pengguna_id = (int) $_POST['pengguna_id'];

    if (
        $nama_lapangan == "" ||
        $jenis_olahraga == "" ||
        $lokasi == "" ||
        $harga <= 0 ||
        $pengguna_id <= 0
    ) {

        $error = "Semua data wajib diisi dengan benar.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE lapangan
             SET nama_lapangan = ?,
                 jenis_olahraga = ?,
                 lokasi = ?,
                 harga = ?,
                 pengguna_id = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sssiii",
            $nama_lapangan,
            $jenis_olahraga,
            $lokasi,
            $harga,
            $pengguna_id,
            $id
        );

        if ($stmt->execute()) {

            header("Location: lapangan.php");
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
        "DELETE FROM lapangan WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    header("Location: lapangan.php");

    exit;
}


/* =========================
   AMBIL DATA UNTUK EDIT
========================= */

$edit = null;

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    $stmt = $conn->prepare(
        "SELECT *
         FROM lapangan
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
   DATA PENGGUNA
========================= */

$pengguna = $conn->query(
    "SELECT id, nama
     FROM pengguna
     ORDER BY nama ASC"
);


/* =========================
   DATA LAPANGAN
========================= */

$data = $conn->query(
    "SELECT
        lapangan.id,
        lapangan.nama_lapangan,
        lapangan.jenis_olahraga,
        lapangan.lokasi,
        lapangan.harga,
        pengguna.nama AS nama_pengguna
     FROM lapangan
     JOIN pengguna
     ON lapangan.pengguna_id = pengguna.id
     ORDER BY lapangan.id DESC"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Lapangan</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container mt-5">

    <h1>Data Lapangan</h1>

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
         FORM TAMBAH
    ========================== -->

    <?php if ($edit) : ?>

        <h2>Edit Lapangan</h2>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($edit['id']) ?>"
            >


            <div class="mb-3">

                <label class="form-label">
                    Nama Lapangan
                </label>

                <input
                    type="text"
                    name="nama_lapangan"
                    class="form-control"
                    value="<?= htmlspecialchars($edit['nama_lapangan']) ?>"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Jenis Olahraga
                </label>

                <input
                    type="text"
                    name="jenis_olahraga"
                    class="form-control"
                    value="<?= htmlspecialchars($edit['jenis_olahraga']) ?>"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Lokasi
                </label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    value="<?= htmlspecialchars($edit['lokasi']) ?>"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Harga per Jam
                </label>

                <input
                    type="number"
                    name="harga"
                    class="form-control"
                    value="<?= htmlspecialchars($edit['harga']) ?>"
                    min="1"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Pengguna
                </label>

                <select
                    name="pengguna_id"
                    class="form-select"
                    required
                >

                    <?php while ($p = $pengguna->fetch_assoc()) : ?>

                        <option
                            value="<?= $p['id'] ?>"
                            <?= $p['id'] == $edit['pengguna_id'] ? 'selected' : '' ?>
                        >

                            <?= htmlspecialchars($p['nama']) ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>


            <button
                type="submit"
                name="update"
                class="btn btn-primary"
            >
                Simpan Perubahan
            </button>


            <a
                href="lapangan.php"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </form>


    <?php else : ?>

        <h2>Tambah Lapangan</h2>

        <form method="POST">


            <div class="mb-3">

                <label class="form-label">
                    Nama Lapangan
                </label>

                <input
                    type="text"
                    name="nama_lapangan"
                    class="form-control"
                    placeholder="Contoh: Lapangan A"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Jenis Olahraga
                </label>

                <input
                    type="text"
                    name="jenis_olahraga"
                    class="form-control"
                    placeholder="Contoh: Futsal"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Lokasi
                </label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    placeholder="Contoh: Denpasar"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Harga per Jam
                </label>

                <input
                    type="number"
                    name="harga"
                    class="form-control"
                    placeholder="Contoh: 100000"
                    min="1"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Pengguna
                </label>

                <select
                    name="pengguna_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        -- Pilih Pengguna --
                    </option>

                    <?php while ($p = $pengguna->fetch_assoc()) : ?>

                        <option value="<?= $p['id'] ?>">

                            <?= htmlspecialchars($p['nama']) ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>


            <button
                type="submit"
                name="tambah"
                class="btn btn-success"
            >
                Tambah Lapangan
            </button>

        </form>

    <?php endif; ?>


    <hr>


    <!-- =========================
         DAFTAR LAPANGAN
    ========================== -->

    <h2>Daftar Lapangan</h2>

    <div class="table-responsive">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Nama Lapangan</th>

                    <th>Jenis Olahraga</th>

                    <th>Lokasi</th>

                    <th>Harga</th>

                    <th>Pengguna</th>

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
                        <?= htmlspecialchars($row['nama_lapangan']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['jenis_olahraga']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['lokasi']) ?>
                    </td>

                    <td>
                        Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nama_pengguna']) ?>
                    </td>

                    <td>

                        <a
                            href="lapangan.php?edit=<?= $row['id'] ?>"
                            class="btn btn-warning btn-sm"
                        >
                            Edit
                        </a>


                        <a
                            href="lapangan.php?hapus=<?= $row['id'] ?>"
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

</div>

</body>

</html>