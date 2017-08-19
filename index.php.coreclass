<?php
$awal = microtime(true);
ob_start();  
define('core', true); 
define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__FILE__) . DS);
include_once DIR.'include'.DS.'config.php';
include_once DIR.'lib'.DS.'database.class.php';
include_once DIR.'lib'.DS.'core.class.php';

$Core = new Core(); // Membuat variabel baru untuk class Core

// Memanggil fungsi cek kamus (cetak awal)
$cekQuran = $Core->cekQuran();
while($result = $cekQuran->fetch_array())
{
	$idAyat = $result['idAyat'];
	$terjemahan = $result['Terjemahan'];
	$terjemahan = strtolower($terjemahan);
	$terjemahan = $Core->clean($terjemahan);
	$terjemahan = $Core->stopword($terjemahan);
	$terjemahan = $Core->stemming1($terjemahan);
	$terjemahan = $Core->stemming2($terjemahan);
	$terjemahan = $Core->stemming3($terjemahan);
	$terjemahan = $Core->stemming4($terjemahan);
	$terjemahan = $Core->stemming5($terjemahan);

	//print($terjemahan."<br>");
	print($idAyat." ".$terjemahan."<br>");
}
//$kataJadi = $Core->kataAkhir();
$akhir = microtime(true);
$totalwaktu = $akhir  - $awal;
echo "<br><br><br>Halaman ini di eksekusi dalam waktu " . number_format($totalwaktu, 3, '.', '') . " detik!";
?>