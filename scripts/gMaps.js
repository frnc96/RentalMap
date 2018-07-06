var _markerLngLat;
var general = false;
var house = false;
var office = false;
var markerType;
var popSrc = '';

$(document).ready(function(){
    updateBadge();
    setInterval(function(){updateBadge()}, 5000);
    
    //$('#map').css('height',$(document).height()*0.8);
	//$('.row.content').css('height', $(window).height());
	
	$('.city').click(function(){
		var city = $(this).text();
		switch(city){
			case 'Tirana':
				fly(19.8187,41.3275);
				break;
			case 'Durres':
				fly(19.44139,41.32306);
				break;
			case 'Vlore':
				fly(19.48972,40.46667);
				break;
			case 'Elbasan':
				fly( 20.08222,41.1125);
				break;
			case 'Shkoder':
				fly(19.51258,42.06828);
				break;
			case 'Fier':
				fly(19.55611,40.72389);
				break;
			case 'Korce':
				fly(20.78083,40.61861);
				break;
			case 'Berat':
				fly(19.95222,40.70583);
				break;
			case 'Lushnje':
				fly(19.705,40.94194);
				break;
			case 'Pogradec':
				fly(20.664,40.9005);
				break;
			case 'Kavaje':
				fly(19.55694,41.18556);
				break;
			case 'Gjirokaster':
				fly(20.13889,40.07583);
				break;
			case 'Sarande':
				fly(20.00528,39.87556);
				break;
		}
	});
	
	$('a.ptr.link').click(function(){
	    $('div.wrap.list-group-item.list-group-item-action').each(function(){
	        $(this).removeClass('active');
	    });
	    if(general || house || office) $(this).parent().toggleClass('active');
	});
	
	$('#img').change(function(){
	    readURL(this);
	});
	
	$(document).on("click",".btn.btn-default.btn-block.loadMore", function(){
        var ID = $(this).attr('id');
            $.ajax({
                type:'POST',
                url:'loadMore.php',
                data:'id='+ID,
                success:function(html){
                    $("#loadBtn").remove();
                    $('#markerList').append(html);
                }
            });
	});
	
	$(document).on("click","#ntf",function(e){
	    e.stopPropagation();
	    $("#tgl").dropdown("toggle");
	});
	
	$(document).on('click','.popImg', function(){
	    var msg;
	    if(isLogged) msg = prompt('Enter message here:');
	    if(msg){
	        var id = $(this).siblings().children().next().next().text();
	        var dt = [id, msg];
	        $.ajax({
                type:'POST',
                url:'insertMsg.php',
                data: {array: dt},
                success:function(data){
                    alert(data);
                }
            });
	    }
	});
});

function updateBadge(){
    $('.dropdown-menu.wrap').load(document.URL +  ' .dropdown-menu.wrap>*');
            $.ajax({
                type:'POST',
                url:'updateBadge.php',
                success:function(data){
                    if(data>0){
                        $('.badge.top').css('visibility','visible');
                        $('.badge.top').text(data);
                    }else{
                        $('.badge.top').css('visibility','hidden');
                    }
                }
            });
}

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      popSrc = e.target.result;
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function fly(lat, lng){
	map.flyTo({
        center: [lat, lng]
    });
}

function addMarker(id,desc){
    markerType = id;
	var el = document.createElement('div');
	el.id = id;
	marker = new mapboxgl.Marker(el).setLngLat(_markerLngLat).addTo(map);
}

function getDesc(){
	general = false;
	house = false;
	office = false;
	
	$('div.wrap.list-group-item.list-group-item-action').each(function(){
	    $(this).removeClass('active');
	});
	
	$('#myModal').modal('toggle');
}

function addPopup(){
	var desc = $('#descr').val();
	var tel = $('#tel').val();

	var html = '<div class="card">'+
	            '<img src="'+popSrc+'" class="popImg">'+
	            '<div class="container" style="width: 100%;padding-left: 0px;padding-right: 0px;">'+
	            '<h5><b>'+desc+'</b></h5> '+
	            '<p>'+tel+'</p>'+
	            '</div></div>';
	            
	var dataArray = [markerType, _markerLngLat.lat, _markerLngLat.lng, popSrc, desc, tel];
	
	if(tel.match(/\+3556[789]\d{7}/) && desc.match(/[a-zA-Z]+/)){
	    var popup = new mapboxgl.Popup({ offset: 25 }).setHTML(html);
	    marker.setPopup(popup);
	    $('#myModal').modal('toggle');
	    
	    $.ajax({
	        type      : 'POST',
            url       : 'insertMarker.php',
            data      : {array: dataArray},
            success   : function(msg){
                alert('Ajax: '+msg);
            }
	    });
	    
	}else alert("Please fill the fields correctly!");
	
}

mapboxgl.accessToken = 'pk.eyJ1IjoiZnJuYyIsImEiOiJjamh2emhldXEwMjN0M2txZ2k3eHpkeW4xIn0.L4iSJTeAyRp4FiZyo-ccHw';
var map = new mapboxgl.Map({
    container: 'map',
	center: [19.8187, 41.3275],
	zoom: 13,
    style: 'mapbox://styles/mapbox/streets-v9'
});

//Search bar inside the map
map.addControl(new MapboxGeocoder({
    accessToken: mapboxgl.accessToken
}));

//Adds a marker to the map on click with description
map.on('click', function (e) {
	_markerLngLat = e.lngLat;
	if(general) addMarker('markerGeneral',getDesc());
	if(house) addMarker('markerHouse',getDesc());
	if(office) addMarker('markerOffice',getDesc());
});