
<h2>Szerelők nyilvántartása</h2>
<?php if (isset($_SESSION['login'])): ?>
    <p>
        <a href="crud-uj">Új szerelő felvétele</a>
    </p>
<?php else: ?>
    <p>Új szerelő felvételéhez jelentkezz be!</p>
<?php endif; ?>
<?php if ($hiba !== ''): ?>
    <p><?= htmlspecialchars($hiba, ENT_QUOTES, 'UTF-8') ?></p>

<?php elseif (empty($szerelok)): ?>
    <p>Még nincs rögzített szerelő.</p>

<?php else: ?>
    <table>
        <thead>
            <tr>
                <th scope="col">Azonosító</th>
                <th scope="col">Név</th>
                <th scope="col">Munkakezdés éve</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($szerelok as $szerelo): ?>
                <tr>
                    <td><?= (int) $szerelo['az'] ?></td>
                    <td>
                        <?= htmlspecialchars(
                            $szerelo['nev'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>
                    <td><?= (int) $szerelo['kezdev'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>