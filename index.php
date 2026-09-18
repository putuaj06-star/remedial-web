<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Lapangan Olahraga</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container mt-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            Sistem Manajemen Lapangan Olahraga
        </h1>

        <p class="text-muted">
            Kelola data pengguna dan lapangan olahraga dengan mudah.
        </p>

    </div>


    <!-- Menu -->
    <div class="row justify-content-center g-4">

        <!-- Pengguna -->
        <div class="col-md-5">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center p-4">

                    <h2 class="card-title">
                        Data Pengguna
                    </h2>

                    <p class="card-text text-muted">
                        Kelola data pengguna seperti nama, email,
                        dan password.
                    </p>

                    <a
                        href="pengguna.php"
                        class="btn btn-primary"
                    >
                        Kelola Pengguna
                    </a>

                </div>

            </div>

        </div>

        <!-- Lapangan -->
        <div class="col-md-5">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center p-4">

                    <h2 class="card-title">
                        Data Lapangan
                    </h2>

                    <p class="card-text text-muted">
                        Kelola nama lapangan, jenis olahraga,
                        lokasi, harga, dan pengguna.
                    </p>

                    <a
                        href="lapangan.php"
                        class="btn btn-success"
                    >
                        Kelola Lapangan
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Footer -->
    <div class="text-center mt-5">

        <p class="text-muted">
            Sistem Manajemen Lapangan Olahraga
        </p>

    </div>

</div>

</body>

</html>