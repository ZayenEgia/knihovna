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
$vysledek = "";
$umisteni = "";
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
	<table>
	<form action="" method="post">

	<tr><th><label for="umisteni_id">Místo uložení</label></th>
		<td><select name="umisteni_id" id="umisteni_id">
		<option value="">Vyberte</option>
		<?php
            $dotaz = $db->prepare("SELECT id, misto FROM umisteni ORDER BY misto");
            $dotaz->execute();
            $seznamMist = $dotaz->fetchAll();
            foreach ($seznamMist as $misto)
            	{
                $selected = "";
                if ($misto['id'] == $umisteni)
                    {
                    	$selected = "selected";
                    }
                    echo "<option value='{$misto['id']}' $selected>{$misto['misto']}</option>";
                    }
		?>

	</select></td></tr> <br>
	<tr><td><button name="hledat">Hledat</button></td></tr>
	
	</form></table>
</div>
<?php	
	if (array_key_exists("hledat", $_POST))
{
	$umisteni = $_POST["umisteni_id"];

	$dotaz = $db->prepare("SELECT knihy.*, umisteni.misto as umisteni FROM knihy
	JOIN umisteni ON umisteni.id = umisteni_id
	WHERE umisteni.id = ?");
	$dotaz->execute([$umisteni]);
	$vysledky = $dotaz->fetchAll();
	//var_dump($vysledek);
	foreach ($vysledky as $vysledek)
	{
		echo "<h1>{$vysledek['nazev']}</h1>";
		echo "<b>Jméno autora:</b> {$vysledek[2]} <br>
		<b>Příjmení autora:</b> {$vysledek[3]} <br>
		<b>Žánr:</b> {$vysledek[4]} <br>
		<b>Popis knihy:</b> {$vysledek[5]} <br>
		<b>Místo uložení:</b> {$vysledek[7]}";
	}
}
?>
</body>
</html>