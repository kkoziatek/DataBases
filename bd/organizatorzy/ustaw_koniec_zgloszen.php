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

$today = date("Y-m-d H:i:s");

if (empty($_POST['nowa_data_konca_zgloszen']))
{
	echo '<p style="padding-top:10px;color:red" ;="">Nie podano daty.<br><br><br>';
}

elseif($today > $_POST['nowa_data_konca_zgloszen'])
{
	echo '<p style="padding-top:10px;color:red" ;="">Podano datę z przeszłości.<br><br><br>';
}

else
{
	$nowa_data = $_POST['nowa_data_konca_zgloszen'];

	$fname = "koniec_zgloszen.txt";
	/*$fhandle = fopen($fname,"r");
	$content = fread($fhandle,filesize($fname));

	$content = str_replace("oldword", "newword", $content);*/

	$fhandle = fopen($fname,"w");
	fwrite($fhandle,$nowa_data);
	fclose($fhandle);

	echo '<p style="padding-top:10px;color:red" ;="">Zmieniono datę na '. $nowa_data .'.<br><br><br>';
}

echo '<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>';


?>

</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>