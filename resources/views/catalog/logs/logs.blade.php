@extends('layouts.main')



@section('content')



  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0 text-dark">Case Summary</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="/home">Home</a></li>

              <li class="breadcrumb-item active">Case Summary</li>

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
                        <th ><strong> Date </strong></th>

                        <th ><strong> Reported By </strong></th>

                        <th ><strong> Assigned Department </strong></th>

                        <th ><strong> Case Type </strong></th>

                        <th class="text-center"><strong> Status </strong></th>

                        <th ><strong> Details </strong></th>

                    </tr>

                </thead>

                <tbody>

                    

                    @foreach($logs as $data)

                      <tr>

                          <td> {{ $data['created_at']->format('M d, Y') }} </td>

                          <td> {{ $data['username']}}  </td>

                          <td> {{ $data['agency']}}  </td>

                          <td> {{ $data['category'] }} </td>

                          <td> 
                          @switch($data['signature'])
                              @case('Open')
                                  <p class="bg-danger text-center"> {{ $data['signature'] }}</p>
                                  @break
                                  @case('Dispatched')
                                  <p class="bg-dark text-center"> {{ $data['signature'] }}</p>
                                  @break
                              @case('Closed')
                                  <p class="bg-dark text-center"> Dispatched</p>
                                  @break

                              @case('In Progress')
                                  <p class="bg-warning text-center"> Dispatched</p>
                                  @break
                              
                              @case('Cancelled')
                                  <p class="bg-secondary text-center"> {{ $data['signature'] }}</p>
                                  @break

                              @default
                              <p class="bg-danger text-center"> {{ $data['signature'] }}</p>
                          @endswitch
                           </td>

                          <td><a href="/catalog/logs/show/{{ $data['id'] }}" class="btn btn-success"><i class="fa fa-eye"></i></a> </td>

                    

                      </tr>

                    @endforeach

                </tbody>

              </table>       

                 

              {{ $logs->links() }} 

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

               url: '/gps_admin/catalog/logs/delete/'+id,

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

