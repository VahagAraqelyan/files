<div id="dhl_map">
    <script>
        var loc_lat_lng = [];
            loc_lat_lng = <?php echo $well_lat_lng;?>;

        var map;
        var infowindow;

        function initMap() {

             map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: new google.maps.LatLng(parseFloat(54.5215038), parseFloat(-107.3458742)),
                mapTypeId: 'satellite'
            });

            for(var i = 0; i<loc_lat_lng.length;i++){

                loc_lat_lng[i]['lat'] =  loc_lat_lng[i]['lat'].replace(/,/gi, ".");
                loc_lat_lng[i]['lng'] =  loc_lat_lng[i]['lng'].replace(/,/gi, ".");

                positions =  {lat:parseFloat(loc_lat_lng[i]['lat']), lng:parseFloat(loc_lat_lng[i]['lng'])};
                marker = new google.maps.Marker({
                    position: {lat:parseFloat(loc_lat_lng[i]['lat']), lng:parseFloat(loc_lat_lng[i]['lng'])},
                    map: map
                });
            }

            marker.setMap(map);
            map.setTilt();

        }
    </script>

    <div id="map" style="width:600px;height: 400px;"></div>
</div>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAT_4SjgkacPQd0Iuj3TGv5br7UdMHprzc&callback=initMap">
</script>