<html>
    <head>
        <title>Pusher Test</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
        <script>
      
          // Enable pusher logging - don't include this in production
          Pusher.logToConsole = true;
      
          var pusher = new Pusher('fa47486f1a0831ec0f3c', {
            cluster: 'ap1',
            forceTLS: true
          });
      
          var channel = pusher.subscribe('notify');
          channel.bind('App\\Events\\sendNote', function(data) {
            alert(JSON.stringify(data));
          });
        </script>
      </head>
      <body>
        <h1>Pusher Test</h1>
        <p>
          Try publishing an event to channel <code>notify</code>
          with event name <code>App\\Events\\sendNote</code>.
        </p>
      </body>
</html>