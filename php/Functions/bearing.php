<?php
	
	######################################
	## Calculate Beaing between two points
	######################################
	function getBearing( $point1, $point2 )
	{
	  return getRhumbLineBearing( $point1['lat'], $point2['lng'], $point2['lat'], $point1['lng'] );
	}


	###############################
	##	Helper function
	##	Calculate rhumbline bearing
	###############################
	function getRhumbLineBearing($lat1, $lon1, $lat2, $lon2) {
	  //difference in longitudinal coordinates
	  $dLon = deg2rad($lon2) - deg2rad($lon1);

	  //difference in the phi of latitudinal coordinates
	  $dPhi = log(tan(deg2rad($lat2) / 2 + pi() / 4) / tan(deg2rad($lat1) / 2 + pi() / 4));

	  //wrecalculate $dLon if it is greater than pi
	  if(abs($dLon) > pi()) {
	    if($dLon > 0) {
	      $dLon = (2 * pi() - $dLon) * -1;
	    }
	    else {
	      $dLon = 2 * pi() + $dLon;
	    }
	  }
	  //return the angle, normalized
	  return (rad2deg(atan2($dLon, $dPhi)) + 360) % 360;
	}

	###################
	## Return direction
	###################
	function getDirection( $bearing )
	{
	  static $cardinals = array( 'north', 'northwest', 'west', 'southwest', 
	  		'south', 'southeast', 'east', 'northeast', 'north' );
	  return $cardinals[round( $bearing / 45 )];
	}
?>