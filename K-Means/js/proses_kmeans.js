function updateDS() {
	var ds = "Ayat" ;
	if (ds in datasets)
		document.getElementById('data').value = datasets[ds] ;
	else
		document.getElementById('data').value = "" ;
}

function parseData(data) {
	var labels = new Array() ;
	var vectors = new Array() ;
	lines = data.split(",") ;
	for (var i = 0 ; i < lines.length ; i++) {
		if (lines[i].length == 0)
			continue ;
		var elements = lines[i].split(";") ;
		var label = elements.shift() ;
		var vector = new Array() ;
		for (j = 0 ; j < elements.length ; j++)
			vector.push(parseFloat(elements[j])) ;
		vectors.push(vector) ;
		labels.push(label) ;
	}
	return {'labels': labels , 'vectors': vectors} ;
}
function runAlgo() {
	runKM() ;
	document.getElementById('output_panel').style.display = 'block' ;
} 
function updateAlgo() {
	document.getElementById('text').innerHTML = ""; 
	document.getElementById('output_panel').style.display = 'none' ;
} 
function runKM() {
	var data = parseData (document.getElementById('data').value) ;
	var vectors = data['vectors'] ;
	var labels = data['labels'] ;
	var domobj = document.getElementById('KM-K') ;
	var K = parseInt (domobj.options[domobj.selectedIndex].value) ;
  	var clusters = figue.kmeans(K , vectors);
	
	var txt ;
	if (clusters) {
		txt = "<table border='1'>" ;
		txt += "<tr><th>Ayat Ke-</th><th>Nilai</th><th>Cluster id</th><th>Cluster centroid</th></tr>";
		for (var i = 0 ; i < vectors.length ; i++) {
			var index = clusters.assignments[i] ;
			txt += "<tr><td>" + labels[i] + "</td><td>" + vectors[i] + "</td><td>" + index + "</td><td>" + clusters.centroids[index] + "</td></tr>";
		}
		txt += "</table>"
	} else 
		txt = "No result (too many clusters/too few different instances (try changing K)" ;
  document.getElementById('text').innerHTML = txt; 
}
	
window.onload = function() {
	updateDS();
	updateAlgo();
} 