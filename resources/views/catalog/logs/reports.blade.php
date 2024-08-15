@extends('layouts.main')



@section('content')

<!--     <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>



<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>





    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0 text-dark">Log Details</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="/catalog/logs ">Back</a></li>

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

            <div class="col-xl-6 col-md-6">

            <a class="btn btn-warning" href="/catalog/reports/exportReportFile" target="_blank">Export CSV</a>

            </div>

        </div>

        <div class="row">



            <div class="col-md-6">

                <div class="form-group">

                <label for="name" class="col-sm-12 control-label">Department</label>

                <div class="col-sm-12">

                    <select class="form-control department_filter" id="department_filter">

                        <option>Please select department</option>

                        @foreach($agencies as $u)

                        <option value="{{ $u->id }}">{{ $u->agency_name }}</option>

                        @endforeach

                    </select>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-group">

                    <label for="name" class="col-sm-12 control-label">*From</label>

                    <div class="col-sm-12">

                        <input id="from" class="form-control" type="date" name="from">

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-group">

                <label for="name" class="col-sm-12 control-label">To</label>

                    <div class="col-sm-12">

                        <input id="to" class="form-control" type="date" name="to">

                    </div>

                </div>

            </div>

            </div>

            



            <div class="table table-responsive">

            <table class="table table-bordered data-table">

                <thead>

                    <tr>

                        <th>Incident Number</th>

                        <th>Date</th>

                        <th>Reported by</th>

                        <th>Assigned Departments</th>

                        <th>Status</th>

                        <th>View</th>

                    </tr>

                </thead>

                <tbody>

                </tbody>

            </table>

            </div>

      </div><!-- /.container-fluid -->

    </div>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->



    <!-- Modal -->

<div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Signature</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <img id="signatureImg" style="width:100%;">

      </div>

    </div>

  </div>

</div>

<script>

setTimeout(function(){

  $('#DataTables_Table_0_filter > label').hide();

},1000)



var table = $('.data-table').DataTable({

    "processing": true,

    "serverSide": true,

    "ajax":{

                "url": "{{ url('getReports') }}",

                "dataType": "json",

                "type": "POST",

                "data":{ _token: "{{csrf_token()}}"}

            },

    "columns": [

        {"data": 'incident_number'},

        {"data": 'date'},

        {"data": 'reported_by'},

        {"data": 'assigned_department'},

        {"data": 'status'},

        {"data": 'view'}

    ],





});



$('#department_filter').on('change', function(){

  

    var datefilter = "created_at|";



    var username = this.value;

    var from = $('#from').val();

    var to = $('#to').val();

    if(username == "Please select username"){

        username = ""

    }

    

    if(from != "" && to != ""){

        datefilter += from + " | " + to 

        if(username == ""){

            table.search(datefilter).draw();   

        }else{

            table.search(datefilter + "|"+ username).draw();   

        }     

    }else{

        table.search(username).draw(); 

    }

});



$('#from').on('change', function(){

    var datefilter = "created_at|";

    var username = $('#username_filter').val();

    var from = $('#from').val();

    var to = $('#to').val();

   

    if(from != "" && to != ""){

        datefilter += from + " | " + to 

        if(username != ""){

            table.search(datefilter + "|"+ username).draw();   

        }else{

            table.search(datefilter).draw();   

        }     

    }else{

        table.search(username).draw(); 

    }

    

});



$('#to').on('change', function(){

    var datefilter = "created_at|";

    var username = $('#username_filter').val();

    var from = $('#from').val();

    var to = $('#to').val();

    if(from != "" && to != ""){

        datefilter += from + " | " + to 

        if(username != ""){

            table.search(datefilter + "|"+ username).draw();   

        }else{

            table.search(datefilter).draw();   

        }     

    }else{

        table.search(username).draw(); 

//        alert('Please fill in from and to date')

    }  

});




// $("#export-csv").on('click',function(e){

//   e.preventDefault();



//   var username = $('#username_filter').val();

//   var from = $('#from').val();

//   var to = $('#to').val();

//   $.ajax({

//     type: 'POST',

//     url: '/catalog/reports/exportReportFile',

//     data: { _token: "{{csrf_token()}}",from:from,to:to,username:username},

//     success:function(data){

      

//       console.log('data testing')       

        

//     }

//   });

// })



</script>

@endsection

