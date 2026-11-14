<?php if (!isset($_SESSION['login'])): ?>
    <h2>Bejelentkezés szükséges</h2>
    <p>Az üzenetek megtekintéséhez jelentkezz be!</p>
<?php else: ?>
    <h2>Üzenetek</h2>
    <p>Ide kerül az elküldött üzenetek listája.</p>
<?php endif; ?>