<html>
<head>

</head>
<body>
    <div class="header">
        <h1>Moje notatki</h1>
    </div>
    <div class="container">
        <div class="menu">
            <ul>
                <li>
                    <a href="/">Lista notatek</a>
                </li>
                <li>
                    <a href="/?action=create">Nowa notatka</a>
                </li>
            </ul>
        </div>
        <div>
            <?php
            if ($page === 'create'){
                include_once ('templates/Pages/create.php');
            } else {
                include_once ('templates/Pages/list.php');
            }
            ?>
        </div>
        <div class="footer">

        </div>
</body>
</html>