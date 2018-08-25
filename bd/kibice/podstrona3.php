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

<hr>
<b>Zobacz wszystkie mecze.</b><br><br>
<form name="form-wszystkie-mecze" action="wszystkie_mecze.php" method="post">
          <input name="pokaz_wszystkie_mecze" value="Wyświetl" type="submit">
</form>
<hr>

<b>Zobacz mecze konkretnej drużyny.</b><br><br>

<?php
$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
$query2 = "SELECT * FROM druzyna;";
$result2 = pg_query($link, $query2);
$numrows2 = pg_numrows($result2);
?>

<form name="form-mecze-druzyny" action="mecze_druzyny.php" method="post">
          Wybierz drużynę:

<select name="druzyna">

<?php
for($ri = 0; $ri < $numrows2; $ri++)
{
  $row = pg_fetch_array($result2, $ri);
  echo " <option value='". $row["id_druzyny"] ."'>" . $row["nazwa"] . "</option>\n";
}
?>

</select>
<br>
<br>
<input name="pokaz_mecze_druzyny_przycisk" value="Wyświetl" type="submit">
</form>
<hr>

<b>Zobacz mecze konkretnego zawodnika.</b><br><br>

<?php
$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
$query3 = "SELECT * FROM zawodnik;";
$result3 = pg_query($link, $query3);
$numrows3 = pg_numrows($result3);
?>

<form name="form-mecze-druzyny" action="mecze_zawodnika.php" method="post">
          Wybierz zawodnika:

<select name="zawodnik">

<?php
for($ri = 0; $ri < $numrows3; $ri++)
{
  $row = pg_fetch_array($result3, $ri);
  echo " <option value='". $row["id_zawodnika"] ."'>" . $row["imie"] . " " . $row["nazwisko"] . "</option>\n";
}
?>

</select>
<br>
<br>
<input name="pokaz_mecze_zawodnika_przycisk" value="Wyświetl" type="submit">
</form>
<hr>

<br>
<br>
<a href="podstrona4.php">Przejdź do aplikacji dla organizatorów.</a>
</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>