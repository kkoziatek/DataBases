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


</select>

Wybierz zawodnika ze wskazanej na poprzedniej stronie drużyny, którego chcesz zgłosić na wybrany mecz:
<br>
<br>
<form name="form-zglos-zawodnika2" action="zglos_zawodnika3.php" method="post">
<select name="zawodnik_na_mecz">

<?php

$druzyna_zawodnika = $_POST['druzyna_zawodnika'];

$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
$query = "select * from zawodnik where id_druzyny = '" . $druzyna_zawodnika . "';";
$result = pg_query($link, $query);
$numrows = pg_numrows($result);

for($ri = 0; $ri < $numrows; $ri++)
{
  $row = pg_fetch_array($result, $ri);
  echo " <option value='". $row["id_zawodnika"] ."'>" . $row["imie"] . " " . $row["nazwisko"] . "</option>\n";
}

pg_close($link); // zamknąłem połączenie z bazą
?>

</select>
<br>
<br>
<input name="nowy_zawodnik_na_mecz_przycisk1" value="Zatwierdź" type="submit">
</form>
<br>
<br>

<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>


</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>