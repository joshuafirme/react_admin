@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

<style>#mapid { height: 180px; }</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="name" class="col-sm-12 control-label">Case Type</label>
                    <div class="col-sm-12">
                        <select class="form-control incident_filter" id="incident_filter">
                            <option value="0">Please select incident</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="name" class="col-sm-12 control-label">Date</label>
                    <div class="col-sm-12">
                        <input id="date" class="form-control" type="date" name="date">
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="small-box bg-gradient-orange">
                    <div class="inner">
                        <p>TOTAL CASES OPEN:</p>
                        <h3><div id="qty_assigned">0</div></h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="/catalog/logs" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>  
            </div>

            <div class="col-lg-3">
                <div class="small-box bg-gradient-orange">
                    <div class="inner">
                        <p>CASES REPORTED TODAY:</p>
                        <h3><div id="current_drop_off">0</div></h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="/catalog/logs" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>  
            </div>

           
            <div class="col-lg-12">
                <div id="map" style="height: 580px; border: 1px solid #AAA;"></div>
            </div>

            <div id="addtoast"></div>
            
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="https://raw.githubusercontent.com/iatkin/leaflet-svgicon/master/svg-icon.js"></script>
<script>
// var map = L.map( 'map', {
//     center: [20.0, 5.0],
//     minZoom: 2,
//     zoom: 2
// });

// L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
//     subdomains: ['a','b','c']
// }).addTo( map );
var map;
var marker;
var userId = 0;
var isMap;
var myDate;
var today;
var agency_id = "{{ Auth::user()->agency_id }}"
var role_id = "{{ Auth::user()->role_id }}"
setTimeout(function(){
    myDate = document.querySelector("#date");
    today = new Date();
    var current_datetime = changeTimezone(today, "Asia/Manila");
    let formatted_date = current_datetime.getFullYear() + "-" + appendLeadingZeroes(current_datetime.getMonth() + 1) + "-" + appendLeadingZeroes(current_datetime.getDate())
    console.log(formatted_date)
    myDate.value = formatted_date;
    loadMap(0, formatted_date);
    loadDataDashboard(0, formatted_date);
    // $("#addtoast").append('<div class="toast" class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="10000" style="z-index:100000 !important;position: absolute; top: 20; right: 0;"> <div class="toast-header"> <strong class="mr-auto text-primary">Toast Header</strong> <small class="text-muted">5 mins ago</small> <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button> </div> <div class="toast-body"> Some text inside the toast body </div> </div>')
    // $('.toast').toast('show');
}, 1000)

  //Remember to replace key and cluster with your credentials.
  var pusher = new Pusher('f32dc778951bef48e635', {
      cluster: 'eu',
      encrypted: true
  });
  //Also remember to change channel and event name if your's are different.
  var channel = pusher.subscribe('update-data');
    channel.bind('update-data-event', function(data) {
        console.log(JSON.parse(data))
        var dataRet = JSON.parse(data);
        myDate = document.querySelector("#date");
        loadDataDashboard(0,myDate.value);
        if(dataRet.agency_id == agency_id || role_id == 1 || role_id == 2 || role_id == 3){
          $("#addtoast").append('<div class="toast"role="alert" aria-live="polite" aria-atomic="true" data-autohide="false" style="z-index:100000 !important;position: absolute; top: 20; right: 0;"> <div class="toast-header"> <strong class="mr-auto text-primary">New Incident incoming!</strong> <small class="text-muted">Just now</small> <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button> </div> <div class="toast-body">'+dataRet.remarks+' at ' + dataRet.drop_off_points+'<a href="/catalog/logs/show/'+dataRet.id+'">View Here</a> </div> </div>')
        }
    $('.toast').toast('show');
        
    }); 

$("#incident_filter, #date").on('change',function(){
    var userId = $("#incident_filter option:selected").val()
    myDate = document.querySelector("#date");
    console.log(myDate.value)
    map.eachLayer(function(layer){
        map.remove();
        map.removeLayer(layer);
        latlngs = [];
        isMap = false;
       loadMap(userId,myDate.value) //reload the map function
       loadDataDashboard(userId,myDate.value)
    });
   
})
 
function loadMap(userId,date){
      $.ajax({
        type: 'POST',
        url: '/catalog/getDropOffPoints',
        data: { _token: "{{csrf_token()}}",userId:userId,date:date},
        success:function(data){
        
            var returnData = JSON.parse(data);
            console.log(returnData)
            if(returnData){
                //map
                map = L.map( 'map', {
                    center: [14.592200, 121.033840],
                    minZoom: 2,
                    zoom: 12
                });

                L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    subdomains: ['a','b','c']
                }).addTo( map );

                $.each(returnData,function(x,y){
                    var coordinate_x = y.coord_x == null ? 14.592200 : y.coord_x;
                    var coordinate_y = y.coord_y == null ? 121.033840 : y.coord_y;
                    marker = new L.marker([coordinate_x,coordinate_y]).addTo(map);
                });

                //map end
                
            }    
            
        }
      });

    // $.ajax({
    //     type: 'GET',
    //     url: '/catalog/getDropOffPoints/'+userId,
    //     success:function(data){
    //         var returnData = JSON.parse(data);
    //         console.log(returnData)
    //         if(returnData){
    //             //map
    //             map = L.map( 'map', {
    //                 center: [14.592200, 121.033840],
    //                 minZoom: 2,
    //                 zoom: 12
    //             });

    //             L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //                 attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    //                 subdomains: ['a','b','c']
    //             }).addTo( map );

    //             $.each(returnData,function(x,y){
    //             marker = new L.marker([y.coord_x,y.coord_y]).addTo(map);
    //             });

    //             //map end
                
    //         }
    //     }
    // });   
}

function loadDataDashboard(category_id,date){
    $.ajax({
        type: 'POST',
        url: '/home/loadDataDashboard',
        data: { _token: "{{csrf_token()}}",category_id:category_id,date:date},
        success:function(data){
        
            var returnData = JSON.parse(data);
            console.log(returnData)
            $('#qty_assigned').html(returnData.qty_assigned)
            $('#current_drop_off').html(returnData.qty_dropped) 
            
        }
      }); 
}


function appendLeadingZeroes(n){
  if(n <= 9){
    return "0" + n;
  }
  return n
}

function changeTimezone(date, ianatz) {

// suppose the date is 12:00 UTC
var invdate = new Date(date.toLocaleString('en-US', {
  timeZone: ianatz
}));

// then invdate will be 07:00 in Toronto
// and the diff is 5 hours
var diff = date.getTime() - invdate.getTime();

// so 12:00 in Toronto is 17:00 UTC
return new Date(date.getTime() + diff);

}

</script>
@endsection
