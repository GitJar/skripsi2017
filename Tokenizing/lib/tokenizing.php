<?php
if(!defined('core')){
    exit('No Dice!');
}
class Core extends Database{

	protected $link;
	function __construct()
	{
		$this->link = parent::connect();
	}
//fungsi untuk mengecek kata dalam tabel dictionary

	function cekQuran(){
        $query = $this->link->query("SELECT idAyat, Terjemahan FROM temp_filtering");
        $result = mysqli_num_rows($query);
        return $query;
    }

    function insertTokenizing($d,$t){
    $query = $this->link->query("INSERT INTO temp_token_filter  (idAyat,kataTerjemahan) VALUES ('$d','$t')");
    }
}
?>