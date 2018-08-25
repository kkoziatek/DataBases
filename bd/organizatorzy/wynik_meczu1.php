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

if (empty($_POST['mecz_do_wyniku']))
{
	echo '<p style="padding-top:10px;color:red" ;="">Nie został podany mecz, ktorego wynik chcesz dodać.<br><br><br>';
}

else{

$id_meczu = $_POST['mecz_do_wyniku'];
$_SESSION['id_meczu_do_wyniku'] = $id_meczu;
$_SESSION['liczba_setow'] = $_POST['liczba_setow'];

$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");

$query3 = "select * from mecz where id_meczu = '" . $id_meczu . "';";
$result3 = pg_query($link, $query3);
$numrows3 = pg_numrows($result3);

$row = pg_fetch_array($result3, 0);

$today = date("Y-m-d H:i:s");

if($today < $row["data"])
{
	echo '<p style="padding-top:10px;color:red" ;="">Ten mecz jeszcze się nie odbył.<br><br><br>';
}

elseif(isset($row["wynik"]))
{
	echo '<p style="padding-top:10px;color:red" ;="">Wynik tego meczu został już podany.<br><br><br>';
}

else
{

$query1 = "select * from druzyna where id_druzyny = (select druzyna1_id from mecz where id_meczu = '" . $id_meczu . "');";
$result1 = pg_query($link, $query1);
$numrows1 = pg_numrows($result1);

$query2 = "select * from druzyna where id_druzyny = (select druzyna2_id from mecz where id_meczu = '" . $id_meczu . "');";
$result2 = pg_query($link, $query2);
$numrows2 = pg_numrows($result2);

$query4 = "select * from druzyna where id_druzyny = (select druzyna1_id from mecz where id_meczu = '" . $id_meczu . "');";
$result4 = pg_query($link, $query4);
$numrows4 = pg_numrows($result4);

$query5 = "select * from druzyna where id_druzyny = (select druzyna2_id from mecz where id_meczu = '" . $id_meczu . "');";
$result5 = pg_query($link, $query5);
$numrows5 = pg_numrows($result5);

?>

Wpisz wyniki setów.
<br>
<br>
<form action="wynik_meczu2.php" method="post">

		<table>
<tr>
<td></td>

<?php


  $row = pg_fetch_array($result1, 0);
  echo "<td>" . $row["nazwa"] . " </td>\n";

  $row = pg_fetch_array($result2, 0);
  echo "<td>" . $row["nazwa"] . " </td>\n";

?>

</tr>

<?php
$liczba_setow = $_POST['liczba_setow'];

for($ri = 1; $ri <= $liczba_setow; $ri++)
{
  echo'<tr>
			<td>Set '.$ri.'.</td>
			<td><input type="number" min ="0" max="21" name="wynik1seta['.$ri.']" value="0"/></td>
			<td><input type="number" min ="0" max="21" name="wynik2seta['.$ri.']" value="0"/></td>
</tr>';
}
?>
		</table>
<br>
<br>

<input name="nowy_wynik_meczu_przycisk1" value="Zatwierdź" type="submit">

	</form>
<br>
<br>

<?php

}  // zamknięcie else
} // zamknięcie else

?>
<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>



</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>