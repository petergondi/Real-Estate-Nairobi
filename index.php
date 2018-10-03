<html>
<head>
<meta charset=utf-8 />
<title>Turf.js Map</title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.mapbox.com/mapbox.js/v2.1.5/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v2.1.5/mapbox.css' rel='stylesheet' />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src='https://api.mapbox.com/mapbox.js/plugins/turf/v1.3.0/turf.min.js'></script>
<style>
  body {
    margin: 0;
    padding: 0;
  }

  #map {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
  }
</style>
</head>
<body>

  <div id='map'></div>
  <script>
    L.mapbox.accessToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY5YzJzczA2ejIzM29hNGQ3emFsMXgifQ.az9JUrQP7klCgD3W-ueILQ';

    var hospitals = {
      type: 'FeatureCollection',
      features: [
        { type: 'Feature', properties: { Name: 'VA Medical Center -- Leestown Division', Address: '2250 Leestown Rd' }, geometry: { type: 'Point', coordinates: [ 36.833074,-1.286327] } },
        { type: 'Feature', properties: { Name: 'St. Joseph East', Address: '150 N Eagle Creek Dr' }, geometry: { type: 'Point', coordinates:[ 36.828267,-1.286735
] } },
        { type: 'Feature', properties: { Name: 'Central Baptist Hospital', Address: '1740 Nicholasville Rd' }, geometry: { type: 'Point', coordinates: [36.826604,-1.289384] } }
      ]
    };
    

    // Add marker color, symbol, and size to hospital GeoJSON
    for (var i = 0; i < hospitals.features.length; i++) {
      hospitals.features[i].properties['marker-color'] = '#DC143C';
      hospitals.features[i].properties['marker-symbol'] = 'building';
      hospitals.features[i].properties['marker-size'] = 'small';
    }

    // Add marker color, symbol, and size to library GeoJSON
    
    var map = L.mapbox.map('map', 'mapbox.light')
      .setView([-1.2921,36.8219], 13);
    map.scrollWheelZoom.disable();

    var hospitalLayer = L.mapbox.featureLayer(hospitals)
   

    // Bind a popup to each feature in hospitalLayer and libraryLayer
    hospitalLayer.eachLayer(function(layer) {
      layer.bindPopup('<strong>' + layer.feature.properties.Name +'<br/>'+ layer.feature.properties.Address+ '</strong>', { closeButton: false });
    }).addTo(map);
    

   
    hospitalLayer.on('mouseover', function(e) {
      e.layer.openPopup();
    });

    // Reset marker size to small
    function reset() {
      var hospitalFeatures = hospitalLayer.getGeoJSON();
      for (var k = 0; k < hospitalFeatures.features.length; k++) {
        hospitalFeatures.features[k].properties['marker-size'] = 'small';
      }
      hospitalLayer.setGeoJSON(hospitalFeatures);
    }

    // When a library is clicked, do the following

    // When the map is clicked on anywhere, reset all
    // hospital markers to small
    map.on('click', function(e) {
      reset();
    });

  </script>
</body>
</html>