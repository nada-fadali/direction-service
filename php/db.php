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
					(1, "30.0900757688", "31.3487148284"),
					(2, "30.0804581136", "31.3589715957"),
					(3, "30.0953483720", "31.3422775268"),
					(4, "30.0887018753", "31.33038997650"),
					(5, "30.0807180625", "31.3167858123"),
					(6, "30.0779699964", "31.3130092620"),
					(7, "30.0690196846", "31.29142284393"),
					(8, "30.0838002620", "31.340517997"),
					(9, "30.08004962107", "31.36180400848"),
					(10, "30.07150802687", "31.35433673858"),
					(11, "30.06946536249", "31.3440370559"),
					(12, "30.068871124", "31.33841514587"),
					(13, "30.06864828493", "31.33635520935"),
					(14, "30.0673855154", "31.32489681243"),
					(15, "30.06682840612", "31.31996154785"),
					(16, "30.0612199977", "31.30811691284"),
					(17, "30.05067087207", "31.31193637847"),
					(18, "30.0508566058", "31.320562362"),
					(19, "30.05278821631", "31.32489681243"),
					(20, "30.05275107031", "31.32712841033"),
					(21, "30.05379115304", "31.3384580612"),
					(22, "30.05464549854", "31.34613990783"),
					(23, "30.0559084305", "31.35734081268"),
					(24, "30.05824852673", "31.38000011444"),
					(25, "30.04899925254", "31.378970146"),
					(26, "30.04658464119", "31.3562679290"),
					(27, "30.04483865477", "31.3397884368"),
					(28, "30.04335268464", "31.32682800292"),
					(29, "30.02585371012", "31.35382175445")
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