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

    /* jeżeli nie wypełniono formularza - to znaczy nie istnieje zmienna login, hasło i sesja auth
     * to wyświetl formularz logowania
     */
if (!isset($_POST['login']) && !isset($_POST['password']) && $_SESSION['auth'] == FALSE) {
?>


<form name="form-logowanie" action="podstrona4.php" method="post">
          Login: <input name="login" type="text"><br>
	  <br>
          Hasło: <input name="password" type="password">
          <input name="zaloguj" value="Zaloguj" type="submit">
</form>

  
<?php
  }
    /* jeżeli istnieje zmienna login oraz password i sesja z autoryzacją użytkownika jest FALSE to wykonaj
     * skrypt logowania
     */
elseif (isset($_POST['login']) && isset($_POST['password']) && $_SESSION['auth'] == FALSE) {
      
        // jeżeli pole z loginem i hasłem nie jest puste      
	if (!empty($_POST['login']) && !empty($_POST['password'])) {
          
        // dodaje znaki unikowe dla potrzeb poleceń SQL
        $login = $_POST["login"];
        $password = $_POST["password"];
        // szyfruję wpisane hasło za pomocą funkcji md5()
        //$password = md5($password);
        
        /* zapytanie do bazy danych
         * mysql_numrows - sprawdzam ile wierszy odpowiada zapytaniu mysql_query
         * mysql_query - pobierz wszystkie dane z tabeli user gdzie login i hasło odpowiadają wpisanym danym
         */
	$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
	$query = "SELECT * FROM myuser WHERE login ='" . pg_escape_string($login) . "'and password = '" . pg_escape_string($password) . "';";
	$result = pg_query($link, $query);
	$numrows = pg_numrows($result);
  
        $sql = $numrows;

        // jeżeli powyższe zapytanie zwraca 1, to znaczy, że dane zostały wpisane poprawnie i rejestruję sesję
        if ($sql == 1) {
              
        	// zmienne sesysje user (z loginem zalogowanego użytkownika) oraz sesja autoryzacyjna ustawiona na TRUE
                $_SESSION['user'] = $login;
                $_SESSION['auth'] = TRUE;
                
                //przekierwuję użytkownika na stronę z ukrytymi informacjami
                echo '<meta http-equiv="refresh" content="1; URL=podstrona4.php">';
                echo '<p style="padding-top:10px;"><strong>Proszę czekać...</strong><br>Trwa logowanie i wczytywanie danych.<p></p>';
		
		exit();
        }
            
        // jeżeli zapytanie nie zwróci 1, to wyświetlam komunikat o błędzie podczas logowania
        else {
        	echo '<p style="padding-top:10px;color:red" ;="">Niepoprawny login lub hasło.<br><br><br>';
                echo '<a href="podstrona4.php" style="">Wróć do formularza.</a></p>';
        }
}
        
// jeżeli pole login lub hasło nie zostało uzupełnione wyświetlam błąd
else {
	echo '<p style="padding-top:10px;color:red" ;="">Niepoprawny login lub hasło.<br><br><br>';
        echo '<a href="podstrona4.php" style="">Wróć do formularza.</a></p>';    
}
}


if ($_SESSION['auth'] == TRUE) {
	echo "Witaj " . $_SESSION['user'] . " !<br><br>";


?>
<hr>

<b>Ustal termin zamknięcia zgłoszeń.</b><br><br>

<form name="form-koniec-zgloszen" action="ustaw_koniec_zgloszen.php" method="post">
          Wprowadź datę: <input name="nowa_data_konca_zgloszen" type="date">

<br>
<br>
<input name="nowa_data_konca_zgloszen_przycisk" value="Zatwierdź" type="submit">
</form>

<?php

$today = date("Y-m-d H:i:s");

$fname = "koniec_zgloszen.txt";
$fhandle = fopen($fname,"r");
$content = fread($fhandle,filesize($fname));
$konwersja_daty = strtotime($content);
if($today > date("Y-m-d H:i:s", $konwersja_daty))
{	
	echo '<p style="padding-top:10px;color:red" ;="">Zgłoszenia dobiegły końca.<br><br>';
}
else
{
?>
<hr>
<b>Dodaj drużynę.</b><br><br>
<form name="form-dodaj-druzyne" action="dodaj_druzyne.php" method="post">
          Nazwa drużyny: <input name="druzyna" type="text">
	  <br>
	  <br>
          <input name="dodaj_druzyne" value="Dodaj" type="submit">
</form>
<hr>

<?php
$link = pg_connect("host=labdb dbname=mrbd user=kk359750 password=kal314");
$query2 = "SELECT * FROM druzyna;";
$result2 = pg_query($link, $query2);
$numrows2 = pg_numrows($result2);
?>

<b>Dodaj zawodnika do drużyny.</b><br><br>

<form name="form-dodaj_zawodnika" action="dodaj_zawodnika.php" method="post">
          Imię zawodnika: <input name="imie" type="text"><br>
	  <br>
          Nazwisko zawodnika: <input name="nazwisko" type="text">

<br>
<br>
Wybierz drużynę, do której chcesz dodać zawodnika.
	<select name="druzynazawodnika">

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
<input name="dodaj_zawodnika" value="Dodaj" type="submit">
</form>

<hr>

<b>Zaplanuj mecz.</b><br><br>

<form name="form-zaplanuj-mecz" action="dodaj_mecz.php" method="post">
          Wprowadź datę meczu: <input name="data_mowego_meczu" type="date">
	  <br>
	  <br>
	  Wybierz pierwszą drużynę:

<select name="druzyna1">

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
          Wybierz drugą drużynę:

<select name="druzyna2">

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
<input name="nowy_mecz_przycisk" value="Dodaj" type="submit">
</form>
<hr>

<?php
$query3 = "select id_meczu, data, d1.nazwa as druz1, d2.nazwa as druz2 from mecz join druzyna d1 on druzyna1_id = d1.id_druzyny join druzyna d2 on druzyna2_id = d2.id_druzyny;";
$result3 = pg_query($link, $query3);
$numrows3 = pg_numrows($result3);

$query4 = "select id_meczu, data, d1.nazwa as druz1, d2.nazwa as druz2 from mecz join druzyna d1 on druzyna1_id = d1.id_druzyny join druzyna d2 on druzyna2_id = d2.id_druzyny where data >= '$today';";
$result4 = pg_query($link, $query4);
$numrows4 = pg_numrows($result4);
?>

<b>Zgłoś zawodnika na mecz.</b><br><br>

<form name="form-zglos-zawodnika" action="zglos_zawodnika1.php" method="post">
          Wybierz mecz, na który chcesz zgłosić zawodnika:

<select name="mecz_zawodnika">

<?php
for($ri = 0; $ri < $numrows4; $ri++)
{
  $row = pg_fetch_array($result4, $ri);
  echo " <option value='". $row["id_meczu"] ."'>" . $row["data"] . " " . $row["druz1"] . " " . $row["druz2"] . "</option>\n";
}
?>

</select>



<br>
<br>
<input name="nowy_zawodnik_na_mecz_przycisk" value="Zatwierdź" type="submit">
</form>
<?php
}   //zamkniecie else (od terminu zgłoszeń)
?>
<hr>

<b>Dodaj wynik meczu.</b><br><br>

<form name="form-wynik-meczu" action="wynik_meczu1.php" method="post">
          Wybierz mecz, którego wynik chcesz dodać:

<select name="mecz_do_wyniku">

<?php
for($ri = 0; $ri < $numrows3; $ri++)
{
  $row = pg_fetch_array($result3, $ri);
  echo " <option value='". $row["id_meczu"] ."'>" . $row["data"] . " " . $row["druz1"] . " " . $row["druz2"] . "</option>\n";
}
?>

</select>

<br>
<br>

Zaznacz, z ilu setów składał się mecz.

<select name="liczba_setow">

	<option>3</option>
	<option>4</option>
	<option>5</option>

</select>



<br>
<br>
<input name="nowy_zawodnik_na_mecz_przycisk" value="Zatwierdź" type="submit">
</form>
<hr>


<br>
<br>
<a href="wylogowanie.php">Wyloguj</a>
<br>
<br>
<?php

}

?>

<br>

<a href="podstrona3.php">Wróć do aplikacji dla kibiców.</a>
</div>


<div id="STOPKA">Copyright 2017 by Krystian Koziatek</div>

</div>

<hr>

</body>
</html>