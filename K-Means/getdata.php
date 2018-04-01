<?php 

$host = "localhost"; // Nama hostnya
$user = "root"; // Username
$pass = ""; // Password (Isi jika menggunakan password)
$connect = mysqli_connect($host, $user, $pass, "niatwoy"); // Koneksi ke MySQL
$query = "SELECT CONCAT(idAyat,CONCAT(';',CONCAT(hasil))) gabung FROM hasil_tfidf";

// $query = "SELECT * FROM hasil_tfidf";
$result = mysqli_query($connect,$query);

$getArrH = array();
while ($row = mysqli_fetch_assoc($result)){
$getArrH[] = $row;
};

$hslH = array_column($getArrH, 'gabung');

// $jHslH =  implode("\n", $hslH);

$jHslH = json_encode($hslH);

// foreach ($getArrH as $key => $value) {
// 	# code...
// 	$jHslH[] = $value."\n";
// }

// print_r($jHslH);
 ?>