/*
* Clear points on the map
*/
function clearPt(i){
    if (i == 1) {
        pt1.setMap(null);  
        f1 = true; 
    }
    else {
        pt2.setMap(null);
        f2 = true;
    }
}