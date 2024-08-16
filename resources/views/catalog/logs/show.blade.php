@extends('layouts.main')



@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0 text-dark">Case Details</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              @if(isset($_GET['from']))
                <li class="breadcrumb-item"><a href="/catalog/reports ">Back</a></li>
              @else
                <li class="breadcrumb-item"><a href="/catalog/logs ">Back</a></li>
              @endif

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
            <div class="col-md-12 col-lg-12 col-xs-12">
                <div id="message"></div>
            </div>
            <div class="col-md-12 col-lg-6 col-xs-6">
                <div class="card" style="min-height:380px;">
                  <h5 class="card-header bg-warning">Case Summary</h5>
                  <div class="card-body">
                    <p class="card-text">Incident No.: {{ str_pad($logs->id, 8, "0", STR_PAD_LEFT) }}</p>
                    <p class="card-text">Date: {{ $logs->created_at->format('M d, Y') }}</p>
                    <p class="card-text">Reported by: {{ isset($userData) ? $userData->username : "N/A" }}</p>
                    <p class="card-text">Assigned to: {{ count($logs->agencies) > 0 ? $logs->agencies[0]->agency_name : "N/A" }}</p>
                    <p class="card-text">Category: {{ count($logs->categories) > 0? $logs->categories[0]->category_name  : "N/A" }}</p>
                    <p class="card-text">Current Status: {{ $logs->signature }}</p>
                    <p class="card-text">Barangay: {{ $logs->brgy }}</p>
                    <p class="card-text">Nearest Location: {{ $logs->drop_off_points }}</p>
                    
                  
                    
                     
                  </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">
                <form id="form-incident" role="form" _lpchecked="1">
                  @csrf
                  
                  <input id="incident_id" name="id" type="hidden" value="{{ $logs->id }}">
                  @if(!isset($_GET['from']))
                  <div class="card" style="min-height:380px;">
                    <h5 class="card-header bg-warning">Resolution Box</h5>
                    <div class="card-body">
                    <p class="card-text">Description: {{ $logs->remarks }}</p>
                    @if(isset($logs->attachment))
                    <p class="card-text">Attachment: (Click for larger image)<br> <a href='/public/{{ $logs->attachment }}' target="_blank"><img src='/public/{{ $logs->attachment }}' style="width:100px;"></a> </p>
                    @endif
                    <p class="card-text">Reassign to: 
                    <select class="form-control" id="agency_id" name="agency_id">
                    @foreach($agencies as $val)
                      @if($val->id == $logs->agency_id)
                      <option value="{{ $val->id }}" selected>{{ $val->agency_name }}</option>
                      @else
                      <option value="{{ $val->id }}">{{ $val->agency_name }}</option>
                      @endif
                    @endforeach
                    </select></p>
                    <p class="card-text">Status to: 
                    <select class="form-control" id="status" name="signature">
                    <option class="bg-danger" value="Open" <?php echo ($logs->signature == "Open") ? "selected" : "" ?>>Open</option>
                    <option class="bg-dark" value="Dispatched" <?php echo ($logs->signature == "Dispatched") ? "selected" : "" ?>>Dispatched</option>
                   
                    </select></p>
                    <a id="btn-change" data-id="{{ $logs->id }}" href="#" class="btn btn-warning btn-block">CHANGE</a>
                    </div>
                  </div>
                  @else
                  <div class="card" style="min-height:380px;">
                    <h5 class="card-header bg-warning">Resolution Box</h5>
                    <div class="card-body">
                    <p class="card-text">Assigned to: {{ count($logs->agencies) > 0 ? $logs->agencies[0]->agency_name : "N/A" }}</p>
                    <p class="card-text">Status to: {{ $logs->signature }}</p>
                    <p class="card-text">Description: {{ $logs->remarks }}</p>
                    @if(isset($logs->attachment))
                    <p class="card-text">Attachment:<br> <img src='/public/{{ $logs->attachment }}' style="width:200px;"> </p>
                    @endif
                    </div>
                  </div>
                  @endif
                </form>
            </div>

            <div class="col-lg-12">
                <div id="map" style="height: 580px; border: 1px solid #AAA;"></div>
            </div>

        </div>

        <!-- /.row -->

      </div><!-- /.container-fluid -->

    </div>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->
<script>
var map;
var marker;
var userId = 0;
var isMap;
var myDate;
var today;

//map

var coordinate_x = "{{ $logs->coord_x }}";
var coordinate_y = "{{ $logs->coord_y }}";
map = L.map( 'map', {
                    center: [coordinate_x, coordinate_y],
                    minZoom: 2,
                    zoom: 18
                });

                L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    subdomains: ['a','b','c']
                }).addTo( map );

                marker = new L.marker([coordinate_x,coordinate_y]).addTo(map);
               


$("#btn-change").click(function(e){

e.preventDefault();

if(confirm("Are you sure, you want to change it?")){
    $.ajax({
       type: 'POST',
       url: '/catalog/logs/update',
       data: $("#form-incident").serialize(),
       success:function(data){
           console.log(JSON.parse(data))
           var ret = JSON.parse(data);
           $.each( ret, function( key, value ) {
              console.log( key + ": " + value );
               if( key== "message"){
                   setTimeout(function(){
                       location.reload(true);
                   },1000)
                   $("#"+key).html('<div class="alert alert-success"><i class="fa fa-check"></i> '+value+'</div>').delay(1000).fadeOut('slow')
                   return false;
               }
           });
       }
    });    
}
});
</script>
@endsection

