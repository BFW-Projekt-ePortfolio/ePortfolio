<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="../css/default.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="header">
            Das ePortfolio von Gnaabert!
        </div>
        <ul>
             <!-- Die Navigationsleiste, horizontal, evtl mit foreach aus dem pages-Array ein li-Element erzeugen? -->
            <li><a class="active" href="#home">Home</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#about">About</a></li>
        </ul>
        <div id="main">
            <div id="description">
                Hier soll die Beschreibung aus der DB rein. <br>
                Ist jetzt zwar noch nicht sonderlich hübsch, aber man vorerst damit arbeiten.<br>
                <br>
                <br>
                <br>
                Wird noch aufgewertet.
            </div>

            <div id="content">
                Hier kommt der Content rein. Dateinamen aus der DB zu den jeweiligen Dateien im Ordner des User (Pfand evtl.: ./userId/pageId/file).
            </div>
        </div>
    </body>
</html>