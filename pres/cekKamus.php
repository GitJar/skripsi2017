<?php 
//function cekKamus($kata){ 
    $k = mysqli_connect('localhost','root','','niatwoy'); 
    $sql = mysqli_query($k, "SELECT Terjemahan from albaqarah LIMIT 10");
    $result = mysqli_num_rows($sql);
    	
//}

while($row = mysqli_fetch_array($sql)) {
    $terj_ayat = $row['Terjemahan'];

    //tampilkan Terjemahan  
    print("<hr />Terjemahan asli: <br /><font color=red>" . $terj_ayat . "</font><br />");
}
 ?>