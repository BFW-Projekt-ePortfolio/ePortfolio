<?php
    $outputString = "";
    if(count($this->userList) == 1){
        $outputString .= "Es gibt momentan nur einen Administrator!<br>";
        $outputString .= "<strong>".$this->userList[0]->getEmail()."</strong> kann nicht gelöscht werden! (letzter seiner Art)";
    }
    else{
        foreach($this->userList as $user){

            $outputString .= "<div>";
            $outputString .= "<strong>".$user->getEmail()."</strong> löschen?";
            $outputString .= '<form action="?cmd=AdminVerwaltung" method="post"><button type="submit" value="'. $user->getId() .'" name="deleteAdmin">löschen!</button></form>';
            $outputString .= '<br>';
            $outputString .= "</div>";    
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
            Das ultimative ePortfolio!
        </div>
        <ul>
             <!-- Die Navigationsleiste, horizontal, evtl mit foreach aus dem pages-Array ein li-Element erzeugen? -->
            <li><a class="active" href="index.php?cmd=AdminHome">Home</a></li>
            <li><a href="index.php?cmd=AddUser">User anlegen</a></li>
            <li><a href="index.php?cmd=RemoveUser">User löschen</a></li>
            <li><a href="index.php?cmd=RemoveGuest">Gäste löschen</a></li>
            <li><a href="index.php?cmd=AddAdmin">Admin anlegen</a></li>
            <li><a href="index.php?cmd=AdminVerwaltung">Admins Verwalten</a></li>
            <li><a href="index.php?cmd=Logout">Logout</a></li>
        </ul>
        <div id="main">
            <div id="description">
                <?= $outputString ?>
            </div>

            <div id="content">
            </div>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>