@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tracking</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Tracking</li>
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
         
               <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group mb-2 float-right">
                        <button onclick="location.href='/catalog/tracking/add'" type="submit" class="btn btn-success mb-2">Add new</button>
                        <a id="exportperridercsv" href="/catalog/tracking/report/exportTrackingPerRider?user_id=1" class="btn btn-success mb-2">EXPORT CSV</a>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group mb-2">
                        <label>Username</label>
                        <select class="form-control" id="username">
                          @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <button id="assign_user" type="submit" class="btn btn-primary mb-2" style="margin-top: 32px;">Assign</button>
                    </div>
                    <div class="col-lg-2">
                      <button id="delete_this_data" type="submit" class="btn btn-danger mb-2" style="margin-top: 32px;">Delete</button>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group mb-2">
                        <label>From:</label>
                        <input type="date" class="form-control" name="date_from" id="date_from">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group mb-2">
                        <label>To:</label>
                        <input type="date" class="form-control" name="date_to" id="date_to">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group mb-2">
                        <label>Search</label>
                        <input type="text" class="form-control" name="serach" placeholder="Order Number" id="serach">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group mb-2">
                        <label>From:</label>
                        <input type="date" class="form-control" name="date_from_update" id="date_from_update">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group mb-2">
                        <label>To:</label>
                        <input type="date" class="form-control" name="date_to_update" id="date_to_update">
                      </div>
                    </div>
                    <div class="col-lg-2">
                          <div class="form-group">
                            <label>Delivery Status</label>
                            <select id="delivery_status_update"    name="delivery_status_update" class="form-control" autocomplete="off">
                              <option value="">Please select</option>
                              <option value="Dispatched from Main Warehouse">Dispatched from Main Warehouse</option>
                              <option value="In Transit">In Transit</option>
                              <option value="Delivered">Delivered</option>
                              <option value="Returned">Returned</option>
                            </select>
                          </div>
                        </div>
                    <div class="col-lg-2">
                      <button id="update_status" type="submit" class="btn btn-primary mb-2" style="margin-top: 32px;">Update Status</button>
                    </div>
                  </div>
                <div class="table-responsive">
                <table class="table table-striped">
                <tbody class="data_loaded">
                </tbody>
                </table>
                <table  class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="created_at" style="cursor: pointer"><strong>Date <span id="id_icon"></span></strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="order_number" style="cursor: pointer"><strong> Order Number </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer"><strong> Name </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="address" style="cursor: pointer"><strong> Address </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="phone_number" style="cursor: pointer"><strong> Phone </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="area" style="cursor: pointer"><strong> Area </strong></th>
                        <th class="sorting" data-sorting_type="asc" ><strong> Actual Wgt. </strong></th>
                        <th class="sorting" data-sorting_type="asc" ><strong> Weight(Cost) </strong></th>
                        <th class="sorting" data-sorting_type="asc"><strong> Cost </strong></th>
                        <th class="sorting" ><strong> Declared Value </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="delivery_status" style="cursor: pointer"><strong> Delivery Status </strong></th>
                        <th class="sorting" ><strong> Aging </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="username" style="cursor: pointer"><strong> Rider </strong></th>
                        <th class="sorting" ><strong> Remarks </strong></th>
                        <th ><strong> Action </strong></th>
                    </tr>
                </thead>
                
                <tbody class="load">
                  @include('catalog.tracking.pagination_data')
                </tbody>
                </table>    
                </div>
                <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
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
    // $(".delete-it").click(function(e){

    //     e.preventDefault();
    //     var id = $(this).attr("data-id")
    //     console.log(id)
    //     if(confirm("Are you sure, you want to delete it?")){
    //         $.ajax({
    //            type: 'GET',
    //            url: '/gps_admin/catalog/logs/delete/'+id,
    //            success:function(data){
    //                console.log(JSON.parse(data))
                   
    //                var ret = JSON.parse(data);
    //                $.each( ret, function( key, value ) {
    //                   console.log( key + ": " + value );

    //                    if( key== "message"){
    //                        setTimeout(function(){
    //                            location.reload(true);
    //                        },1000)
    //                        $("#"+key).html('<div class="alert alert-success"><i class="fa fa-check"></i> '+value+'</div>').delay(1000).fadeOut('slow')
    //                        return false;
    //                    }

    //                });
    //            }
    //         });    
    //     }
        
    // });

    $(document).ready(function(){


    function clear_icon(){
      $('#id_icon').html('');
      $('#post_title_icon').html('');
    }

    function fetch_data(page, sort_type, sort_by, query){
      $.ajax({
        url:"/catalog/tracking/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query,
        success:function(data)
        {
        $('tbody.load').html('');
        $('tbody.load').html(data);
        
        }
      })
    }

    function update_data(value,data,type){
      $.ajax({
        url:"/catalog/tracking/update_data?value="+value+"&data="+data+"&type="+type,
        success:function(data)
        {
          var query = $('#serach').val();
          var column_name = $('#hidden_column_name').val();
          var sort_type = $('#hidden_sort_type').val();
          var page = $('#hidden_page').val();
            $('#message').show();
          $('#message').html(data)
          setTimeout(function(){
            $('#message').fadeOut();
          },5000)
          fetch_data(page, sort_type, column_name, query);
        
        }
      })
    }

    $(document).on('keyup', '#serach', function(){
        var query = $('#serach').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = $('#hidden_page').val();
        fetch_data(page, sort_type, column_name, query);
    });

    $(document).on('click', ".data_id", function(event){
      
        var n = checkedArray.includes($(this).val());
        const index = checkedArray.indexOf($(this).val());

        if(n){
          
          if (index > -1) {
            console.log(index)
            checkedArray.splice(index, 1);
          }
          $(".tr_"+$(this).val()).prependTo('.load');
        }else{
          checkedArray.push($(this).val());
          $(".tr_"+$(this).val()).prependTo('.data_loaded');
          
        }
        

        console.log(checkedArray)
    });
    
    $(document).on('click', '#assign_user', function(event){
        event.preventDefault();
  
        var data = $('#username option:selected').val();
        var checked = $("input[name='id[]']:checked");
        var usedata = checked;
        if(checkedArray.length > 0){
          usedata = checkedArray;
        }
        console.log(usedata)
        $.each(usedata, function(x,y){
          console.log(y)
          update_data(y,data,"assign");
        });
        checkedArray = [];
        $('tbody.data_loaded').html('')
    });

    $(document).on('click','#delete_this_data',function(event){
      event.preventDefault();
      if(confirm("Are you sure, you want to delete these data?")){
        var checked = $("input[name='id[]']:checked");
        var usedata = checked;
        if(checkedArray.length > 0){
          usedata = checkedArray;
        }
        console.log(usedata)
        $.each(usedata, function(x,y){
          console.log(y)
          update_data(y,"0","delete");
        });
        checkedArray = [];
        $('tbody.data_loaded').html('')
      }
    })

    $(document).on('click', '#update_status', function(event){
        event.preventDefault();
  
        var delivery_status_update = $('#delivery_status_update option:selected').val();
        var date_from_update = $('#date_from_update').val();
        var date_to_update = $('#date_to_update').val();
        console.log(delivery_status_update)
        console.log(date_to_update)
        console.log(date_from_update)
        if(delivery_status_update && date_to_update && date_from_update){
          $.ajax({
            url:"/catalog/tracking/update_status?delivery_status_update="+delivery_status_update+"&date_from_update="+date_from_update+"&date_to_update="+date_to_update,
            success:function(data)
            {
              var query = $('#serach').val();
              var column_name = $('#hidden_column_name').val();
              var sort_type = $('#hidden_sort_type').val();
              var page = $('#hidden_page').val();
                $('#message').show();
              $('#message').html(data)
              setTimeout(function(){
                $('#message').fadeOut();
              },5000)
              fetch_data(page, sort_type, column_name, query);
            
            }
          })
          
        }

        if(username && date_from != '' && date_to != ''){
          $("#exportperridercsv").attr('href','/catalog/tracking/report/exportTrackingPerRider?user_id='+username+'&date_from='+date_from+'&date_to='+date_to)
        }
    });

    $(document).on('change', '#username,#date_from,#date_to', function(){
        var username = $('#username option:selected').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        console.log(username)
        console.log(date_to)
        console.log(date_from)
        if(username && date_from == '' && date_to == ''){
          $("#exportperridercsv").attr('href','/catalog/tracking/report/exportTrackingPerRider?user_id='+username)
          
        }

        if(username && date_from != '' && date_to != ''){
          $("#exportperridercsv").attr('href','/catalog/tracking/report/exportTrackingPerRider?user_id='+username+'&date_from='+date_from+'&date_to='+date_to)
        }
        
    });

    $(document).on('click', '.sorting', function(){
        var column_name = $(this).data('column_name');
        var order_type = $(this).data('sorting_type');
        var reverse_order = '';
        if(order_type == 'asc')
        {
          $(this).data('sorting_type', 'desc');
          reverse_order = 'desc';
          clear_icon();
          $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
        }
        if(order_type == 'desc')
        {
          $(this).data('sorting_type', 'asc');
          reverse_order = 'asc';
          clear_icon
          $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
        }
        $('#hidden_column_name').val(column_name);
        $('#hidden_sort_type').val(reverse_order);
        var page = $('#hidden_page').val();
        var query = $('#serach').val();
        fetch_data(page, reverse_order, column_name, query);
    });

    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        console.log(page);
        $('#hidden_page').val(page);
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();

        var query = $('#serach').val();

        $('li').removeClass('active');
              $(this).parent().addClass('active');
        fetch_data(page, sort_type, column_name, query);
    });

    $('body > div > div.content-wrapper > div.content > div > div > div > ul > li:nth-child(1) > span').remove();
    $('body > div > div.content-wrapper > div.content > div > div > div > ul > li.page-item.active > span').before('<a class="page-link" href=/catalog/tracking?page=1>1</a>')
    $('body > div > div.content-wrapper > div.content > div > div > div > ul > li.page-item.active > span').hide();
    });
</script>

@endsection
