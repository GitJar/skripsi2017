<?php
define('core', true); 
define("DOC_ID", 0);
define("TERM_POSITION", 1);
define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__FILE__) . DS);
include_once DIR.'include'.DS.'config.php';
include_once DIR.'include'.DS.'dokumen.php';
include_once DIR.'lib'.DS.'database.class.php';
include_once DIR.'lib'.DS.'core.tfidf.php';
$ir = new IR();
$cekTerm = $ir->cekTerm();
$countTerm = $ir->countTerm();
print("Jumlah Term = ".$countTerm);
echo "<br>";
/*$json = mysqli_fetch_all ($cekTerm, MYSQLI_ASSOC);
echo json_encode($json);*/
$ir->create_index($D);

/*echo "<p><b>Corpus</b></p>";
$ir->show_docs($D);*/

echo "<p><b>Inverted Index:</b></p>";
$ir->show_index();

/*while ($result= $cekTerm->fetch_assoc()) {
	# code...
	$term = $result['kataTerjemahan'];
	// print($terms."<br>");
	$tf  = $ir->tf($term);
	$ndw = $ir->ndw($term);
	$idf = $ir->idf($term);
	echo "<p>";
	echo "Term Frequency of '$term' is $tf<br />";
	echo "Number Of Documents with '$term' is $ndw<br />";
	echo "Inverse Document Frequency of '$term' is $idf";
	echo "</p>";
}*/

?>