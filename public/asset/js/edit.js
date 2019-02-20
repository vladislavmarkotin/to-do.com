$( document ).ready(function() {
    $(function() {

        $('button:submit').bind("click", false);

    });


    function editRequest(){
        var id;
        var task = '';
        var task_desc = '';

        function makeRequest(formData){


            $.post( "edit", { id: formData.getId(),task_name: formData.getName(), task_desc: formData.getDesc() }).done(function(response) {
                var answer = JSON.parse(response);
                console.log(answer);

            });
        }

        this.init = function(task_id, task_name, task_description){
            //alert(task_description);

            id = task_id;
            task = task_name;
            task_desc = task_description;

            var formData = {
                task_id: id,
                task_name: task,
                task_desc: task_desc,

                getId: function (){
                    return this.id;
                },

                getName: function () {
                    return this.task_name;
                },

                getDesc: function (){
                    return this.task_desc;
                }
            };

            if ( (task !== '') && (task_desc !== '') ){
                makeRequest(formData);
            }
        };
    }

    $.each($("td button").click(function (elem){
        //alert("Yeaaaa!"); //работает !!!
        var id = $(this).parent().parent().children().eq(0).html();
        var task_name = $(this).parent().parent().children().eq(1).html();
        var task_description = $(this).parent().parent().children().eq(2).html();
        var task_status = $(this).parent().parent().children().eq(3).html();
        /* works */
        console.log(id);
        console.log(task_name);
        console.log(task_description);
        console.log(task_status);
        /* Insert data in form */
        $("#edit_task-id").val(id);
        $('#edit_task-name').val(task_name);
        $("#edit_task-description").val(task_description);
        $("#edit_status [value="+task_status +"]").attr("selected", "selected");



    }));

});


