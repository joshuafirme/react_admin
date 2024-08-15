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

              <li class="breadcrumb-item"><a href="/catalog/categories ">Category</a></li>

              <li class="breadcrumb-item active">Update Category</li>

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

                    <h3 class="card-title">Update Category</h3>

                  </div>

                  <!-- /.card-header -->

                  <div class="card-body">

                    <form id="form-category" role="form" _lpchecked="1">

                      @csrf

                      <input type="hidden" name="id" value="{{$categories->id}}"> 

                      <div class="row">

                        <div class="col-sm-6">

                          <!-- text input -->

                          <div class="form-group">

                            <label>Category Name</label>

                            <input id="category_name" type="text" required name="category_name" class="form-control" value="{{$categories->category_name}}" autocomplete="off">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <!-- text input -->

                          <div class="form-group">

                            <label>Category Description</label>

                            <input id="category_description" type="text" name="category_description" class="form-control" value="{{$categories->category_description}}" placeholder="Enter First name" autocomplete="off">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <!-- select -->

                          <div class="form-group">

                            <label>Select Agency</label>

                            <select id="agency_id" name="agency_id" class="form-control">

                              @foreach($agencies as $agency)

                                    @if($agency->id == $categories->agency_id)

                                        <option value="{{ $agency->id }}" selected>{{ $agency->agency_name }}</option>

                                    @else

                                        <option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>

                                    @endif

                                @endforeach

                            </select>

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <!-- text input -->

                          <div class="form-group">

                            <label>Code Color</label>
                            <br>
                            <input type="color" id="code_color" name="code_color" value="{{$categories->code_color}}">

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

               url: '/catalog/categories/update',

               data: $("#form-category").serialize(),

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

