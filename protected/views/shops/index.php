	    
  
		<div class="h1-substrate">
		<h1 style='display:inline-block'><strong>Магазины    </strong></h1>


		 


		<select name="" id="" class='cityMag cityLink'>
				<option value="0">Все</option>
		 	<?foreach ($city as $data) {?>
				<option value="<?=$data->id?>"><?=$data->name?></option>
		 	<?}?>
			 
			</select>



		</div> 
		 <div class="map" id='map'> 		
 		</div>	

 		    <script src="https://maps.googleapis.com/maps/api/js?v=1.exp"></script>
			 <script type="text/javascript">


				$(function(){
					$(".citylist").height($(window).height()-380);
					$(".map").height($(window).height()-335);


					$(window).resize(function(){
							$(".citylist").height($(window).height()-380);
							$(".map").height($(window).height()-335);

					})

				})

				 


				  map;
				var centerLatLng = new google.maps.LatLng(59.940224, 30.308533);
				 placesArr = [
				 			<?foreach ($shops as $data) {?>
				 				<?$data->name = str_replace("'", '"', $data->name)?>
					            ['<?=$data->name?>',<?=$data->map_coords?>,<?=$data->city_id?>],
				 			<?}?>
					          
    						]; 


				function initialize(places) {
				  var mapOptions = {
				    zoom:4,
				    center: new google.maps.LatLng(59.940224, 30.308533)
				  };
				  map = new google.maps.Map(document.getElementById('map'),
				      mapOptions);

				  setMarkers(map, places); 


				  	

 function setMarkers(map, locations) { 

		var latlngbounds = new google.maps.LatLngBounds(); 
	var image = new google.maps.MarkerImage('/img/markerMap.png',      
      new google.maps.Size(66, 34),      
      new google.maps.Point(0,0),      
      new google.maps.Point(19, 18));   
		
         for (var i = 0; i < places.length; i++) {
            var myLatLng = new google.maps.LatLng(locations[i][1], locations[i][2]);
			
			latlngbounds.extend(myLatLng);
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
				icon: image,
                title: locations[i][0],
            }); 
             marker.setTitle((i + 1).toString());
             attachSecretMessage(marker, i);
         }  


            function attachSecretMessage(marker, num) {
  var message = [
  <?foreach ($shops as $key=>$data) {?>
  		'<div><strong><?=$data->name?></strong></div><div><?=$data->address?></div><div>тел.:<?=$data->phone?></div>',
  <?}?>	  
  				  
  				  
  	  ];
				  var infowindow = new google.maps.InfoWindow({
				    content: message[num]
				  });

				   infoWindows = [];

				  google.maps.event.addListener(marker, 'click', function() {
				    infoWindows.push(infowindow);
				  	closeAllInfoWindows();
				    infowindow.open(marker.get('map'), marker);
				 
				  });
			}

			function closeAllInfoWindows() {
			  for (var i=0;i<infoWindows.length;i++) {
			     infoWindows[i].close();
			  }
		}



	map.setCenter( latlngbounds.getCenter(), map.fitBounds(latlngbounds));	  
    }; 
}	 

				google.maps.event.addDomListener(window, 'load', initialize(placesArr));


function ToPoint(x, y, title) {
		var centerLatLng = new google.maps.LatLng(x, y);

			var image = new google.maps.MarkerImage('/img/markerMap.png',      
      new google.maps.Size(38, 37),      
      new google.maps.Point(0,0),      
       new google.maps.Point(19, 18));     

            var mapOptions = {
                center: new google.maps.LatLng(x, y),
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }; 

            var map = new google.maps.Map(document.getElementById("map"),
                mapOptions);


    
              var marker = new google.maps.Marker({
				      position: centerLatLng,
				      map: map,
				      icon: image,
				      title:title
				  });


              
  var infowindow = new google.maps.InfoWindow({
    content: title
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(marker.get('map'), marker);
    });


            return (false);
        }


        function showMarkers() {
			  setAllMap(map);
			}

			function setAllMap(map) {
			  for (var i = 0; i < markers.length; i++) {
			    markers[i].setMap(map);
			  }
			}



       $(function(){
        	$(".city").click(function(){
        		$(".city").removeClass("activeMap")

        		$(this).addClass("activeMap")

        	})

        	$(".cityLink").change(function(){
        		var id = $(this).val();
        		 
        		$('.city').hide();
        		$('.shop'+id).show();
  
				  		var id = $(this).val();
				  		var tempPlaces = [];
				  	 
				  			 for(var i = 0; i<placesArr.length; i++){

				  			 	 
				  			 	if(placesArr[i][3] == id){

				  			 		tempPlaces.push(placesArr[i])
				  			 	}

				  			 	if(0 == id){
				  			 		tempPlaces = placesArr;

				  			 	}
				  			 }


				  			 initialize(tempPlaces)
 
				   
        		 

        	})
        })


				</script> 


 	


 <div class="citylist"> 

<br>
 	<?foreach ($shops as $key=>$data) {?>
		 <div class="city shop0 shop<?=$data->city_id?>" onclick="ToPoint(<?=$data->map_coords?>,'<div><strong><?=htmlspecialchars(str_replace("\'","\"",$data->name) ) //=strtr($data->name,'"',' ');?></strong></div><div><?=$data->address?></div><div>тел.:<?=$data->phone?></div>');return false;">
 	   	<div class="numberCity"><?=$key+1?>.</div>
				<div class="text">
					<big><?=$data->name?></big><br>
					<div class='telContact'><?=$data->address?></div>
					<div class="phone"><?=$data->phone?><span></span></div>		
					<p><a href="#"  class="maplink">показать на карте</a> </p>  
				</div>
				<div class="clear"></div>
		</div>




 	<?}?> 
		 <?/*<div class="city" onclick="ToPoint('42.958998', '47.539116');return false;">
						 
							<div class="text">
								<big>ЭККО-Миркато</big><br>
								<div class='telContact'>ул. Имама Шамиля, д. 2, ТЦ «Миркато»</div>
								<div class="phone">+7 (988) 302-11-55 <span></span></div>												 
							</div>
							<div class="clear"></div>
		</div>*/?>


 
  
 </div>
			 
			 
			 
			
 <div style='clear:both'></div>