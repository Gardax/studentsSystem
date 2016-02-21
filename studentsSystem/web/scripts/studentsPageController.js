var studentsPageController = (function(){
    function load(container){
        studentsPageService.getUsers(1,[],[],
            function(data){
                var table = generateUsersTable(data);
                container.append(table);
            },
            function(error){
                alert(error);
            }
        );
    }

    function generateUsersTable(usersData){
        var table = "<table border='1'>" +
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
                "<td>MOLIF</td>"+
                "<td>DEL</td>";
        }
        table += "</tbody></table>";
        return table;
    }

    return {
        load: load
    };
}());