jQuery(function ($) {
  let map,
    marker,
    mapContainer = $('.map-container'),
    locationField = mapContainer.find('.tfcl-map-location-field'),
    addressField = mapContainer.find('.tfcl-map-address-field input'),
    findAddressButton = mapContainer.find('.tfcl-map-address-field .button');
  let zipcodeField = $('#property_zip');
  let fullAddressField = $('#property_address');
  let geocoder = new google.maps.Geocoder();

  async function initMap(mapId) {
    let locationValue = locationField.val();
    locationValue = locationValue ? locationValue.split(',') : [-34.397, 150.644];
    let latLng = new google.maps.LatLng(locationValue[0], locationValue[1]);

    const { Map } = await google.maps.importLibrary("maps");
    map = new Map(document.getElementById(mapId), {
      center: latLng,
      zoom: 10,
      scrollwheel: true,
      streetViewControl: 0,
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position: google.maps.ControlPosition.LEFT_BOTTOM
      }
    });

    // Init Marker
    marker = new google.maps.Marker({
      position: latLng,
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
    });

    // Init listener marker
    google.maps.event.addListener(marker, "dragend", function (event) {
      const pos = {
        lat: event.latLng.lat(),
        lng: event.latLng.lng(),
      };
      map.setCenter(pos);
      marker.setPosition(pos);
      locationField.val(pos.lat + ',' + pos.lng);

      geocoder.geocode({ location: pos }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          addressField.val(results[0].formatted_address);
          fullAddressField.val(results[0].formatted_address);
          var zipCodeValue = results[0].address_components.find(item => item.types[0] == "postal_code");
          if(zipCodeValue){
            zipcodeField.val(zipCodeValue.long_name);
          }
        }
      });
    });
  }

  function findAddress() {
    findAddressButton.on('click', function () {
      let address = addressField.val();

      geocoder.geocode({ 'address': address }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          console.log(results[0]);
          map.setCenter(results[0].geometry.location);
          marker.setPosition(results[0].geometry.location);
          locationField.val(results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng());
          addressField.val(results[0].formatted_address);
          fullAddressField.val(results[0].formatted_address);
          var zipCodeValue = results[0].address_components.find(item => item.types[0] == "postal_code");
          if(zipCodeValue){
            zipcodeField.val(zipCodeValue.long_name);
          }
          initMap('map');
        }
      });
    })

    addressField.on('keydown', function (event) {
      if (event.which === 13) {
        event.preventDefault();
        findAddressButton.trigger('click');
      }
    });
  }

  if (document.getElementById('map')) {
    initMap('map');
    findAddress();
  }
});