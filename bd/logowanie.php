<?php

    /* jeżeli nie wypełniono formularza - to znaczy nie istnieje zmienna login, hasło i sesja auth
     * to wyświetl formularz logowania
     */
    if (!isset($_POST['login']) && !isset($_POST['password']) && $_SESSION['auth'] == FALSE) {
  ?>

<html lang="pl-PL">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="Stylesheet" type="text/css" href="style.css" />
<title>Zadanie zaliczeniowe BD</title>
</head>


<body style="background-color:#a5d5ff">
<p>
<h1 align = "center" style="color: #3b5998"> Zadanie zaliczeniowe na przedmiot Bazy danych </h1>

<hr>

<ul>
<li><a href="index.html">Strona główna</a></li>
<li><a href="podstrona1.html">Diagram ERD</a></li>
<li><a href="podstrona2.html">Skrypt SQL</a></li>
<li><a href="podstrona3.html">Logowanie</a></li>
</ul>

<h2 align="center">Logowanie</h2>

<form name="form-logowanie" action="logowanie.php" method="post">
          Login: <input name="login" type="text"><br>
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
$query = "SELECT * FROM myuser WHERE login ='" . $login . "'and password = '" . $password . "';";
$result = pg_query($link, $query);
$numrows = pg_numrows($result);
  
           $sql = $numrows;

            // jeżeli powyższe zapytanie zwraca 1, to znaczy, że dane zostały wpisane poprawnie i rejestruję sesję
            if ($sql == 1) {
              
                // zmienne sesysje user (z loginem zalogowanego użytkownika) oraz sesja autoryzacyjna ustawiona na TRUE
                $_SESSION['user'] = $login;
                $_SESSION['auth'] = TRUE;
                
                //przekierwuję użytkownika na stronę z ukrytymi informacjami
                echo '<meta http-equiv="refresh" content="1; URL=hide.php">';
                echo '<p style="padding-top:10px;"><strong>Proszę czekać...</strong><br>trwa logowanie i wczytywanie danych<p></p>';
	exit();
            }
            
            // jeżeli zapytanie nie zwróci 1, to wyświetlam komunikat o błędzie podczas logowania
            else {
                echo '<p style="padding-top:10px;color:red" ;="">Niepoprawny login lub hasło<br>';
                echo '<a href="podstrona3.html" style="">Wróć do formularza</a></p>';
            }
        }
        
        // jeżeli pole login lub hasło nie zostało uzupełnione wyświetlam błąd
        else {
            echo '<p style="padding-top:10px;color:red" ;="">Niepoprawny login lub hasło<br>';
            echo '<a href="podstrona3.html" style="">Wróć do formularza</a></p>';    
        }
    }
 ?>

</p>
</body>
</html>