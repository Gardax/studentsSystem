var homePageController = (function(){
    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;
    var paging;

    var errorsContainer;

    var container;
    var subjectsContainer;

    var homeFirstPageButton;
    var homePreviousPageButton;
    var homeNextPageButton;
    var homeLastPageButton;
    var homePageSearchButton;

    var nameFilterInput;
    var specialityFilterInput;
    var courseFilterInput;

    function initialize(containerElement, subjectsContainerElement) {
        nameFilterInput = $('#nameInput');
        specialityFilterInput = $('#specialtiesSelectElement');
        courseFilterInput = $('#coursesSelectElement');
        paging = $(".paging");

        container = containerElement;
        subjectsContainer = subjectsContainerElement;

        errorsContainer = $("#errorsContainer");
        errorsContainer.text("");
        atachEvents();
    }

    function atachEvents(){
        homeFirstPageButton = $(".homeFirstPageButton");
        homePreviousPageButton = $(".homePreviousPageButton");
        homeNextPageButton = $(".homeNextPageButton");
        homeLastPageButton = $(".homeLastPageButton");
        homePageSearchButton = $("#homePageSearchButton");

        homePreviousPageButton.on("click",function(){
            loadStudentsTable(currentPage - 1, currentOrder, currentFilters );
        });

        homeNextPageButton.on("click",function(){
            loadStudentsTable(currentPage + 1, currentOrder, currentFilters );
        });

        homeFirstPageButton.on("click",function(){
            loadStudentsTable(1, currentOrder, currentFilters );
        });

        homeLastPageButton.on("click",function(){
            loadStudentsTable(lastPage, currentOrder, currentFilters );
        });

        homePageSearchButton.on("click", function (event) {
            event.preventDefault();
            var filters = generateFilters();

            loadStudentsTable(1, currentOrder, filters);

        });

    }

    function loadPage(page, order, filters) {
        loadStudentsTable(page, order, filters);
        populateSubjects();
        populateSpecialities();
        populateCourses();
    }

    function populateCourses(){
        coursePageService.getAllCourses(
            function(data){
                var options = generateCourseOptions(data);
                courseFilterInput.html(options);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

    }

    function populateSpecialities(){
        specialitiesPageService.getAllSpecialities(
            function(data){
                var options = generateSpecialitiesOptions(data);
                specialityFilterInput.html(options);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);

            }
        );
    }

    function generateSpecialitiesOptions(data){
        var specialitiesOptions = "<option value='0'>Всички</option>";
        for(var i = 0; i < data.specialities.length; i++){
            specialitiesOptions += "<option value='"+data.specialities[i].id+"'>"+data.specialities[i].specialityLongName +"</option>";
        }
        return specialitiesOptions;
    }

    function generateCourseOptions(data){
        var options = "<option value='0'>Всички</option>";
        for(var i =0; i < data.courses.length ; i++){
            options += "<option value='"+data.courses[i].id+"'>"+data.courses[i].name +"</option>";
        }
        return options;
    }

    function loadStudentsTable(page, order, filters){
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
                paging.show();
                container.show();
                errorsContainer.text("");

                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
                paging.hide();
                container.hide();
            }
        );
    }

    function populateSubjects(){
        disciplinesPageService.getUsers('all', [], [],
            function(data){
                var subjects = generateSubjectsElements(data.subjects);
                subjectsContainer.html(subjects);
            },
            function (error) {

            });
    }

    function generateFilters(){
        var subjectIds = [];
        var checkedSubjects = subjectsContainer.find('input:checked');

        for(var i = 0; i < checkedSubjects.length; i++) {
            subjectIds.push($(checkedSubjects[i]).val());
        }

        return {
            'name': nameFilterInput.val(),
            'specialityId': specialityFilterInput.val(),
            'courseId': courseFilterInput.val(),
            'subjectIds': subjectIds
        }
    }

    function generateSubjectsElements(subjects) {
        var html = "";
        for(var i = 0; i < subjects.length;i++) {
            html += "<input type='checkbox' value='" + subjects[i].id + "' id='subject" + subjects[i].id + "'" + ((i < 3) ? "checked=checked" : "") +">" +
                "<label for='subject" + subjects[i].id + "'>" + subjects[i].name + "</label>"
        }

        return html;
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
         var student, j,average,attendedLecture,totalLectures ,attendedExcercise,totalExcercise, currentSubject;
         var currentSubjectStudentLectureAttended, currentSubjectStudentExercisesAttended, currentSubjectStudentAssesment, assesmentsCount;

         for(i = 0; i < usersData.students.length;i++){
             attendedLecture =0;
             average =0;
             totalLectures =0;
             attendedExcercise=0;
             totalExcercise = 0;
             assesmentsCount = 0;

             student = usersData.students[i];
             table += "<tr>"+
             "<td>"+student.id+"</td>"+
             "<td>"+student.firstName +" "+student.lastName+"("+student.facultyNumber+")</td>"+
             "<td>"+student.courseName+" "+student.shortSpecialityName+"</td>";

             for(j = 0; j < usersData.subjects.length;j++){
                 currentSubject = usersData.subjects[j];
                 currentSubjectStudentLectureAttended = 0;
                 currentSubjectStudentExercisesAttended = 0;
                 currentSubjectStudentAssesment = '-';
                 if(student.studentAssessments &&  ("undefined" != typeof (student.studentAssessments[currentSubject.id]))) {
                     currentSubjectStudentLectureAttended = student.studentAssessments[currentSubject.id].lectureAttended;
                     currentSubjectStudentExercisesAttended = student.studentAssessments[currentSubject.id].exerciseAttended;
                     currentSubjectStudentAssesment = student.studentAssessments[currentSubject.id].assessment;
                 }

                 table += "<td>" + currentSubjectStudentLectureAttended + "(" + currentSubject.workloadLectures + ")</td>"+
                     "<td>" + currentSubjectStudentExercisesAttended + "(" + currentSubject.workloadExercises + ")</td>"+
                     "<td>" + currentSubjectStudentAssesment + "</td>";

                 if(currentSubjectStudentAssesment != "-") {
                     average +=  parseInt(currentSubjectStudentAssesment);
                     attendedLecture += parseInt(currentSubjectStudentLectureAttended);
                     totalLectures += parseInt(currentSubject.workloadLectures);
                     attendedExcercise += parseInt(currentSubjectStudentExercisesAttended);
                     totalExcercise += parseInt(currentSubject.workloadExercises);
                     assesmentsCount++;
                 }
             }

             table += "<td>"+ ((assesmentsCount != 0) ? average/assesmentsCount : "-") + "</td>"+
                 "<td>"+attendedLecture+"("+totalLectures+")</td>"+
                 "<td>"+attendedExcercise+"("+totalExcercise+")</td>";

             table += "</tr>";
         }

         table += "</tbody></table>";
        return table;
     }

    return {
        loadPage: loadPage,
        initialize: initialize
    };
}());