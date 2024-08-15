<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trace your package</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #b45812;
                color: #fff;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                width:80%;
            }

            .title {
                font-size: 20px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
      
            
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="message"></div>
                                <!-- <label for="exampleFormControlTextarea1">Trace your Package</label> -->
                                <input type="text" required class="form-control text-center" id="order_number" placeholder="Track your package (please enter order number)">
                            </div>
                            <div class="form-group">
                                <button id="btn-getorder" type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                    
            <div class="table-responsive">
                <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th class="sorting" data-sorting_type="asc" data-column_name="updated_at"><strong>Date <span id="id_icon"></span></strong></th>
                            <!-- <th class="sorting" data-sorting_type="asc" data-column_name="order_number"><strong> Order Number </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="name"><strong> Name </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="address"><strong> Address </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="phone_number"><strong> Phone </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="area"><strong> Area </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="actual_weight"><strong> Actual Wgt. </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="weight_cost"><strong> Weight(Cost) </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="cost"><strong> Cost </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="declared_value"><strong> Declared Value </strong></th> -->
                            <th class="sorting" data-sorting_type="asc" data-column_name="delivery_status"><strong> Delivery Status </strong></th>
                            <!-- <th class="sorting" data-sorting_type="asc" data-column_name="delivery_status"><strong> Delivery Date </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="aging"><strong> Aging </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="username"><strong> Rider </strong></th>
                            <th class="sorting" data-sorting_type="asc" data-column_name="remark"><strong> Remarks </strong></th> -->
                        </tr>
                    </thead>
                    <tbody>
                            @include('catalog.tracking.getsearchdata')
                    </tbody>
                </table>    
            </div>
            </div>
             
        </div>
    </body>
    <script>
        $('#btn-getorder').on('click',function(){
            var ordernumber = $('#order_number').val();
            if(ordernumber == ''){
                $("#message").show();
                $('#message').html('<div class="alert alert-danger" role="alert">Please enter your order number.</div>')
                
                return false;
            }
            $.ajax({
                url:"/catalog/tracking/getsearchdata?query="+ordernumber,
                success:function(data)
                {
                    if(data){
                        $('tbody').html('');
                        $('tbody').html(data);
                    }else{
                        $("#message").show();
                        $('tbody').html('');
                        $('#message').html('<div class="alert alert-danger" role="alert">Order not yet received by Flying High</div>')
                       
                        return false;
                    }
                    
                    
                },
                error:function(err){
                    console.log(err)
                $("#message").show();
                $('tbody').html('');
                    $('#message').html('<div class="alert alert-danger" role="alert">Order not yet received by Flying High</div>')
                   
                    return false;
                }
            })
        })
    </script>
</html>

