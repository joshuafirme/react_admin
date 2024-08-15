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
              <li class="breadcrumb-item"><a href="/ofw_admin/catalog/roles">Role</a></li>
              <li class="breadcrumb-item active">Role information</li>
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
                    <h3 class="card-title">Role information</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-user" role="form" _lpchecked="1">
                      @csrf
                      <input type="hidden" name="id" value="{{$roles->id}}"> 
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Role Name</label>
                            <input id="role_name" type="text" required name="role_name" class="form-control" placeholder="Enter Username" value="{{$roles->role_name}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Role Description</label>
                            <input id="role_description" type="text" name="role_description" class="form-control" value="{{$roles->role_description}}" placeholder="Enter First name" autocomplete="off">
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
