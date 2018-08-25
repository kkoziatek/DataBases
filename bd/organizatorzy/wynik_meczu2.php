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

<form action="wyniki_meczu2.php" method="post">

<?php
$id_meczu = $_SESSION['id_meczu_do_wyniku'];
$liczba_setow = $_SESSION['liczba_setow'];

//sprawdzanie poprawności danych

$wynik1 = 0;
$wynik2 = 0;

$podwojne21 = 0;

$pozazakresem = 0;

$brak21 = 0;

$wczesniejsze_zwyciestwo = 0;

$brak_zwyciezcy = 0;


$wyn1 = $_POST['wynik1seta'];
$wyn2 = $_POST['wynik2seta'];

for($ri = 1; $ri <= $liczba_setow; $ri++)
{	

	if($wyn1[$ri] == $wyn2[$ri])
	{
		$podwojne21 = 1;
		break;
	}
	if(($wyn1[$ri] != 21) && ($wyn2[$ri] != 21))
	{
		$brak21 = 1;
		break;
	}

	if(($wyn1[$ri] > 21) || ($wyn1[$ri] < 0))
	{
		$pozazakresem = 1;
		break;
	}
	if(($wyn2[$ri] > 21) || ($wyn2[$ri] < 0))
	{
		$pozazakresem = 1;
		break;
	}
	
	if($wyn1[$ri] > $wyn2[$ri])
	{
		$wynik1++;
	}
	
	if($wyn1[$ri] < $wyn2[$ri])
	{
		$wynik2++;
	}
	
	if(($wynik1 == 3) && ($ri < $liczba_setow))
	{
		$wczesniejsze_zwyciestwo = 1;
		break;
	}

	if(($wynik2 == 3) && ($ri < $liczba_setow))
	{
		$wczesniejsze_zwyciestwo = 1;
		break;
	}
}

if($podwojne21)
{
	echo '<p style="padding-top:10px;color:red" ;="">Remis w przynajmniej jednym z setów.<br><br><br>';
}
elseif($pozazakresem)
{
	echo '<p style="padding-top:10px;color:red" ;="">Wynik poza zakresem w przynajmniej jednym z setów.<br><br><br>';
}
elseif($brak21)
{
	echo '<p style="padding-top:10px;color:red" ;="">Brak wyniku 21 w przynajmniej jednym z setów.<br><br><br>';
}
elseif($wczesniejsze_zwyciestwo)
{
	echo '<p style="padding-top:10px;color:red" ;="">Zwycięstwo nastąpi wcześniej niz podano.<br><br><br>';
}
elseif($wynik1 == $wynik2)
{
	$brak_zwyciezcy = 1;
	echo '<p style="padding-top:10px;color:red" ;="">Remis. Brak zwycięzcy<br><br><br>';
}

else
{
$wynik = 0;
if($wynik1 > $wynik2)
{
	$wynik = -$wynik2-1;
}
else
{
	$wynik = $wynik1+1;
}
	
	$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
	$query = 'update mecz set wynik = '. $wynik .' where id_meczu = '. $id_meczu .';';

	$result = pg_query($link, $query);
	$numrows = pg_numrows($result);
	
	for($ri = 1; $ri <= $liczba_setow; $ri++)
	{	
		$wyn_przegranych_w_secie = 0;
		
		if($wyn1[$ri] > $wyn2[$ri])
		{
			$wyn_przegranych_w_secie = -$wyn2[$ri]-1;
		}
		else
		{
			$wyn_przegranych_w_secie = $wyn1[$ri]+1;
		}
		$query2 = 'INSERT INTO Sety (id_meczu, nr_seta, wynik) VALUES ('. $id_meczu .', '. $ri .', '. $wyn_przegranych_w_secie . ');';
		$result2 = pg_query($link, $query2);
		$numrows2 = pg_numrows($result2);
	}
	echo '<p style="padding-top:10px;color:black" ;="">Dodano wyniki do meczu.<br><br><br>';
}

?>

<br>
<br>

<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>



</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>