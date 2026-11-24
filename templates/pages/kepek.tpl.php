<div class="kepek-wrap">
    <section class="kepek-fejlec">
        <h2>Képek</h2>
        <p>Ide kerül a képgaléria – Vaszilij EDC: kések, multiszerszámok és mindennapi felszerelések.</p>
    </section>

    <section class="kepek-feltoltes-blokk" aria-label="Képfeltöltés">
        <h3>Új kép feltöltése</h3>

        <?php if (!empty($kepek_uzenetek)): ?>
            <div class="kepek-uzenetek" role="status">
                <?php foreach ($kepek_uzenetek as $uzenet): ?>
                    <p><?= htmlspecialchars($uzenet, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($kepek_hibak)): ?>
            <div class="kepek-hibak" role="alert">
                <?php foreach ($kepek_hibak as $hiba): ?>
                    <p><?= htmlspecialchars($hiba, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($bejelentkezve)): ?>
            <form method="post" enctype="multipart/form-data" class="kepek-urlap">
                <div class="kepek-mezo">
                    <label for="kep_fajl">Kép kiválasztása (JPG, JPEG, PNG, GIF, WEBP – max. 3 MB):</label>
                    <input type="file" id="kep_fajl" name="kep_fajl" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" required>
                </div>
                <button type="submit" name="kep_feltoltes" value="1">Feltöltés</button>
            </form>
        <?php else: ?>
            <p>Új kép feltöltéséhez jelentkezz be a <strong>Bejelentkezés</strong> menüpontban.</p>
        <?php endif; ?>
    </section>

    <section class="kepek-galeria-blokk" aria-label="Képgaléria">
        <h3>Galéria</h3>
        <?php if (!empty($galeria_kepek)): ?>
            <div class="kepek-lista">
                <?php foreach ($galeria_kepek as $kep): ?>
                    <figure class="kepek-elem">
                        <img src="<?= htmlspecialchars($kep['url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($kep['fajlnev'], ENT_QUOTES, 'UTF-8') ?>">
                        <figcaption><?= htmlspecialchars($kep['fajlnev'], ENT_QUOTES, 'UTF-8') ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Még nincsenek kilistázott képek.</p>
        <?php endif; ?>
    </section>
</div>