var specialitiesPageController = (function(){
    function load(container){
        specialitiesPageService.getUsers(1,1,1,
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
            "<th>Пълно име</th>"+
            "<th>Абравиатура</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
        for(var i = 0; i < usersData.specialities.length; i++){
            table += "<tr>"+
                "<td>"+usersData.specialities[i].id+"</td>"+
                "<td>"+usersData.specialities[i].specialityLongName+"</td>"+
                "<td>"+usersData.specialities[i].specialityShortName+"</td>"+
                "<td class='edit'></td>"+
                "<td class='delete'></td>";
        }
        table += "</tbody></table>";
        return table;
    }

    return {
        load: load
    };
}());