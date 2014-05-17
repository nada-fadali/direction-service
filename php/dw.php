<?php
	if (isset($_POST['dw']) && isset($_POST['type'])) {
		//	split
		$tmp = explode("|", $_POST['dw']);
		for ($i=0; $i < count($tmp); $i++) { 
			$dw[$i] = explode(" ", $tmp[$i]);
		}

		//	download json file
		if ($_POST['type'] == 'json') {
			$fh = fopen("direction.JSON", "w");

			$data = '{' . "\n" . '	"directions": ' .'['. "\n";
			for ($i=0; $i < count($dw)-1; $i++) { 
				$data .= '		{ "direction" : "'.$dw[$i][1].'" , "distance" : "'.$dw[$i][3].'" }' . "\n";
			}
			$data.= "	]" . "\n" . "}";

			fwrite($fh, $data);
			fclose($fh);
		}

		//download xml file
		else
		{
			$fh = fopen("direction.xml", "w");	

			$data = "<instructions>" . "\n\n";
			for ($i=0; $i < count($dw)-1; $i++) {
				$data .= '	<instruction>' . "\n" . 
						"		<direction>". "\n" . "			" . $dw[$i][1]. "\n" . "		</direction>" ."\n"
						. "		<distance>" . "\n" . "			" . $dw[$i][3] . "\n" . "		</distance>" . "\n" 
						. "	</instruction>" . "\n\n";
			}
			$data .= "</instructions>";


			fwrite($fh, $data);
			fclose($fh);
		}
	}
	else
		echo "Data has been corrupted. File can't be downloaded!"
?>