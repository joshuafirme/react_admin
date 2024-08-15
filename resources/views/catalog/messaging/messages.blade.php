@extends('layouts.main')

@section('content')
<style>
.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write > textarea {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 95%;
  padding:10px;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}


/* loading */
.spanner{
  position:absolute;
  top: 50%;
  left: 0;
  background: #2a2a2a55;
  width: 100%;
  display:block;
  text-align:center;
  height: 300px;
  color: #FFF;
  transform: translateY(-50%);
  z-index: 1000;
  visibility: hidden;
}

.overlay{
  position: fixed;
	width: 100%;
  top:0;
	height: 100%;
  background: rgba(0,0,0,0.5);
  visibility: hidden;
}

.loader,
.loader:before,
.loader:after {
  border-radius: 50%;
  width: 2.5em;
  height: 2.5em;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  -webkit-animation: load7 1.8s infinite ease-in-out;
  animation: load7 1.8s infinite ease-in-out;
}
.loader {
  color: #ffffff;
  font-size: 10px;
  margin: 80px auto;
  position: relative;
  text-indent: -9999em;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}
.loader:before,
.loader:after {
  content: '';
  position: absolute;
  top: 0;
}
.loader:before {
  left: -3.5em;
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}
.loader:after {
  left: 3.5em;
}
@-webkit-keyframes load7 {
  0%,
  80%,
  100% {
    box-shadow: 0 2.5em 0 -1.3em;
  }
  40% {
    box-shadow: 0 2.5em 0 0;
  }
}
@keyframes load7 {
  0%,
  80%,
  100% {
    box-shadow: 0 2.5em 0 -1.3em;
  }
  40% {
    box-shadow: 0 2.5em 0 0;
  }
}

.show{
  visibility: visible;
}

.spanner, .overlay{
	opacity: 0;
	-webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	transition: all 0.3s;
}

.spanner.show, .overlay.show {
	opacity: 1
}
/* end loading */
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Messaging</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Messages</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="overlay"></div>
<div class="spanner">
  <div class="loader"></div>
  <p>Loading....</p>
</div>  
    <input type="hidden" class="selected_conversation">
    <div class="container">
      <div class="messaging">
            <div class="inbox_msg">
              <div class="inbox_people">
                <div class="headind_srch">
                  <div class="recent_heading">
                    <h4>Recent</h4>
                  </div>
                  <div class="srch_bar">
                    <div class="stylish-input-group">
                    <input id="last_load_id" type="hidden" name="last_load_id">
                      <input type="text" class="search-bar"  placeholder="Search" >
                      <span class="input-group-addon">
                      <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                      </span> </div>
                  </div>
                </div>
                <div class="inbox_chat">
                  <!-- <div class="chat_list active_chat">
                    <div class="chat_people">
                      <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                      <div class="chat_ib">
                        <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                        <p>Test, which is a new approach to have all solutions 
                          astrology under one roof.</p>
                      </div>
                    </div>
                  </div> -->
                  
                  @foreach($messages as $val)
                  <a href="javascript:void(0)" class="populateConversation" data-conversationid="{{$val['conversation_id']}}">
                    <div class="chat_list">
                      <div class="chat_people">
                        <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                        <div class="chat_ib chat_text-{{$val['conversation_id']}}">
                          <h5>{{ $val['username'] }} <span class="chat_date">{{ $val['updated_at'] }}</span></h5>
                          <p>{{ $val['message'] }}</p>
                        </div>
                      </div>
                    </div>
                  </a>
                  @endforeach
                 
                  <!-- <div class="chat_list">
                    <div class="chat_people">
                      <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                      <div class="chat_ib">
                        <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                        <p>Test, which is a new approach to have all solutions 
                          astrology under one roof.</p>
                      </div>
                    </div>
                  </div> -->
                </div>
              </div>
              <div class="mesgs">
                <div class="msg_history">
                  <!-- <div class="incoming_msg">
                    <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                    <div class="received_msg">
                      <div class="received_withd_msg">
                        <p>Test which is a new approach to have all
                          solutions</p>
                        <span class="time_date"> 11:01 AM    |    June 9</span></div>
                    </div>
                  </div>
                  <div class="outgoing_msg">
                    <div class="sent_msg">
                      <p>Test which is a new approach to have all
                        solutions</p>
                      <span class="time_date"> 11:01 AM    |    June 9</span> </div>
                  </div> -->
                </div>
                <div class="type_msg">
                  <div class="input_msg_write">
                    <textarea class="write_msg" placeholder="Type a message" ></textarea>
                    <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
            </div>
            
            
          </div></div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
    $(".populateConversation").click(function(e){
      $("div.spanner").addClass("show");
            $("div.overlay").addClass("show");
        e.preventDefault();
        
        var conversation_id = $(this).attr("data-conversationid")
        $('.selected_conversation').val(conversation_id);
                $('.msg_history').html('')
        updateConversation(conversation_id);
       
        setTimeout(function(){
          var messageBody = document.querySelector('body > div > div.content-wrapper > div.container > div > div > div.mesgs > div.msg_history');
          //messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
          document.querySelectorAll('.msg_history')[0].scrollTop = document.querySelectorAll('.msg_history')[0].scrollHeight;
          console.log('testing here!')
          $('.write_msg').removeAttr('disabled');
          $('.write_msg').css('cursor','auto');
          $('.msg_send_btn').removeAttr('disabled')
          $('.msg_send_btn').css('cursor','auto');
        },2000)    
    
    });

    $('.write_msg').attr('disabled','true');
    $('.write_msg').css('cursor','not-allowed');
    $('.msg_send_btn').attr('disabled','true')
    $('.msg_send_btn').css('cursor','not-allowed');


    $('.msg_history').on('scroll', function(e) {
          var scrollTop = $('.messages-content').scrollTop();
          if (scrollTop <= 0) {
              setTimeout(function(){
                $('.messages-content').scrollTop(30); 
                console.log($$('#last_load_id').val())
                updateConversation(conversation_id,$$('#last_load_id').val())
                app.dialog.progress();
              },3000)
            
          }
        });

    // load conversation here
    var setDate;
    var date;
    var m_names = new Array("January", "February", "March","April", "May", "June", "July", "August", "September","October", "November", "December");
    var d_names = new Array("Sunday", "Monday", "Tuesday","Wednesday", "Thursday", "Friday", "Saturday");
    var counDate;
    function updateConversation(conversation_id,last_id){
           
            var auth_id = "{{ Auth::user()->id }}"
            if(last_id != 0){
                
                  $.ajax({
                    type: 'POST',
                    url: '/catalog/messaging/getConversationById',
                    data: {"_token": "{{ csrf_token() }}",conversation_id:conversation_id,last_id:last_id},
                    success:function(data){
                      
                      var getData = JSON.parse(data);
                      console.log(getData)
                      getData.forEach(function(value, idx) {
                        console.log(value)
                        var formattedDate = new Date(value.created_at);
                        var d = formattedDate.getDate();
                        var day = formattedDate.getDay();
                        var m =  formattedDate.getMonth();
                        var curr_hour = formattedDate.getHours();
                        var curr_min = formattedDate.getMinutes();
                        var time = curr_hour + ':' + curr_min;
                        m += 1;  // JavaScript months are 0-11
                        var y = formattedDate.getFullYear();
                        setDate = d + "." + m + "." + y;

                        
                        if(auth_id == value.user_id_fk){

                                //$('.msg_history').prepend('<div class="message message-sent"><div class="message-avatar" style="background-image:url(https://cdn.framework7.io/placeholder/people-100x100-7.jpg);"></div><div class="message-content"><div class="message-name">John Doe</div><div class="message-header"></div><div class="message-bubble"><div class="messaxge-text">'+value.reply+'</div></div><div class="message-footer">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</div></div></div>')
                                $('.msg_history').prepend('<div class="outgoing_msg"><div class="sent_msg"><p>'+value.reply+'</p><span class="time_date">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</span> </div></div>')
                        }else{

                                // $('.msg_history').prepend('<div class="message message-received"><div class="message-avatar" style="background-image:url(https://cdn.framework7.io/placeholder/people-100x100-7.jpg);"></div><div class="message-content"><div class="message-name">John Doe</div><div class="message-header"></div><div class="message-bubble"><div class="message-text">'+value.reply+'</div></div><div class="message-footer">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</div></div></div>')  
                                $('.msg_history').prepend('<div class="incoming_msg"><div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="received_msg"><div class="received_withd_msg"><p>'+value.reply+'</p><span class="time_date">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</span></div></div></div>')
                        }
                           
                        // if(date == setDate){
                        //     if(countDate == 0){
                        //        $('.msg_history').prepend('<div class="messages-title"><b>'+d_names[day]+','+ m_names[m-1] +'</b> ' + d+', '+time+'</div>')
                        //         countDate = 1
                        //     }
                        // }else{
                        //     date = setDate
                        //     countDate = 0
                        // }
                          
                        convo_last_id = value.conversation_id
                        $('#last_load_id').val(convo_last_id)
                      });  
                      console.log(getData)
                    }
                  });    

               
            }else{
              $.ajax({
                type: 'POST',
                    data: {conversation_id:conversation_id,last_id:last_id},
                    url:'/catalog/messaging/getConversationById',
                    success: function(data) {
                        app.dialog.close();
                        var getData = JSON.parse(data);
                        console.log(getData)
                        getData.forEach(function(value, idx) {
                          var formattedDate = new Date(value.created_at);
                          var d = formattedDate.getDate();
                          var day = formattedDate.getDay();
                          var m =  formattedDate.getMonth();
                          var curr_hour = formattedDate.getHours();
                          var curr_min = formattedDate.getMinutes();
                          var time = curr_hour + ':' + curr_min;
                          m += 1;  // JavaScript months are 0-11
                          var y = formattedDate.getFullYear();
                          setDate = d + "." + m + "." + y;

                          if(auth_id == value.user_id_fk){

                                //  $('.messages').prepend('<div class="message message-sent"><div class="message-avatar" style="background-image:url(https://cdn.framework7.io/placeholder/people-100x100-7.jpg);"></div><div class="message-content"><div class="message-name">John Doe</div><div class="message-header"></div><div class="message-bubble"><div class="messaxge-text">'+value.reply+'</div></div><div class="message-footer">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</div></div></div>')
                                 $('.msg_history').prepend('<div class="outgoing_msg"><div class="sent_msg"><p>'+value.reply+'</p><span class="time_date">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</span> </div></div>')
                          }else{

                                //  $('.messages').prepend('<div class="message message-received"><div class="message-avatar" style="background-image:url(https://cdn.framework7.io/placeholder/people-100x100-7.jpg);"></div><div class="message-content"><div class="message-name">John Doe</div><div class="message-header"></div><div class="message-bubble"><div class="message-text">'+value.reply+'</div></div><div class="message-footer">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</div></div></div>')  
                                $('.msg_history').prepend('<div class="incoming_msg"><div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="received_msg"><div class="received_withd_msg"><p>'+value.reply+'</p><span class="time_date">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</span></div></div></div>')
                          }
                            
                          // if(date == setDate){
                          //     if(countDate == 0){
                          //         $('.messages').prepend('<div class="messages-title"><b>'+d_names[day]+','+ m_names[m-1] +'</b> ' + d+', '+time+'</div>')
                          //         countDate = 1
                          //     }
                          // }else{
                          //    date = setDate
                          //    countDate = 0
                          // }
                            
                          convo_last_id = value.conversation_id
                          $('#last_load_id').val(convo_last_id)
                          console.log(convo_last_id)  
                        });  
                       console.log(getData)
                    },
                    error: function(err) {
                        console.log(err)
                    }
                }) 
            }
            
            console.log($('#last_load_id').val())
            $("div.spanner").removeClass("show");
            $("div.overlay").removeClass("show");
        }


  $('.msg_send_btn').on('click',function(){
    var auth_id = "{{ Auth::user()->id }}"
    var conversation_id = $(".selected_conversation").val();
    var message = $('.write_msg').val();
    var formattedDate = new Date();
    var d = formattedDate.getDate();
    var day = formattedDate.getDay();
    var m =  formattedDate.getMonth();
    var curr_hour = formattedDate.getHours();
    var curr_min = formattedDate.getMinutes();
    var time = curr_hour + ':' + curr_min;
    m += 1;  // JavaScript months are 0-11
    var y = formattedDate.getFullYear();
    setDate = d + "." + m + "." + y;

    $('.msg_history').append('<div class="outgoing_msg"><div class="sent_msg"><p>'+message+'</p><span class="time_date">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</span> </div></div>')
  
    var messageBody = document.querySelector('.msg_history');
    messageBody.scrollTop = messageBody.scrollHeight;
    document.querySelectorAll('.msg_history')[0].scrollTop = document.querySelectorAll('.msg_history')[0].scrollHeight;
    $.ajax({
        type: 'POST',
        data: {"_token": "{{ csrf_token() }}",auth_id:auth_id,conversation_id:conversation_id,message:message},
        url: '/catalog/messaging/addReply',
        success: function(data) {
            var getData = JSON.parse(data);

           console.log(getData)
        },
        error: function(err) {
            console.log(err)
        }
    })  
  })

  //Remember to replace key and cluster with your credentials.
  var pusher = new Pusher('727ae9a0b76b78743c14', {
      cluster: 'ap1',
      encrypted: true
  });
  //Also remember to change channel and event name if your's are different.
  var channel = pusher.subscribe('reply-sent');
        channel.bind('reply-sent-event', function(data) {
            var ret = JSON.parse(data);
            var auth_id = "{{ Auth::user()->id }}"
            var conversation_id = $(".selected_conversation").val();
            console.log(ret);
            if(ret.sent_to == auth_id){
               
                if(conversation_id == ret.conversation_id){
                    var formattedDate = new Date();
                    var d = formattedDate.getDate();
                    var day = formattedDate.getDay();
                    var m =  formattedDate.getMonth();
                    var curr_hour = formattedDate.getHours();
                    var curr_min = formattedDate.getMinutes();
                    var time = curr_hour + ':' + curr_min;  
                    var y = formattedDate.getFullYear();

                    $('.msg_history').append('<div class="incoming_msg"><div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="received_msg"><div class="received_withd_msg"><p>'+ret.message+'</p><span class="time_date">'+d_names[day]+','+ m_names[m-1] +' ' + d+', '+time+'</span></div></div></div>')
                    
                    var height = 0;
                    $('.msg_history > div > div > div > p').each(function(i, value){
                        height += parseInt($(this).height());
                    });
                    document.querySelectorAll('.msg_history')[0].scrollTop = document.querySelectorAll('.msg_history')[0].scrollHeight;
                }
               
            }
           
        });


        $(".search-bar").on('keyup', function(){
          var matcher = new RegExp($(this).val(), 'gi');
          $('.chat_list').show().not(function(){
              return matcher.test($(this).find('h5').text())
          }).hide();
        });
</script>


@endsection
