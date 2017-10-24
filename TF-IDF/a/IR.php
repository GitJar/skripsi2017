<?php

/*
* Information Retrievel

*/

define("DOC_ID", 0);
define("TERM_POSITION", 1);

class IR {

	public $num_docs = 0;

	public $corpus_terms = array();

	function show_docs($doc) {
		$jumlah_doc = count($doc);
		for($i=0; $i < $jumlah_doc; $i++) {
			echo "Dokumen ke-$i : $doc[$i] <br>";
		}
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
		foreach($doc_locations AS $doc_location)
			echo "{".$doc_location[DOC_ID].", ".$doc_location[TERM_POSITION]."} ";
		echo "<br />";
	}
}

/*
* Menghitung Term Frequency (TF)
*

*/
function tf($term) {
	$term = strtolower($term);
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
	$term = strtolower($term);
	$doc_locations = $this->corpus_terms[$term];
	$num_locations = count($doc_locations);
	$docs_with_term = array();
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
	return log($this->num_docs)/$this->ndw($term);
}

}



?>