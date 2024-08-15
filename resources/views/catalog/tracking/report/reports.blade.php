@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tracking Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Reports</li>
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
         
               <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group mb-2">
                        
                        <a id="exportcsv" href="/catalog/tracking/report/exportTracking?user_id=1" class="btn btn-success mb-2">EXPORT CSV</a>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
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
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group mb-2">
                        <label>From:</label>
                        <input type="date" class="form-control" name="date_from" id="date_from">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group mb-2">
                        <label>To:</label>
                        <input type="date" class="form-control" name="date_to" id="date_to">
                      </div>
                    </div>
                  </div>
                <div class="table-responsive">
                <table  class="table table-striped">
                <thead>
                    <tr>
                        <th class="sorting" data-sorting_type="asc" data-column_name="created_at" style="cursor: pointer"><strong>Date <span id="id_icon"></span></strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="order_number" style="cursor: pointer"><strong> Order Number </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer"><strong> Name </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="address" style="cursor: pointer"><strong> Address </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="phone_number" style="cursor: pointer"><strong> Phone </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="area" style="cursor: pointer"><strong> Area </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="actual_weight" style="cursor: pointer"><strong> Actual Wgt. </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="weight_cost" style="cursor: pointer"><strong> Weight(Cost) </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="cost" style="cursor: pointer"><strong> Cost </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="declared_value" style="cursor: pointer"><strong> Declared Value </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="delivery_status" style="cursor: pointer"><strong> Delivery Status </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="aging" style="cursor: pointer"><strong> Aging </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="username" style="cursor: pointer"><strong> Rider </strong></th>
                        <th class="sorting" data-sorting_type="asc" data-column_name="remark" style="cursor: pointer"><strong> Remarks </strong></th>
                    </tr>
                </thead>
                <tbody>
                  @include('catalog.tracking.report.pagination_data')
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
   

    $(document).ready(function(){

    function clear_icon(){
      $('#id_icon').html('');
      $('#post_title_icon').html('');
    }

    function fetch_data(page, sort_type, sort_by, query){
      $.ajax({
        url:"/catalog/tracking/report/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query,
        success:function(data)
        {
        $('tbody').html('');
        $('tbody').html(data);
        
        }
      })
    }

    // function exportData(user_id,date_from,date_to){
    //   $.ajax({
    //     url:"/catalog/tracking/report/exportTracking?user_id="+user_id+"&date_from="+date_from+"&date_to="+date_to,
    //     success:function(data)
    //     {
        
    //     }
    //   })
    // }

    
    $(document).on('change', '#username,#date_from,#date_to', function(){
        var username = $('#username option:selected').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        console.log(username)
        console.log(date_to)
        console.log(date_from)
        if(username && date_from == '' && date_to == ''){
          $("#exportcsv").attr('href','/catalog/tracking/report/exportTracking?user_id='+username)
        }

        if(username && date_from != '' && date_to != ''){
          $("#exportcsv").attr('href','/catalog/tracking/report/exportTracking?user_id='+username+'&date_from='+date_from+'&date_to='+date_to)
        }
        
    });

    $(document).on('keyup', '#serach', function(){
        var query = $('#serach').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = $('#hidden_page').val();
        fetch_data(page, sort_type, column_name, query);
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
