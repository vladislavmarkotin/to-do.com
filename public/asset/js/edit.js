function editRequest(){
    var id;
    var task = '';
    var task_desc = '';
    var status;

    function makeRequest(formData){


        $.post( "/edit", { id: formData['task_id'],task: formData['task_name'],
            task_desc: formData['task_desc'], status: formData['task_status'] })
            .done(function(response) {

                var answer = JSON.parse(response);
                console.log(answer['id']);
                //$("#edit_status [value="+task_status +"]").attr("selected", "selected");
            })
            .fail(function (error){
                //$("#error").show();
                console.log("Fail!");
            });
    }

    this.init = function(task_id, task_name, task_description, task_status){
        //alert(task_status);

        id = task_id;
        task = task_name;
        task_desc = task_description;
        status = task_status;

        var formData = {
            task_id: id,
            task_name: task,
            task_desc: task_desc,
            task_status: status

        };

        if ( (task !== '') && (task_desc !== '') ){

            makeRequest(formData);

        }
    };
}

$( document ).ready(function() {
    $("#error").hide();

    $.each($("td button:button").click(function (elem){
        //alert("Yeaaaa!"); //работает !!!
        var id = $(this).parent().parent().children().eq(0).html();
        var task_name = $(this).parent().parent().children().eq(1).html();
        var task_description = $(this).parent().parent().children().eq(2).html();
        var task_status = $(this).parent().parent().children().eq(3).html();
        /* works */
        //console.log(id);
        /* Insert data in form */
        $("#edit_task-id").val(id);
        $('#edit_task-name').val(task_name);
        $("#edit_task-description").val(task_description);
        $("#edit_status [value="+task_status +"]").attr("selected", "selected");

    }));



});

$("#edit").click(function (event){


    var id = $("#edit_task-id").val();
    var task_name = $('#edit_task-name').val();
    var task_description = $("#edit_task-description").val();
    var task_status = $("#sel1 option:selected").text();


    //console.log(task_status);

    var edit_request = new editRequest();
    edit_request.init(id, task_name, task_description, task_status);
    // Stop form from submitting normally
    //event.preventDefault();

});


