<?php
	if (isset($_POST['dw']) && isset($_POST['type'])) {
		//	split
		$tmp = explode("|", $_POST['dw']);
		for ($i=0; $i < count($tmp); $i++) { 
			$dw[$i] = explode(" ", $tmp[$i]);
		}

		//	download json file
		if ($_POST['type'] == 'json') {
			if (file_exists($_SERVER['DOCUMENT_ROOT']. "/web-project/downloads")) 
				$fh = fopen($_SERVER['DOCUMENT_ROOT']. "/web-project/downloads/direction.JSON", "w");
			else
				$fh = fopen("direction.JSON", "w");

			$data = '{"directions": ['. "\n";
			for ($i=0; $i < count($dw)-1; $i++) { 
				$data .= '{"direction" : "'.$dw[$i][1].'", "distance" : "'.$dw[$i][3].'"}' . "\n";
			}
			$data.= "]" . "\n" . "}";

			fwrite($fh, $data);
			fclose($fh);
		}

		//download xml file
		else
		{

		}
	}
	else
		echo "Data has been corrupted. File can't be downloaded!"
?>