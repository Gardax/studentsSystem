var disciplinesPageController = (function(){
    function load(container){
        disciplinesPageService.getUsers(1,1,1,
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
            "<th>Име на дисциплината</th>"+
            "<th>Хорариум(Л)</th>"+
            "<th>Хорариум(У)</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
        for(var i = 0; i < usersData.disciplines.length; i++){
            table += "<tr>"+
                    "<td>"+usersData.disciplines[i].id+"</td>"+
                    "<td>"+usersData.disciplines[i].name+"</td>"+
                    "<td>"+usersData.disciplines[i].workload_lectures+"</td>"+
                    "<td>"+usersData.disciplines[i].workload_exercises+"</td>"+"<td>MOLIF</td>"+
                "<td>DEL</td>";
        }
        table += "</tbody></table>";
        return table;
    }

    return {
        load: load
    };
}());