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

<b>Składy w meczu.</b><br><br>


<?php

$jaki_id_meczu = $_POST['jaki_id_meczu'];

$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");

$query1 = "select * from druzyna where id_druzyny = (select druzyna1_id from mecz where id_meczu = '" . $jaki_id_meczu . "') ;";
$result1 = pg_query($link, $query1);
$numrows1 = pg_numrows($result1);

$query2 = "select * from druzyna where id_druzyny = (select druzyna2_id from mecz where id_meczu = '" . $jaki_id_meczu . "') ;";
$result2 = pg_query($link, $query2);
$numrows2 = pg_numrows($result2);

$row1 = pg_fetch_array($result1, 0);
$row2 = pg_fetch_array($result2, 0);

echo'<table>
<tr>
<td>'. $row1["nazwa"] .'</td>
<td>'. $row2["nazwa"] .'</td>
</tr>';

$id_druz1 = $row1["id_druzyny"];
$id_druz2 = $row2["id_druzyny"];


$query3 = "select imie, nazwisko from zawodnik z join wejscie_zawodnika wz on z.id_zawodnika = wz.id_zawodnika where id_meczu = '". $jaki_id_meczu ."' and z.id_druzyny = '". $id_druz1 ."';";
$result3 = pg_query($link, $query3);
$numrows3 = pg_numrows($result3);

$query4 = "select imie, nazwisko from zawodnik z join wejscie_zawodnika wz on z.id_zawodnika = wz.id_zawodnika where id_meczu = '". $jaki_id_meczu ."' and z.id_druzyny = '". $id_druz2 ."';";
$result4 = pg_query($link, $query4);
$numrows4 = pg_numrows($result4);


for($ri = 0; $ri < $numrows3 || $ri < $numrows4; $ri++)
{
	$row3 = pg_fetch_array($result3, $ri);
	$row4 = pg_fetch_array($result4, $ri);

	echo'<tr>
	<td>'. $row3["imie"] .' '. $row3["nazwisko"] .'</td>
	<td>'. $row4["imie"] .' '. $row4["nazwisko"] .'</td>
	</tr>';

}
  
?>
		</table>
<br>
<br>
<b>Wyniki setów.</b><br><br>

<?php

$query5 = "select * from sety where id_meczu = '". $jaki_id_meczu ."';";
$result5 = pg_query($link, $query5);
$numrows5 = pg_numrows($result5);

echo'<table>
<tr>
<td>Nr seta</td>
<td>'. $row1["nazwa"] .'</td>
<td>'. $row2["nazwa"] .'</td>
</tr>';

for($ri = 0; $ri < $numrows5; $ri++)
{
	$nr = $ri + 1;
	$row5 = pg_fetch_array($result5, $ri);
	
	$wypisz_jako_wynik1 = "";
	$wypisz_jako_wynik2 = "";

	if(is_null($row5["wynik"]))
	{
		$wypisz_jako_wynik1 = "brak wyniku";
		$wypisz_jako_wynik2 = "brak wyniku";

	}
	else
	{
		$wynik = $row5["wynik"];
		if($wynik > 0)
		{
			$w1 = $wynik - 1;
			$w2 = 21;
		}
		else
		{
			$w1 = 21;
			$w2 = -$wynik - 1;
		}
		$wypisz_jako_wynik1 = $w1;
		$wypisz_jako_wynik2 = $w2;
	}
	echo'<tr>
	<td>'. $nr .'</td>
	<td>'. $wypisz_jako_wynik1 .'</td>
	<td>'. $wypisz_jako_wynik2 .'</td>
	</tr>';

}

?>
	</table>

<br>
<br>

<a href="podstrona3.php">Wróć do aplikacji dla kibiców.</a>


</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>