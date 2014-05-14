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