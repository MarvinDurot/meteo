
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Météo</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.min.css">
    <link rel="stylesheet" href="<?= HOME; ?>/public/css/all.css">

    <!--  Scripts-->
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.min.js"></script>
</head>
<body>
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="<?= HOME; ?>" class="brand-logo">Météo</a>
        <ul class="right hide-on-med-and-down">
            <li><a href="<?= HOME; ?>/api">API</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="<?= HOME; ?>/api">API</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>

<div class="container">
    <br/>
    <div class="section">
        <?= $content; ?>
    </div>
</div>

</body>
</html>
