<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Mes annonces</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/annonces">Liste des annonces</a>
                    </li>
                    <?php if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/index">Administration</a>
                    </li>
                    <?php endif; ?>

                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/annonces/ajouter">Créer une annonce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/logout">Déconnexion</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/login">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/register">Inscription</a>
                    </li>
                    <?php endif; ?>


                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['message']; unset($_SESSION['message']);?>
        </div>
        <?php endif; ?>
        <?php if(!empty($_SESSION['erreur'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['erreur']; unset($_SESSION['erreur']);?>
        </div>
        <?php endif; ?>
        <?= $contenu ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="/js/script.js"></script>
</body>

</html>