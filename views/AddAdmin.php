<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="./css/<?= $this->style ?>.css" rel="stylesheet" type="text/css"> <!-- $style in $this->style ändern, wenn es mit dem Command ausgeführt wird-->
        <link rel="shortcut icon" type="image/x-icon" href="./favicon_96x96.png" size="48x48">
    </head>
    <body>
        <div id="header">
            Das ultimative ePortfolio!
        </div>
        <ul>
             <!-- Die Navigationsleiste, horizontal, evtl mit foreach aus dem pages-Array ein li-Element erzeugen? -->
            <li><a href="index.php?cmd=AdminHome">Home</a></li>
            <li><a href="index.php?cmd=AddUser">User anlegen</a></li>
            <li><a href="index.php?cmd=RemoveUser">User löschen</a></li>
            <li><a href="index.php?cmd=RemoveGuest">Gäste löschen</a></li>
            <li><a href="index.php?cmd=AddAdmin">Admin anlegen</a></li>
            <li><a href="index.php?cmd=AdminVerwaltung">Admins Verwalten</a></li>
            <li><a href="index.php?cmd=Logout">Logout</a></li>
        </ul>
        <div id="main">
            <div id="description">
                Neuen Admin anlegen. <?= $this->error ?> <br><br>
                <form method="POST" action="#">
                    Vorname:<br><input type="text" name="firstname"><br>
                    Nachname:<br><input type="text" name="lastname"><br>
                    Displayname:<br><input type="text" name="displayname"><br>
                    E-Mail:<br><input type="text" name="email"><br>
                    Passwort:<br><input type="password" name="password"><br>
                    Passwort wiederholen:<br><input type="password" name="pwRepeat"><br>
                    <input type="submit" name="submit" value="anlegen">
                </form>
            </div>

            <div id="content">
            </div>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>