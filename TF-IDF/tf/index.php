<!DOCTYPE html>
<?php 
define('core', true); 
define("DOC_ID", 0);
define("TERM_POSITION", 1);
define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__FILE__) . DS);
include_once DIR.'include'.DS.'config.php';
include_once DIR.'include'.DS.'dokumen2.php';
include_once DIR.'lib'.DS.'database.class.php';
include_once DIR.'lib'.DS.'core.tfidf.php';
$ir = new IR();
$cekTerm = $ir->cekTerm();
// print_r($cekTerm);
$countTerm = $ir->countTerm();
$ayat = $ir->ayat();
print("Jumlah Term = ".$countTerm);
echo "<br>";
$ir->create_index($D);
echo "<br>";
$arr = $ir->indexAyat();
echo "<br>";
$indexAyat = $ir->indexAyat();

 ?>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    /*width: 100%;*/
}

td{
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
th {
    border: 1px solid #dddddd;
    text-align: center;
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
    <th rowspan="2">No</th>
    <th rowspan="2">Term</th>
    <th colspan="286">Ayat (D)</th>
    <th rowspan="2">TF</th>
    <th rowspan="2">DF</th>
    <th rowspan="2">IDF *LOG(D/DF)</th>
  </tr>
  <tr>
    <?php for ($i=1; $i <= 286; $i++) { 
      # code...
      ?><th><?php echo $i ?></th><?php 
    } ?>
  </tr>
   <tr>
   	<td>***</td>
   	<td>Jumlah Kata</td>
   	<?php 
   	$arrAyat = array();
   	$i = 0;
   	while ($result= $ayat->fetch_assoc()) {
		$terjemahan = $result['Terjemahan'];
		$cekKata = $ir->cekKata($terjemahan);
		$arrAyat[$i] = $cekKata;
		$i++;
	}
	for ($i=0; $i < 286; $i++) { 
	 	# code...
		?><td><?php echo $arrAyat[$i] ?></td><?php 
	 }
   	 ?>
   </tr>
<?php 
  $id = 0;
  $no = 1;
  while ($result= $cekTerm->fetch_assoc()) {
    # code...
    $term = $result['kataTerjemahan'];
    // print($terms."<br>");
    $tf  = $ir->tf($term);
    // $ndw = $ir->ndw($term);
    $ndw   = $ir->ndw($term);
    $idf = $ir->idf($term);
    ?>
      <tr>
        <td><?php echo $no ?></td>
        <td><?php echo $term ?></td>
        <?php 
        for ($i=0; $i < 286; $i++) { 
            echo "<td>".$arr[$id][$i]."</td>";
        }
         ?>
        <td><?php echo $tf ?></td>
        <td><?php echo $ndw ?></td>
        <td><?php echo $idf ?></td>
      </tr>
    <?php
    $id++;
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
