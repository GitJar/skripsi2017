<?php 
$conn = new mysqli("localhost","root","","niatwoy");

if ($conn->connect_error){
	die("Koneksi gagal".$conn->connect_error);
}
$query = "SELECT kataTerjemahan from temp_term_filter";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
	# code...
	echo $row['kataTerjemahan'];
	echo "<br>";
}

$conn->close();

 ?>