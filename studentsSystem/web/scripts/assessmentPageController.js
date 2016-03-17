var assessmentPageController = (function() {
    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage = 1;

    var $deleteButton;
    var errorsContainer;
    var assessmentStudentName;
    var assessmentDisciplineSelect;
    var container;
    var pagingButtons;
    var assessmentTable;
    var assessmentCurrentPageContainer;
    var addNewAssessment;
    var mainContainer;
    var currentEditAssessmentId;
    var assessmentName;
    var assessmentLecture;
    var assessmentExercise;
    var assessmentGrade;
    var generateAssessmentSubjectsContainer;
    var reject;
    var results;
    var from = 0;
    var to = 0;

    var assessmentFirstPageButton;
    var assessmentPreviousPageButton;
    var assessmentNextPageButton;
    var assessmentLastPageButton;
    var assessmentSearchButton;
    var addAssessmentButton;

    function initializeAssessmentsPage(containerElement ,assessmentElement) {
        assessmentDisciplineSelect = assessmentElement;
        container = containerElement;
        mainContainer = $("#mainContainer");
        errorsContainer = $("#errorsContainer");
        addNewAssessment = $("#addNewAssessment");
        results = $(".results");

        pagingButtons = $(".paging");
        assessmentCurrentPageContainer = $(".assessmentCurrentPage");
        assessmentTable = $("#assessmentTable");
        assessmentStudentName = $("#assessmentsName");
        errorsContainer.text("");
        attachEvents();
    }

    function attachEvents() {
        assessmentFirstPageButton = $(".assessmentFirstPageButton");
        assessmentPreviousPageButton = $(".assessmentPreviousPageButton");
        assessmentNextPageButton = $(".assessmentNextPageButton");
        assessmentLastPageButton = $(".assessmentLastPageButton");
        assessmentSearchButton = $("#assessmentSearchButton");

        assessmentPreviousPageButton.on("click", function () {
            loadAssessmentsPage(currentPage - 1, currentOrder, currentFilters);
        });

        assessmentNextPageButton.on("click", function () {
            loadAssessmentsPage(currentPage + 1, currentOrder, currentFilters);
        });

        assessmentFirstPageButton.on("click", function () {
            loadAssessmentsPage(1, currentOrder, currentFilters);
        });

        assessmentLastPageButton.on("click", function () {
            loadAssessmentsPage(lastPage, currentOrder, currentFilters);
        });
        assessmentSearchButton.on("click", function(event){
            event.preventDefault();
            loadAssessments(1, [], getFilterValues());
        });
        addNewAssessment.on("click",function(){
            loadAddEditForm(addAssessmentHandler);
        });
        assessmentTable.on('click', function(e) {
            var element = $(e.target);
            var assessmentId = element.attr('data-id');
            if(element.hasClass('edit')) {
                currentEditAssessmentId = assessmentId;
                loadAddEditForm(editAssessmentHandler);
            }
            else if(element.hasClass('delete')) {
                var response = confirm('Сигурен ли сте, че искате да изтриете тази оценка?');
                if(response) {
                    assessmentPageService.deleteAssessment(assessmentId, function(){
                            var pageToGo = (currentPage == lastPage) ? --currentPage : currentPage;
                            if(pageToGo < 1) {
                                pageToGo = 1;
                            }
                            loadAssessments(pageToGo, currentOrder, currentFilters );
                        },
                        function(error){
                            errorsContainer.text(error.responseJSON.errorMessage);
                        }
                    );
                }
            }
        });

    }

    function loadAddEditForm(handler) {
        mainContainer.load("/pages/assessmentAdd.html", function() {
            addAssessmentButton = $("#addAssessmentButton");
            assessmentName = $("#assessmentName");
            assessmentLecture = $("#assessmentLecture");
            assessmentExercise = $("#assessmentExercise");
            assessmentGrade = $("#assessmentGrade");
            generateAssessmentSubjectsContainer = $("#generateAssessmentSubjects");

            subjectsPageService.getAllSubjects(
                function(data){
                    var options = generateAssessmentSubjects(data);
                    generateAssessmentSubjectsContainer.html(options);
                },
                function(error){
                    errorsContainer.text(error.responseJSON.errorMessage);

                }
            );
            studentsPageService.getStudentsAutocomplete(
              function(data){
                  assessmentName.autocomplete({
                      source: data
                  });
              }
            );



            handler();
        });
    }

    function addAssessmentHandler() {
        addAssessmentButton.on("click", function (event) {
            event.preventDefault();
            errorsContainer.text('');

            var data = getFormData();
            assessmentPageService.addAssessment(data, function () {
                    uiController.loadAssessmentPage();
                },
                function (error) {

                    if(error.responseJSON.errors){
                        printErrors(error.responseJSON.errors);
                    }
                    else{
                        errorsContainer.text(error.responseJSON.errorMessage);
                    }
                }
            );
        });
    }

    function getFormData(){
        return {
            'studentData': assessmentName.val(),
            'subjectId' : generateAssessmentSubjectsContainer.val(),
            'workloadLectures' : assessmentLecture.val(),
            'workloadExercises' : assessmentExercise.val(),
            'assessment' : assessmentGrade.val()
        };
    }

    function editAssessmentHandler() {
        var assessmentFormHeader = $("#assessmentFormHeader");
        assessmentFormHeader.text("Редактиране на оценка");
        addAssessmentButton.val("Редактирай");

        reject = $("#reject");

        reject.on("click",function(event){
            event.preventDefault();
            uiController.loadAssessmentPage();
        });

        assessmentPageService.getAssessmentById(currentEditAssessmentId,function(data) {
                assessmentName.val(data.studentFirstName + " " + data.studentLastName + "(" + data.facultyNumber + ")");
                assessmentLecture.val(data.lectureAttended);
                assessmentExercise.val(data.exerciseAttended);
                assessmentGrade.val(data.assessment);
                generateAssessmentSubjectsContainer.val(data.subjectId);

                addAssessmentButton.on("click",function(event){

                    event.preventDefault();
                    var data = getFormData();
                    assessmentPageService.updateAssessment(currentEditAssessmentId, data, function(){

                            uiController.loadAssessmentPage();
                        },
                        function (error) {

                            if(error.responseJSON.errors){
                                printErrors(error.responseJSON.errors);
                            }
                            else{
                                errorsContainer.text(error.responseJSON.errorMessage);
                            }
                        }
                    );

                });
            },
            function(error){

                errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

    }

    function getFilterValues(){
        return {
            'name' : assessmentStudentName.val(),
            'subjectId' : assessmentDisciplineSelect.val()
        };
    }

    function loadAssessmentsPage(page, order, filters) {
        loadAssessments(page, order, filters);

        subjectsPageService.getAllSubjects(
            function(data) {
                var option = generateAssessmentsOptions(data);
                assessmentDisciplineSelect.html(option);
            }
        );
    }

    function loadAssessments(page, order, filters) {
        assessmentPageService.getAssessments(page, order, filters,
            function (data) {
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if (data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                assessmentCurrentPageContainer.text(currentPage + " от " + lastPage);

                if(currentPage == 1){
                    from = 1;
                }else{
                    from = (currentPage-1)* data.itemsPerPage+1;
                }

                if(data.totalCount < data.itemsPerPage){
                    to = data.totalCount;
                }else {
                    to = currentPage * data.itemsPerPage;
                }

                if(to > data.totalCount){
                    to = data.totalCount;
                }
                results.text("Резултати " +from +  " - " + to  + " от " + data.totalCount);

                manageButtonsState();
                pagingButtons.show();
                assessmentTable.show();
                assessmentCurrentPageContainer.show();
                errorsContainer.text("");

                var table = generateAssessmentsTable(data);
                container.html(table);
            },
            function (error) {
                errorsContainer.text(error.responseJSON.errorMessage);
                pagingButtons.hide();
                assessmentTable.hide();
                assessmentCurrentPageContainer.hide();
            }
        );
    }

    function generateAssessmentSubjects(data){
        var option = "";
        for(var i = 0 ; i < data.subjects.length ; i++ ){
            option += "<option value='"+data.subjects[i].id+"'>"+data.subjects[i].name +"</option>";
        }
        return option;
    }

    function generateAssessmentsOptions(data){
        var option = "<option value='0'>Всички</option>";
        for(var i = 0 ; i < data.subjects.length ; i++ ){
            option += "<option value='"+data.subjects[i].id+"'>"+data.subjects[i].name +"</option>";
        }
        return option;
    }

    function manageButtonsState() {
        assessmentFirstPageButton.prop('disabled', false);
        assessmentPreviousPageButton.prop('disabled', false);
        assessmentNextPageButton.prop('disabled', false);
        assessmentLastPageButton.prop('disabled', false);

        if (currentPage == 1) {
            assessmentFirstPageButton.prop('disabled', true);
            assessmentPreviousPageButton.prop('disabled', true);
        }

        if (currentPage == lastPage) {
            assessmentNextPageButton.prop('disabled', true);
            assessmentLastPageButton.prop('disabled', true);
        }
    }
    function generateAssessmentsTable(usersData) {
        $deleteButton = $(".delete");

        var table = "<table border='1'>" +
            "<thead>" +
            "<tr>" +
            "<th>#</th>" +
            "<th>Име, Фамилия</th>" +
            "<th>Дисциплина</th>" +
            "<th>Оценка</th>" +
            "<th colspan='2'>Операции</th>" +
            "</thead><tbody>";
        for (var i = 0; i < usersData.studentAssessments.length; i++) {
            var assesment = usersData.studentAssessments[i];
            table += "<tr>" +
                "<td>" + assesment.id + "</td>" +
                "<td>" + assesment.studentFirstName + " " + assesment.studentLastName + "</td>" +
                "<td>" + assesment.subjectName + "</td>" +
                "<td>";
            if (assesment.assessment == 6) {
                table += "Отличен("
            } else if (assesment.assessment == 5) {
                table += "Мн-добър("
            } else if (assesment.assessment == 4) {
                table += "Добър("
            } else if (assesment.assessment == 3) {
                table += "Среден("
            } else if (assesment.assessment == 2) {
                table += "Слаб("
            }
            table += assesment.assessment + ")</td>" +
                "<td class='edit' data-id='" + assesment.id + "'></td>";

            if(loginService.getRole() == "Администратор"){
                table += "<td class='delete' data-id='" + assesment.id + "'></td>";
            }else if(loginService.getRole() != "Администратор"){
                $deleteButton.hide();
            }
        }
    table += "</tbody></table>";
    return table;
    }

    function printErrors(errors) {
        for(var e in errors) {
            if(errors.hasOwnProperty(e)) {
                errorsContainer.append('<p>' + errors[e] + '</p>');
            }
        }
    }

    return {
        loadAssessmentsPage: loadAssessmentsPage,
        initializeAssessmentsPage: initializeAssessmentsPage
    };
}());