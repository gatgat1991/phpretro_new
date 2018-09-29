<?php

// Cache System Online  15 Minuten\\

// Pfad und Name der Cache-Datei und Gueltigkeitsdauer in Sekunden
$CacheDatei = "cache/status.txt";
$CacheDauer = 15;

// Pruefen ob eine entsprechende Cache-Datei bereits existiert
// und ob sie noch gueltig ist
if (file_exists( $CacheDatei ) &&
   (time() - filemtime( $CacheDatei )) < $CacheDauer &&  empty($_GET) )
{
    // Statt die Seite dynamisch generieren zu lassen wird die
    // statische HTML-Datei eingebunden
    include( $CacheDatei );
    exit();
}

// Der interne Ausgabe-Puffer wird aktiviert
ob_start();

require_once('./includes/core.php');
$core = new core_sql;


//echo $GLOBALS['db']->result($GLOBALS['core']->select14());
$dn1 = $GLOBALS['db']->result($GLOBALS['core']->select18());
$nb_cats = $db->rowCount($dn1);
echo $nb_cats;



// Die Daten im Puffer umladen
$output = ob_get_contents();
 
// Die Cache-Datei anlegen und die Daten hinein schreiben
$datei = fopen( $CacheDatei, "w" );
fwrite( $datei, $output );
fclose( $datei );
 
// Puffer an den Browser ausgeben und die Pufferung deaktivieren
ob_end_flush();


