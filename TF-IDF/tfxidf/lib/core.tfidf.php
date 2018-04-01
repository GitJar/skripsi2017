<?php

/*
* Information Retrievel

*/

if(!defined('core')) {
	exit('No Dice!');
} 

class IR extends Database{
	protected $link;

	public $num_docs = 0;
	public $corpus_terms = array();

	function __construct()
	{
		$this->link = parent::connect();
	}

	function cekTerm(){
		$query = $this->link->query("SELECT * FROM temp_term order by kataTerjemahan");
		return $query;
	}

	function countTerm(){
		$query = $this->link->query("SELECT * FROM temp_term order by kataTerjemahan");
		$rowCnt = $query->num_rows;
		return $rowCnt;	
	}

	function cekJmlAyat(){
		$query = $this->link->query("SELECT idAyat, Terjemahan FROM temp_stemming");
		$result = $query->num_rows;
		return $result;
	}

	function show_docs($doc) {
		$jumlah_doc = count($doc);
		for($i=0; $i < $jumlah_doc; $i++) {
			echo "Dokumen ke-$i : $doc[$i] <br>";
		}
	}

	function insertTFIDF($a,$h){
        $query = $this->link->query("INSERT INTO hasil_tfidf  VALUES ('$a','$h')");
    }

/*
* Membuat  Index
*/
function create_index($D) {
	$this->num_docs = count($D);
	for($doc_num=0; $doc_num < $this->num_docs; $doc_num++) {

		$doc_terms = array();
// simplified word tokenization process
		$doc_terms = explode(" ", $D[$doc_num]);

		$num_terms = count($doc_terms);
		for($term_position=0; $term_position < $num_terms; $term_position++) {
			$term = strtolower($doc_terms[$term_position]);
			$this->corpus_terms[$term][]=array($doc_num, $term_position);
		}
	}
}

/*
* Show Index
*
*/
function show_index() {

	ksort($this->corpus_terms);

	foreach($this->corpus_terms AS $term => $doc_locations) {
		echo "<b>$term:</b> ";

		foreach($doc_locations AS $doc_location){
			echo "{".$doc_location[DOC_ID].", ".$doc_location[TERM_POSITION]."} ";
		}
			//mulai

			//end	
		echo "<br />";
	}

	
}

function indexAyat(){
	ksort($this->corpus_terms);
	$pos = 0;
	$tempArr = array();
	$tempArrCount = array();
	// print_r( $this->corpus_terms);
	foreach ($this->corpus_terms as $term) {
		// echo "$term";
		// print_r($this->corpus_terms);
		for ($i=0; $i < count($term); $i++) { 
			$tempArr[$pos][$i] = $term[$i][0];
			// echo $value[$i][0];
			// echo "<br>";
		}
		$tempArrCount[$pos] = array_count_values($tempArr[$pos]);
		$pos++;
	}

	//START VIEW
// echo '<pre>';
	$i = 0;
	$arr = array();
	foreach ($tempArrCount as $value) {
		for ($c=0; $c < 286; $c++) { 
			if(isset($value[$c])){
				$arr[$i][$c] = $value[$c];
			}else{
				$arr[$i][$c] = '0';
			}
		}
		$i++;
	}
	// echo "<pre>";
	// print_r($arr);

	return $arr;

/*echo "<table>";
foreach ($tempArrCount as $array1) {
	// foreach ($array1 as $array2) {
		// echo '<br>';
	echo "<tr>";
		// var_dump($array1);

		for ($i=0; $i < 286; $i++) { 

			if(isset($array1[$i])) {
				echo "<td>".$array1[$i]."</td>";
			}
			else {
				echo "<td>".'0'."</td>";
			}
		}
	// }
		echo "</tr>";
}
		echo "</table>";*/
		//END VIEW
	// foreach ($tempArrCount as $value) {
	// 	// print_r( $tempArrCount);
	// 		$j=1;
	// 		$max=286;
	// 	foreach ($value as $indexx => $arrVal) {
	// 		for ($i=$j; $i <=$max ; $i++) { 
	// 			# code...
	// 			// echo "<br>".$i."<br>";
	// 			if ($i == $indexx) {
	// 				$j=$indexx+1;
	// 				// echo "Ayat ".$indexx." Jumlah ".$arrVal;
	// 				echo $arrVal;
	// 				# code...
	// 				break;
	// 			}
	// 			else {
	// 				echo "0";
	// 			}
	// 		}
	// 		/*for ($a=$j;$i<=286;$i++)
	// 			echo "0";*/
	// 		// echo $j;
	// 		// echo "<br>";
	// 	}
	// 	/*foreach ($value as $index => $arrVal) {
	// 		echo "Ayat ".$index." Jumlah ".$arrVal."<br>";
	// 	}*/
	// 	echo "<br>";
	// }
}

/*
* Menghitung Term Frequency (TF)
*

*/
function tf($term) {
	// $term = strtolower($term);
	return count($this->corpus_terms[$term]);
}

/*
* Menghitung Number Documents With
*
*/

/*function grabArray($arr){
	$temp = array();
	for ($i=0; $i < count($arr); $i++) { 
		$temp[$i] = $arr[$i];
	}
}*/

function ndw($term){
	// $term = strtolower($term);
	$doc_locations = $this->corpus_terms[$term];
	// $num_locations = count($doc_locations);
	// $docs_with_term = array();
	$temp = array();
	$i=0;
	// print_r($doc_locations);
	// echo("test");
	// echo("count :". count($doc_locations));

	foreach ($doc_locations as $value) {
		$temp[$i] = $value[0];
		$i++;
		// echo($value[0]);
	}
	// echo($i);
	// print_r($temp);
	// echo(count(array_count_values($temp)));

	// $temp = grabArray($doc_locations);
	// print_r($temp);
	// for($doc_location=0; $doc_location < $num_locations; $doc_location++){
	// 	$docs_with_term[$i];
	// 	$i++;	
	// }
	// return count($docs_with_term);
	return count(array_count_values($temp));
}

/*
* Menghitung Inverse Document Frequency (IDF)
*
*/
function idf($term) {
	return log10($this->num_docs)/$this->ndw($term);
}

}



?>