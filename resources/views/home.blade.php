@extends('layouts.app')

@section('content')
    <div class="row chat-row">
        <div class="col-md-3">
            <div class="users">
                <h5>Users</h5>

                <ul class="list-group list-chat-item">
                    @if($users->count())
                        @foreach ($users as $user)

                            <li class="chat-user-list" >
                                <a href="{{route('message.conversation',$user->id)}}">
                                    
                                    <div class="chat-image">
                                        {!!  makeImageForname($user->name) !!}
                                        <i class="fa fa-circle user-status-icon user-icon-{{$user->id}}" title="away"></i>

                                    </div>
                                    <div class="chat-name font-weight-bold">

                                        {{$user->name}}</a>
                                    </div>
                            </li>
                            
                        @endforeach
                    @endif
                </ul>
            </div>

        </div>
        <div class="col-md-9">
            <h1>
                Message Section

            </h1>

            <p class="lead">Select user form the list to begin conversation</p>

        </div>
    </div>
@endsection


@section('scripts')

    <script>
        $(function(){
            // var socket = io();
            let user_id = "{{ auth()->user()->id }}";
            var ip_address = '127.0.0.1';
            var socket_port = '7005';
            var socket = io(ip_address + ':' + socket_port);



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

                    console.log(key,val);

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


            

        })
                 
                


        
    </script>
    
@endsection