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
              <li class="breadcrumb-item active">Update Incident Type</li>
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
                    <h3 class="card-title">Update Incident Type/Sub-Category</h3>
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
                            <input id="subcategory_name" type="text" required name="subcategory_name" class="form-control" value="{{$subcategories->subcategory_name}}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Sub-Category Description</label>
                            <input id="subcategory_description" type="text" name="subcategory_description" class="form-control" value="{{$subcategories->subcategory_description}}" placeholder="Enter First name" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Select Categry</label>
                            <select id="category_id" name="category_id" class="form-control">
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
               url: '/ofw_admin/catalog/subcategories/update',
               data: $("#form-subcategory").serialize(),
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
