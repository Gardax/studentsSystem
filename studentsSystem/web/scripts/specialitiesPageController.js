var specialitiesPageController = (function(){
    function load(container){
        specialitiesPageService.getUsers(1,1,1,
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
            "<th>Пълно име</th>"+
            "<th>Абравиатура</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
        for(var i = 0; i < usersData.specialities.length; i++){
            table += "<tr>"+
                "<td>"+usersData.specialities[i].id+"</td>"+
                "<td>"+usersData.specialities[i].fullName+"</td>"+
                "<td>"+usersData.specialities[i].shortName+"</td>"+
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