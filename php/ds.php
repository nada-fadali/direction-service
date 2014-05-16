<?php
	
	require_once 'Graph/Graph.php';
	require_once 'Graph/Vertex.php';
	require_once 'Graph/Dijkstra.php';
	require_once 'fns.php';

	session_start(); 

	####################
	##	Start of script
	####################
	
	/*
	*	Initialize graph one time only
	*/
	if (!isset($_SESSION['graph']) || !isset($_SESSION['link']) || !isset($_SESSION['node'])) {
		$con = mysql_connect("localhost", "root", "");
		if(mysql_errno())
			echo "error connecting to database";
		else {
			mysql_select_db("dmetprojdb", $con);

			//get nodes
			$rs = mysql_query(" SELECT * FROM Nodes ");
			$_SESSION['node'] = array();
			while($row = mysql_fetch_array($rs)){
				$_SESSION['node'][$row[0]] = array($row[1], $row[2]);
			}

			//connections between nodes
			$rs = mysql_query(" SELECT * FROM Nodes_Streets");
			$_SESSION['link'] = array();
			$i = 1;
			while($row = mysql_fetch_array($rs)){
				$_SESSION['link'][$i] = array($row[0], $row[1], $row[2]);
				$i++;
			}
			
			mysql_close($con); 
			

			//This graph is undirected
			//but weighted
			//since all streets are two ways
			//because -you know, because Egypt om el donia~
			$_SESSION['graph'] = new Graph();

			//create nodes of the graph
			$v = array();
			for ($i=1; $i < 30; $i++) { 
				$v[$i] = new Vertex($i);
			}

			//connect nodes
			for ($i=1; $i < count($_SESSION['link']); $i++) {
				$n1 = $_SESSION['link'][$i][0];
				$n2 = $_SESSION['link'][$i][1]; 

				$distance = distance(
					$_SESSION['node'][$n1][0], $_SESSION['node'][$n1][1],
					$_SESSION['node'][$n2][0], $_SESSION['node'][$n1][1]
				);

				$v[$n1]->connect($v[$n2], $distance.'');
				$v[$n2]->connect($v[$n1], $distance.'');
		
			}

			//add node to graph
			for ($i=1; $i <= count($v); $i++) { 
				$_SESSION['graph']->add($v[$i]);
			}
		}
	} //end if graph isn't created

	/*
	*	round user input to the nearst nodes
	*/
	$ref= array($_POST['lat1'], $_POST['lng1']);
	$distances = array_map(function($item) use($ref) {
	    $a = array_slice($item, -2);
	    return distance($a[0], $a[1], $ref[1], $ref[0]);
	}, $_SESSION['node']);

	asort($distances);
	//$n1 = array($_SESSION['node'][key($distances)][1], $_SESSION['node'][key($distances)][0]);

	//	Index of first node
	$key1 = array_search2d($_SESSION['node'][key($distances)][1], $_SESSION['node']);

	$ref= array($_POST['lat2'], $_POST['lng2']);
	$distances = array_map(function($item) use($ref) {
	    $a = array_slice($item, -2);
	    return distance($a[0], $a[1], $ref[1], $ref[0]);
	}, $_SESSION['node']);

	asort($distances);
	//$n2 = array($_SESSION['node'][key($distances)][1], $_SESSION['node'][key($distances)][0]);

	//	Index of second node
	$key2 = array_search2d($_SESSION['node'][key($distances)][1], $_SESSION['node']);

	//	calculate shortest path
	$algorithm = new Dijkstra($_SESSION['graph']);
	$algorithm->setStartingVertex($_SESSION['graph']->getVertex($key1));
	$algorithm->setEndingVertex($_SESSION['graph']->getVertex($key2));

	//	return the nodes along this path
	$nn = split("-", $algorithm->getLiteralShortestPath());

	for ($i=0; $i < count($nn); $i++) { 
		echo $_SESSION['node'][(int)$nn[$i]][0] . " " . $_SESSION['node'][(int)$nn[$i]][1]. " ";
	}

?>


