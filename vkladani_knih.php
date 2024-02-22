<?php
session_start();
$db = new PDO(
	//parametry připojení
	"mysql:host=localhost;dbname=knihovna;charset=utf8",
	"root", //přihlašovací jméno
	"", //heslo
	array(
		//v případě sql chyby chceme vyhazovat výjimky
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	),
);
$chyba = "";
// zpracovani prihl. formulare
if (array_key_exists("prihlasit", $_POST))
{
    $jmeno = $_POST["jmeno"];
    $heslo = $_POST["heslo"];

    if ($jmeno == "Katka" && $heslo == "Chibi202104Katka")
    {
        // uzivatel. zadal platne prihlasovaci udaje
        $_SESSION["prihlasenyUzivatel"] = $jmeno;
    }
    else
    {
        // spatne prihlasovaci udaje
        $chyba = "Nesprávné přihlašovací údaje";
    }
}

// zpracování odhl. formuláře
if (array_key_exists("odhlasit", $_POST))
{
    unset($_SESSION["prihlasenyUzivatel"]);
    header("Location: ?");
}

$chyby = [];
$nazev = "";
$autorJmeno = "";
$autorPrijmeni= "";
$zanr = "";
$popis = "";
$umisteni = "";
$ulozeno = false;
$zanrId = "";
$mistoId = "";
// zpracovani ukladaciho formulare
if (array_key_exists("ulozit", $_POST))
{
    //var_dump($_POST);
    $nazev = $_POST["nazev"];
    $spisovatel_jmeno = $_POST["spisovatel_jmeno"];
    $spisovatel_prijmeni = $_POST["spisovatel_prijmeni"];
    $zanr = $_POST["zanr"];
    $popis = $_POST["popis"];
	$umisteni = $_POST["umisteni_id"];

    // validace
    // nazev
    if ($nazev == "")
    {
        $chyby["nazev"] = "Musí být vyplněno";
    }
    // jmeno autora
    if ($spisovatel_jmeno == "")
    {
        $chyby["spisovatel_jmeno"] = "Musí být vyplněno";
    }
    // prijmeni autora
    if ($spisovatel_prijmeni == "")
    {
        $chyby["spisovatel_prijmeni"] = "Musí být vyplněno";
    }
    // zanr
    if ($zanr == "")
    {
        $chyby["zanr"] = "Musí být vyplněno";
    }
    // popis
    if ($popis == "")
    {
        $chyby["popis"] = "Musí být vyplněno";
    }
	// umisteni
    if ($umisteni == "")
    {
        $chyby["umisteni_id"] = "Musí být vyplněno";
    }
    //var_dump($chyby);

    // zkontrolujeme zda-li zadna chyba nenastala
    if (count($chyby) == 0)
    {
        // vse je ok
        $ulozeno = true;

        // vlozime produkt do databaze
        $dotaz = $db->prepare("INSERT INTO knihy SET nazev = ?, spisovatel_jmeno = ?, spisovatel_prijmeni = ?, zanr_id = ?, popis = ?, umisteni_id = ?");
        $dotaz->execute([$nazev, $spisovatel_jmeno, $spisovatel_prijmeni, $zanr, $popis, $umisteni]);
        // zjistime id ulozeneho produktu
        $idProdukt = $db->lastInsertId();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Knihovna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Moje knihovna</h1>
	<div class="admin-body">
        <?php
        if (array_key_exists("prihlasenyUzivatel", $_SESSION) == false)
        {
            // sekce pro neprihlasene uzivatele
            ?>
            <main class="form-signin">
                <form method="post">
                    <h1 class="h3 mb-3 fw-normal">Přihlašte se prosím</h1>

                    <?php if ($chyba != "") { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $chyba; ?>
                        </div>
                    <?php } ?>

                    <div class="form-floating">
                        <input name="jmeno" type="text" class="form-control" id="floatingInput" placeholder="login">
                        <label for="floatingInput">Přihlašovací jméno</label>
                    </div>
                    <div class="form-floating">
                        <input name="heslo" type="password" class="form-control" id="floatingPassword" placeholder="heslo">
                        <label for="floatingPassword">Heslo</label>
                    </div>

                    <button name="prihlasit" class="w-100 btn btn-lg btn-primary" type="submit">Přihlásit</button>
                </form>
            </main>

            <?php
        }
        else
        {
            // sekce pro prihlasene uzivatele
            echo "<main class='admin'>";

            ?>
            <div class="container">
                <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                    <div>Přihlášený uživatel: <?php echo $_SESSION["prihlasenyUzivatel"]; ?></div>

                    <div class="col-md-3 text-end">
                        <form method='post'>
                            <button name='odhlasit' class="btn btn-outline-primary me-2">Odhlásit</button>
                        </form>
                    </div>
                </header>
    </div>
<?php
		}
?>
<?php
if (array_key_exists("prihlasenyUzivatel", $_SESSION))
{?>  
    <table>
	    <form method="post">
		<tr>
            <th><label for="nazev">Název knihy</label></th>
		    <td><input type="text" name="nazev"></td></tr> <br>
        <tr>
		    <th><label for="spisovatel_jmeno">Jméno autora</label></th>
            <td><input type="text" name="spisovatel_jmeno"></td></tr><br>
        <tr>
		    <th><label for="spisovatel_prijmeni">Příjmení autora</label></th>
		    <td><input type="text" name="spisovatel_prijmeni"></td></tr><br>
	    <tr>
		    <th><label for="zanr">Žánr</label></th>
		    <td><select name="zanr" id="zanr" multiple>
		<option value=""></option>
		<?php
            $dotaz = $db->prepare("SELECT id, druh FROM zanr ORDER BY druh");
            $dotaz->execute();
            $seznamZanru = $dotaz->fetchAll();
            foreach ($seznamZanru as $zanr)
            	{
                $selected = "";
                if ($zanr['id'] == $zanrId)
                    {
                    	$selected = "selected";
                    }
                    echo "<option value='{$zanr['id']}' $selected>{$zanr['druh']}</option>";
                    }
        ?>
		</select></td></tr>
        <tr>
	        <th><label for="popis">Popis knihy</label></th>
	        <td><textarea name="popis" id="popis" cols="30" rows="10"></textarea></td></tr> <br>
        <tr>
	        <th><label for="umisteni_id">Místo uložení</label></th>
	        <td><select name="umisteni_id" id="umisteni_id">
		<option value="">Vyberte</option>
		<?php
            $dotaz = $db->prepare("SELECT id, misto FROM umisteni ORDER BY misto");
            $dotaz->execute();
            $seznamMist = $dotaz->fetchAll();
            foreach ($seznamMist as $misto)
            	{
                $selected = "";
                if ($misto['id'] == $mistoId)
                    {
                    	$selected = "selected";
                    }
                    echo "<option value='{$misto['id']}' $selected>{$misto['misto']}</option>";
                    }
		?>
<?php	
}
?>
	</select></td></tr> <br>
	<tr><td><button name="ulozit">Uložit</button></td></tr>
        </table>
	</form>
    <?php
    if (array_key_exists("ulozit", $_POST))
    {
     echo "<h1>Kniha byla vložena do knihovny</h1>";
    }
     ?>
</body>
</html>