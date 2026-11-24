<?php
$kepek_uzenetek = [];
$kepek_hibak = [];
$galeria_kepek = [];

$bejelentkezve = isset($_SESSION['login']) && !empty($_SESSION['login']);

$kepek_mappa = __DIR__ . '/../images/galeria';
$kepek_url_alap = 'images/galeria';
$engedelyezett_kiterjesztesek = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$max_meret_bajtok = 3 * 1024 * 1024; // 3 MB

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kep_feltoltes'])) {
    if (!$bejelentkezve) {
        $kepek_hibak[] = 'Képfeltöltéshez be kell jelentkezni.';
    } elseif (!isset($_FILES['kep_fajl']) || !is_array($_FILES['kep_fajl'])) {
        $kepek_hibak[] = 'Nem érkezett érvényes fájl.';
    } else {
        $fajl_info = $_FILES['kep_fajl'];
        $hiba_kod = $fajl_info['error'] ?? UPLOAD_ERR_NO_FILE;

        if ($hiba_kod === UPLOAD_ERR_NO_FILE) {
            $kepek_hibak[] = 'Válassz ki egy képfájlt a feltöltéshez.';
        } elseif ($hiba_kod === UPLOAD_ERR_INI_SIZE || $hiba_kod === UPLOAD_ERR_FORM_SIZE) {
            $kepek_hibak[] = 'A kiválasztott kép túl nagy.';
        } elseif ($hiba_kod !== UPLOAD_ERR_OK) {
            $kepek_hibak[] = 'Hiba történt a fájl feltöltése során (hibakód: ' . (int)$hiba_kod . ').';
        } else {
            $atmeneti_ut = $fajl_info['tmp_name'] ?? '';
            $meret = (int)($fajl_info['size'] ?? 0);
            $eredeti_nev = (string)($fajl_info['name'] ?? '');

            if ($meret <= 0 || $meret > $max_meret_bajtok) {
                $kepek_hibak[] = 'A kép mérete legfeljebb 3 MB lehet.';
            } elseif (!is_uploaded_file($atmeneti_ut)) {
                $kepek_hibak[] = 'Érvénytelen feltöltött fájl.';
            } else {
                $kit = strtolower(pathinfo($eredeti_nev, PATHINFO_EXTENSION));
                $kep_adat = @getimagesize($atmeneti_ut);

                if (!in_array($kit, $engedelyezett_kiterjesztesek, true) || $kep_adat === false) {
                    $kepek_hibak[] = 'Csak érvényes JPG, JPEG, PNG, GIF vagy WEBP képfájl tölthető fel.';
                } elseif (!is_dir($kepek_mappa) && !@mkdir($kepek_mappa, 0775, true)) {
                    $kepek_hibak[] = 'A galéria mappa nem érhető el.';
                } else {
                    $alap_nev = pathinfo($eredeti_nev, PATHINFO_FILENAME);
                    $tisztitott_nev = preg_replace('/[^a-zA-Z0-9_-]+/', '_', $alap_nev);
                    $tisztitott_nev = trim((string)$tisztitott_nev, '_-');
                    if ($tisztitott_nev === '') {
                        $tisztitott_nev = 'kep';
                    }

                    $cel_fajlnev = $tisztitott_nev . '.' . $kit;
                    $cel_ut = $kepek_mappa . '/' . $cel_fajlnev;
                    $szamlalo = 1;
                    while (file_exists($cel_ut)) {
                        $cel_fajlnev = $tisztitott_nev . '_' . $szamlalo . '.' . $kit;
                        $cel_ut = $kepek_mappa . '/' . $cel_fajlnev;
                        $szamlalo++;
                    }

                    if (@move_uploaded_file($atmeneti_ut, $cel_ut)) {
                        $kepek_uzenetek[] = 'A kép sikeresen feltöltve: ' . $cel_fajlnev;
                    } else {
                        $kepek_hibak[] = 'A kép mentése az images/galeria mappába nem sikerült.';
                    }
                }
            }
        }
    }
}

if (is_dir($kepek_mappa)) {
    $fajlok = scandir($kepek_mappa);
    if ($fajlok !== false) {
        foreach ($fajlok as $fajl) {
            if ($fajl === '.' || $fajl === '..') {
                continue;
            }
            $teljes_ut = $kepek_mappa . '/' . $fajl;
            if (!is_file($teljes_ut)) {
                continue;
            }
            $kit = strtolower(pathinfo($fajl, PATHINFO_EXTENSION));
            if (in_array($kit, $engedelyezett_kiterjesztesek, true)) {
                $galeria_kepek[] = [
                    'fajlnev' => $fajl,
                    'url' => $kepek_url_alap . '/' . rawurlencode($fajl),
                ];
            }
        }
    }
}