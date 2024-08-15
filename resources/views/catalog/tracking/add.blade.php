@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tracking</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/catalog/tracking">Tracking</a></li>
              <li class="breadcrumb-item active">Add new</li>
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
            <div class="col-lg-12">
                <div id="message"></div>
                <div class="row"> 
                  <div class="col-sm-4 offset-8">
                  <form action="{{ route('importTracking') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <div class="input-group">
                        <div class="">
                          <input type="file" class="" name="imported_file" id="inputGroupFile04">
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-success" type="submit">Batch Upload</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <br><br>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Add new</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-tracking" role="form" _lpchecked="1">
                      @csrf
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Date</label>
                            <input id="date" type="date" required name="date" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Weight (Cost)</label>
                            <input id="weight_cost" type="number" name="weight_cost" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Order Number</label>
                            <input id="order_number" type="text" required name="order_number" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Cost</label>
                            <input id="cost" type="number" name="cost" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Name</label>
                            <input id="name" type="text" required name="name" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Declared Value</label>
                            <input id="declared_value" type="number" name="declared_value" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Address</label>
                            <input id="address" type="text" required name="address" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Delivery Status</label>
                            <select id="delivery_status"  name="delivery_status" class="form-control" autocomplete="off">
                              <option value="">Please select</option>
                              <option value="Order received by Flying High">Order received by Flying High</option>
                              <option value="In Transit">In Transit</option>
                              <option value="Delivered">Delivered</option>
                              <option value="Delivered">Returned</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Phone Number</label>
                            <input id="phone_number" type="text"  name="phone_number" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Delivery Date</label>
                            <input id="delivery_date" type="date" name="delivery_date" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Area</label>
                            <input id="area" type="text"    name="area" class="form-control" value="" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Returned Date</label>
                            <input id="returned_date" type="date"   name="returned_date" class="form-control" value="" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Aging</label>
                            <input id="aging" type="text"  name="aging" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Actual Weight</label>
                            <input id="actual_weight" type="number"  name="actual_weight" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Remarks</label>
                            <input id="remarks" type="text"  name="remarks" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                              <div class="col-sm-4  offset-2"> <a href="#" onclick="location.href='/catalog/tracking'" class="btn btn-block btn-outline-warning btn-lg float-right">Cancel</a></div>
                              <div class="col-sm-4"> <button id="btn-submit" type="submit" class="btn btn-block btn-warning btn-lg float-right">Save</button></div>
                            </div>
                        </div>
                      </div>
                 
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col-md-3 -->
        
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <script>
        var myDate = document.querySelector("#date");
        var today = new Date();
        var current_datetime = changeTimezone(today, "Asia/Manila");
        let formatted_date = current_datetime.getFullYear() + "-" + appendLeadingZeroes(current_datetime.getMonth() + 1) + "-" + appendLeadingZeroes(current_datetime.getDate())
        console.log(formatted_date)
        myDate.value = formatted_date;
        
        $("#btn-submit").click(function(e){

            e.preventDefault();

            $.ajax({
               type: 'POST',
               url: '/catalog/tracking/store',
               data: $("#form-tracking").serialize(),
               success:function(data){
                  console.log(JSON.parse(data))
                   var ret = JSON.parse(data);
                  $.each( ret, function( key, value ) {
                      console.log( key + ": " + value );
                       
                       if( key== "message"){
                           $("#"+key).html('<div class="alert alert-success"><i class="fa fa-check"></i> '+value+'</div>').fadeOut()
                           $("input").val('');
                           $("select").val('1');
                           locatiom.href='/catalog/tracking'
                           return false;
                       }
                       
                       if($('#added'+key).length === 0){
                           
                           $("#"+key).addClass("is-invalid");
                           $("<p id='added"+key+"' class='text-danger'>"+value+"</p>").insertAfter("#"+key);
                           setTimeout(function(){
                               $("#"+key).removeClass("is-invalid");
                               $("#"+key).nextAll('p').remove();
                           },3000)  
                       }
                       
                   });
               }
            });
        });

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

        function appendLeadingZeroes(n){
          if(n <= 9){
            return "0" + n;
          }
          return n
        }
    </script>

@endsection
