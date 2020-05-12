<?php
    $outputString = "";
    if($this->deleteAccText != ""){
        $outputString = $this->deleteAccText;
    }
    else{
        $outputString .= 'Hier erstellen Sie einen Gast und wählen welche Seiten Ihres Portfolios dieser sehen darf.';
        $outputString .= '<form action="?cmd=AddGuest" method="post"><button type="submit" value="createGuest" name="createGuest">Gast erstellen!</button></form>';
        $outputString .= '<br>Hier können Sie einen Gast löschen oder dessen Berechtigungen verwalten.';
        $outputString .= '<form action="?cmd=GuestManagement" method="post"><button type="submit" value="manageGuest" name="manageGuest">Gäste verwalten!</button></form>';
        $outputString .= '<br>Hier können Sie Ihr Profil verwalten.';
        $outputString .= '<form action="?cmd=UpdateGuest" method="post"><button type="submit" value="updateUser" name="updateUser">Profil bearbeiten!</button></form>';
        $outputString .= '<br>';
        $outputString .= '<br>Hier können Sie Ihr Portfolio löschen!';
        $outputString .= '<br>Es werden alle Daten gelöscht, die mit Ihrem Konto in verbindung stehen.';
        $outputString .= '<br>Sie werden ausgeloggt und weder Sie noch einer Ihrer Gäste wird sich erneut einloggen können.';
        $outputString .= '<form action="#" method="post"><button type="submit" value="deleteAcc" name="deleteAcc">Account löschen!</button></form>';
        $outputString .= '<br>';
    }
?>

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
            Das ePortfolio von <?= $this->displayname ?>!
        </div>
        <ul>
             <!-- Die Navigationsleiste, horizontal, evtl mit foreach aus dem pages-Array ein li-Element erzeugen? -->
            <li><a class="active" href="./index.php?cmd=UserHome">Home</a></li>
            <?php 
                // Wenn über Command ausgeführt muss das genommen werden
                $indexOfPageList = 0;
                foreach($this->pageList as $page) {
                     echo '<li><a href="./index.php?cmd=UserHome&page='.$indexOfPageList.'">'. $page->getTitle() ."</a></li>"; // Link zur jeweiligen Page?
                     $indexOfPageList++;
                }
            ?>
            <li><a href="./index.php?cmd=UserSettings">Einstellungen</a></li>
            <li><a href="./index.php?cmd=AddPage">±</a></li>
            <li><a href="index.php?cmd=Logout">Logout</a></li>
        </ul>
        <div id="main">
                <?= $outputString ?>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>
