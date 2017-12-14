<?php
define('core', true); 
define("DOC_ID", 0);
define("TERM_POSITION", 1);
define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__FILE__) . DS);
include_once DIR.'include'.DS.'config.php';
include_once DIR.'include'.DS.'dokumen.php';
include_once DIR.'lib'.DS.'database.class.php';
include_once DIR.'lib'.DS.'IR.php';
$ir = new IR();
$cekTerm = $ir->cekTerm();
$countTerm = $ir->countTerm();
print("Jumlah Term = ".$countTerm);
echo "<br>";
/*$json = mysqli_fetch_all ($cekTerm, MYSQLI_ASSOC);
echo json_encode($json);*/

$ir->create_index($D);

/*while ($result= $cekTerm->fetch_assoc()) {
	# code...
	$term = $result['kataTerjemahan'];
	// print($terms."<br>");
	$tf  = $ir->tf($term);
	// $ndw = $ir->ndw($term);
	$ts	 = $ir->ndw($term);
	$idf = $ir->idf($term);
	echo "<p>";
	echo "Term Frequency of '$term' is $tf<br />";
	echo "Number Of Documents with $term is $ts<br />";
	echo "Inverse Document Frequency of $term is $idf";
	echo "</p>";
}*/

?>

<!DOCTYPE html>
<html>
<head>
	<title>TFIDF</title>
</head>
<body>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    /*width: 100%;*/
}

 th {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 8px;
}

td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>

<table>
  <tr>
    <th>No</th>
    <th>Term</th>
    <th>TF</th>
    <th>df</th>
    <th>IDF</th>
    
  </tr>
  <?php 
  $no = 1;
	while ($result= $cekTerm->fetch_assoc()) {
		# code...
		$term = $result['kataTerjemahan'];
		// print($terms."<br>");
		$tf  = $ir->tf($term);
		// $ndw = $ir->ndw($term);
		$ndw	 = $ir->ndw($term);
		$idf = $ir->idf($term);
		?>
		  <tr>
		    <td><?php echo $no ?></td>
		    <td><?php echo $term ?></td>
		    <td><?php echo $tf ?></td>
		    <td><?php echo $ndw ?></td>
		    <td><?php echo $idf ?></td>
		    
		  </tr>
		<?php
		$no++;
		/*echo "<p>";
		echo "Term Frequency of '$term' is $tf<br />";
		echo "Number Of Documents with $term is $ndw<br />";
		echo "Inverse Document Frequency of $term is $idf";
		echo "</p>";*/
	}
   ?>
</table>
</body>
</html>