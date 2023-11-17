<?php
session_start();
include 'db_conn.php';
$stmt = $pdo->query("SELECT * FROM game");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Topup Game - Proyek Tekweb</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="bg-dark">

    <!-- Navigation -->
    <nav class="py-4 navbar navbar-expand-lg navbar-dark bg-dark fixed-top"
        style="background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
        <div class="container px-4 px-lg-5 text-white">
            <a class="navbar-brand" href="index.php">
                <h3>PAY2WIN</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item me-4"><a class="nav-link active" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item me-4"><a class="nav-link" href="about.php">ABOUT</a></li>
                </ul>
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-3"><a href="login.php" class="nav-link"><button class="btn btn-outline-light"
                                type="submit">Login</button></a></li>
                    <li class="nav-item"><a href="signup.php" class="nav-link"><button class="btn btn-outline-light"
                                type="submit">Sign up</button></a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5" style="margin-top: 150px !important; margin-bottom: 40px !important;">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="3000">
                        <img src="assets/coc_home.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="assets/hsr_banner.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Game Terbaru-->
    <section class="bg-dark py-5">
        <h1 class="text-center text-white">Produk Terbaru</h1>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- LOOPING UNTUK LOAD IMAGE DARI DATABASE game -->
                <?php
                foreach ($rows as $row) {
                    $id = $row["game_id"];
                    echo "<div class='col mb-5' data-aos='fade-up'>";
                    echo "<div class='card text-white bg-dark mb-3 h-80' style='background-color: rgb(10, 10, 12, 0.4) !important'>";
                    echo "<img class='card-img-top' src='" . $row['logo'] . "' alt='...' />";
                    echo "<div class='card-body p-4'>";
                    echo "<div class='text-center'><h5 class='fw-bolder'>" . $row['game_name'] . "</h5></div>";
                    echo "</div>";
                    echo "<div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>";
                    echo "<div class='text-center'><a href='details.php?id=$id'><button class='btn btn-outline-light' type='submit'>Learn More</button></a></div>";
                    echo "</div></div></div>";
                }
                ?>
            </div>
        </div>
    </section>

</body>

<!-- Footer-->
<footer class="py-5 bg-dark" style="background-color: rgb(10, 10, 12) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>

</html>
