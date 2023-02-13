<?php
// GET SURAH
function get_surah()
{
    $res = file_get_contents("https://quran.kemenag.go.id/api/v1/surah");
    $data = json_decode($res);
    echo '<pre>', print_r($data->data), '</pre>';

    $fp = fopen("surah_list.json", "wb");
    fwrite($fp, json_encode($data->data));
    fclose($fp);
}

// GET AYAH
function get_ayah($surah_start = 1, $surah_end = 1, $ayah_start = 0, $ayah_end = 1000)
{
    // MAX: $surah = 114;
    $surah_end = ($surah_end < $surah_start) ? $surah_start : $surah_end;
    $surah_end = $surah_end > 114 ? 114 : $surah_end;
    for ($i = $surah_start; $i <= $surah_end; $i++) {
        $res = file_get_contents("https://quran.kemenag.go.id/api/v1/ayatweb/" . $i . "/0/" . $ayah_start . "/" . $ayah_end);
        $data = json_decode($res);
        echo '<pre>', print_r($data->data), '</pre>';

        $fp = fopen("Surah/" . $i . ".json", "wb");
        fwrite($fp, json_encode($data->data));
        fclose($fp);
    }
}

function get_tafsir($ayah_id_start = 1, $ayah_id_end = 1)
{
    // MAX: $ayah_id = 6231;
    $ayah_id_end = ($ayah_id_end < $ayah_id_start) ? $ayah_id_start : $ayah_id_end;
    $ayah_id_end = $ayah_id_end > 6231 ? 6231 : $ayah_id_end;
    for ($i = $ayah_id_start; $i <= $ayah_id_end; $i++) {
        $res = file_get_contents("https://quran.kemenag.go.id/api/v1/tafsirbyayat/" . $i);
        $data = json_decode($res);
        echo '<pre>', print_r($data->tafsir), '</pre>';

        $fp = fopen("Tafsir/" . $i . ".json", "wb");
        fwrite($fp, json_encode($data->tafsir));
        fclose($fp);
    }
}

function get_audio($surah = 1, $ayah = 1)
{
    for ($i = 1; $i <= 3; $i++) {
        $surah = (strlen($surah) < $i ? "0" : "") . $surah;
        $ayah = (strlen($ayah) < $i ? "0" : "") . $ayah;
    }
    file_put_contents("Audio/" . $surah . $ayah . ".mp3", fopen("https://quran.kemenag.go.id/cmsq/source/s01/" . $surah . $ayah . ".mp3", 'r'));
}

// get_surah();
// get_ayah(1);
// get_tafsir(1, 50);
// get_audio(2, 21);
