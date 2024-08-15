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
              <li class="breadcrumb-item"><a href="/ofw_admin/catalog/users">Users</a></li>
              <li class="breadcrumb-item active">User information</li>
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
                    <h3 class="card-title">User information </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-user" role="form" _lpchecked="1">
                      @csrf
                      <input type="hidden" name="id" value="{{$user->id}}"> 
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Employee No</label>
                            <input id="firstname" type="text" required name="employee_no" class="form-control" value="{{$user->firstname}}" placeholder="Enter First name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Username</label>
                            <input id="username" type="text" readonly required name="username" class="form-control" placeholder="Enter Username" value="{{$user->username}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" name="password" class="form-control" placeholder="Enter Password" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Confirm password</label>
                            <input id="cpassword" type="password" name="cpassword" class="form-control" placeholder="Confirm Password" autocomplete="off">
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
