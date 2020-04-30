<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="./css/<?= $this->style ?>.css" rel="stylesheet" type="text/css"> <!-- $style in $this->style ändern, wenn es mit dem Command ausgeführt wird-->
    </head>
    <body>
        <div id="header">
            Das ultimative ePortfolio!
        </div>
        <ul>
             <!-- Die Navigationsleiste, horizontal, evtl mit foreach aus dem pages-Array ein li-Element erzeugen? -->
            <li><a href="index.php?cmd=AdminHome">Home</a></li>
            <li><a class="active" href="index.php?cmd=AddUser">User anlegen</a></li>
            <li><a href="index.php?cmd=RemoveUser">User löschen</a></li>
            <li><a href="index.php?cmd=RemoveGuest">Gäste löschen</a></li>
            <li><a href="index.php?cmd=Logout">Logout</a></li>
        </ul>
        <div id="main">
            <div id="description">
                Neuen User anlegen.<br><br>
                <form method="POST" action="#">
                    Vorname:<br><input type="text" name="firstname"><br>
                    Nachname:<br><input type="text" name="lastname"><br>
                    E-Mail:<br><input type="text" name="email"><br>
                    Passwort:<br><input type="password" name="password"><br>
                    Passwort wiederholen:<br><input type="password" name="pwRepeat"><br>
                    <input type="submit" name="submit" value="anlegen">

                    <?php
                        // Prüft, ob submit betätigt und, ob in den Felder was eingetragen wurde und danach, ob die PW übereinstimmen
                        if(isset($_POST['submit'])) {
                            if($_POST['firstname'] == "" || $_POST['lastname'] == "" || $_POST['email'] == "" || $_POST['password'] == "") {
                                echo "geht so nich!";
                            } else {
                                if($_POST['password'] === $_POST['pwRepeat']) {
                                    $this->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                                    $this->firstname = $_POST['firstname'];
                                    $this->lastname = $_POST['lastname'];
                                    $this->email = $_POST['email'];
                                }
                            }
                        }
                    ?>

                </form>
            </div>

            <div id="content">
            </div>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>