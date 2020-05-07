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
            <li><a class="active" href="./?cmd=UserHome">Home</a></li>
            <?php 
                // Wenn über Command ausgeführt muss das genommen werden
                $indexOfPageList = 0;
                foreach($this->pageList as $page) {
                     echo '<li><a href="./?cmd=UserHome&page='.$indexOfPageList.'">'. $page->getTitle() ."</a></li>"; // Link zur jeweiligen Page?
                     $indexOfPageList++;
                }
            ?>
            <li><a href="./?cmd=UserSettings">Einstellungen</a></li>
        </ul>
        <div id="main">
            Hier erstellen Sie einen Gast und wählen welche Seiten Ihres Portfolios dieser sehen darf.
            <form action="?cmd=AddGuest" method="post"><button type="submit" value="createGuest" name="createGuest">Gast erstellen!</button></form>
            <br>
            Hier können Sie einen Gast löschen oder dessen Berechtigungen verwalten.
            <form action="?cmd=GuestManagement" method="post"><button type="submit" value="manageGuest" name="manageGuest">Gäste verwalten!</button></form>
            <br>
             Hier können Sie Ihr Profil verwalten.
            <form action="?cmd=updateGuest" method="post"><button type="submit" value="updateUser" name="updateUser">Profil bearbeiten!</button></form>
            <br>
            
                Hier soll der User Einstellungen vornehmen können. Wie Displaynamen ändern, Style ändern, Seite löschen, Account löschen usw.
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>
