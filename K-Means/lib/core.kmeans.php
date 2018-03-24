<?php

/*
* Information Retrievel

*/

if(!defined('core')) {
	exit('No Dice!');
} 

class Cluster extends Database{
	protected $link;

	function __construct()
	{
		$this->link = parent::connect();
	}

	function insertTFIDF($a,$h){
        $query = $this->link->query("INSERT INTO hasil_tfidf  VALUES ('$a','$h')");
    }

    function cekNilai(){
    	$query = $this->link->query("SELECT * FROM hasil_tfidf ORDER BY idAyat");
		return $query;
    }

    function nilaiMin(){
    	$query = $this->link->query("SELECT min(hasil) nMin FROM hasil_tfidf");
    	$result = $query->fetch_assoc();
		return $result;
		// return $query;
    }

    function nilaiMax(){
    	$query = $this->link->query("SELECT max(hasil) nMax FROM hasil_tfidf");
    	$result = $query->fetch_assoc();
		return $result;
    }
}



?>