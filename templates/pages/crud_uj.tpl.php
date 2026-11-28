<h2>Új szerelő felvétele</h2>

<?php if (!empty($hibak)): ?>
    <ul role="alert">
        <?php foreach ($hibak as $hiba): ?>
            <li><?= htmlspecialchars($hiba, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="crud-uj" method="post">
    <input type="hidden" name="token"
           value="<?= htmlspecialchars(
               $_SESSION['crud_token'], ENT_QUOTES, 'UTF-8'
           ) ?>">

    <p>
        <label for="nev">Szerelő neve:</label><br>
        <input type="text" id="nev" name="nev"
               value="<?= htmlspecialchars($nev, ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        <label for="kezdev">Munkakezdés éve:</label><br>
        <input type="text" id="kezdev" name="kezdev"
               inputmode="numeric"
               value="<?= htmlspecialchars($kezdev, ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <button type="submit">Mentés</button>
</form>

<p><a href="crud">Vissza a szerelők listájához</a></p>