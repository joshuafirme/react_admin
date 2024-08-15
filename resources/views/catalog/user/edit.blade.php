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
              <li class="breadcrumb-item"><a href="/catalog/users">Admin Users</a></li>
              <li class="breadcrumb-item active">Add Admin User</li>
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
                    <h3 class="card-title">Update Admin User</h3>
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
                            <label>Username</label>
                            <input id="username" type="text" readonly required name="username" class="form-control" placeholder="Enter Username" value="{{$user->username}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Firstname</label>
                            <input id="firstname" type="text" required name="firstname" class="form-control" value="{{$user->firstname}}" placeholder="Enter First name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Middlename</label>
                            <input id="middlename" type="text" name="middlename" class="form-control" value="{{$user->middlename}}" placeholder="Enter Middle name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Lastname</label>
                            <input id="lastname" type="text" name="lastname" class="form-control" value="{{$user->lastname}}" placeholder="Enter Last name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Email address</label>
                            <input id="email" type="email" name="email" readonly class="form-control" value="{{$user->email}}" placeholder="Enter Email address" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Mobile number</label>
                            <input id="phone_number" type="text" name="phone_number" class="form-control" value="{{$user->phone_number}}" placeholder="Enter Mobile number" autocomplete="off">
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
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Select Agency</label>
                            <select id="agency_id" name="agency_id" class="form-control">
                              @foreach($agencies as $agency)
                                    @if($agency->id == $user->agency_id)
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
                            <label>Select Role</label>
                            <select id="role_id" name="role_id" class="form-control">
                                @foreach($roles as $role)
                                     @if($role->id == $user->role_id)
                                        <option value="{{ $role->id }}" selected>{{ $role->role_name }}</option>
                                    @else
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endif
                                    
                                @endforeach
                            </select>
                          </div>
                            
                          <button id="btn-submit" type="submit" class="btn btn-success btn-lg float-right">Update</button>
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

            $.ajax({
               type: 'POST',
               url: '/catalog/user/update',
               data: $("#form-user").serialize(),
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
