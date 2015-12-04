(function(resin) {
    resin(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
         (function registerUploadNotification() {
                var conn = new ab.Session('ws://resin.app:8080',
                    function() {
                        conn.subscribe('uploadJob', function(topic, data) {
                            // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                            $.notify({
                                message: 'Upload read ' + data.read + ' rows and saved ' + data.saved + ' objects.'
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
        }());
    });
}));

/*    var conn = new ab.Session('ws://resin.app:8080',
        function() {
            conn.subscribe('mergeJob', function(topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                $.notify({
                    message: 'Event has been triggered with data : ' + data.foo
                },{
                    type: 'info'
                })
            });

            conn.subscribe('uploadJob', function(topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                $.notify({
                    message: 'Upload read ' + data.read + ' rows and saved ' + data.saved + ' objects.'
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
*/
