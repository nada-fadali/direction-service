<?php
	
	//calculates distance between two points
	function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
	  	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		return ($miles * 1.609344);
	}

	$lat1 = $_POST['lat1'];
	$lng1 = $_POST['lng1'];
	$lat2 = $_POST['lat2'];
	$lng2 = $_POST['lng2'];

	$con = mysql_connect("localhost", "root", "");
	if(mysql_errno())
		echo "error connection to localhost";
	else {
		mysql_select_db("dmetprojdb", $con); //CLOSE THIS AND DELETE COMMENT

		


	}



	//create graph
	require_once 'Graph/Graph.php';
	require_once 'Graph/Vertex.php';
	require_once 'Graph/Dijkstra.php';

	//This graph is undirected
	//but weighted
	//since all streets are two ways
	//because -you know, because Egypt om el donia~
	$graph = new Graph();
	

?>