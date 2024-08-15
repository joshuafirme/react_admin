@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Status</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Update Status</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <script>
  
  var checkedArray = [];
  </script>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
               <div id="message"></div>
         
              
            <div class="table-responsive">
                <div id="error_message" class="alert alert-danger" style="display:none" role="alert"><i>Rows in red are invalid</i></div>
                <div id="success_message" class="alert alert-success" style="display:none" role="alert"></div>
                <form id="update_status">
                 
                <table class="table table-striped">
                <tbody class="data_loaded">
                </tbody>
                </table>
                <table id="update_table" class="table table-striped order-list">
                <thead>
                    <tr>
                        <th><strong>Order Number</strong></th>
                        <th><strong>Delivery Date</strong></th>
                        <th><strong> Action </strong></th>
                    </tr>
                </thead>
                <tbody class="load">
                    <tr class="add-row-new" style="display:none;">
                        <td></td>   
                        <td></td>   
                        <td><a href="#"  class="btn btn-primary add-row"><i class="fa fa-plus"></i></a></td>        
                    </tr>
                    <td id=""><input id="counter0" type="hidden" value="0" name="counter[]"><input id="order_number0" class="form-control" type="text" required name="order_number[]"></td><td><input id="delivery_date0" class="form-control" type="date" required name="delivery_date[]"></td><td><a href="#" class="btn btn-primary add-row"><i class="fa fa-plus"></i></a> <a href="#" class="btn btn-danger remove-row"> <i class="fa fa-minus "></i></a> </td>
                </tbody>
                </table>    
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 offset-lg-4 offset-md-4">
                        <a href="#" id="btndelivered" class="btn btn-warning btn-block">Delivered</i></a>
                    </div>
                </div>
                </form>
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

    //$('#update_table').append('<td><input type="text" name="order_number[]"></td><td><input type="text" name="delivery_date[]"></td><td><a href="#" class="btn btn-primary add-row"><i class="fa fa-plus"></i></a> <a href="#" class="btn btn-danger remove-row"> <i class="fa fa-minus "></i></a> </td>');
    var counter = 0;
    $("#update_table").on("click",".add-row", function () {
        counter = $('#update_table tr').length - 2;

        var newRow = $("<tr>");
        var cols = "";
        cols += '<td><input id="counter'+counter+'" type="hidden" value="'+counter+'" name="counter[]"><input id="order_number'+counter+'" class="form-control" type="text" required name="order_number[]"></td>';
        cols += '<td><input id="delivery_date'+counter+'" class="form-control" type="date" required name="delivery_date[]"></td>';
        cols += '<td><a href="#" class="btn btn-primary add-row"><i class="fa fa-plus"></i></a> <a href="#" class="btn btn-danger remove-row"> <i class="fa fa-minus "></i></a> </td>';
        newRow.append(cols);
        newRow.insertAfter($(this).parents().closest('tr'));
        counter++;
        
        console.log(counter)

        if(counter > 0){
            $(".add-row-new").hide()
        }
    });
    $("#update_table").on("click",".remove-row", function () {
            counter -= 1
            if(counter < 1){
                $(".add-row-new").show()
            }else{
                $(".add-row-new").hide()
            }
    });
    
    $("table.order-list").on("click", ".remove-row", function (event) {
        
        console.log(counter)
        $(this).closest("tr").remove();
      
    });

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $("#btndelivered").on('click',function(){
        var url = "/catalog/tracking/update_status_del";
        var postData = $('#update_status').serialize();
        console.log(postData)
        var dataType = 'json'; //whatever dataType you are expecting back




        //validations

        var reqlength = $('.form-control').length;
        console.log(reqlength);
        var value = $('.form-control').filter(function () {
            return this.value != '';
        });

        if (value.length>=0 && (value.length !== reqlength)) {
            $("#error_message").show();
            $("#error_message").html('<i>Please fill in all fields.</i>');
            setTimeout(() => {
                $("#error_message").fadeOut(); 
            $("#error_message").html('<i>Rows in red are invalid</i>');
            }, 3000);
            return false;
        }
    

        $.ajax({
            type: 'POST',
            url: "/catalog/tracking/update_status_del",
            data: postData,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, // here $(this) refers to the ajax object not form
            success: function (data) {
                if(data.error.length > 0){
                    $("#error_message").show();
                    setTimeout(() => {
                        $("#error_message").fadeOut(); 
                    }, 10000);
                    console.log(data.error.length)
                    data.error.forEach(function(val) {
                        $("#order_number"+val).css({'border':'red 1px solid'})
                    });
                    
                }

                if(data.success.length > 0){
                    $("#success_message").show();
                    setTimeout(() => {
                        $("#success_message").fadeOut(); 
                    }, 10000);
                    
                    data.success.forEach(function(val) {
                        $("#order_number"+val.counter).css({'border':'1px solid #ced4da'})
                        $("#success_message").append('<p>Order Number: '+val.order_number+' has been updated to Delivered.</p>')
                    });
                    
                }
            },
        });

    })

</script>

@endsection
