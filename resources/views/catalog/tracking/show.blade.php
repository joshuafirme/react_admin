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
              <li class="breadcrumb-item"><a href="/catalog/tracking ">Tracking</a></li>
              <li class="breadcrumb-item active">Tracking Information</li>
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
                    <h3 class="card-title">{{ $tracking['order_number'] }} - {{ $tracking['name'] }}</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-tracking" role="form" _lpchecked="1">
                      @csrf
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Date</label>
                            <input id="date" type="date" required readonly  name="date" class="form-control" value="{{ date('Y-m-d',strtotime($tracking['date'])) }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Weight (Cost)</label>
                            <input id="weight_cost" type="text" required readonly  name="weight_cost" class="form-control" value="{{ $tracking['weight_cost'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Order Number</label>
                            <input id="order_number" type="text" required readonly  name="order_number" class="form-control" value="{{ $tracking['order_number'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Cost</label>
                            <input id="cost" type="text" required readonly  name="cost" class="form-control" value="{{ $tracking['cost'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Name</label>
                            <input id="name" type="text" required readonly  name="name" class="form-control" value="{{ $tracking['name'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Declared Value</label>
                            <input id="declared_value" type="text" required readonly  name="declared_value" value="{{ $tracking['declared_value'] }}" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Address</label>
                            <input id="address" type="text" required readonly  name="address" class="form-control" value="{{ $tracking['address'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Delivery Status</label>
                            <select id="delivery_status" name="delivery_status" class="form-control" autocomplete="off">
                              <option value="">Please select</option>
                              <option {{ $tracking['delivery_status'] == 'Dispatched from Main Warehouse' ? 'selected' : '' }} value="Dispatched from Main Warehouse">Dispatched from Main Warehouse</option>
                              <option {{ $tracking['delivery_status'] == 'In Transit' ? 'selected' : '' }}  value="In Transit">In Transit</option>
                              <option {{ $tracking['delivery_status'] == 'Delivered' ? 'selected' : '' }}  value="Delivered">Delivered</option>
                              <option {{ $tracking['delivery_status'] == 'Returned' ? 'selected' : '' }}  value="Delivered">Returned</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Phone Number</label>
                            <input id="phone_number" type="text"  readonly  name="phone_number" class="form-control" value="{{ $tracking['phone_number'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Delivery Date</label>
                            <input id="delivery_date" type="date" name="delivery_date" class="form-control" value="{{ date('Y-m-d',strtotime($tracking['delivery_date'])) }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Area</label>
                            <input id="area" type="text"  readonly  name="area" class="form-control" value="{{ $tracking['area'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Aging</label>
                            <input id="aging" type="text"  readonly  name="aging" class="form-control" value="{{ $tracking['aging'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Actual Weight</label>
                            <input id="actual_weight" type="text"  readonly  name="actual_weight" class="form-control" value="{{ $tracking['actual_weight'] }}" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Remarks</label>
                            <input id="remarks" type="text"  readonly  name="remarks" class="form-control" value="{{ $tracking['remarks'] }}" autocomplete="off">
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
