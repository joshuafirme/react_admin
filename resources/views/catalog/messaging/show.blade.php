@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="/ofw_admin/catalog/agencies">Agency</a></li>
              <li class="breadcrumb-item active">Agency Information</li>
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
                    <h3 class="card-title">Agency Information</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-agency" role="form" _lpchecked="1">
                      @csrf
                      <input type="hidden" name="id" value="{{$agencies->id}}"> 
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Agency Name</label>
                            <input id="agency_name" type="text" required name="agency_name" class="form-control" value="{{$agencies->agency_name}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Agency Description</label>
                            <input id="agency_description" type="text" name="agency_description" class="form-control" value="{{$agencies->agency_description}}" placeholder="Enter First name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Agency Email Address</label>
                            <input id="agency_email" type="text" name="agency_email" value="{{$agencies->agency_email}}" class="form-control" autocomplete="off">
                          </div>
                         </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Select Agency Type</label>
                            <select id="agency_type" name="agency_type" class="form-control">
                                <option value="1" {{$agencies->agency_type == 1 ? 'selected' : ''}}>Domestic Help</option>
                                <option value="2" {{$agencies->agency_type == 2 ? 'selected' : ''}}>IT / Communiation</option>
                                <option value="3" {{$agencies->agency_type == 3 ? 'selected' : ''}}>Etc..</option>
                             
                            </select>
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
   
@endsection
