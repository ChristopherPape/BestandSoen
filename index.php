<?php
# Mietgliedsnummer 3633900  (falls benötigt


#Laufzeitmessung Beginn
$script_start = time();

# Zugangsdaten FTP Server
$ftp_server = 'ftpshop.soennecken.de';

$ftp_user = '3633900';

$ftp_pass = 'fj7eG94ms';

# Verzeichnis
$ftp_dir  = 'Bestand';

$local_dir = 'Bestand';

# Verbindung aufbauen
$conn_id = ftp_connect($ftp_server);

# Login
$login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);

# Verzeichnung festlegen
ftp_chdir($conn_id, $ftp_dir . '/');

# Dateiformat auswählen
list($file) = ftp_nlist($conn_id, '*.txt');

# Datei löschen falls bereits vorhanden
if(file_exists($local_dir . '/' . $file)){

    unlink($local_dir . '/' . $file);

}

# Datei herunterladen
$ftp_get = ftp_get($conn_id, $local_dir . '/' . $file, $file, FTP_ASCII);

# wenn Datei erfolgreich heruntergeladen wurde, dann Datei auslesen
if($ftp_get){

    $file_content = file($local_dir . '/' . $file);

    # Zeilen auslesen
    foreach($file_content as $file_row){

        list($LogserveArtikelNr, $Artikeltext, $Artikelstatus, $Bestand, $Zeitstempel, $LogserveArtikelNrErsatz, $EAN, $BesorgerKennzeichen, $StreckenKennzeichen, $Kundenartikelnummer, $Lieferzeit, $temp_1, $temp_2) = explode('|', $file_row);

        $Artikeltext = utf8_encode($Artikeltext);

        echo $Artikeltext .': <b>'. $LogserveArtikelNr .'</b> -> '. $Bestand .' -> '. $EAN .' -> '. $Lieferzeit .'<br>';

    }

    # Status für Logfile
    $status = 'Transfer abgeschlossen';

} else{

    $status = 'Transfer fehlgeschlagen';

}

# Verbindung trennen
ftp_close($conn_id);

#Laufzeitmessung Ende
$script_end = time();

# Dateigröße
$size = round((filesize($local_dir . '/' . $file) / 1024) / 1024, 3);

$laufzeit = $script_end - $script_start;

# Logfile aktualisieren
$content = '############## Logfile ##############';

$content .= "\r\n#\r\n";

$content .= '# Aktualisierung: ' . date('Y-m-d H:i:s', time());

$content .= "\r\n";

$content .= '# Status: ' . $status;

$content .= "\r\n";

$content .= '# Dateigröße: ' . $size . ' MB';

$content .= "\r\n";

$content .= '# Laufzeit: ' . $laufzeit . ' Sekunden';

$content .= "\r\n#\r\n";

$content .= '################ END ################';

$handle = fopen($local_dir . '/logfile.txt', 'w');

fwrite($handle, $content);

fclose($handle);

?>