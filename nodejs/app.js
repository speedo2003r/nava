// Dependencies
const fs      = require('fs');
const http    = require('http');
const https   = require('https');
const express = require('express');
const app     = express();


const privateKey  = fs.readFileSync('/var/cpanel/ssl/apache_tls/wassetabd.4hoste.com/combined', 'utf8');
const certificate = fs.readFileSync('/var/cpanel/ssl/apache_tls/wassetabd.4hoste.com/certificates', 'utf8');
const ca          = fs.readFileSync('/var/cpanel/ssl/apache_tls/wassetabd.4hoste.com/combined', 'utf8');

const httpsServer     = https.createServer({
    key               : privateKey,
    cert              : certificate,
    ca                : ca
}, app).listen(4518, () => {
    console.log('HTTPS Server running on port 4558');
});

// });
const httpServer           = http.createServer(app).listen(9018, (req,res) => {
    console.log('HTTP Server running on port 9018');
});

var socketIO   = require('socket.io');
const io       = socketIO(httpsServer);


io.on('connection', function (socket) {
    if(connection.state === 'disconnected'){
        connection = mysql.createConnection({
            host     : 'localhost',
            user     : 'wassetab_wassetab',
            password : 'i9[dF8kQS;ID',
            database : 'wassetab_wassetab',
            charset  : 'utf8mb4'
        });
        connection.connect();
        console.log('new db connection ');
    }



});

// const app = new Server();
// app.appRun();

//
// 'use strict';
//
// const express       = require('express');
// const http          = require('http');
// const https   = require('https');
// const socketio      = require('socket.io');
// const socketEvents  = require('./utils/socket');
//
// const path    = require( 'path' );
// const fs      = require( 'fs' );
// const utf8    = require( 'utf8' );
//
// class Server {
//     constructor() {
//         this.port = 4558;
//         this.host = `localhost`;
//
//         this.app    = express();
//
//
//         const privateKey  = fs.readFileSync('/var/cpanel/ssl/apache_tls/wassetabd.4hoste.com/combined', 'utf8');
//         const certificate = fs.readFileSync('/var/cpanel/ssl/apache_tls/wassetabd.4hoste.com/certificates', 'utf8');
//         const ca          = fs.readFileSync('/var/cpanel/ssl/apache_tls/wassetabd.4hoste.com/combined', 'utf8');
//
//
//
//         const httpsServer     = https.createServer({
//             key               : privateKey,
//             cert              : certificate,
//             ca                : ca
//         }, this.app).listen(4518, () => {
//             console.log('HTTPS Server running on port 4518');
//         });
//
//         // });
//         const httpServer      = http.createServer(this.app).listen(9018, (req,res) => {
//             console.log('HTTP Server running on port 9018');
//         });
//
//         var socketIO   = require('socket.io');
//         this.socket       = socketIO(httpsServer);
//     }
//
//     appRun(){
//
//         // this.app.use( (req, res, next) => {
//         //     res.header("Access-Control-Allow-Origin", `${this.host}`);
//         //     res.header("Access-Control-Allow-Credentials", "*");
//         //     res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
//         //     next();
//         // });
//
//         //this.app.use(express.static(__dirname + '/uploads'));
//
//         new socketEvents(this.socket).socketConfig();
//
//         // this.http.listen(this.port, this.host, () => {
//         //     console.log(`Listening on ${this.host}:${this.port}`);
//         // });
//
//     }
// }

