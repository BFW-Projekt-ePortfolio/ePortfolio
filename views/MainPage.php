<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ePortfolio</title>
    <link href="./css/<?= $this->style ?>.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="./favicon_96x96.png" size="48x48">
</head>
    <body>
        <main>
            <div id="header">
                Das ultimative ePortfolio!
            </div>

            <div id="main">
                <div id="description">
                Bitte melden Sie sich an:<br>
                <br>
                <form method="POST" action="#">
                    E-Mail: <br><input type="text" name="email"><br>
                    Password: <br><input type="password" name="password"><br><br>
                    <input type="submit" name="submit" value="anmelden"><br>
                </form>
                <br>
            </div>
        </main>
        <footer>&copy; 2020 M. Mandler & D. Zielke</footer>
    </body>
</html>