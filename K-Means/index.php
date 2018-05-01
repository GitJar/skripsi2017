<?php 
include_once "getdata.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>K-Means Clutering</title>
<script type="text/javascript" src="js/figue.js"></script>
<!-- Inline JS-->
<script type="text/javascript" src="js/proses_kmeans.js"></script>
<script type="text/javascript">
	var datasets = {
	'Ayat': <?php echo $jHslH ?>
} ;
</script>
<!-- end of Inline JS-->
<!-- end JS-->
</head>
<body id="home">
<!-- main content area -->   
<div id="main" class="wrapper clearfix">   
	<!-- content area -->    
<!-- 	<section id="content">
    	<main>
 <div id="data_panel"> -->
  <!-- <fieldset>
   <legend>
    Input
   </legend> -->
   <textarea cols="40" id="data" rows="8">
   </textarea>
  <!-- </fieldset> -->
  <!-- <fieldset id="km_params"> -->
  Number of clusters (K):  
  <select id="KM-K">
    <option value="2">2</option>
    <option value="3" selected="selected">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
  </select>
 <!-- </fieldset> -->
 </div>
 <div id="cluster_button" style="">
  <div style="display:table-row; width:100%;text-align:center;">
   <div style="vertical-align: left; display:table-cell;">
    <input onClick="runAlgo();" type="button" value="Cluster data"/>
   </div>
  </div>
 </div>
 <div id="output_panel">
  <fieldset>
   <legend>
    <strong>
     Output
    </strong>
   </legend>
   <pre id="text"> </pre>
   <pre>
   
   </fieldset>
 <!-- </div> -->

  <span class="AgExposePic">
   <!--#include virtual="../../Ads/Ag Expose Picture Yellow.log" -->
  </span>
 </p>
</main>
	</section><!-- #end content area -->
        
</div><!-- #end div #main .wrapper -->
<!-- footer area -->    

</body>
</html>