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
              <li class="breadcrumb-item"><a href="/ofw_admin/marketing/advertisements">Advertisement</a></li>
              <li class="breadcrumb-item active">Advertisement Information</li>
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
                    <h3 class="card-title">Advertisement Information</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-advertisement" role="form" _lpchecked="1">
                      @csrf
                      <input type="hidden" name="id" value="{{$advertisements->id}}"> 
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Advertisement Name</label>
                            <input id="ads_name" type="text" required name="ads_name" class="form-control" value="{{$advertisements->ads_name}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Advertisement Description</label>
                            <input id="ads_description" type="text" name="ads_description" class="form-control" value="{{$advertisements->ads_description}}" placeholder="Enter First name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Advertisement Email Address</label>
                            <input id="ads_email" type="text" name="ads_email" value="{{$advertisements->ads_email}}" class="form-control" autocomplete="off">
                          </div>
                         </div>
                         <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Advertisement URL</label>
                            <input id="ads_url" type="text" name="ads_url" value="{{$advertisements->ads_url}}" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Select Advertisement Type</label>
                            <select id="ads_type" name="ads_type" class="form-control">
                                <option value="1">Domestic Help</option>
                                <option value="2">IT / Communiation</option>
                                <option value="3">Etc..</option>
                             
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Advertisement Image</label>
                              @if($advertisements->ads_img)
                                <img id="image-attached" src="/ofw_admin/public{{$advertisements->ads_img}}" style="width: 100%;" alt="ads_img"/>
                              @else
                                <img id="image-attached" style="width: 100%;display:none;" alt="ads_img"/>
                              @endif
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
