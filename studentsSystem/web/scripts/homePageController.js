var homePageController = (function(){
    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var container;

    var homeFirstPageButton;
    var homePreviousPageButton;
    var homeNextPageButton;
    var homeLastPageButton;

    function initizlize(containerElement) {
        container = containerElement;
        atachEvents();
    }

    function atachEvents(){
        homeFirstPageButton = $(".homeFirstPageButton");
        homePreviousPageButton = $(".homePreviousPageButton");
        homeNextPageButton = $(".homeNextPageButton");
        homeLastPageButton = $(".homeLastPageButton");

        homePreviousPageButton.on("click",function(){
            loadPage(currentPage - 1, currentOrder, currentFilters );
        });

        homeNextPageButton.on("click",function(){
            loadPage(currentPage + 1, currentOrder, currentFilters );
        });

        homeFirstPageButton.on("click",function(){
            loadPage(1, currentOrder, currentFilters );
        });

        homeLastPageButton.on("click",function(){
            loadPage(lastPage, currentOrder, currentFilters );
        });

    }

    function loadPage(page, order, filters) {
        homePageService.getUsers(page, order, filters,
            function(data){
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if(data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                manageButtonsState();

                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                alert(error);
            }
        );
    }

    function manageButtonsState(){
        homeFirstPageButton.prop('disabled', false);
        homePreviousPageButton.prop('disabled', false);
        homeNextPageButton.prop('disabled', false);
        homeLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            homeFirstPageButton.prop('disabled', true);
            homePreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            homeNextPageButton.prop('disabled', true);
            homeLastPageButton.prop('disabled', true);
        }
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
         var student, j,average,attendedLecture,totalLectures ,attendedExcercise,totalExcercise;

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
             "<td>"+student.courseName+" "+student.shortSpecialityName+"</td>";

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
        loadPage: loadPage,
        initialize: initizlize
    };
}());