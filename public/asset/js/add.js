/**
 * Created by Vlad on 17.02.2019.
 */



function addRequest(){
    var task = '';
    var task_desc = '';

    function makeRequest(formData){


        $.post( "add", { task_name: formData.getName(), task_desc: formData.getDesc() }).done(function(response) {
            console.log("Response" + response);
            $("#tasks").append("<td>" + response.task_name + "</td>");
            $("#tasks").append("<td>" + response.task_desc + "</td>")
            $("#tasks").append("<td>" + response.status + "</td>")
        });
    }

    this.init = function(task_name, task_description){
        //alert(task_description);

        task = task_name;
        task_desc = task_description;

        var formData = {
            task_name: task,
            task_desc: task_desc,

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

$("#send").click(function (e){
    var task_name = $('#task-name').val();
    var task_description = $("#task-description").val();

    var add = new addRequest();

    add.init(task_name, task_description);
    e.preventDefault();
});

