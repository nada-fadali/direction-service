<?php
	
	//connect to localhost
	$con = mysql_connect("localhost", "root", "");
	if(mysql_errno())
		echo "error";
	
	//create database if it doesn't exist
	if(mysql_query("CREATE DATABASE dmetprojdb")){
		mysql_select_db("dmetprojdb", $con);

		//create tables
		mysql_query("
			CREATE TABLE Streets(
			name VARCHAR(20) PRIMARY KEY, 
			start VARCHAR(20), end VARCHAR(20))
		");
		mysql_query("
			CREATE TABLE Nodes(
				no INTEGER PRIMARY KEY, 
				lat VARCHAR(20), 
				lng VARCHAR(20))
		");

		//insert into tables
		//street name, start(lat lng), end(lat lng)
		mysql_query("
			INSERT INTO Streets(name, start, end) 
			VALUES
				('Hassen Kamel', '30.080383 31.359186', '30.089964 31.348628'),
				('El Orooba', '30.095311 31.342363', '30.088701 31.330432'),
				('Suez Road', '30.080161 31.361761', '30.088776 31.330518'),
				('Salah Salem', '30.088776 31.330432', '30.069242 31.291809'),
				('El Nozha', '30.095162 31.342191', '30.068796 31.338243'),
				('Nasr Road', '30.080086 31.361761', '30.061294 31.308031'),
				('El Mokhaym EL Daem', '30.061294 31.308031', '30.050522 31.311893'),
				('Yussef Abbas', '30.066791 31.319961', '30.052528 31.324939'),
				('El Tayaraan', '30.052528 31.327171', '30.080680 31.316614'),
				('Abbas EL Akkad', '30.068722 31.336269', '30.044652 31.339702'),
				('Makram Abed', '30.054534 31.346139', '30.069465 31.343994'),
				('Hassan El Maamoon', '30.071619 31.354379', '30.055796 31.357383'),
				('Mostafa EL Nahaas', '30.054014 31.338415', '30.058322 31.379871'),
				('Ali Amin', '30.053865 31.338500', '30.050819 31.311893'),
				('EL Khalyfa El Zahar', '30.050968 31.320390', '30.043464 31.326913'),
				('Hassan El Shrief', '30.055945 31.357297', '30.046510 31.356353'),
				('Mahdy Arafa', '30.058174 31.379957', '30.048962 31.379013'),
				('Zaker Hassen', '30.043389 31.326656', '30.044727 31.339874'),
				('Ahmed EL Zomor', '30.044727 31.339874', '30.048962 31.378927'),
				('El Waffaa w EL Amaal', '30.046510 31.356353', '30.036182 31.354894')
		");

		mysql_query("
			INSERT INTO Nodes(no, lng, lat)
			VALUES
				(1, '30.090112', '31.348543'),
				(2, '30.080235', '31.359272'),
				(3, '30.095311', '31.342020'),
				(4, '30.088776', '31.330175'),
				(5, '30.080978', '31.316528'),
				(6, '30.077932', '31.313009'),
				(7, '30.073922', '31.301851'),
				(8, '30.083874', '31.340475'),
				(9, '30.080161', '31.361761'),
				(10, '30.071545', '31.354465'),
				(11, '30.069465', '31.344079'),
				(12, '30.068871', '31.338500'),
				(13, '30.068648', '31.336183'),
				(14, '30.067459', '31.324939'),
				(15, '30.066865', '31.319961'),
				(16, '30.061368', '31.308202'),
				(17, '30.050596', '31.311979'),
				(18, '30.050968', '31.320476'),
				(19, '30.052602', '31.324853'),
				(20, '30.052676', '31.327085'),
				(21, '30.053939', '31.338500'),
				(22, '30.054756', '31.346054'),
				(23, '30.055945', '31.357383'),
				(24, '30.058397', '31.379957'),
				(25, '30.049110', '31.378841'),
				(26, '30.046658', '31.356267'),
				(27, '30.044801', '31.339702'),
				(28, '30.043464', '31.326828'),
				(29, '30.035811', '31.354894')
		");
	}	
	
	mysql_close($con);

	



	/*
	//relation
	INSERT INTO Nodes_Streets(node, street)
	(1, 'Hassen Kamel'),
	(2, 'Hassen Kamel'),
	(2, 'Suez Road'),
	(3, 'El Orooba'),
	(3, 'El Nozha'),
	(4, 'El Orooba'),
	(4, 'Suez Road'),
	(4, 'Salah Salem'),
	(5, 'Salah Salem'),
	(5, 'El Tayaraan'),
	(6, 'Salah Salem'),
	(6, 'Yussef Abbas'),
	(7, 'Salah Salem'),
	(8, 'El Nozha'),
	(8, 'Suez Road'),
	(9, 'Nasr Road'),
	(9, 'Suez Road'),
	(10, 'Nasr Road'),
	(10, 'Hassan El Maamoon'),
	(11, 'Nasr Road'),
	(11, 'Makram Abed'),*/

?>