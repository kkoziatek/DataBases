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

<table>
<tr>
<td>Data</td>
<td>Drużyna 1</td>
<td>Drużyna 2</td>
<td>Wynik</td>
<td></td>

<form name="form-mecz-do-podejrzenia" action="podejrzyj_mecz.php" method="post">

<?php

$druzyna = $_POST['druzyna'];

$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
$query = "select id_meczu, data, d1.nazwa as druz1, d2.nazwa as druz2, wynik from mecz join druzyna d1 on druzyna1_id = d1.id_druzyny join druzyna d2 on druzyna2_id = d2.id_druzyny where druzyna1_id = '". $druzyna ."' or druzyna2_id = '". $druzyna ."';";
$result = pg_query($link, $query);
$numrows = pg_numrows($result);

for($ri = 0; $ri < $numrows; $ri++)
{
	$w1 = 0;
	$w2 = 0;
	
	$wypisz_jako_wynik = "";

	$row = pg_fetch_array($result, $ri);

	if(is_null($row["wynik"]))
	{
		$wypisz_jako_wynik = "brak wyniku";

	}
	else
	{
		$wynik = $row["wynik"];
		if($wynik > 0)
		{
			$w1 = $wynik - 1;
			$w2 = 3;
		}
		else
		{
			$w1 = 3;
			$w2 = -$wynik - 1;
		}
		$wypisz_jako_wynik = $w1 .' : '. $w2;
	}	
echo "<tr>
			<td>". $row["data"] ."</td>
			<td>". $row["druz1"] ."</td>
			<td>". $row["druz2"] ."</td>
			<td>". $wypisz_jako_wynik . "</td>
			<td><button type=\"submit\" name=\"jaki_id_meczu\" value='". $row["id_meczu"] ."'>Zobacz szczegóły</button></td>
</tr>";
}

//<td><input id='". $row["id_meczu"] ."' name=\"jaki_id_meczu\" value=\"Zobacz szczegóły\" type=\"submit\"></td>
?>
		</table>
<br>
<br>

	</form>
<br>
<br>

<a href="podstrona3.php">Wróć do aplikacji dla kibiców.</a>


</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>