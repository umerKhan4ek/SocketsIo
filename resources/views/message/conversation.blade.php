@extends('layouts.app')

@section('content')
    <div class="row chat-row">
        <div class="col-md-3">
            <div class="users">
                <h5>Users</h5>

                <ul class="list-group list-chat-item">
                    @if($users->count())
                        @foreach ($users as $user)

                            <li class="chat-user-list"  @if($user->id == $friendInfo->id) active @endif >
                                <a href="{{route('message.conversation',$user->id)}}">
                                    
                                    <div class="chat-image">
                                        {!!  makeImageForname($user->name) !!}
                                        <i class="fa fa-circle user-status-icon user-icon-{{$user->id}}" title="away"></i>

                                    </div>
                                    
                                    {{$user->name}}</a>
                            </li>
                            
                        @endforeach
                    @endif
                </ul>
            </div>

        </div>
        <div class="col-md-9 chat-section">
            <div class="chat-header">

                <div class="chat-image">
                    {!!  makeImageForname($user->name) !!}
                </div>

                <div class="chat-name font-weight-bold">
                    {{$user->name}}
                    <i class="fa fa-circle user-status-head" title="away" 
                    id= "userStatusHead{{$friendInfo->id}}"></i>

                </div>

            </div>
            <div class="chat-body" id="chatBody">
                <div class="message-listing" id="messageWrapper">
                    <div class="row message align-items-center mb-2">
                        <div class="col-md-12 user-info">
                            <div class="chat-image">
                                {!! makeImageForname('Umer') !!}
                            </div>

                            <div class="chat-name font-weight-bold">
                                Umer
                                <span class="small time">
                                    10:30 PM
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 message-content">
                            <div class="message-text">
                                Message Here
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat-box">
                <div class="chat-input bg-white" id="chatInput" contenteditable="">

                </div>

                <div class="chat-input-toolbar">    
                    <button title="Add File" class="btn btn-light btn-sm btn-file-upload">
                        <i class="fa fa-paperclip"></i>

                    </button>

                    <button title="Bold" class="btn btn-light btn-sm tool-items"
                    onclick="document.execCommand('bold' ,false, '')">
                        <i class="fa fa-bold tool-icon"></i>
                    </button>
                    <button title="Italic" class="btn btn-light btn-sm tool-items" 
                    onclick="document.execCommand('italic',false,'')" >
                        <i class="fa fa-italic tool-icon"></i>

                    </button>

           

                </div>

            </div>
             
        </div>
    </div>
@endsection


@section('scripts')


<script>
    $(function(){
        // var socket = io();

        let $chatInput =  $('.chat-input');
        let $chatInputtoolbar = $('.chat-inpu-toolbar');
        let $chatBody = $('.chat-body');

        let user_id = "{{ auth()->user()->id }}";
        var ip_address = '127.0.0.1';
        var socket_port = '7005';
        var socket = io(ip_address + ':' + socket_port);
        let friendId = " {{  $friendInfo->id }}  ";

        // alert(socket);
        // alert(user_id);
        socket.on('connect',function(){
            // alert('hello'); 
            socket.emit('user_connected',user_id);
        });


        socket.on('updateUserStatus',(data)=>{

            // alert(data);
            $.each(data, function(key,val)
            {
                let $userIcon= $('.user-status-icon');
                $userIcon.removeClass('text-success');
                $userIcon.attr('title','Away');

                // console.log(key,val);

                if(val!== 0 && val!==null)
                {
                    // console.log(key,val);
                    let userIcon = $('.user-icon-'+key);
                    // console.log(userIcon);
                    userIcon.addClass('text-success');
                    userIcon.attr('title','Online');
                }
            })
        });

        $chatInput.keypress(function(e)
        {
            let message = $(this).html();
            if(e.which===13 )
            {
                $chatInput.html('');
                sendMessage(message);
                return false;
            }
        });

        function sendMessage(message)
        {
            let url = "{{ route('message.send-message') }}";
                let form = $(this);
                let formData = new FormData();
                let token = "{{ csrf_token() }}";
                formData.append('message', message);
                formData.append('_token', token);
                formData.append('receiver_id', friendId);

            // console.log(token);

            $.ajax({
                   url: url,
                   type: 'POST',
                   data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                   success: function (response) {
                       if (response.success) {
                           console.log(response.data);
                       }
                   }
                });




        }


        

    })
            
         
</script>
    
@endsection