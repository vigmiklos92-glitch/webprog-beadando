<?php
$hibak = [];
$nev = '';
$kezdev = '';

if (!isset($_SESSION['login'])) {
    header('Location: belepes');
    exit;
}

// Az űrlaphoz tartozó biztonsági azonosító.
if (empty($_SESSION['crud_token'])) {
    $_SESSION['crud_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev = is_string($_POST['nev'] ?? null)
        ? trim($_POST['nev']) : '';

    $kezdev = is_string($_POST['kezdev'] ?? null)
        ? trim($_POST['kezdev']) : '';

    $token = is_string($_POST['token'] ?? null)
        ? $_POST['token'] : '';

    if (!hash_equals($_SESSION['crud_token'], $token)) {
        $hibak[] = 'Érvénytelen űrlap. Frissítsd az oldalt!';
    }

    if ($nev === '' || mb_strlen($nev, 'UTF-8') > 100) {
        $hibak[] = 'A név megadása kötelező, legfeljebb 100 karakter lehet.';
    }

    if (
        !preg_match('/^[0-9]{4}$/', $kezdev)
        || (int) $kezdev < 1900
        || (int) $kezdev > (int) date('Y')
    ) {
        $hibak[] = 'A munkakezdés éve 1900 és az aktuális év közötti évszám legyen.';
    }

    if (empty($hibak)) {
        try {
            $dbh = new PDO(
                'mysql:host=localhost;dbname=gyakorlat7;charset=utf8mb4',
                'root',
                '',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $utasitas = $dbh->prepare(
                'INSERT INTO szerelo (nev, kezdev)
                 VALUES (:nev, :kezdev)'
            );

            $utasitas->execute([
                ':nev' => $nev,
                ':kezdev' => (int) $kezdev
            ]);

            // Sikeres mentés után visszatérünk a listához.
            header('Location: crud', true, 303);
            exit;
        } catch (PDOException $e) {
            $hibak[] = 'A mentés nem sikerült. Próbáld újra később!';
            error_log($e->getMessage());
        }
    }
}