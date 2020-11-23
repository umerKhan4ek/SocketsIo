
var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);
var users = [];



http.listen(7005, () => {
    console.log('listening on');
  });
io.on('connection' , function(socket){
    socket.on("user_connected",function(user_id){

        
        
        users[user_id] = socket.id;
        // console.log(socket.id)
        io.emit('updateUserStatus',users);
        console.log('user connected '+users[user_id]);
    });

    socket.on('disconnect', function(){
            var i = users.indexOf(socket.id);
            console.log(users.indexOf(socket.id));
            users.splice(i,1,0 );
            io.emit('updateUserStatus',users);
            console.log(users);
        });

});

