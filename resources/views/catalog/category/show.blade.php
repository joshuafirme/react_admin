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

              <li class="breadcrumb-item"><a href="/catalog/categories">Category</a></li>

              <li class="breadcrumb-item active">Category information</li>

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

                    <h3 class="card-title">Category information</h3>

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

                            <input id="category_name" type="text" readonly required name="category_name" class="form-control" value="{{$categories->category_name}}" autocomplete="off">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <!-- text input -->

                          <div class="form-group">

                            <label>Category Description</label>

                            <input id="category_description" type="text" readonly name="category_description" class="form-control" value="{{$categories->category_description}}" placeholder="Enter First name" autocomplete="off">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <!-- select -->

                          <div class="form-group">

                            <label>Agency</label>

                           
                              @foreach($agencies as $agency)

                                    @if($agency->id == $categories->agency_id)
                                        <input id="category_description" readonly type="text" name="category_description" class="form-control" value="{{ $agency->agency_name }}" placeholder="Enter First name" autocomplete="off">
                                    @endif

                                @endforeach

                           
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

