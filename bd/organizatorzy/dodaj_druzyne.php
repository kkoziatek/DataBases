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

if (empty($_POST['druzyna']))
{
	echo '<p style="padding-top:10px;color:red" ;="">Nie podano nazwy drużyny.<br><br><br>';
	echo '<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>';
}


else
{
	$druzyna = $_POST['druzyna'];

	$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
	$query = "INSERT INTO Druzyna (nazwa) VALUES ('". pg_escape_string($druzyna) ."');";
	$result = pg_query($link, $query);
	$numrows = pg_numrows($result);

	echo '<p style="padding-top:10px;color:red" ;="">Dodano drużynę o nazwie "'. $druzyna .'".<br><br><br>';
	echo '<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>';
}


?>

</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>