<?php
$szerelok = [];
$hiba = '';

try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=gyakorlat7;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $lekerdezes = $dbh->query(
        'SELECT az, nev, kezdev FROM szerelo ORDER BY az'
    );

    $szerelok = $lekerdezes->fetchAll();
} catch (PDOException $e) {
    $hiba = 'A szerelők adatait most nem sikerült betölteni.';
    error_log($e->getMessage());
}