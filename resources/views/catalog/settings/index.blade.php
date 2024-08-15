@extends('layouts.main')



@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <div class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

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

                                <h3 class="card-title">Settings</h3>

                            </div>

                            <!-- /.card-header -->

                            <div class="card-body">

                                <form action="/catalog/settings/update" method="POST" enctype="multipart/form-data">

                                    @csrf

                                    <div class="row">

                                        <div class="col-sm-6">

                                            <!-- text input -->

                                            <div class="form-group">

                                                <label>App Name</label>

                                                <input id="app_name" type="text" required name="app_name" value="{{ isset($data->app_name) ? $data->app_name : '' }}"
                                                    class="form-control" autocomplete="off">

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label>Logo</label>

                                                <img id="image-attached" style="width: 100%;display:none;" alt="logo" />

                                                <input id="logo" type="file" enctype="multipart/form-data"
                                                    name="logo" class="form-control" autocomplete="off">

                                                    @if (isset($data->logo) )
                                                        <img src="{{asset($data->logo)}}" alt="" width="200px;">
                                                    @endif

                                            </div>

                                        </div>

                                        <div class="col-sm-12">

                                            <button id="btn-submit" type="submit"
                                                class="btn btn-success btn-lg float-right">Save</button>

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
