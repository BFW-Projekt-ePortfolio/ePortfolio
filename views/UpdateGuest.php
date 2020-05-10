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
            <li><a class="active" href="./index.php?cmd=UserHome">Home</a></li>
            <?php 
                // Wenn über Command ausgeführt muss das genommen werden
                $indexOfPageList = 0;
                foreach($this->pageList as $page) {
                     echo '<li><a href="./index.php?cmd=UserHome&page='.$indexOfPageList.'">'. $page->getTitle() ."</a></li>"; // Link zur jeweiligen Page?
                     $indexOfPageList++;
                }
            ?>
            <li><a href="./index.php?cmd=UserSettings">Einstellungen</a></li>
            <li><a href="./index.php?cmd=AddPage">+</a></li>
            <li><a href="index.php?cmd=Logout">Logout</a></li>
        </ul>
        <div id="main">
            <br>
            <?= $this->allertText ?><?= $this->successText ?>
                <div style="display: flex; justify-content: center">
                    <table>
                    <caption>Hier können Sie Ihre Daten ändern:</caption>
                        <tr>
                            <form method="POST" action="#">
                                <td>Vorname:</td>
                                <td><input type="text" name="firstname" value="<?= $this->user->getFirstname() ?>"></td>
                                <td><input type="submit" name="firstnameChange" value="ändern!"></td>
                            </form>
                        </tr>
                        <tr>
                            <form method="POST" action="#">
                                <td>Nachname:</td>
                                <td><input type="text" name="lastname" value="<?= $this->user->getLastname() ?>"></td>
                                <td><input type="submit" name="lastnameChange" value="ändern!"></td>
                            </form>
                        </tr>
                        <tr>
                            <form method="POST" action="#">
                                <td>E-Mail:</td>
                                <td><input type="text" name="email" value="<?= $this->user->getEmail() ?>"></td>
                                <td><input type="submit" name="emailChange" value="ändern!"></td>
                            </form>
                        </tr>
                        <tr>
                            <form method="POST" action="#">
                                <td>Passwort:<br>Passwort wiederholen:</td>
                                <td><input type="password" name="password"><br>
                                <input type="password" name="pwRepeat"></td>
                                <td><input type="submit" name="pwChange" value="ändern!"></td>
                            </form>
                        </tr>
                    </table>
                </div>
                <br><br>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>