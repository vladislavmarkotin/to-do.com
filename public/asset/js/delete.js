/**
 * Created by Vlad on 20.02.2019.
 */

$(document).ready(function (){

    function deleteRequest(){
        var id;

        function makeRequest(formData){

            $.post( "del", { id: formData['id'] })
                .done(function (response){
                    console.log(response);
                });
        }

        this.init = function(task_id){
            //alert(task_description);

            var formData = {
                id: task_id
            };

            console.log(formData);

            if ( (task_id !== '')){
                makeRequest(formData);
            }
        };
    }

    $('button:submit').bind("click", function (){

        var id = $(this).parent().parent().children().eq(0).html();
        var task_name = $(this).parent().parent().children().eq(1).html();
        var task_description = $(this).parent().parent().children().eq(2).html();
        var task_status = $(this).parent().parent().children().eq(3).html();

        var delete_request = new deleteRequest();
        delete_request.init(id);
    });




    /*$.each($("td button:submit").click(function (elem){
        //alert("Yeaaaa!"); //

        var id = $(this).parent().parent().children().eq(0).html();
        var task_name = $(this).parent().parent().children().eq(1).html();
        var task_description = $(this).parent().parent().children().eq(2).html();
        var task_status = $(this).parent().parent().children().eq(3).html();
        //console.log(id); it works!

    }));*/
});
