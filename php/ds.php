<?php
	
	session_start();
	
	/*
	*	calculates distance between two points
	*/
	function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
	  	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;

		return ($miles * 1.609344);
	}

	$con = mysql_connect("localhost", "root", "");
	if(mysql_errno())
		echo "error connection to localhost";
	else {
		/*
		*	Initialize graph one time only
		*/
		if (!isset($_SESSION['graph']) || !isset($_SESSION['link']) || !isset($_SESSION['node'])) {
			mysql_select_db("dmetprojdb", $con); //CLOSE THIS AND DELETE COMMENT

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


			//create graph
			require_once 'Graph/Graph.php';
			require_once 'Graph/Vertex.php';
			require_once 'Graph/Dijkstra.php';

			//This graph is undirected
			//but weighted
			//since all streets are two ways
			//because -you know, because masr om el donia~
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
			for ($i=1; $i < count($v); $i++) { 
				$_SESSION['graph']->add($v[$i]);
			}

		} //end if there isn't session variables

		
		//round user input to the nearst nodes
		
		//calculate shortest path
		$path = new Dijkstra($_SESSION['graph']);
		$path->setStartingVertex();
		$path->setEndingVertex();


	}

?>