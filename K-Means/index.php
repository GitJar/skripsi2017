<?php 
define('core', true);
define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__FILE__) . DS);

include_once DIR.'include'.DS.'config.php';
include_once DIR.'lib'.DS.'database.class.php';
include_once DIR.'lib'.DS.'core.kmeans.php';

$cl = new Cluster();

$nilai = $cl->cekNilai();
$nMin = $cl->nilaiMin();
$nMax = $cl->nilaiMax();
$c1 = rand($nMin['nMin'],$nMax['nMax']);
// printf("%F",$nMin);
// print_r($nMin);
// echo $nMin;
echo "Nilai Min = ".$nMin['nMin'];
// echo "Nilai Min = ".floatval($nMin);
echo "<br>";
// echo "Nilai Max = ".floatval($nMax);
echo "Nilai Max = ".$nMax['nMax'];
echo "<br>";
echo $c1;
while($result = $nilai->fetch_assoc()){
	$ayat = $result['idAyat'];
	$tfidf = $result['hasil'];
	// echo "[".$ayat."] ".$tfidf;
	// echo "<br>";
}

 ?>