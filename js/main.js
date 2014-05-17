var map;

//flags to render markers
var f1 = true;
var f2 = true;


//markers 
var pt1 = new google.maps.Marker({title:'Point 1'});
var pt2 = new google.maps.Marker({title:'Point 2', icon: 'css/blue-icon.png'});

//download string
var dw = "";

function initialize() {
    /*
    *   Map intialization
    */
    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(30.067543,31.345868)
    };
    map = new google.maps.Map(document.getElementById('map'),
        mapOptions);

    /*
    *   Click event
    */
    google.maps.event.addListener(map, 'click', function(event){
        if (!f1 && !f2) {
            alert("Only two locations!");
        } 
        else {
            if (f1) {
                f1 = false;
                pt1.setMap(map);
                pt1.setPosition(event.latLng);
            }
                       
            else if (f2){
                f2 = false;  
                pt2.setMap(map);
                pt2.setPosition(event.latLng);
            } 
        }
    }); //end of click event



    /*
    * create database of the nodes
    */
    $(document).ready(function(){
        $.ajax({
            url: 'php/db.php',
            success:function(data){
                //user isn't suppose to see this alert
                //this is just to show that the database I'm trying to create already exists
                //and so needed to be changed in the code
                //alert(data);
            }
        });
    });

    
    /*
    *   click event
    *   takes input points and return shortest path
    */
    $('#btn').click(function(){
        if (f1 || f2) {
            alert("Please Choose two locations!")
        }  
        else{ 
            $.ajax({
                url:'php/ds.php',
                type:'post',
                //dataType:'html',
                data:{
                    lat1:pt1.getPosition().lat()+'', 
                    lng1:pt1.getPosition().lng()+'',
                    lat2:pt2.getPosition().lat()+'',
                    lng2:pt2.getPosition().lng()+''
                },
                success:function(data){
                    //alert(data);
                       
                    /*
                    *   Hide/Show direction service buttons
                    */
                    $('#btn').hide(300);
                    $('#btnClearPt1').hide(300);
                    $('#btnCLearpt2').hide(300);
                            
                    $('#btnReload').show(300);
                    $('#dw').show(300);


                    /*
                    *   Render Path
                    */
                    var nc = [new google.maps.LatLng(pt1.getPosition().lat(), pt1.getPosition().lng())];
                    var s = data.split("|"); 
                    var direction = "<i><big>&nabla; Directions</big></i><ul style='list-style: square; font-size:14px;'>";
                           
                    var i;
                    for (i = 0; i < s.length-1; i+=2) {
                       if (s[i].indexOf("Go") == -1 && s[i+1].indexOf("Go") == -1) {
                            var lat = parseFloat(s[i]);
                            var lng = parseFloat(s[i+1]);
                            var n = new google.maps.Marker({
                                map: map,
                                position: new google.maps.LatLng(lat, lng),
                                icon: 'css/yellow-dot.png'
                            });
                            nc.push(new google.maps.LatLng(n.getPosition().lat(), n.getPosition().lng()));
                        } 
                        else
                            break;                                    
                    }

                            
                    for(i++; i < s.length; i++){
                        direction+= "<li>" + s[i] + "</li>";
                        dw += s[i] + "|";
                    }

                    nc.push(new google.maps.LatLng(pt2.getPosition().lat(), pt2.getPosition().lng()));                
                    var path = new google.maps.Polyline({
                        path: nc,
                        map: map,
                        strokeColor: '#4F6B5A',
                        strokeOpacity: 0.8,
                        strokeWeight: 4
                    });


                    /*
                    *   Render Directions
                    */
                    $('#c').html(direction+"</ul>");
                        
                }//end of success function
            });//end of ajax
        }//end else two button are clicked
    });//end of button click trigger

    
    /*
    *   Go Again button
    */
    $('#btnReload').click(function(){
        location = "#map";
        location.reload(true);
    });

    /*
    *   Download JSON file
    */
    $('#btnjson').click(function(){
        $.ajax({
            url:'php/dw.php',
            data:{dw:dw, type:'json'},
            type:'post',
            success:function(data){
                alert(data);
            }
        });
    });

  
        /*
        *   Download xml file
        */
        $('#btnxml').click(function(){
            $.ajax({
                url:'php/dw.php',
                data:{dw:dw, type:'xml'},
                type:'post',
                success:function(data){
                    //alert(data);
                }
            });
        });

}//end of function


google.maps.event.addDomListener(window, 'load', initialize);
         
