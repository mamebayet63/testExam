<?php
require_once "../bd.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../testConnexion/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

$searchTerm = '';
$searchResults = [];

if ($pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM abonne WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $searchStmt = $pdo->prepare("SELECT * FROM livre WHERE titre LIKE :searchTerm");
            $searchStmt->execute([':searchTerm' => '%' . $searchTerm . '%']);
            $searchResults = $searchStmt->fetchAll();
        } else {
            $popularBooksStmt = $pdo->query("SELECT * FROM livre ORDER BY popularite DESC LIMIT 5");
            $popularBooks = $popularBooksStmt->fetchAll();

            $newBooksStmt = $pdo->query("SELECT * FROM livre ORDER BY date_ajout DESC LIMIT 5");
            $newBooks = $newBooksStmt->fetchAll();

            $categoriesStmt = $pdo->query("SELECT * FROM categorie");
            $categories = $categoriesStmt->fetchAll();
        }
    } catch (PDOException $e) {
        echo "Requête échouée: " . $e->getMessage();
    }
} else {
    echo "Impossible d'exécuter la requête.";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>A propos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link rel="stylesheet" href="indexT.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
      @import url("https://fonts.googleapis.com/css2?family=Itim&display=swap");
      :root {
        --btn-color: #f2e416;
      }
    </style>
    <link
      href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css"
      rel="stylesheet"
    />
  </head>

  <body style="font-family: Poppins, sans-serif">
  <div class="container-fluid">
    <div class="row">
    <header class="sticky-top bg-white">
      <div class="row d-flex justify-content-between align-items-center mt-2">
          <div class="col-4">
              <ul>
                  <a href="index3.php" class="text-decoration-none text-black"><li class="mx-3">Accueil</li></a>
                  <a href="MesLivres.php" class="text-decoration-none  text-black"><li class="mx-3">Livres</li></a>
                  <a href="propos.php" class="text-decoration-none text-black"><li class="mx-3">Qui sommes nous</li></a>
              </ul>
          </div>
          <div class="col-1">
              <img src="image/1-removebg-preview.png" alt="" class="w-75 h-75">
          </div>
          <div class="col-3">
              <form class="d-flex" method="GET" action="">
                  <input class="form-control me-2 monSearch" type="search" name="search" placeholder="Recherche par titre" aria-label="Search" value="<?= htmlspecialchars($searchTerm) ?>">
                  <button class="monSearch bg-primary text-white" type="submit"><i class="ri-search-2-line"></i></button>
              </form>
          </div>
          <div class="col-1">
              <a href="profil.php"><img src="image/<?= $user['profil'] ?>" alt=""></a>
          </div>
      </div>
      <div class="row d-flex">
          <hr>
      </div>
  </header>
    </div>
  </div>

    <main>
      <div class="container-fluid">
        <div class="row">
          <div class="">
            <div id="carouselExampleDark" class="carousel carousel-dark slide">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                  <img src="image/Group 16.svg" class="d-block h-100 w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                  </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                  <img src="image/bibio.svg" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                  </div>
                </div>
               
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="container" style="margin-top: 90px">
        <div class="row">
          <div class="col-12">
            <img src="../assets/ligne.svg" alt="" />
            <h1 style="margin-top: -50px">Qui sommes-nous ?</h1>
          </div>
          <div class="col-12 mt-5">
            <p class="">
              Depuis notre fondation en 2020,
              <span
                class="fw-bold"
                style="color: var(--btn-color); text-transform: uppercase"
                >Bibliothéque</span
              >
              Ce projet a été développé dans le cadre du cursus de Licence 1
               en Développement Web et Gestion de Projets à l'École Supérieure 221.
                L'objectif principal de ce projet est de créer une application efficace 
                pour gérer les livres, les abonnés et les emprunts au sein d'une bibliothèque.
                'application permet aux utilisateurs de gérer leurs emprunts de manière intuitive, 
                de consulter les livres disponibles, et d'avoir un aperçu clair de leurs activités 
                de prêt. Grâce à une interface moderne et responsive, elle offre une expérience
                 utilisateur fluide et agréable sur tous les types d'écrans.
            </p>
          </div>
        </div>
      </div>
      <div class="container" style="margin-top: 120px">
        <div class="row">
          <div class="col-12">
            <img src="../assets/ligne.svg" alt="" />
            <h1 style="margin-top: -50px">Notre missions</h1>
          </div>
        </div>
      </div>
      <div class="container" style="margin-top: 100px">
        <div class="row d-flex justify-content-center">
          <div class="col-12 col-sm-6 col-lg-4 shadow-sm p-3">
            <p class="fs-5 fw-bold">Promotion de lecture</p>
            <span>
            La promotion de la lecture est au cœur de notre mission. 
            Nous croyons fermement que la lecture est un moyen essentiel
             d'enrichir les connaissances, d'élargir les horizons et 
             d'améliorer la qualité de vie. À travers notre application 
             de gestion de bibliothèque en ligne, nous visons à encourager
              et faciliter l'accès à la lecture pour tous.
            </span>
          </div>
          <div class="col-12 col-sm-6 col-lg-4 shadow-sm p-3">
            <p class="fs-5 fw-bold">Soutien au Développement</p>
            <span>
            Le soutien au développement est essentiel 
            pour garantir la réussite et la pérennité de 
            notre projet de gestion de bibliothèque en ligne. 
            Nous nous engageons à fournir des ressources et un 
            accompagnement continu pour assurer le bon fonctionnement 
            et l'amélioration continue de l'application.
            </span>
          </div>
          <div class="col-12 col-sm-6 col-lg-4 shadow-sm p-3">
            <p class="fs-5 fw-bold">Sensibilisation et Éducation</p>
            <span>
            La sensibilisation et l'éducation jouent un rôle crucial 
            dans notre mission pour promouvoir la lecture et maximiser 
            les bénéfices de l'application de gestion de bibliothèque 
            en ligne. Nous cherchons à encourager une culture de la lecture 
            et à fournir des outils éducatifs qui enrichissent les connaissances 
            et soutiennent le développement personnel.
            </span>
          </div>
          <div class="col-12 col-sm-6 col-lg-4 shadow-sm p-3 mt-4">
            <p class="fs-5 fw-bold">Création d'Opportunités de Marché</p>
            <span>
            La création d'opportunités de marché est un aspect fondamental 
            de notre projet de gestion de bibliothèque en ligne.
             En développant une solution adaptée aux besoins des
              bibliothèques et des utilisateurs, nous visons à ouvrir 
              de nouvelles avenues pour la croissance et l'innovation 
              dans le secteur de la gestion des bibliothèques et de la lecture.
            </span>
          </div>
          <div class="col-12 col-sm-6 col-lg-4 shadow-sm p-3 mt-4">
            <p class="fs-5 fw-bold">Renforcement de la Communauté</p>
            <span>
            Le renforcement de la communauté est 
            un élément clé pour assurer le succès et 
            l'impact durable de notre application de
             gestion de bibliothèque en ligne.
              Nous visons à créer un environnement 
              interactif et engageant où les utilisateurs, 
              les bibliothécaires, et les passionnés de lecture 
              peuvent se connecter, partager et collaborer.
            </span>
          </div>
        </div>
      </div>
      <div style="background-color: #262626; margin-top: 150px">
        <div class="container py-5">
          <div class="row">
            <div class="col-12">
              <h2 class="text-white">Notre equipe</h2>
              <div
                style="width: 10%; height: 2px; background-color: white"
              ></div>
              <div>
                <p class="text-white mt-5">
                Notre équipe est composée de professionnels 
                passionnés et expérimentés dans le domaine 
                du développement web, de la gestion de projets 
                et de la promotion de la lecture. Chacun apporte
                 une expertise unique pour garantir le succès de 
                 notre application de gestion de bibliothèque en ligne.
                </p>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      
      <div class="container" style="margin-top: 90px">
        <div class="row">
          <div class="col-12">
            <h3 class="text-center">
              Pour plus d'information,Démarrer un chat
            </h3>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-12 d-flex justify-content-center">
            <button
              data-bs-toggle="modal"
              data-bs-target="#exampleModal"
              class="btn"
              style="background-color: var(--btn-color); rotate: 5deg"
            >
              Démarrerz une discussion <i class="ri-wechat-fill fs-3"></i>
            </button>
          </div>
        </div>
        <div
          class="modal fade"
          id="exampleModal"
          tabindex="-1"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                  New message
                </h1>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"
                      >Recipient:</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="recipient-name"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label"
                      >Message:</label
                    >
                    <textarea class="form-control" id="message-text"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                >
                  Close
                </button>
                <button type="button" class="btn btn-primary">
                  Send message
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Bibliothèque. Tous droits réservés.</p>
            <p>Suivez-nous sur les réseaux sociaux :</p>
            <div class="d-flex justify-content-center">
                <a href="#" class="text-white mx-2"><i class="ri-facebook-fill"></i></a>
                <a href="#" class="text-white mx-2"><i class="ri-twitter-fill"></i></a>
                <a href="#" class="text-white mx-2"><i class="ri-instagram-fill"></i></a>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="
    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
    "></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script src="../script/propos.js"></script>
  </body>
</html>
