/**
 * Created by Vlad on 24.06.2018.
 */


$('#add').click(function (){
    $('#modal_window').modal('show');
});

$('#final_add_task').submit(function (){

    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $( this ),
        term = $form.find( "input[name='name']" ).val(),
        url = $form.attr( "action" );

    if ( term == '' || url == ''){
        alert('stop!');
    }else{
        // Send the data using post
        var posting = $.post( url, { name: term } );

        // Put the results in a div
        posting.done(function( data ) {
            /*var content = $( data ).find( "#content" );
             $( "#result" ).empty().append( content );*/
            alert("Yea");
        });
    }


});
