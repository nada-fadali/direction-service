<?php
	###############################
	##	Search by value in 2D array
	#	returns index
	###############################
	function array_search2d($needle, $haystack) {
	    for ($i = 1; $i <= count($haystack); ++$i) {
	        if (in_array($needle, $haystack[$i])) return $i;
	    }
	    return false;
	}
?>