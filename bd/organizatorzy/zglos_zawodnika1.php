<?php session_start();
?>
<html lang="pl-PL">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="Stylesheet" type="text/css" href="style.css" />
<title>Zadanie zaliczeniowe BD</title>
</head>

<body>
<div id="top">

<div id="NAGLOWEK">
<h1 align = "center" style="color: #3b5998"> Zadanie zaliczeniowe na przedmiot Bazy danych </h1>
</div>

<div id="MENU">
<ul>
<li><a href="index.html">Strona główna</a></li>
<li><a href="podstrona1.html">Diagram ERD</a></li>
<li><a href="podstrona2.html">Skrypt SQL</a></li>
<li><a href="podstrona3.php">Aplikacja</a></li>
</ul>
</div>

<div id="TRESC">

<?php

if (empty($_POST['mecz_zawodnika']))
{
	echo '<p style="padding-top:10px;color:red" ;="">Nie został podny mecz, na który chcesz zgłosić zawodnika.<br><br><br>';
}

else
{

?>
Wybierz drużynę grającą we wskazanym meczu, której zawodnika chcesz zgłosić.
<br>
<br>
<form name="form-zglos-zawodnika1" action="zglos_zawodnika2.php" method="post"> 
<select name="druzyna_zawodnika">

<?php

$id_meczu = $_POST['mecz_zawodnika'];
$_SESSION['id_meczu_do_zgloszenia'] = $id_meczu;

$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
$query2 = "select * from druzyna where id_druzyny = (select druzyna1_id from mecz where id_meczu = '" . $id_meczu . "') or id_druzyny = (select druzyna2_id from mecz where id_meczu = '" . $id_meczu . "');";
$result2 = pg_query($link, $query2);
$numrows2 = pg_numrows($result2);

for($ri = 0; $ri < $numrows2; $ri++)
{
  $row = pg_fetch_array($result2, $ri);
  echo " <option value='". $row["id_druzyny"] ."'>" . $row["nazwa"] . " </option>\n";
}
?>

</select>
<br>
<br>
<input name="nowy_zawodnik_na_mecz_przycisk1" value="Zatwierdź" type="submit">
</form>
<br>
<br>


<?php

}    // zamknięcie else

?>

<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>



</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>