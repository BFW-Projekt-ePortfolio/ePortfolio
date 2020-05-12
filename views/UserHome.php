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

            <h2><?= $this->requestedTitle ?></h2>
            <?= $this->alert ?>
            <?= $this->editLink ?><br>
            <?= $this->addContentLink ?>

            <?php

                foreach($this->requestedContent as $content) {

                    $file = $this->filepath . $content->getContent();

                    if(file_exists($file)) {

                        $mimeType = mime_content_type($file);

                        $tmp = base64_encode(file_get_contents($file));

                        $output = "<a href='data:" . $mimeType . ";base64," . $tmp . "'>" . $content->getContent() . "</a>";

                        if(strpos($mimeType, "image") >= 0) {
                            $output = "<a href='data:" . $mimeType . ";base64," . $tmp . "' target='_blank'><img src='data:" . $mimeType . ";base64," . $tmp . "'></a>";
                        }

                        if($mimeType === "application/pdf") {
                            $output = "<a href='data:application/pdf;base64," . $tmp . "' target='_blank'>" . $content->getContent() . "</a>";
                        }

                        echo "<div id='content'><br>" . $output . "<br><br>" . $content->getContentDescription() . "<br></div>";
                    }
                }
            ?>
        </div>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>