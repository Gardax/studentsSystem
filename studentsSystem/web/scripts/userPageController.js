var userPageController = (function(){
    function load(container){
        userPageService.getUsers(1,1,1,
            function(data){
                var table = generateUsersTable(JSON.parse(data));
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
            "<th>Потребителско име</th>"+
            "<th>E-mail</th>"+
            "<th>Роля</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
        for(var i = 0; i < usersData.users.length; i++){
            table += "<tr>"+
                "<td>"+usersData.users[i].user_id+"</td>"+
                "<td>"+usersData.users[i].username+"</td>"+
                "<td>"+usersData.users[i].email+"</td>"+
                "<td>"+usersData.users[i].role+"</td>"+
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