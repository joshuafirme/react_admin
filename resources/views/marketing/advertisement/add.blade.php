@extends('layouts.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="/flying_high/catalog/announcements">Advertisement</a></li>
              <li class="breadcrumb-item active">Add Advertisement</li>
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
                    <h3 class="card-title">Add Announcement</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form id="form-advertisement" role="form" _lpchecked="1">
                        @csrf
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Announcement Name</label>
                            <input id="ads_name" type="text" required name="ads_name" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Announcement Description</label>
                            <input id="ads_description" type="text" name="ads_description" class="form-control" autocomplete="off">
                          </div>
                         </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Announcement Email Address</label>
                            <input id="ads_email" type="text" name="ads_email" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Announcement URL</label>
                            <input id="ads_url" type="text" name="ads_url" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>Select Advertisement Type</label>
                            <select id="ads_type" name="ads_type" class="form-control">
                                <option value="1">Information</option>
                                <option value="2">Urgent</option>
                                <option value="3">Etc..</option>
                             
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Announcement Image</label>
                              <img id="image-attached" style="width: 100%;display:none;" alt="ads_img"/>
                              <input id="advertisement_id_attachment" type="hidden" name="advertisement_id_attachment" >
                            <input id="ads_img" type="file" enctype="multipart/form-data" name="ads_img" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-12">
                            <button id="btn-submit" type="submit" class="btn btn-success btn-lg float-right">Save</button>
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
               url: '/flying_high/catalog/announcements/store',
               data: $("#form-advertisement").serialize(),
               success:function(data){
                   console.log(JSON.parse(data))
                   var ret = JSON.parse(data);
                    
                   if(document.getElementById("ads_img").files.length != 0){
                        $('#advertisement_id_attachment').val(ret.id)
                        var attachmentForm =  new FormData();
                        var advertisement_id_attachment = $('#advertisement_id_attachment').val();
                        console.log(advertisement_id_attachment)
                        var ads_img = $('#ads_img')[0].files[0];
                        attachmentForm.append('advertisement_id_attachment', advertisement_id_attachment);
                        attachmentForm.append('ads_img', ads_img);
                        attachmentForm.append('_token', "{{ csrf_token() }}");
                        attachmentForm.append('_method', 'POST');
                        console.log(ads_img)

                        for (var key of attachmentForm.entries()) {
                            console.log(key[0] + ', ' + key[1]);
                        }

                        $.ajax({
                            type: 'POST',
                            url: '/flying_high/catalog/announcements/uploadAnnouncementFiles',
                            data:  attachmentForm,
                            dataType: "text",
                            mimeType: "multipart/form-data",
                            processData: false,
                            contentType: false,
                            async: false,
                            success: function(data) {
                                var imageAttached = JSON.parse(data)
                                console.log(imageAttached.ads_img);
                                $("#image-attached").attr('src',imageAttached.ads_img);
                                $("#image-attached").show()

                            },
                            error: function(err) {
                                console.log(err)
                            }
                        })
                       
                   }
                   
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
