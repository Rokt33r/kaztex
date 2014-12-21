var config = require('./server-config'),
    express = require('express'),
    app = express(),
    server = require('http').createServer(app);

// CONFIG SERVER
app.use('/', express.static(config.static_site_root));

// FIRE IT UP
server.listen(config.port, function(){
    console.log("Express server listening on port %d", config.port);
});
