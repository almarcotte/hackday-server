<html>
    <head>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <title>Hello</title>
    </head>

    <body>
    <div class="ui-widget">
        <input id="player" placeholder="Player">
    </div>
    </body>

    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#player" ).autocomplete({
                source: "search",
                minLength: 2,
                select: function( event, ui ) {
                    console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
                }
            });
        } );
    </script>
</html>