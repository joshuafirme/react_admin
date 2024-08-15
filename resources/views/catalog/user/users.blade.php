@extends('layouts.main')



@section('content')



  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0 text-dark">Users</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="/home">Home</a></li>

              <li class="breadcrumb-item active">Users</li>

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

               <div class="btn-group float-right">

                   <a href="/catalog/users/add" title="Add user"><button type="submit" class="btn  btn-warning">Add User</button></a>

                   <!-- <a href="/catalog/users/add-admin" title="Add admin"><button type="submit" class="btn btn-primary">Add Admin</button></a> -->

                   

                </div>

                <br><br>

              <table id="data" class="table table-striped">

                <thead>

                    <tr>

                        <th ><strong> Employee No </strong></th>

                        <th ><strong> Username </strong></th>

                        @if(Request::path() != 'catalog/adminUsers')

                        <th ><strong> Department </strong></th>

                        <th ><strong> Role </strong></th>

                        @endif

                        <th ><strong> Action </strong></th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($users as $data)

                      <tr>

                          <td> {{ $data->employee_no }} </td>

                          <td> {{ $data->username }}</td>

                          <!-- @if(Request::path() != 'catalog/adminUsers') -->

                          <td> 
                                <select id="agency_id_{{$data->id }}" name="agency_id" class="form-control">
                                  @foreach($agencies as $agency)
                                    @if($agency->id == $data->agency_id)
                                      <option value="{{ $agency->id }}" selected>{{ $agency->agency_name }}</option>
                                    @else
                                      <option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>
                                    @endif
                                  @endforeach
                                </select>
                          </td>

                         


                          <td> 
                                <select id="role_id_{{$data->id }}" name="role_id" class="form-control">
                                  @foreach($roles as $role)
                                    @if($role->id == $data->role_id)
                                      <option value="{{ $role->id }}" selected>{{ $role->role_name }}</option>
                                    @else
                                      <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endif
                                  @endforeach
                                </select>
                          </td>
                          <!-- @endif -->
                          
                          <td> 
                              <!-- <a href="/catalog/user/show/{{ $data->id }}" class="btn btn-success"><i class="fa fa-eye"></i></a>  -->

                          @if(isAdmin() || isSuperAdmin())

                              

                              

                              @if(Request::path() != 'catalog/adminUsers')

                              <a href="#" data-id="{{ $data->id }}" class="btn btn-primary update-it"><i class="fa fa-save"></i></a> 

                              @else

                              <a href="/catalog/user/edit/{{ $data->id }}" class="btn btn-primary"><i class="fa fa-pen"></i></a> 

                              @endif

                              <a href="#" data-id="{{ $data->id }}" class="btn btn-danger delete-it">

                              <i class="fa fa-trash"></i></a> 

                          @endif

                          </td>

                      </tr>

                    @endforeach

                </tbody>

              </table>       

                 

              {{ $users->links() }} 

            </div>

            <div class="col-lg-12">

            <!-- <a href="#" class="btn btn-danger float-right update-all">Refresh qty assigned</a>  -->

            </div>

            <br>

            <br>

            <!-- /.col-md-3 -->

        

        </div>

        <!-- /.row -->

      </div><!-- /.container-fluid -->

    </div>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

<script>

    $(".delete-it").click(function(e){



        e.preventDefault();

        var id = $(this).attr("data-id")

        console.log(id)

        if(confirm("Are you sure, you want to delete it?")){

            $.ajax({

               type: 'GET',

               url: '/catalog/user/delete/'+id,

               data: $("#form-user").serialize(),

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



    $(".update-it").click(function(e){



      e.preventDefault();

      var id = $(this).attr("data-id")

      console.log(id)

      if(confirm("Are you sure, you want to update it?")){

          $.ajax({

            type: 'POST',

            url: '/catalog/user/updateQtyAssigned',

            data: { "_token": "{{ csrf_token() }}",id:id,role_id:$("#role_id_"+id+" option:selected").val(),agency_id:$("#agency_id_"+id+" option:selected").val()},

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

    

  $(".update-all").click(function(e){



      e.preventDefault();

      if(confirm("Are you sure, you want to update all qty assigned?")){

          $.ajax({

            type: 'POST',

            url: '/catalog/user/updateAll',

            data: { "_token": "{{ csrf_token() }}"},

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

