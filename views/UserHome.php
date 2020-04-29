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
            Das ePortfolio von Gnaabert!
        </div>
        <ul>
             <!-- Die Navigationsleiste, horizontal, evtl mit foreach aus dem pages-Array ein li-Element erzeugen? -->
            <li><a class="active" href="#home">Home</a></li>
            <?php 
                // Wenn über Command ausgeführt muss das genommen werden
                // foreach($this->pageList as $page) {
                //     echo "<li><a></a></li>"; // Link zur jeweiligen Page?
                // }
            ?>
        </ul>
        <div id="main">
            <div id="description">
                Hier soll die Beschreibung aus der DB rein. <br>
                Ist jetzt zwar noch nicht sonderlich hübsch, aber man kann vorerst damit arbeiten.<br>
                <br>
                <br>
                <br>
                Wird noch aufgewertet.
            </div>

            <div id="content">
                Hier kommt der Content rein. Dateinamen aus der DB zu den jeweiligen Dateien im Ordner des User (Pfad evtl.: ./userId/pageId/file).
            </div>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>