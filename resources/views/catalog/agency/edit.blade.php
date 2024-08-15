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

              <li class="breadcrumb-item"><a href="/catalog/agencies">Agency</a></li>

              <li class="breadcrumb-item active">Update Agency</li>

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

                    <h3 class="card-title">Update Agency</h3>

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

                         <div class="col-sm-6" style="display:none;">

                          <!-- select -->

                          <div class="form-group">

                            <label>Select Agency Type</label>

                            <select id="agency_type" name="agency_type" class="form-control">

                                <option value="1" {{$agencies->agency_type == 1 ? 'selected' : ''}}>Public</option>

                                <option value="2" {{$agencies->agency_type == 2 ? 'selected' : ''}}>IT / Communiation</option>

                                <option value="3" {{$agencies->agency_type == 3 ? 'selected' : ''}}>Etc..</option>

                            

                            </select>

                          </div>

                          </div>

                        <div class="col-sm-12">

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

               url: '/catalog/agencies/update',

               data: $("#form-agency").serialize(),

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

