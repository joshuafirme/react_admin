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

              <li class="breadcrumb-item"><a href="/catalog/roles">Roles</a></li>

              <li class="breadcrumb-item active">Add Role</li>

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

                    <h3 class="card-title">Add Role</h3>

                  </div>

                  <!-- /.card-header -->

                  <div class="card-body">

                    <form id="form-role" role="form" _lpchecked="1">

                        @csrf

                      <div class="row">

                        <div class="col-sm-6">

                          <!-- text input -->

                          <div class="form-group">

                            <label>Role Name</label>

                            <input id="role_name" type="text" required name="role_name" class="form-control" placeholder="Enter Username" autocomplete="off">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <!-- text input -->

                          <div class="form-group">

                            <label>Role Description</label>

                            <input id="role_description" type="text" name="role_description" class="form-control" placeholder="Enter First name" autocomplete="off">

                          </div>

                            <button id="btn-submit" type="submit" class="btn btn-success btn-lg float-right">Save</button>

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

               url: '/catalog/roles/store',

               data: $("#form-role").serialize(),

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

