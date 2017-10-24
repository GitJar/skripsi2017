<?php
define('core', true);
define('DOC_ID', 0);
define('TERM_POSITION', 1);
define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__FILE__) . DS);
include_once DIR.'include'.DS.'config.php';
include_once DIR.'lib'.DS.'database.class.php';
include_once DIR.'lib'.DS.'core.tfidf.php';

$ir = new IR(); // Membuat variabel baru untuk class IR

// Memanggil fungsi cek kamus (cetak awal)
$jmlAyat = $ir->cekJmlAyat();
$cekQuran = $ir->cekQuran();
$row = $cekQuran->fetch_assoc();

while($result = $cekQuran->fetch_array()){
	$ayat[] = $result;
}

// print_r($ayat);
// echo $jmlAyat;

$D[0] = "alif laam miim";
$D[1] = "kitab alquran ragu tunjuk takwa";
$D[2] = "iman ghaib diri shalat nafkah rezeki anugerah";
$D[3] = "iman kitab alquran turun kitab kitab turun belum hidup akhirat";


echo "<p><b>Corpus:</b></p>";
mysqli_free_result($cekQuran);
foreach ($ayat as $key) {
	echo $key[1]."<BR>";
}
echo count($ayat);
	// $ir->show_docs($ayat['Terjemahan']);


echo "<p><b>Inverted Index:</b></p>";
$ir->create_index($key);
$ir->show_index();

$term = "kitab";  //kata asyik yang akan menjadi pusat perhitungan kita
$tf  = $ir->tf($term);
// $ndw = $ir->ndw($term);
$ts	 = $ir->ndw($term);
$idf = $ir->idf($term);
echo "<p>";
echo "Term Frequency of '$term' is $tf<br />";
echo "Number Of Documents with $term is $ts<br />";
echo "Inverse Document Frequency of $term is $idf";
echo "</p>";

?>