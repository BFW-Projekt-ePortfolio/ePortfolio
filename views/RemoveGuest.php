<?php
    $outputString = "";
    foreach($this->userList as $user){
        $outputString .= "<p> Die Gäste von: ". $user[0]->getFirstname()." ". $user[0]->getLastname();
        for($i = 0; $i < count($user[1]); $i++){
            $outputString .= "<div>";
            $outputString .= "<strong>".$user[1][$i]->getEmail()."</strong> löschen?";
            $outputString .= '<form action="?cmd=RemoveGuest" method="post"><button type="submit" value="'. $user[1][$i]->getId() .'" name="deleteGuest">löschen!</button></form>';
            $outputString .= '<br>';
            $outputString .= "</div>";
        }
        $outputString .= "</p>";
        
    }
?>

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
            <li><a class="active" href="index.php?cmd=AdminHome">Home</a></li>
            <li><a href="index.php?cmd=AddUser">User anlegen</a></li>
            <li><a href="index.php?cmd=RemoveUser">User löschen</a></li>
            <li><a href="index.php?cmd=RemoveGuest">Gäste löschen</a></li>
            <li><a href="index.php?cmd=AddAdmin">Admin anlegen</a></li>
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