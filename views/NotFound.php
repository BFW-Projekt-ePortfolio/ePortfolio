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
                Die gewünschte Seite wurde nicht gefunden!<br>
                <br>
                <br>
                <br>
            </div>

            <div id="content">
                Kann man leider nichts machen.
            </div>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>