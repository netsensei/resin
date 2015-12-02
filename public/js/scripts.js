    var conn = new ab.Session('ws://resin.app:8080',
        function() {
            conn.subscribe('foobar', function(topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                $.notify({
                    message: 'Event has been triggered with data : ' + data.foo
                },{
                    type: 'info'
                })
            });
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
