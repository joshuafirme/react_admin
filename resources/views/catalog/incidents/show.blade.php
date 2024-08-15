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
                        <div class="col-sm-12 float-left">
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
                            <input readonly id="location" type="text" name="location" class="form-control" value="{{$incidents['location']}}" autocomplete="off">
                          </div>
                        </div> 
                        <div class="col-sm-12">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Incident Description</label>
                              <textarea readonly id="incident_description" name="incident_description" class="form-control">{{$incidents['incident_description']}}</textarea>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Category</label>
                            <input readonly class="form-control" value="{{$incidents['category_name']}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Case Type / Sub-Category</label>
                            <input readonly class="form-control" value="{{$incidents['subcategory_name']}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Agency</label>
                            <input readonly class="form-control" value="{{$incidents['agency_name']}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Case Status</label>
                            <input readonly id="location" type="text" name="location" class="form-control" value="{{$incidents['incident_status']}}" autocomplete="off">
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
        
   
    </script>

@endsection
