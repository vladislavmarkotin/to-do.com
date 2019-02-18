/**
 * Created by Vlad on 26.06.2018.
 */

/* Кстати говоря, подвесить обработчик можно через each()!!!*/

$.each($("td button").click(function (elem){
    //alert("Yeaaaa!"); //работает !!!
    $('#edit_window').modal('show');
    id = $(this).parent().children().eq(0).html();
    status = $(this).parent().children().eq(1).html();
    name = $(this).parent().children().eq(2).html();
    comment = $(this).parent().children().eq(3).html();
    $("#edit-name").val(name);
    $("#edit-status").val(status);
    $("#edit-comment").val(comment);
    $("#id").val(id);
    //alert(id);

}));

$('#final_edit_task').submit(function (event){

    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $( this ),
        id = $form.find( "input[name='id']" ).val(),
        new_name = $form.find( "input[name='edit-name']" ).val(),
        new_status = $form.find( "input[name='edit-status']" ).val(),
        new_comment = $form.find( "input[name='edit-comment']" ).val(),
        url = $form.attr( "action" );

    if ( (new_name || new_status || new_comment) == ''){
        throw stop;
    }
    // Send the data using post
    var posting = $.post( url, { id: id, name: new_name, status: new_status, comment: new_comment } );

    // Put the results in a div
    posting.done(function( data ) {
        /*var content = $( data ).find( "#content" );
         $( "#result" ).empty().append( content );*/
        alert("Yea");
    });
});

