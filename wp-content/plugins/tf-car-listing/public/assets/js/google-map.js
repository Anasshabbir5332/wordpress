jQuery(function ($) {

  let map,
    marker,
    zipCodeField = $('#zip_code'),
    fullAddressField = $('#full_address'),
    mapContainer = $('.map-container'),
    findAddressButton = mapContainer.find('.tfcl-map-address-field .button-location'),
    latlngSearching = mapContainer.find('.latlng_searching'),
    addressSearching = mapContainer.find('.address_searching');

  async function initMap(mapId) {
    let latlngValue = latlngSearching.val();
    latlngValue = latlngValue ? latlngValue.split(',') : [-34.397, 150.644];
    let latLng = new google.maps.LatLng(latlngValue[0], latlngValue[1]);
    let geocoder = new google.maps.Geocoder();
    let optionsGeoLocation = {
      enableHighAccuracy: true,
      timeout: 10000,
    };
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

      marker.setPosition(pos);
      map.setCenter(pos);
      latlngSearching.val(pos.lat + ',' + pos.lng);

      geocoder.geocode({ location: pos }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          addressSearching.val(results[0].formatted_address);
          fullAddressField.val(results[0].formatted_address);
          var zipCodeValue = results[0].address_components.find(item => item.types[0] == "postal_code");
          if (zipCodeValue) {
            zipCodeField.val(zipCodeValue.long_name);
          }
        }
      });
    });

    findAddressButton.on('click', function () {
      if (addressSearching.val() !== '') {
        let address = addressSearching.val();
        geocoder.geocode({ 'address': address }, function (results, status) {
          if (status === google.maps.GeocoderStatus.OK) {

            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
            latlngSearching.val(results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng());
            addressSearching.val(results[0].formatted_address);
            fullAddressField.val(results[0].formatted_address);
            var zipCodeValue = results[0].address_components.find(item => item.types[0] == "postal_code");
            if (zipCodeValue) {
              zipCodeField.val(zipCodeValue.long_name);
            }

            initMap('map-add-listing');
          }
        });
      }
      else {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            (position) => {
              const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
              };

              marker.setPosition(pos);
              map.setCenter(pos);
              latlngSearching.val(position.coords.latitude + ',' + position.coords.longitude);

              geocoder.geocode({ location: pos }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                  addressSearching.val(results[0].formatted_address);
                  fullAddressField.val(results[0].formatted_address);
                  var zipCodeValue = results[0].address_components.find(item => item.types[0] == "postal_code");
                  if (zipCodeValue) {
                    zipCodeField.val(zipCodeValue.long_name);
                  }
                }
              });

              initMap('map-add-listing');
            }
            , function () { }, optionsGeoLocation);
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }
    });

    addressSearching.on('keydown', function (event) {
      if (event.which === 13) {
        event.preventDefault();
        findAddressButton.trigger('click');
      }
    });
  }

  if (document.getElementById('map-add-listing')) {
    initMap('map-add-listing');
  }
});