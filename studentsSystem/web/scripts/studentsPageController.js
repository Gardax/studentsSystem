var studentsPageController = (function(){
    var $errorsContainer;

    function initialize() {
        $errorsContainer = $("#errorsContainer");
    }

    function load(container){
        studentsPageService.getUsers(1,[],[],
            function(data){
                var table = generateUsersTable(data);
                container.append(table);
            },
            function(error){
                $errorsContainer.text(error.responseJSON.errorMessage);
            }
        );
    }

    function generateUsersTable(usersData){
        var table = "<a href=''>Първа</a> <a href=''Предходна</a> <a href=''>Следваща</a> <a href=''>Последна</a>" +
                "<table border='1'>" +
                "<thead>" +
                "<th>#</th>"+
                "<th>Име</th>"+
                "<th>E-mail</th>"+
                "<th>Факултетен номер</th>"+
                "<th colspan='2'>Операции</th>"+
                "</thead><tbody>";
        for(var i = 0; i < usersData.students.length; i++){
            table += "<tr>"+
                "<td>"+usersData.students[i].id+"</td>"+
                "<td>"+usersData.students[i].firstName+" "+usersData.students[i].lastName+"</td>"+
                "<td>"+usersData.students[i].email+"</td>"+
                "<td>"+usersData.students[i].facultyNumber+"</td>"+
                "<td class='edit'></td>"+
                "<td class='delete'></td>";
        }
        table += "</tbody></table>";
        table += "<a href=''>Първа</a> <a href=''Предходна</a> <a href=''>Следваща</a> <a href=''>Последна</a>";
        return table;
    }

    return {
        load: load,
        initialize: initialize
    };
}());