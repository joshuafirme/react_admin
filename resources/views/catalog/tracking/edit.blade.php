@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $tracking['order_number'] }} - {{ $tracking['name'] }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/catalog/tracking ">Trackings</a></li>
              <li class="breadcrumb-item active">Edit Tracking</li>
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
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-tracking" role="form" _lpchecked="1">
                      @csrf
                      <input id="id" type="hidden" name="id" value="{{$tracking['id']}}"> 
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Date</label>
                            <input id="date" type="date" required   name="date" class="form-control" value="{{ date('Y-m-d',strtotime($tracking['date'])) }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Weight (Cost)</label>
                            <input id="weight_cost" type="number" required   name="weight_cost" class="form-control" value="{{ $tracking['weight_cost'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Order Number</label>
                            <input id="order_number" type="text" required readonly name="order_number" class="form-control" value="{{ $tracking['order_number'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Cost</label>
                            <input id="cost" type="number" required   name="cost" class="form-control" value="{{ $tracking['cost'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Name</label>
                            <input id="name" type="text" required   name="name" class="form-control" value="{{ $tracking['name'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Declared Value</label>
                            <input id="declared_value" type="number" required   name="declared_value" value="{{ $tracking['declared_value'] }}" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Address</label>
                            <input id="address" type="text" required   name="address" class="form-control" value="{{ $tracking['address'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Delivery Status</label>
                            <select id="delivery_status"    name="delivery_status" class="form-control" autocomplete="off">
                              <option value="">Please select</option>
                              <option {{ $tracking['delivery_status'] == 'Dispatched from Main Warehouse' ? 'selected' : '' }} value="Dispatched from Main Warehouse">Dispatched from Main Warehouse</option>
                              <option {{ $tracking['delivery_status'] == 'In Transit' ? 'selected' : '' }}  value="In Transit">In Transit</option>
                              <option {{ $tracking['delivery_status'] == 'Delivered' ? 'selected' : '' }}  value="Delivered">Delivered</option>
                              <option {{ $tracking['delivery_status'] == 'Returned' ? 'selected' : '' }}  value="Returned">Returned</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Phone Number</label>
                            <input id="phone_number" type="text"    name="phone_number" class="form-control" value="{{ $tracking['phone_number'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Delivery Date</label>
                            <input id="delivery_date" type="date"   name="delivery_date" class="form-control" value="{{ date('Y-m-d',strtotime($tracking['delivery_date'])) }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Area</label>
                            <input id="area" type="text"    name="area" class="form-control" value="{{ $tracking['area'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Returned Date</label>
                            <input id="returned_date" type="date"   name="returned_date" class="form-control" value="{{ date('Y-m-d',strtotime($tracking['returned_date'])) }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Aging</label>
                            <input id="aging" type="text"    name="aging" class="form-control" value="{{ $tracking['aging'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Actual Weight</label>
                            <input id="actual_weight" type="number"    name="actual_weight" class="form-control" value="{{ $tracking['actual_weight'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Remarks</label>
                            <input id="remarks" type="text"    name="remarks" class="form-control" value="{{ $tracking['remarks'] }}" autocomplete="off">
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
        
        $("#btn-submit").click(function(e){

        e.preventDefault();
        console.log($('#delivery_status option:selected').val())
        if($('#delivery_status option:selected').val() == 'Delivered'){
          if(confirm("Are you sure you want to update this status to delivered?")){
              
          }else{
            return false;
          }
        }
        $.ajax({
          type: 'POST',
          url: '/catalog/tracking/update',
          data: $("#form-tracking").serialize(),
          success:function(data){
              console.log(JSON.parse(data))
              var ret = JSON.parse(data);
              $.each( ret, function( key, value ) {
                  console.log( key + ": " + value );
                  
                  if( key== "message"){
                      $("#"+key).html('<div class="alert alert-success"><i class="fa fa-check"></i> '+value+'</div>')
                      location.href="/catalog/tracking"
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
        
   
    </script>

@endsection
