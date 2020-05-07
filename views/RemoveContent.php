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
                     echo '<li><a href="./index.php?cmd=UserHome&page='.$indexOfPageList.'">'. $page->getTitle() ."</a></li>"; // Link zur jeweiligen Page?
                     $indexOfPageList++;
                }
            ?>
            <li><a href="./?cmd=UserSettings">Einstellungen</a></li>
            <li><a href="./?cmd=AddPage">+</a></li>
            <li><a href="index.php?cmd=Logout">Logout</a></li>
        </ul>
        <div id="main">

            <h2>Inhalt löschen</h2>

            <div id="content">
                Sind Sie sicher, dass Sie den Inhalt löschen möchten? Dies lässt sich nicht mehr rückgängig machen!<br><br>
                <form method="POST" action="#">
                <input type="submit" name="remove" value="löschen">
                <input type="submit" name="keep" value="behalten">
                </form>

            </div>

        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>