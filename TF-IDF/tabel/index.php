<!DOCTYPE html>
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
$ir->create_index($D);
echo "<br>";
$ir->indexAyat();
echo "<br>";
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
    <th rowspan="2">Term</th>
    <th colspan="286">Ayat</th>
  </tr>
  <tr>
    <?php for ($i=1; $i <= 286; $i++) { 
      # code...
      ?><th><?php echo $i ?></th><?php 
    } ?>
  </tr>
  <?php 
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
        <td><?php echo $term ?></td> 
        <?php 
        for ($i=1; $i <= 286; $i++) { 
          # code...
        }
         ?>       
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
