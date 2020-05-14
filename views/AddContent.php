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
            <!-- <li><a class="active" href="./index.php?cmd=UserHome">Home</a></li> -->
            <?php 
                // Wenn über Command ausgeführt muss das genommen werden
                $indexOfPageList = 0;
                foreach($this->pageList as $page) {
                     echo '<li><a href="./index.php?cmd=UserHome&page='.$indexOfPageList.'">'. $page->getTitle() ."</a></li>"; // Link zur jeweiligen Page?
                     $indexOfPageList++;
                }
            ?>
            <li><a href="./index.php?cmd=AddPage">±</a></li>
            <li style="float: right"><a href="index.php?cmd=Logout">Logout</a></li>
            <li style="float: right"><a href="./index.php?cmd=UserSettings">Einstellungen</a></li>
        </ul>
        <div id="main">
                <h3>Neuen Inhalt hinzufügen:</h3><br>
                <?= $this->alert ?>
                <br><br>

                <strong>Mit Dateiupload:</strong>
                <form enctype="multipart/form-data" action="#" method="POST">
                    Datei: <br><input name="userfile" type="file"><br><br>
                    Beschreibung: <br><input type="text" name="descriptionFile" size="50"><br>
                    <input type="submit" name="saveFile" value="speichern">
                    <input type="submit" name="cancel" value="abbrechen">
                </form>
                <br>
                <br>

                <strong>Ohne Dateiupload:</strong>
                <form action="#" method="POST">
                    Text oder html: <br><textarea name="descriptionNoFile" cols="35" rows="4"></textarea><br>
                    <input type="submit" name="saveNoFile" value="speichern">
                    <input type="submit" name="cancel" value="abbrechen">
                </form>
                <br>
                <br>

                <strong>Link erzeugen:</strong>
                <form action="#" method="POST">
                    Name des Links: <br><input type="text" name="linkName" size="50"><br>
                    Ziel-Adresse:<br><input type="text" name="linkAddress" size="50"><br>
                    <input type="submit" name="createLink" value="speichern">
                    <input type="submit" name="cancel" value="abbrechen">
                </form>

        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>
