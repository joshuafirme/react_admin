@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Incident</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/ofw_admin/catalog/incidents ">Incident</a></li>
              <li class="breadcrumb-item active">Edit Incident</li>
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
                    <h3 class="card-title">Update Incident</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-incident" role="form" _lpchecked="1">
                      @csrf
                      <input id="id" type="hidden" name="id" value="{{$incidents['id']}}"> 
                      <div class="row">
                        <div class="col-sm-12">
                          <!-- text input -->
                          <div class="form-group">
                            <label>QR Code</label>
                            <div id="qrcode"></div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Case No</label>
                            <input readonly type="text" class="form-control" value="{{$incidents['case_no']}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Incident Location</label>
                            <input id="location" type="text" name="location" class="form-control" value="{{$incidents['location']}}" autocomplete="off">
                          </div>
                        </div> 
                        <div class="col-sm-12">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Incident Description</label>
                              <textarea id="incident_description" name="incident_description" class="form-control">{{$incidents['incident_description']}}</textarea>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Categry</label>
                            <select id="category_id" name="category_id" class="form-control">
                              @foreach($categories as $category)
                                    @if($incidents['category_id'] == $category->id )
                                    <option value="{{ $category->id }}" selected>{{ $category->category_name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Sub-Category</label>
                            <select id="subcategory_id" name="subcategory_id" class="form-control">
                              @foreach($subcategories as $subcategory)
                                    @if($incidents['subcategory_id'] == $subcategory->id)
                                    <option value="{{ $subcategory->id }}" selected>{{ $subcategory->subcategory_name }}</option>
                                    @else
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Agency</label>
                            <select id="agency_id" name="agency_id" class="form-control">
                              @foreach($agencies as $agency)
                                    @if($incidents['agency_id'] == $agency->id)
                                    <option value="{{ $agency->id }}" selected>{{ $agency->agency_name }}</option>
                                    @else
                                    <option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Case Status</label>
                            <select id="incident_status" name="incident_status" class="form-control">
                              <option value="1" <?php echo $incidents['incident_status'] == 'Pending' ? "selected" : ""; ?>>Pending</option>
                              <option value="2" <?php echo $incidents['incident_status'] == 'No Action' ? "selected" : ""; ?>>No Action</option>
                              <option value="3" <?php echo $incidents['incident_status'] == 'Done / Completed' ? "selected" : ""; ?>>Done / Completed</option>
                              <option value="4" <?php echo $incidents['incident_status'] == 'Rejected' ? "selected" : ""; ?>>Rejected</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="btn-group float-right">
                                <button id="btn-submit" type="submit" class="btn btn-success btn-lg">Update Status</button>
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
        var qrcode = new QRCode(document.getElementById("qrcode"), {
          width : 250,
          height : 250
        });

        function makeCode () {    
          var code = '{{$incidents['case_no']}}'; 
          $('#code_value').html('')
          $('#code_value').html(code)
          console.log(code)
          qrcode.makeCode(code);
        }

        makeCode();
        
        $("#btn-submit").click(function(e){

            var updateStatusForm =  new FormData();
            var id = $('#id').val();
            console.log(id)
            var incident_status =  $('#incident_status option:selected').val();
            updateStatusForm.append('incident_id', id);
            updateStatusForm.append('incident_status', incident_status);
            updateStatusForm.append('_token', "{{ csrf_token() }}");
            updateStatusForm.append('_method', 'POST');
            
            e.preventDefault();
            $.ajax({
               type: 'POST',
               url: '/ofw_admin/catalog/incidents/updateStatus',
               data: updateStatusForm,
               dataType: "text",
               processData: false,
               contentType: false,
               async: false,
               success:function(data){
                  console.log(JSON.parse(data))
                   var ret = JSON.parse(data);
                   $.each( ret, function( key, value ) {
                      console.log( key + ": " + value );
                       
                       if( key== "message"){
                           $("#"+key).html('<div class="alert alert-success"><i class="fa fa-check"></i> '+value+'</div>')
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
