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
                <br>
                <?= $this->allertText ?>
                <div>Hier Können Sie eine <strong>neue Seite</strong> in Ihrem Portfolio <strong>erstellen:</strong> (Maximal 10 Seiten)<br>
                Bitte wählen Sie zuerst einen Namen für die neue Seite</div><br>
                <form method="POST" action="#">
                <label for="pageInput"><strong>Namen der Seite hier eingeben:</strong></label>
                <input type="text" name="pageInput"><br>
                <label for="createPage">Im nächsten Schritt können Sie Ihre neue Seite einrichten, <strong>klicken Sie dazu auf den Button:</strong></label>
                <button type="submit" name="createPage">erstellen und weiter!</button>
                </form>
                <br>
                <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                <br>
                <?php
                    if(count($this->pageList) > 1){
                        $outputString = '<table style="min-width: 30%"><caption>Hier können Sie eine Seite Ihres Portfolios löschen:</caption>';
                        $indexOfPageList = 0;
                        foreach($this->pageList as $page){
                            if($indexOfPageList != 0){
                                $outputString .= '<tr>';
                                $outputString .= '<form method="POST" action="#">';
                                $outputString .= '<td>'.$page->getTitle().':</td>';
                                $outputString .= '<td style="text-align: center"><button type="submit" name="deletePage" value="'.$indexOfPageList.'">Seite löschen!❌</button></td>';
                                $outputString .= '</form>';
                                $outputString .= '</tr>';
                            }
                            $indexOfPageList++;
                        }
                        $outputString .= "</table>";
                        echo $outputString;
                    }
                ?>

        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>
