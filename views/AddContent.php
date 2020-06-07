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
                <!-- ??? -->
                <image style="position: absolute; left: 48vw; margin-top: 5vh" src="./Example.jpg">
                <!-- ??? -->
                <h3>Neuen Inhalt hinzufügen:</h3><br>
                <?= $this->alert ?>
                <br>
                <br>

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
                <div style="display:flex;">
                <form action="#" method="POST">
                    Text oder html: (html Beispiele rechts)<br><textarea name="descriptionNoFile" cols="40" rows="15"></textarea><br>
                    <input type="submit" name="saveNoFile" value="speichern">
                    <input type="submit" name="cancel" value="abbrechen">
                </form>
                
                <!-- ??? -->
                <style>
                    .h1{
                        line-height: 150%;
                    }
                    .h2{
                        line-height: 100%;
                    }
                    .h3{
                        line-height: 110%;
                    }
                    .flex{
                        display: flex;
                        justify-content: center;
                        line-height: 80%;
                    }
                </style>
                <div style="width: 70%;">
                    <div class="flex"><h3>Hier einige nützliche html Beispiele:</h3></div>
                    <div class="flex"><p class="h1">&lt;h1&gt; ...</p><h1>Überschrift h1</h1><p class="h1">... &lt;/h1&gt;</p></div>
                    <div class="flex"><p class="h2">&lt;h2&gt; ...</p><h2>Überschrift h2</h2><p class="h2">... &lt;/h2&gt;</p></div>
                    <div class="flex"><p class="h3">&lt;h3&gt; ...</p><h3>Überschrift h3</h3><p class="h3">... &lt;/h3&gt;</p></div>
                    <div class="flex"><p>&lt;p&gt; ...</p><p>Dies ist ein Absatz</p><p>... &lt;/p&gt;</p></div>
                    <div class="flex"><p>dies ist nicht hervorgehobener text...&lt;strong&gt; ...</p><p><strong>Dies ist fettgedruckt</strong></p><p>... &lt;/strong&gt; ...und hier wieder die normale Größe</p></div>
                </div>
                </div>
                <!-- ??? -->
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
