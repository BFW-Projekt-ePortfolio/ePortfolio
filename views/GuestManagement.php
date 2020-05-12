<?php
    $outputString = "";
    if(count($this->pageList) > 1 && count($this->guestList) != 0){ // andernfalls gibts keine Tabelle weil er keine Seiten hat zum freigeben - nur die default-Page
        $outputString .= '<table style="width:100%">';
        $outputString .= '<caption>Verwalten sie ihre Berechtigungen:</caption>';
        $outputString .= '<tr>';
        $outputString .= '<th>Deine Gäste</th>';
        for($i = 1; $i < count($this->pageList); $i++){
            $outputString .= "<th>".$this->pageList[$i]->getTitle()."</th>";
        }
        $outputString .= '</tr>';
        $outputString .= '<tr>';
        for($guestIndex = 0; $guestIndex < count($this->guestList); $guestIndex++){
            $outputString .= '<td>'.$this->guestList[$guestIndex]->getEmail().'</td>';
            for($pageIndex = 1; $pageIndex < count($this->pageList); $pageIndex++){
                if(count($this->guestList[$guestIndex]->getPages()) > 1){// die default page muss öffentlich sein.
                    $guestPages = $this->guestList[$guestIndex]->getPages();
                    $guestHasPermissionAllready = false;
                    for($guestPageIndex = 1; $guestPageIndex < count($guestPages); $guestPageIndex++){
                        if($this->pageList[$pageIndex]->getNummer() == $guestPages[$guestPageIndex]->getNummer()){
                            // zu dieser Seite hat dieser Gast schon eine berechtigung
                            // möglichkeit zum entfernen einbauen:
                            $outputString .= '<td>';
                            $outputString .= '<form method="POST" action="#">';
                            $outputString .= '<input type="hidden" name="guestIndex" value="'. $guestIndex .'">';
                            $outputString .= '&nbsp;✅&nbsp;berechtigt&nbsp;<button type="submit" value="'. $pageIndex .'" name="removePermission">entfernen!</button>';
                            $outputString .= '</form>';
                            $outputString .= '</td>';
                            $guestHasPermissionAllready = true;
                        }
                    }
                    if(!$guestHasPermissionAllready){
                        // zu dieser Seite hat dieser Gast noch keine Berechtigung:
                        // möglichkeit zum setzuen bieten
                        $outputString .= '<td>';
                        $outputString .= '<form method="POST" action="#">';
                        $outputString .= '<input type="hidden" name="guestIndex" value="'. $guestIndex .'">';
                        $outputString .= '&nbsp;❌&nbsp;unberechtigt&nbsp;<button type="submit" value="'. $pageIndex .'" name="addPermission">hinzufügen!</button>';
                        $outputString .= '</form>';
                        $outputString .= '</td>';
                    }
                }
                else{
                    // Der Gast hat noch garkeine Extra-Rechte, also bei allen hinzufügen möglich machen
                    $outputString .= '<td>';
                    $outputString .= '<form method="POST" action="#">';
                    $outputString .= '<input type="hidden" name="guestIndex" value="'. $guestIndex .'">';
                    $outputString .= '&nbsp;❌&nbsp;unberechtigt&nbsp;<button type="submit" value="'. $pageIndex .'" name="addPermission">hinzufügen!</button>';
                    $outputString .= '</form>';
                    $outputString .= '</td>';
                }
            }
            $outputString .= '</tr>';
        }
        $outputString .= '</table>';
        $outputString .= '<br><br>';

        // Die lösch optionen:
        $outputString .= '<div style="text-align: center;">Entfernen Sie Gäste, diese können dann nicht mehr auf Ihr Portfolio zugreifen:</div>';
        $outputString .= '<br>';
        $outputString .= '<div style="display: flex; justify-content: space-around;">';
        for($guestIndex = 0; $guestIndex < count($this->guestList); $guestIndex++){
            $outputString .= '<form method="POST" action="#">';
            $outputString .= '<label for="removeGuest">'.$this->guestList[$guestIndex]->getEmail().'&emsp;</label>';
            $outputString .= '<button type="submit" value="'. $guestIndex .'" name="removeGuest">Gast entfernen!❌</button>';
            $outputString .= '</form>';
        }
        $outputString .= '</div>';
        $outputString .= '<br><br>';
    }
    else{
        $outputString .= '<p style="text-align: center;">Sie haben keine Seiten die Sie freigeben könnten</p>';
        $outputString .= '<br><br>';
        if (count($this->guestList) != 0){
            $outputString .= '<div style="text-align: center;">Entfernen Sie Gäste, diese können dann nicht mehr auf Ihr Portfolio zugreifen:</div>';
            $outputString .= '<br>';
            $outputString .= '<div style="display: flex; justify-content: space-around;">';
            for($guestIndex = 0; $guestIndex < count($this->guestList); $guestIndex++){
                $outputString .= '<form method="POST" action="#">';
                $outputString .= '<label for="removeGuest">'.$this->guestList[$guestIndex]->getEmail().'&emsp;</label>';
                $outputString .= '<button type="submit" value="'. $guestIndex .'" name="removeGuest">Gast entfernen!❌</button>';
                $outputString .= '</form>';
            }
            $outputString .= '</div>';
            $outputString .= '<br><br>';
        }
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
            <?= $outputString ?>                
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>
