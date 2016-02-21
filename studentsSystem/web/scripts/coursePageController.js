var coursePageController = (function(){

    function load(container){

        coursePageService.getUsers(1,1,1,
            function(data){
                var table = generateUsersTable(JSON.parse(data));
                container.append(table);
            },
            function(error){

            }
        );
    }

    function generateUsersTable(usersData){
        var table = "<table border='1'>"+
            "<thead>" +
            "<tr>" +
            "<th>#</th>"+
            "<th>Курс</th>"+
            "<th>Име</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
            for(var i = 0; i < usersData.students.length; i++){
                student = usersData.students[i];
                table += "<tr>"+
                "<td>"+student.id+"</td>"+
                "<td>"+student.course+"</td>"+
                "<td>"+student.firstName+" " +student.lastName+ " ("+student.facultyNumber+")</td>"+
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