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

if (empty($_POST['data_mowego_meczu']))
{
	echo '<p style="padding-top:10px;color:red" ;="">Nie została podana data meczu.<br><br><br>';
}

elseif (empty($_POST['druzyna1']) || empty($_POST['druzyna2']))
{
	echo '<p style="padding-top:10px;color:red" ;="">Nie zostały podane drużyny.<br><br><br>';
}

elseif($today > $_POST['data_mowego_meczu'])
{
	echo '<p style="padding-top:10px;color:red" ;="">Podano datę meczu z przeszłości.<br><br><br>';
}

elseif($_POST['druzyna1'] == $_POST['druzyna2'])
{
	echo '<p style="padding-top:10px;color:red" ;="">Wprowadzono nieprawidłowe dane. Obie drużyny są takie same.<br><br><br>';
}

else
{
	$data_mowego_meczu = $_POST['data_mowego_meczu'];
	$druzyna1 = $_POST['druzyna1'];
	$druzyna2 = $_POST['druzyna2'];

	$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
	$query = "INSERT INTO Mecz (data, druzyna1_id, druzyna2_id) VALUES ('". pg_escape_string($data_mowego_meczu) ."', '". pg_escape_string($druzyna1) ."', '". pg_escape_string($druzyna2) ."');";
	$result = pg_query($link, $query);
	$numrows = pg_numrows($result);

	echo '<p style="padding-top:10px;color:black" ;="">Pomyślnie dodano mecz.<br><br><br>';
}

?>

<a href="podstrona4.php">Wróć do aplikacji dla organizatorów.</a>


</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>