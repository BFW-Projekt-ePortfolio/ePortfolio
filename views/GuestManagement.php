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
            <li><a href="./?cmd=AddPage">+</a></li>
        </ul>
        <div id="main">
                
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
                    foreach($this->guestList as $guest){
                        $outputString .= '<td>'.$guest->getEmail().'</td>';
                        for($i = 1; $i < count($this->pageList); $i++){
                            if(count($guest->getPages()) > 1){// die default page muss öffentlich sein.
                                $guestPages = $guest->getPages();
                                $guestHasPermissionAllready = false;
                                for($k = 1; $k < count($guestPages); $k++){
                                    if($this->pageList[$i]->getNummer() == $guestPages[$k]->getNummer()){
                                        // zu dieser Seite hat dieser Gast schon eine berechtigung
                                        // möglichkeit zum entfernen einbauen:
                                        $outputString .= '<td>';
                                            $outputString .= '<form method="POST" action="#">';
                                            $outputString .= '<input type="hidden" name="guestId" value="'.$guest->getId().'">';
                                            $outputString .= '<button type="submit" value="'. $this->pageList[$i]->getNummer() .'" name="removePermission">entfernen!</button>';
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
                                        $outputString .= '<input type="hidden" name="guestId" value="'.$guest->getId().'">';
                                        $outputString .= '<button type="submit" value="'. $this->pageList[$i]->getNummer() .'" name="addPermission">hinzufügen!</button>';
                                        $outputString .= '</form>';
                                    $outputString .= '</td>';
                                }

                            }
                            else{
                                // Der Gast hat noch garkeine Extra-Rechte, also bei allen hinzufügen möglich machen
                                $outputString .= '<td>';
                                    $outputString .= '<form method="POST" action="#">';
                                    $outputString .= '<input type="hidden" name="guestId" value="'.$guest->getId().'">';
                                    $outputString .= '<button type="submit" value="'. $this->pageList[$i]->getNummer() .'" name="addPermission">hinzufügen!</button>';
                                    $outputString .= '</form>';
                                $outputString .= '</td>';
                            }

                        }
                        $outputString .= '</tr>';
                    }
                    $outputString .= '</table>';


                    // $outputString .= '<form method="POST" action="#">';
                    // $outputString .= '<input type="hidden" name="guestId" value="'.$guest->getId().'">';
                    // $outputString .= '<button type="submit" value="'. $this->pageList[$i]->getNummer() .'" name="addPermission">hinzufügen!</button>';
                    // $outputString .= '</form>';

                    // $outputString .= '<form method="POST" action="#">';
                    // $outputString .= '<input type="hidden" name="guestId" value="'.$guest->getId().'">';
                    // $outputString .= '<button type="submit" value="'. $this->pageList[$i]->getNummer() .'" name="removePermission">entfernen!</button>';
                    // $outputString .= '</form>';

                }
                echo $outputString;  
            ?>

                
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>