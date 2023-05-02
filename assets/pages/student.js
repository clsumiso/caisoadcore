let map = "";
function pwdMapLocation() 
{
  if ($('#map').length > 0) {
        map = L.map('map').setView([15.735859, 120.934876], 16); //Center point
        map.addControl(new L.Control.Fullscreen());

        map.on('fullscreenchange', function () {
            if (map.isFullscreen()) {
                // console.log('entered fullscreen');
                map.setView([15.735859, 120.934876], 16);
            } else {
                // console.log('exited fullscreen');
                map.setView([15.735859, 120.934876], 16);
            }
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 20}).addTo(map);

        L.control.browserPrint({position: 'topleft', title: 'Print ...'}).addTo(map);
        
        // L.Control.Watermark = L.Control.extend({
        //     onAdd: function(map) {
        //         let img = L.DomUtil.create('img');

        //         img.src = window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/images/wr.png';
        //         img.style.width = '100px';

        //         return img;
        //     },

        //     onRemove: function(map) {
        //         // Nothing to do here
        //     }
        // });

        // L.control.watermark = function(opts) {
        //     return new L.Control.Watermark(opts);
        // }

        // L.control.watermark({ position: 'bottomright' }).addTo(map);

        let legend = L.control({position: 'topright'});

        legend.onAdd = function (map) {

            let div = L.DomUtil.create('div', 'row clearfix'),
                region = ['REGION II', 'REGION III', 'REGION VI'],
                legend = ['REGION II', 'REGION III', 'REGION VI'],
                labels = [];

            // loop through our density intervals and generate a label with a colored square for each interval
            ///for (let i = 0; i < region.length; i++) {
            //}
                            
                                
            /*div.innerHTML += '<div class="col-md-12 pull-right"><div class="card"><div class="header bg-blue">' +
                                '<h2>' +
                                    'LEGEND<small>waterice.philrice.gov.ph</small>' +
                                '</h2>' +
                                '<ul class="header-dropdown m-r--5">' +
                                    '<li>' +
                                        '<a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="rotation" data-loading-color="lightGreen">' +
                                            '<i class="material-icons">loop</i>' +
                                        '</a>' + 
                                    '</li>' +
                                '</ul>' +
                            '</div>' +
                            '<div class="body">' + 
                                'Quis ' +
                            '</div></div></div>';*/


            /*div.innerHTML += '<div class="box-body">'+
                                '<div class="box-header">' +
                                  '<h2 class="box-title">' +
                                    'Legends' +
                                  '</h2>' +
                                '</div>' +
                                '<div class="box-body">' +
                                  '<div class="row">' +
                                    '<div class="col-md-12">' +
                                      //'<center><button class="btn btn-primary btn-sm btn-flat" onclick="reload_map()">REFRESH</button></center>' +
                                    '</div>' +
                                  '</div>' +
                                '</div>' +
                              '</div>';*/

            return div;
        };

        legend.addTo(map); 
        let marker;
        let customPopup = "";
        let markerIcon = L.icon({
            iconUrl: window.location.origin + '/office-of-admissions/assets/leaflet-color-markers-master/img/r.png',
            iconSize: [20, 20], // size of the icon
            popupAnchor: [0,-15]
        });
        let customOptions = { 'minWidth': '350', 'keepInView': 'true' }
        // marker = L.marker([15.735859, 120.934876], {icon: markerIcon}).bindPopup(customPopup,customOptions).addTo(map);
        // marker = L.marker([15.735859, 120.944876], {icon: markerIcon}).bindPopup(customPopup,customOptions).addTo(map);

        // $.ajax({
        //     url : window.location.origin + "/" + window.location.pathname.split('/', 2)[1] + "/system_admin/automon_marker_map",
        //     type: "POST",
        //     data: {uid: 0},
        //     dataType: "JSON",
        //     success: function(response)
        //     {
        //         //console.log((response));
        //         let marker;
        //         for(let automon in response){
        //             //console.log((response[automon].longitude));
        //             // create custom icon
        //             /*switch(response[automon].cluster.split(",")[0]){
        //                 case "REGION II":
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-green.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //                 case "REGION III":
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-blue.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //                 case "REGION VI":
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-red.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //                 default:
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-black.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //             }
        //             */
        //             let markerIcon = L.icon({
        //                 iconUrl: window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/leaflet-color-markers-master/img/marker-icon-2x-red.png',
        //                 iconSize: [25, 35], // size of the icon
        //                 popupAnchor: [0,-15]
        //             });
        //             let customPopup = '<ul class="list-group">' +
        //                                   '<li class="list-group-item">' + 
        //                                     '<b>AUTOMON NAME</b>' +
        //                                     '<h4 class="col-teal">'+ response[automon].automon +'</h4>' + 
        //                                   '</li>' +
        //                                   '<li class="list-group-item">' + 
        //                                     '<b>LOCATION</b>' +
        //                                     '<h4 class="col-teal">'+ response[automon].cluster +'</h4>' + 
        //                                   '</li>' +
        //                                   '<li class="list-group-item">' +
        //                                     '<b>REPORTS (<small>Water Level & Battery Percentage</small>)</b>' +
        //                                     '<br><small>'+ response[automon].reading_date +'</small>' +
        //                                     '<div class="row clearfix" style="margin-top: 15px;">' +
        //                                       '<div class="col-md-6">' + 
        //                                         '<img src="'+window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/images/water.png'+'" height="50">' +
        //                                         '<span class="col-teal" style="font-size: 24px; font-weight: bolder;">&nbsp;'+ parseInt(((response[automon].reading / 48) * -1) * 100) +'% <small>'+response[automon].reading+'</small></span>' + 
        //                                       '</div>' +
        //                                       '<div class="col-md-6">' + 
        //                                         '<img src="'+window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/images/battery.png'+'" height="50">' +
        //                                         '<span class="col-teal" style="font-size: 24px; font-weight: bolder;">&nbsp;'+ parseInt((response[automon].batt / 4.1) * 100) +'% <small>'+response[automon].batt+'</small></span>' + 
        //                                       '</div>' +
        //                                     '</div>' +
        //                                   '</li>' +
        //                                   '<li class="list-group-item"><center><a href="#">SHOW MORE <i class="fa fa-arrow-circle-right"></i></a></center></li>' +
        //                               '</ul>';
        //             let customOptions = { 'minWidth': '350', 'keepInView': 'true' }
        //             marker = L.marker([response[automon].latitude, response[automon].longitude], {icon: markerIcon}).bindPopup(customPopup,customOptions).addTo(map);
                     
        //         }
                
        //     },
        //     error: function (jqXHR, textStatus, errorThrown)
        //     {
        //         alert(errorThrown);
        //     }
        // });
  }
  
}pwdMapLocation();

function gradeList()
{
  
}