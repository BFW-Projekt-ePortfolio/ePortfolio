README
======

Installation
------------

Alle Ordner bis auf database in htdocs kopieren (unter Linux /opt/lampp/htdocs), die sql in database über phpMyAdmin importieren.

30.04-----------------------
//////// Page DAO
createPage($ownerId, $title)
createPagePassingPageObject(Page $page)
setPermissionForPage($guestIdToSetPermissionFor, $pageId)
setPermissionForPagePassingObjects(User $user,Page $page)

deletePermissionOfGuestForPage($guestId, $pageId)
deleteAllPermissionsOfGuest($guestId)
deletePage($pageId)
deleteAllPagesOfUser($userId)

///////// UserDAO
deleteGuest($guestId) mit all seinen permissions
deleteUser($userId) mit allen Gästen, permissions und pages und Contents

//////// ContentDAO
deleteContent($contentId)
deleteAllContentOfPage($pageId)
------------------------------

Bin die Problematik angeganen wenn ein Gast mehrere Freigaben verschiedener Portfolios hat.
So, wenn er mehrere Freigaben hat mit verschiedenen pws, wird er anhand des pws zum richtigen portfolio geleitet.
Wenn er mehrere freigaben hat mit gleichem pw, so wird er jetzt aufgefordert zu wählen welches portfolio er sehen will und wird
dann dorthin geleitet.
