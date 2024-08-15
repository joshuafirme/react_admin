@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Incident Types</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/ofw_admin/catalog/subcategories ">Incident Type</a></li>
              <li class="breadcrumb-item active">Incident Type Information</li>
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
                    <h3 class="card-title">Incident Type/Sub-Category Information</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-subcategory" role="form" _lpchecked="1">
                      @csrf
                      <input type="hidden" name="id" value="{{$subcategories->id}}"> 
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Sub-Category Name</label>
                            <input readonly id="subcategory_name" type="text" required name="subcategory_name" class="form-control" value="{{$subcategories->subcategory_name}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Sub-Category Description</label>
                            <input readonly id="subcategory_description" type="text" name="subcategory_description" class="form-control" value="{{$subcategories->subcategory_description}}" placeholder="Enter First name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Categry</label>
                            <select readonly id="category_id" name="category_id" class="form-control">
                              @foreach($categories as $category)
                                    @if($subcategories->category_id == $category->id )
                                    <option value="{{ $category->id }}" selected>{{ $category->category_name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endif
                                @endforeach
                            </select>
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
