<?php
	
	require_once 'Graph/Graph.php';
	require_once 'Graph/Vertex.php';
	require_once 'Graph/Dijkstra.php';
	require_once 'Functions/search.php';
	require_once 'Functions/distance.php';
	require_once 'Functions/bearing.php';

	//session_start(); 

	####################
	##	Start of script
	####################
	
	/*
	*	Initialize graph one time only
	*/

	$con = mysql_connect("localhost", "root", "") or die("error connecting to database");
	
	mysql_select_db("dmetprojdb", $con);

	//get nodes
	$rs = mysql_query(" SELECT * FROM Nodes ");
	$node = array();
	while($row = mysql_fetch_array($rs)){
		$node[$row[0]] = array($row[1], $row[2]);
	}

	#for ($i=1 ; $i <= count($node) ; $i++) { 
	#	echo "Node #" . $i . " lat: " . $node[$i][0] . " lng:". $node[$i][1]."<br>";
	#}



	//connections between nodes
	$rs = mysql_query(" SELECT * FROM Nodes_Streets");
	$link = array();
	$i = 1;
	while($row = mysql_fetch_array($rs)){
		$link[$i] = array($row[0], $row[1], $row[2]);
		$i++;
	}

	#for ($i=1 ; $i <= count($link) ; $i++) { 
	#	echo "Link #" . $i . " n1: " . $link[$i][0] . " n2: ". $link[$i][1]. " street: ". $link[$i][2] ."<br>";
	#}


	mysql_close($con); 
		

	//This graph is undirected
	//but weighted
	//since all streets are two ways
	//because -you know, because Egypt om el donia~
	$graph = new Graph();

	//create nodes of the graph
	$v = array();
	for ($i=1; $i < 30; $i++) { 
		$v[$i] = new Vertex($i);
		#var_dump($v[$i]); echo "<br><br>";
	}

	//connect nodes
	for ($i=1; $i < count($link); $i++) {
		$n1 = intval($link[$i][0]);
		$n2 = intval($link[$i][1]); 
		#echo "$n1 <br> $n2 <br><br>";

		$distance = distance(
			floatval($node[$n1][0]), floatval($node[$n1][1]),
			floatval($node[$n2][0]), floatval($node[$n2][1])
		);

		$v[$n1]->connect($v[$n2], $distance.'');
		$v[$n2]->connect($v[$n1], $distance.'');
		#echo"$n1 ";var_dump($v[$n1]->getConnections());echo "<br><br>";
		#echo"$n2 ";var_dump($v[$n2]->getConnections());echo "<br><br><br>";
		
	}

	//add node to graph
	for ($i=1; $i <= count($v); $i++) { 
		$graph->add($v[$i]);
	}
	#var_dump($graph);


	/*
	*	round user input to the nearst nodes
	*/
	$ref= array($_POST['lat1'], $_POST['lng1']); #var_dump($ref);
	$distances = array_map(function($item) use($ref) {
	    $a = array_slice($item, -2);
	    return distance(floatval($a[0]), floatval($a[1]), floatval($ref[0]), floatval($ref[1]));
	}, $node);

	asort($distances);
	#var_dump($distances);
	//$n1 = array($node[key($distances)][1], $node[key($distances)][0]);

	//	Index of first node
	$key1 = array_search2d($node[key($distances)][0], $node);
	#var_dump($key1);

	$ref= array($_POST['lat2'], $_POST['lng2']);
	$distances = array_map(function($item) use($ref) {
	    $a = array_slice($item, -2);
	    return distance(floatval($a[0]), floatval($a[1]), floatval($ref[0]), floatval($ref[1]));
	}, $node);

	asort($distances);
	#var_dump($distances);
	//$n2 = array($node[key($distances)][1], $node[key($distances)][0]);

	//	Index of second node
	$key2 = array_search2d($node[key($distances)][0], $node);
	#var_dump($key2);

	//	calculate shortest path
	$algorithm = new Dijkstra($graph);
	$algorithm->setStartingVertex($graph->getVertex($key1));
	$algorithm->setEndingVertex($graph->getVertex($key2));

	//	return the nodes along this path
	$nn = split("-", $algorithm->getLiteralShortestPath());

	#var_dump($nn);echo "<br>";
	#echo $algorithm->getDistance();

	//	return value to the client side
	$res = "";

	// get directions from first node
	$s = array(
		'lat' => floatval($_POST['lat1']),
		'lng' => floatval( $_POST['lng1'])
	);
	$d = array(
		'lat' => floatval($node[intval($nn[0])][0]),
		'lng' => floatval($node[intval($nn[0])][1])
	);
	$direction = getDirection(getBearing($s, $d));
	$distance = intval(distance($s['lat'], $s['lng'], $d['lat'], $d['lng']) * 1000);
	$tmp = "|Go $direction for $distance M";

	for ($i=0; $i < count($nn)-1; $i+=2) { 
		// get nodes
		$lat1 = $node[intval($nn[$i])][0];
		$lng1 = $node[intval($nn[$i])][1];
		$lat2 = $node[intval($nn[$i+1])][0];
		$lng2 = $node[intval($nn[$i+1])][1];

		$res .=  $lat1 . "|" . $lng1 . "|" . $lat2 . "|" . $lng2 . "|";

		// get directions
		$s = array(
			'lat' => floatval($lat1),
			'lng' => floatval($lng1)
		);
		$d = array(
			'lat' => floatval($lat2),
			'lng' => floatval($lng2)
		);

		$direction = getDirection(getBearing($s, $d));
		$distance = intval(distance(floatval($lat1), floatval($lng1), floatval($lat2), floatval($lng2))*1000);
		$tmp .= "|". "Go $direction for $distance M";

	}

	// get direction to last node
	$s = array(
		'lat' => floatval($node[intval($nn[count($nn)-1])][0]),
		'lng' => floatval($node[intval($nn[count($nn)-1])][1])
	);
	$d = array(
		'lat' => floatval($_POST['lat2']),
		'lng' => floatval($_POST['lng2'])
	);
	$direction = getDirection(getBearing($s, $d));
	$distance = intval(distance($s['lat'], $s['lng'], $d['lat'], $d['lng'])*1000);
	$tmp .=  "|Go $direction for $distance M";




	//	return the final result
	echo $res .= $tmp . "|" . $algorithm->getDistance();

	//	free variables for memory usage sake
	$algorithm = null; unset($algorithm);
    $node = null; unset($node);
    $link = null; unset($link);
    $graph = null; unset($graph);
    $key1 = null; unset($key1);
    $key2 = null; unset($key2);
    $ref = null; unset($ref);
    $distances = null; unset($distances);
    $v = null; unset($v);
    $res = null; unset($res);
    $tmp = null; unset($tmp);
    $lat1 = null; unset($lat1);
    $lng1 = null; unset($lng2);
    $lat2 = null; unset($lat2);
    $lng2 = null; unset($lng2);
    $s = null; unset($s);
    $d = null; unset($d);
    $direction = null; unset($direction);
    $distance = null; unset($distance);
    $tmp = null; unset($tmp);
    $res = null; unset($res);

?>