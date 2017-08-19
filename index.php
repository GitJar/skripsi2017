<?php
$awal = microtime(true);
ob_start();  
define('core', true); 
define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__FILE__) . DS);
include_once DIR.'include'.DS.'config.php';
include_once DIR.'lib'.DS.'database.class.php';
include_once DIR.'lib'.DS.'core.naziefadriani.php';

$Core = new Core(); // Membuat variabel baru untuk class Core

// Memanggil fungsi cek kamus (cetak awal)
$cekQuran = $Core->cekQuran();
while($result = $cekQuran->fetch_array())
{
	$idAyat = $result['idAyat'];
	$terjemahanAsli = $result['Terjemahan'];
	$terjemahan = $result['Terjemahan'];
	$terjemahan = strtolower($terjemahan);
	$terjemahan = $Core->clean($terjemahan);
	$terjemahan = $Core->stopword($terjemahan);
	echo "<font color = red>";
	// var_dump($terjemahan);
	print($terjemahanAsli."<br>");
	echo "</font>";
	$terjemahan = $Core->stemming(trim($terjemahan));
	//$terjemahan = $Core->stemming(trim($terjemahan));
	print($idAyat." ".$terjemahan."<br>");
}
//$kataJadi = $Core->kataAkhir();
$akhir = microtime(true);
$totalwaktu = $akhir  - $awal;
echo "<br><br><br>Halaman ini di eksekusi dalam waktu " . number_format($totalwaktu, 3, '.', '') . " detik!";
?>