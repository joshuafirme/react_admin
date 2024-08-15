@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Incidents</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Incidents</li>
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
<!--                   <a href="/catalog/subcategories/add" title="Add Sub-categories"><button type="submit" class="btn btn-block btn-success"><i class="fa fa-plus"></i></button></a>-->
                </div>
                <br><br>
              <table id="data" class="table table-striped">
                <thead>
                    <tr>
                        <th ><strong> Full Name </strong></th>
                        <th ><strong> Case No </strong></th>
                        <th ><strong> Incident Description </strong></th>
                        <th ><strong> Case Type </strong></th>
                        <th ><strong> Case Status </strong></th>
                        <th ><strong> Action </strong></th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($incidents as $data)
                      <tr>
                          <td> {{ $data['firstname']}}  {{ $data['middlename']}}  {{ $data['lastname']}}  </td>
                          <td> {{ $data['case_no']}}  </td>
                          <td> {{ $data['incident_description'] }} </td>
                          <td> {{ $data['category_name'] }} > {{ $data['subcategory_name'] }} </td>
                          <td> {{ $data['incident_status'] }} </td>
                          @if(isAdmin() || isSuperAdmin())
                          <td> <a href="/ofw_admin/catalog/incidents/show/{{ $data['id'] }}" class="btn btn-success"><i class="fa fa-eye"></i></a> <a href="/ofw_admin/catalog/incidents/edit/{{ $data['id'] }}" class="btn btn-primary"><i class="fa fa-pen"></i></a> <a href="#" data-id="{{ $data['id'] }}" class="btn btn-danger delete-it"><i class="fa fa-trash"></i></a> </td>
                          @endif
                      </tr>
                    @endforeach
                </tbody>
              </table>       
                 
              {{ $incidents->links() }} 
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
    $(".delete-it").click(function(e){

        e.preventDefault();
        var id = $(this).attr("data-id")
        console.log(id)
        if(confirm("Are you sure, you want to delete it?")){
            $.ajax({
               type: 'GET',
               url: '/ofw_admin/catalog/incidents/delete/'+id,
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
