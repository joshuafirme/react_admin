@extends('layouts.main')



@section('content')



  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0 text-dark">Roles</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="/home">Home</a></li>

              <li class="breadcrumb-item active">Roles</li>

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

                   <a href="/catalog/roles/add" title="Add role"><button type="submit" class="btn btn-block btn-success"><i class="fa fa-plus"></i></button></a>

                </div>

                <br><br>

              <table id="data" class="table table-striped">

                <thead>

                    <tr>

                        <th ><strong> Name </strong></th>

                        <th ><strong> Description </strong></th>

                        <th ><strong> Action </strong></th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($roles as $data)

                      <tr>

                          <td> {{ $data->role_name }} </td>

                          <td> {{ $data->role_description }}  </td>

                          <td>

                              <a href="/catalog/roles/show/{{ $data->id }}" class="btn btn-success"><i class="fa fa-eye"></i></a>

                              <a href="/catalog/roles/edit/{{ $data->id }}" class="btn btn-primary"><i class="fa fa-pen"></i></a> <a href="#" data-id="{{ $data->id }}" class="btn btn-danger delete-it"><i class="fa fa-trash"></i></a> </td>

                      </tr>

                    @endforeach

                </tbody>

              </table>       

                 

              {{ $roles->links() }} 

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

               url: '/catalog/roles/delete/'+id,

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

</script>



@endsection

