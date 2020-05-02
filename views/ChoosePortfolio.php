<?php
    $prepareButtons = '';
    foreach($this->users as $user){
        $buttonValue = $user->getId();
        $userInformation = $user->getFirstname() ." ". $user->getLastname() ."&nbsp;&nbsp;Nickname:&nbsp;". $user->getDisplayname();
        $prepareButtons .= '<form method="post" action="./?cmd=ChoosePortfolio" class="inline">';
        $prepareButtons .= '<button type="submit" name="submit_param" value="'. $buttonValue .'" class="link-button">';
        $prepareButtons .= $userInformation;
        $prepareButtons .= '</button></form>';
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
            Das ePortfolio von Gnaabert!
        </div>
        <hr>
        <div id="main">
            <div id="description">
                <h1 Style="text-align:center">Willkommen <?= $this->Guestemail ?></h1>
                <br>
                <h3>Sie haben Freigaben zu folgenden Portfolios:</h1> 
            </div>

            <div id="content">
                <div Style="display:flex; justify-content: space-evenly">
                    <?= $prepareButtons ?>
                </div>
            </div>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>