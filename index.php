<?php
$db = new PDO(
    // parametry pripojeni
    "mysql:host=localhost;dbname=knihovna;charset=utf8",
    "root", // prihlasovaci jmeno
    "", // heslo
    array(
        // v pripade sql chyby chceme aby to vyhazovalo vyjimky
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ),
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Knihovna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Moje knihovna</h1>
<div class="container">
    <form action="hledat_knihy.php" method="get">
        <button name="hledat">Hledat</button>
    </form>	
    <form action="vkladani_knih.php" method="get">
        <button name="vlozit">Vložit</button>
    </form>
</div>
</body>
</html>