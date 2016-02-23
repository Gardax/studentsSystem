var homePageController = (function(){
    function load(container){
          homePageService.getUsers(1,1,1,
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
             "<tr>" +
             "<th>" +
             "</th>" +
             "<th colspan='2'>" +
             "</th>" +
             "<th colspan='";
         var colspan = (usersData.subjects.length*3)+3;
         table+=colspan;
         table += "'";
         table += ">Предмети (хорариум и оценки)</th></tr><tr><th></th><th colspan='2'></th>";
         for(var i = 0; i < usersData.subjects.length;i++){
            table += "<th colspan='3'>"+usersData.subjects[i].name+"</th>";
         }
         table += "<th colspan='3'>Общо</th></tr>";
         table += "<tr>" +
             "<th>#</th>" +
             "<th>Име,Фамилия</th>" +
             "<th>Курс</th>";
         for(i = 0; i< usersData.subjects.length; i++){
             table +=   "<th>Лекции</th>" +
                        "<th>Упражнения</th>" +
                        "<th>Оценка</th>";
         }
         table += "<th>Ср. успех</th>" +
             "<th>Лекции</th>"+
             "<th>Упражнения</th>"+
             "</tr>"+
             "</thead><tbody>";
         var student, j,k,average,attendedLecture,totalLectures ,attendedExcercise,totalExcercise;

         for(i = 0; i < usersData.students.length;i++){
             attendedLecture =0;
             average =0;
             totalLectures =0;
             attendedExcercise=0;
             totalExcercise = 0;
             student = usersData.students[i];
             table += "<tr>"+
             "<td>"+student.id+"</td>"+
             "<td>"+student.firstName +" "+student.lastName+"("+student.facultyNumber+")</td>"+
             "<td>"+student.courseName+","+student.shortSpecialityName+"</td>";

             for(j = 0; j < student.studentAssessments.length;j++){
                 table += "<td>"+student.studentAssessments[j].lectureAttended+"("+student.studentAssessments[j].lectureTotal+")</td>"+
                     "<td>"+student.studentAssessments[j].exerciseAttended+"("+student.studentAssessments[j].exerciseTotal+")</td>"+
                     "<td>"+student.studentAssessments[j].assessment+"</td>";

                 average +=  parseInt(student.studentAssessments[j].assessment);
                 attendedLecture += parseInt(student.studentAssessments[j].lectureAttended);
                 totalLectures += parseInt(student.studentAssessments[j].lectureTotal);
                 attendedExcercise += parseInt(student.studentAssessments[j].exerciseAttended);
                 totalExcercise += parseInt(student.studentAssessments[j].exerciseTotal);

             }
             table += "<td>"+ average/student.studentAssessments.length+"</td>"+
                 "<td>"+attendedLecture+"("+totalLectures+")</td>"+
                 "<td>"+attendedExcercise+"("+totalExcercise+")</td>";

             table += "</tr>";
         }
         table += "</tbody></table>";
        return table;
     }

    return {
        load: load
    };
}());