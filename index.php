<?php
session_start();
include 'db_conn.php';

if (isset($_SESSION['user'])) {
    $_admin_status = $_SESSION['user']['admin_access'];

    if ($_admin_status == 1) {
        header('location: admin.php');
    } else {
        header('location: home.php');
    }
    exit();
}

$stmt = $pdo->query("SELECT * FROM game");
$stmt1 = $pdo->query("WITH ItemSales AS (
    SELECT
        i.game_id,
        g.game_name,
        g.logo,
        SUM(COUNT(i.item_id)) OVER (PARTITION BY i.game_id) AS jumlah_penjualan,
        RANK() OVER (ORDER BY COUNT(i.item_id) DESC) AS sales_rank
    FROM
        item i
        JOIN invoice inv ON i.item_id = inv.item_id
        JOIN game g ON g.game_id = i.game_id
    GROUP BY
        i.game_id, g.game_name, g.logo
)
SELECT
    game_name,
    game_id,
    logo,
    jumlah_penjualan
FROM
    ItemSales
WHERE
    sales_rank <= 4;");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Topup Game - PAY2WIN</title>
    <link rel="icon" href="assets\Web Logo\pay-2-win-logo.png" />
    
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>

.carousel-inner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        opacity: 0;
    }

    .animate {
        animation: fadeIn 0.8s ease-out;
        animation-fill-mode: forwards;
    }
    
    #carouselExampleIndicators {
        border-radius: 1rem;
        overflow: hidden;
    }
    </style>
</head>

<body class="body">

    <div class="blob-c">
        <div class="shape-blob one"></div>
        <div class="shape-blob two"></div>
        <div class="shape-blob three"></div>
        <div class="shape-blob four"></div>
        <div class="shape-blob five"></div>
        <div class="shape-blob six"></div>
    </div>

    <!-- Navigation -->
    <nav class="py-4 navbar navbar-expand-lg navbar-dark fixed-top"
        style="background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
        <div class="container px-4 px-lg-5 text-white">
            <a class="navbar-brand" style="height: 52px;" href="index.php">
                <img src="assets\Web Logo\pay-2-win-full.png" alt="PAY2WIN Logo" class="img-fluid"
                    style="max-height: 50px;margin-top: -2px;height: 100%;object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 align-items-center">
                    <li class="nav-item me-4"><a class="nav-link active" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item me-4"><a class="nav-link" href="about.php">ABOUT</a></li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-4">
                        <a href="login.php" class="nav-link">
                            <button class="btn btn-outline-light" type="submit">Login</button>
                        </a>
                    </li>
                    <li class="nav-item me-4">
                        <a href="signup.php" class="nav-link">
                            <button class="btn btn-outline-light" type="submit">Sign up</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header-->
    <header class="py-3">
    <div class="container d-flex justify-content-center" style="margin-top: 150px !important; margin-bottom: 40px !important;">
        <div id="carouselExampleIndicators" class="carousel slide" style="width: 1000px; height: 350px;">
            <div class="carousel-indicators" style="z-index: 1;">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                    class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" style="border-radius: 1rem;">
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="assets/banner2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="assets/banner1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="assets/banner3.jpeg" class="d-block w-100" alt="...">
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
    <section class="py-5">
        <h1 class="text-center text-white">Produk Terbaru</h1>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- LOOPING UNTUK LOAD IMAGE DARI DATABASE game -->
                <?php
                foreach ($rows as $row) {
                    $id = $row["game_id"];
                    echo "
                    <div class='col mb-5'>
                    <div class='card border-black text-white mb-3 h-80' style='border-radius: 1rem;background-color: rgb(0, 0, 0, 0.6) !important'>
                    <img class='card-img-top' style='border-radius: 1rem;' src='" . $row['logo'] . "' alt='...' />
                    <div class='card-body p-4'>
                    <div class='text-center'><h5 class='fw-bolder'>" . $row['game_name'] . "</h5></div>
                    </div>
                    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                    <div class='text-center'><a href='details.php?id=$id'><button class='btn btn-outline-light stretched-link' type='submit'>Learn More</button></a></div>
                    </div></div></div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Paling Laris -->
    <section class="py-5">
        <h1 class="text-center text-white">Paling Laris</h1>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- Looping to load images and game names from the database -->
                <?php
                foreach ($rows1 as $row1) {
                    $id = $row1["game_id"];
                    echo "<div class='col mb-5'>
                    <div class='card border-black text-white mb-3 h-80' style='border-radius: 1rem;background-color: rgb(0, 0, 0, 0.6) !important'>
                    <img class='card-img-top' style='border-radius: 1rem;' src='" . $row1['logo'] . "' alt='...' />
                    <div class='card-body p-4'>
                    <div class='text-center'><h5 class='fw-bolder'>" . $row1['game_name'] . "</h5></div>
                    </div>
                    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                    <div class='text-center'><a href='details.php?id=$id'><button class='btn btn-outline-light  stretched-link' type='submit'>Learn More</button></a></div>
                    </div></div></div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!--Script Animation Card-->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                root: null,
                rootMargin: "0px",
                threshold: 0.5
            };

            var observer = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("animate");
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            var elements = document.querySelectorAll(".card");

            elements.forEach(function (element) {
                observer.observe(element);
            });
        });
    </script>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script auto next script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var carousel = document.getElementById('carouselExampleIndicators');
            var carouselInstance = new bootstrap.Carousel(carousel, {
                interval: false
            });

            function nextSlide() {
                carouselInstance.next();
            }

            setInterval(nextSlide, 2500);
        });
    </script>
</body>

<!-- Footer-->
<footer class="py-5 bg-dark" style="background-color: rgb(0, 0, 0, 0.6) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>

</html>
