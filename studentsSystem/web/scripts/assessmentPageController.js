var assessmentPageController = (function(){

    function load(container){

        assessmentPageService.getUsers(1,1,1,
            function(data){
                var table = generateUsersTable(data);
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
            "<th>Име, Фамилия</th>"+
            "<th>Дисциплина</th>"+
            "<th>Оценка</th>"+
            "<th>Операции</th>"+
            "</thead><tbody>";
        for(var i = 0; i < usersData.studentAssessments.length; i++){
            var assesment = usersData.studentAssessments[i];
            table += "<tr>"+
                "<td>"+assesment.id+"</td>"+
                "<td>"+assesment.studentFirstName+" "+assesment.studentLastName+"</td>"+
                "<td>"+assesment.subjectName+"</td>"+
                "<td>"+assesment.assessment+"</td>"+
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