'use strict';

const DB 	    = require('./db');
const moment    = require('moment');
const path      = require('path');
const fs        = require('fs');
const helper    = require('./helper');
const  users = {};

class Socket{

    constructor(socket){
        this.io = socket;
        this.db = DB;
    }

    socketEvents(){
        this.io.on('connection', (socket) => {
            const ConnectedUserID = socket.request._query['id'];
            allPrivateRooms(this.io);

            socket.broadcast.emit('userConnected', {
                userId: ConnectedUserID,
                socket_id: socket.id
            });
            
             socket.on("adduser",function(data){
              console.log('add user');
              console.log(data);
             //console.log(socket.user_id);

            //   if(!(data.room_id in users)){
            //      users[data.room_id] = {};
            //     }
                
            //      users[data.room_id] = socket;
            //   //  socket.user_id = data.id;
            //      socket.room_id = data.room_id;  
            //     console.log(socket.room_id)
            //     // users[data.id] = socket;
            //     // socket.user_id = data.id;
                
            });
            
            socket.on('tracking', async (data) => {
                socket.emit('userTracking', data);
            });

            // get user online status
            socket.on('isUserConnected', async (userId) => {
                console.log("isUserConnected")
                console.log(userId)
                console.log(ConnectedUserID +  ' ask userStatus ' + userId);
                const result = await helper.isUserConnected(userId);
                
                socket.broadcast.emit('isUserConnectedRes', {
                    userData: result.userData,
                });
            });

            // send the messages to the user
            socket.on('addMessage', (response) => {
                console.log('addMessage')
                console.log(response);
                
                //save message in database
                
              //  socket.id = response.user_id;
            //    var otherUsersIds = response.other_users;
                // if(otherUsersIds.length){
                //     otherUsersIds.forEach(function(user_id) {
                //         socket.to(user_id).emit('addMessageResponse', response);
                //     });
                // }
            
                    // console.log('receiver user : '+data.receiver_id+' in socket');
                    
                
              //  socket.emit('addMessageResponse',response);
            //          console.log("jhvfgjhcghchg");
            //   console.log(socket.room_id);
                socket.broadcast.emit('addMessageResponse',response);
        
            //   if(response.message.room_id == socket.room_id){
   
            //   }else{
            //       console.log("not equl")
            //       console.log(response.message.room_id)
            //       console.log("close connection ")
            //       socket.emit('addMessageResponse',response);
            //   }
             });

            socket.on('startTyping', async (data) =>{
                var otherRoomUsers = data.users;
                if(otherRoomUsers.length){
                    otherRoomUsers.forEach(async(user)=> {
                        if(user.socket_id !=''){
                            socket.to(user.socket_id).emit('ResTyping', {'room_id':data.room_id});
                            console.log('typing to',user.socket_id );
                            //console.log('typing to room',data.room_id );
                        }
                    });
                }
            });

            socket.on('disconnect', async () => {
                console.log("disconnect");
                console.log('user_id ',ConnectedUserID,' disConnected');

                // make user online 0 and delete socket id from DB
                //const isLoggedOut = await helper.logoutUser(socket.id);
                const isLoggedOut = await helper.logoutUser(ConnectedUserID);
                socket.broadcast.emit('userDisconnect', {
                    userId: ConnectedUserID,
                });
            });

            socket.on('createOrJoinRoom', async (roomId) => {
                console.log('user_id ',ConnectedUserID,' createOrJoinRoom ',roomId);
                socket.join('private_'+roomId);
                allPrivateRooms(this.io);
            });

            socket.on('leaveRoom', async (roomId) => {
                console.log('user_id ',ConnectedUserID,' leaveRoom ',roomId);
                socket.leave('private_'+roomId);
                allPrivateRooms(this.io);
            });

            function allPrivateRooms(iiiooo){
                var allRooms = iiiooo.sockets.adapter.rooms;
                var newObj = {}
                Object.keys(allRooms).forEach(function(room, idx) {
                    if(room.includes("private")){
                        newObj[room] = allRooms[room];
                    }
                });
                console.log('private rooms -> ',newObj);
            }

            socket.on('updatelocation',async function(data){
                console.log("updatelocation")
                console.log(data);
                // pool.getConnection(function(err,connection){
                var tracker_id;
                await helper.CreateTrack(data);
                console.log('update location for : '+data.order_id+' lat: '+data.lat+' lng: '+data.lng);
                 await helper.track_order(data);
                 console.log(data)
                socket.broadcast.emit('ordertracking',data);
               

                // });//end of pool connection

            });

        //    end of trach
        });
    }

    // start user connecting then call socketEvents
    socketConfig(){
        this.io.use( async (socket, next) => {
            console.log("enter user")
            let userId = socket.request._query['id'];
            socket.id = parseInt(userId);
            let userSocketId = socket.id;
            
            console.log(userId);
            console.log(userSocketId);
            // make user online and save socket id in DB
            const response = await helper.addSocketId( userId, userSocketId);
            if(userId != 0 && response &&  response !== null){
                console.log('user_id ',userId,' connected');
                next();
            }else{
                console.error(`Socket connection failed, for  user Id ${userId}.`);
            }
        });
        //console.log('in socket js');
        this.socketEvents();
    }
}
module.exports = Socket;
