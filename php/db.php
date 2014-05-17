<?php
	
	//connect to localhost
	$con = mysql_connect("localhost", "root", "");
	if(mysql_errno())
		echo "error";

	else {
		//create database if it doesn"t exist
		if(mysql_query("CREATE DATABASE dmetprojdb")){
			mysql_select_db("dmetprojdb", $con);

			//create tables
			mysql_query("
				CREATE TABLE Nodes(
					no INTEGER PRIMARY KEY, 
					lat VARCHAR(20), 
					lng VARCHAR(20)
				)
			");
			mysql_query("
				CREATE TABLE Nodes_Streets(
					first_node INTEGER,
					second_node INTEGER,
					street VARCHAR(20),
					PRIMARY KEY (first_node, second_node, street)
				)
			");

			//insert into tables
			mysql_query('
				INSERT INTO Nodes(no, lat, lng)
				VALUES
					(1, "30.0900386368612", "31.34871482849121"),
					(2, "30.08045811362098", "31.35897159576416"),
					(3, "30.09534837205046", "31.34227752685547"),
					(4, "30.088739007888524", "31.330432891845703"),
					(5, "30.080643791494502", "31.31678581237793"),
					(6, "30.077895723374578", "31.312923431396484"),
					(7, "30.07381061617228", "31.301937103271484"),
					(8, "30.08376312765574", "31.34047508239746"),
					(9, "30.080086756828326", "31.36176109313965"),
					(10, "30.071470887901302", "31.354422569274902"),
					(11, "30.069391082993874", "31.34403705596924"),
					(12, "30.06883398497148", "31.338372230529785"),
					(13, "30.068611144884407", "31.33622646331787"),
					(14, "30.067348374913234", "31.32502555847168"),
					(15, "30.06675412464581", "31.32004737854004"),
					(16, "30.06118285487219", "31.308159828186035"),
					(17, "30.050633725283078", "31.31202220916748"),
					(18, "30.0508937525496", "31.3205623626709"),
					(19, "30.05282536229875", "31.324896812438965"),
					(20, "30.052751070312752", "31.327214241027832"),
					(21, "30.053791153044696", "31.338415145874023"),
					(22, "30.054645498545135", "31.346139907836914"),
					(23, "30.055796996034978", "31.357340812683105"),
					(24, "30.058211382779742", "31.37995719909668"),
					(25, "30.049110694726327", "31.3789701461792"),
					(26, "30.04654749286669", "31.356310844421387"),
					(27, "30.044801505795355", "31.339702606201172"),
					(28, "30.043352684649776", "31.326913833618164"),
					(29, "30.025816554021542", "31.353821754455566")
			');

			mysql_query('
				INSERT INTO Nodes_Streets(first_node, second_node, street)
				VALUES
					(1, 2, "Hassen Kamel"),
					(2, 9, "Suez Road"),
					(2, 8, "Suez Road"),
					(3, 4, "El Orooba"),
					(3, 8, "El Nozha"),
					(4, 8, "Suez Road"),
					(4, 5, "Salah Salem"),
					(5, 6, "Salah Salem"),
					(5, 14, "El Tayaraan"),
					(6, 7, "Salah Salem"),
					(6, 15, "Yussef Abbas"),
					(8, 12, "El Nozha"),
					(9, 10, "Nasr Road"),
					(10, 11, "Nasr Road"),
					(10, 23, "Hassan El Maamoon"),
					(11, 12, "Nasr Road"),
					(11, 22, "Makram Abed"),
					(12, 13, "Nasr Road"),
					(13, 14, "Nasr Road"),
					(13, 21, "Abbas EL Akkad"),
					(14, 15, "Nasr Road"),
					(14, 20, "EL Tayaraan"),
					(15, 16, "Nasr Road"),
					(15, 19, "Yussef Abbas"),
					(16, 17, "El Mokhaym El Daem"),
					(17, 18, "Ali Amin"),
					(18, 19, "Ali Amin"),
					(18, 28, "El Khalyfa EL Zahar"),
					(19, 20, "Ali Amin"),
					(20, 21, "Ali Amin"),
					(21, 22, "Mostafa El Nahaas"),
					(21, 27, "Abbas El Akkad"),
					(22, 23, "Mostafa El Nahaas"),
					(23, 24, "Mostafa EL Nahaas"),
					(23, 26, "Hassan El Shrief"),
					(24, 25, "Mahdy Arafa"),
					(25, 26, "Ahmed EL Zomor"),
					(26, 27, "Ahmed El Zomor"),
					(26, 29, "El Waffaa w El Amaal"),
					(27, 28, "Zaker Hassen")

			');
		}
		//else
			//echo "Error creating database. Name Already Exists!";	

		
		mysql_close($con);
	}

	



	/*
	//relation
	INSERT INTO Nodes_Streets(first_node, second_node, street)
	


	mysql_query("
			CREATE TABLE Streets(
			name VARCHAR(20) PRIMARY KEY, 
			start VARCHAR(20), end VARCHAR(20))
		");

	//street name, start(lat lng), end(lat lng)
		mysql_query("
			INSERT INTO Streets(name, start, end) 
			VALUES
				("Hassen Kamel", "30.080383 31.359186", "30.089964 31.348628"),
				("El Orooba", "30.095311 31.342363", "30.088701 31.330432"),
				("Suez Road", "30.080161 31.361761", "30.088776 31.330518"),
				("Salah Salem", "30.088776 31.330432", "30.069242 31.291809"),
				("El Nozha", "30.095162 31.342191", "30.068796 31.338243"),
				("Nasr Road", "30.080086 31.361761", "30.061294 31.308031"),
				("El Mokhaym EL Daem", "30.061294 31.308031", "30.050522 31.311893"),
				("Yussef Abbas", "30.066791 31.319961", "30.052528 31.324939"),
				("El Tayaraan", "30.052528 31.327171", "30.080680 31.316614"),
				("Abbas EL Akkad", "30.068722 31.336269", "30.044652 31.339702"),
				("Makram Abed", "30.054534 31.346139", "30.069465 31.343994"),
				("Hassan El Maamoon", "30.071619 31.354379", "30.055796 31.357383"),
				("Mostafa EL Nahaas", "30.054014 31.338415", "30.058322 31.379871"),
				("Ali Amin", "30.053865 31.338500", "30.050819 31.311893"),
				("EL Khalyfa El Zahar", "30.050968 31.320390", "30.043464 31.326913"),
				("Hassan El Shrief", "30.055945 31.357297", "30.046510 31.356353"),
				("Mahdy Arafa", "30.058174 31.379957", "30.048962 31.379013"),
				("Zaker Hassen", "30.043389 31.326656", "30.044727 31.339874"),
				("Ahmed EL Zomor", "30.044727 31.339874", "30.048962 31.378927"),
				("El Waffaa w EL Amaal", "30.046510 31.356353", "30.036182 31.354894")
		");
	*/

?>