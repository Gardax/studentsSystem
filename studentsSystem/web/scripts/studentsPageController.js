var studentsPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var container;
    var errorsContainer;
    var coursesContainer;
    var specialitiesContainer;
    var studentCurrentPageContainer;
    var addNewStudent;
    var mainContainer;
    var studentFormHeader;

    var $deleteButton;
    var reject;
    var studentAddPasswordMatch;
    var studentAddEmail;
    var studentAddFirstName;
    var studentAddFamilyName;
    var studentAddFacultyNumber;
    var studentAddGenerateSpeciality;
    var studentAddGenerateFormOfEducation;
    var studentAddCourse;

    var filterByName;
    var filterByEmail;
    var filterByFacultyNumber;
    var studentsTable;
    var studentCourse;
    var studentSpecialities;
    var currentEditStudentId;

    var studentsFirstPageButton;
    var studentsPreviousPageButton;
    var studentsNextPageButton;
    var studentsLastPageButton;

    var pagingButtons;
    var studentSearchButton;
    var addStudentButton;

    function initialize(containerElement, coursesElement, specialitiesElement) {
        filterByName = $("#studentName");
        filterByEmail =$("#studentEmail");
        filterByFacultyNumber = $("#studentFacultyNumber");
        studentCurrentPageContainer = $(".studentCurrentPage");
        studentCourse = $("#studentCourse");
        studentSpecialities = $("#studentSpecialities");
        addStudentButton = $("#addStudentButton");
        studentFormHeader = $("#studentFormHeader");

        container = containerElement;
        coursesContainer = coursesElement;
        specialitiesContainer = specialitiesElement;
        mainContainer = $("#mainContainer");

        studentSearchButton = $("#studentSearchButton");
        addNewStudent = $("#addNewStudent");
        pagingButtons = $(".paging");
        studentsTable = $("#studentsTable");
        errorsContainer = $("#errorsContainer");
        errorsContainer.text("");
        attachEvents();
    }

    function attachEvents(){
        studentsFirstPageButton = $(".studentsFirstPageButton");
        studentsPreviousPageButton = $(".studentsPreviousPageButton");
        studentsNextPageButton = $(".studentsNextPageButton");
        studentsLastPageButton = $(".studentsLastPageButton");

        studentsPreviousPageButton.on("click",function(event){
            populateStudentsTable(currentPage - 1, currentOrder, currentFilters );
        });

        studentsNextPageButton.on("click",function(){
            populateStudentsTable(currentPage + 1, currentOrder, currentFilters );
        });

        studentsFirstPageButton.on("click",function(){
            populateStudentsTable(1, currentOrder, currentFilters );
        });

        studentsLastPageButton.on("click",function(){
            populateStudentsTable(lastPage, currentOrder, currentFilters );
        });

        studentSearchButton.on("click", function(event){
            event.preventDefault();
            populateStudentsTable(1, [], getFilterValues());
        });

        addNewStudent.on("click",function(){
            loadAddEditForm(addStudentHandler);
        });

        studentsTable.on('click', function(e) {
            var element = $(e.target);
            var studentId = element.attr('data-id');
            if(element.hasClass('edit')) {
                currentEditStudentId = studentId;
                loadAddEditForm(editStudentHandler);
            }
            else if(element.hasClass('delete')) {
                var response = confirm('Сигурен ли сте, че искате да изтриете този студент?');
                if(response) {
                    studentsPageService.deleteStudent(studentId, function(){
                            var pageToGo = (currentPage == lastPage) ? --currentPage : currentPage;
                            if(pageToGo < 1) {
                                pageToGo = 1;
                            }
                            populateStudentsTable(pageToGo, currentOrder, currentFilters );
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
        mainContainer.load("/pages/studentAdd.html", function() {
            addStudentButton = $("#addStudentButton");
            //studentAddUserName = $("#studentAddUserName");
            //studentAddPassword = $("#studentAddPassword");
            //studentAddPasswordMatch = $("#studentAddPasswordMatch");
            studentAddEmail = $("#studentAddEmail");
            studentAddFirstName = $("#studentAddFirstName");
            studentAddFamilyName = $("#studentAddFamilyName");
            studentAddFacultyNumber = $("#studentAddFacultyNumber");
            studentAddGenerateSpeciality = $("#studentAddGenerateSpeciality");
            studentAddGenerateFormOfEducation = $("#studentAddGenerateFormOfEducation");
            studentAddCourse = $("#studentAddCourse");


            handler();
        });
    }

    function addStudentHandler() {
        coursePageService.getAllCourses(
            function(data){
                var options = generateCourseOptions(data, true);
                studentAddCourse.html(options);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

        specialitiesPageService.getAllSpecialities(
            function(data){
                var options = generateSpecialitiesOptions(data, true);

                studentAddGenerateSpeciality.html(options);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);

            }
        );

        addStudentButton.on("click", function (event) {
            event.preventDefault();
            errorsContainer.text('');

            var data = getFormData();

            studentsPageService.addStudent(data, function () {
                    uiController.loadStudentPage();
                },
                function (error) {
                    printErrors(error.responseJSON.errors);
                }
            );
        });
    }

    function editStudentHandler() {
        var studentFormHeader = $("#studentFormHeader");
        studentFormHeader.text("Редактиране на студент");
        addStudentButton.val("Редактирай");
        reject = $("#reject");

        reject.on("click",function(event){
            event.preventDefault();
            uiController.loadStudentPage();
        });

        studentsPageService.getStudentById(currentEditStudentId,function(data) {
                studentAddFirstName.val(data.firstName);
                studentAddFamilyName.val(data.lastName);
                studentAddFacultyNumber.val(data.facultyNumber);
                studentAddGenerateSpeciality.text(data.specialityName);
                studentAddEmail.val(data.email);

                coursePageService.getAllCourses(
                    function(data){
                        var options = generateCourseOptions(data, true);
                        studentAddCourse.html(options);
                    },
                    function(error){
                        errorsContainer.text(error.responseJSON.errorMessage);
                    }
                );

                specialitiesPageService.getAllSpecialities(
                    function(data){
                        var options = generateSpecialitiesOptions(data, true);

                        studentAddGenerateSpeciality.html(options);
                    },
                    function(error){
                        errorsContainer.text(error.responseJSON.errorMessage);

                    }
                );


                addStudentButton.on("click",function(event){
                    event.preventDefault();
                    var data = getFormData();
                    studentsPageService.updateStudent(currentEditStudentId, data, function(){

                            uiController.loadStudentPage();
                        },
                        function (error) {
                            printErrors(error.responseJSON.errors);
                        }
                    );

                });
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

    }

    function getFormData(){
        return {
            'firstName': studentAddFirstName.val(),
            'lastName' : studentAddFamilyName.val(),
            'facultyNumber' : studentAddFacultyNumber.val(),
            'email' : studentAddEmail.val(),
            'courseId' : studentAddCourse.val(),
            'specialityId' : studentAddGenerateSpeciality.val(),
            'educationForm' : studentAddGenerateFormOfEducation.val()

        };
    }

    function getFilterValues(){
        return {
            'name': filterByName.val(),
            'facultyNumber': filterByFacultyNumber.val(),
            'email' : filterByEmail.val(),
            'courseId' : studentCourse.val(),
            'specialityId' : studentSpecialities.val()
        };
    }

    function manageButtonsState(){
        studentsFirstPageButton.prop('disabled', false);
        studentsPreviousPageButton.prop('disabled', false);
        studentsNextPageButton.prop('disabled', false);
        studentsLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            studentsFirstPageButton.prop('disabled', true);
            studentsPreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            studentsNextPageButton.prop('disabled', true);
            studentsLastPageButton.prop('disabled', true);
        }
    }

    function loadStudentsPage(page, order, filters) {
        populateStudentsTable(page, order, filters);

        coursePageService.getAllCourses(
            function(data){
                var options = generateCourseOptions(data);
                coursesContainer.html(options);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

        specialitiesPageService.getAllSpecialities(
            function(data){
                var options = generateSpecialitiesOptions(data);
                specialitiesContainer.html(options);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);

            }
        );



    }

    function populateStudentsTable(page, order, filters){
        studentsPageService.getAllStudents(page, order, filters,
            function(data){
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;
                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if(data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                studentCurrentPageContainer.text(currentPage + " от " + lastPage);

                manageButtonsState();
                studentsTable.show();
                pagingButtons.show();
                studentCurrentPageContainer.show();
                errorsContainer.text("");
                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
                studentsTable.hide();
                pagingButtons.hide();
                studentCurrentPageContainer.hide();
            }
        );
    }

    function generateSpecialitiesOptions(data, withoutZeroOption){
        var specialitiesOptions = (!withoutZeroOption ? "<option value='0'>Всички</option>" : "");
        for(var i = 0; i < data.specialities.length; i++){
            specialitiesOptions += "<option value='" + data.specialities[i].id + "'>" + data.specialities[i].specialityLongName + "</option>";
        }
        return specialitiesOptions;
    }

    function generateCourseOptions(data, withoutZeroOption){
        var options = (!withoutZeroOption ? "<option value='0'>Всички</option>" : "");
        for(var i =0; i < data.courses.length ; i++){
             options += "<option value='" + data.courses[i].id+"'>" + data.courses[i].name + "</option>";
        }
        return options;
    }

    function generateUsersTable(usersData){
        $deleteButton = $(".delete");

        var table =
                "<table border='1'>" +
                "<thead>" +
                "<th>#</th>" +
                "<th>Име</th>" +
                "<th>E-mail</th>" +
                "<th>Факултетен номер</th>" +
                "<th colspan='2'>Операции</th>" +
                "</thead><tbody>";
        for(var i = 0; i < usersData.students.length; i++){
            table += "<tr>"+
                "<td>" + usersData.students[i].id + "</td>" +
                "<td>" + usersData.students[i].firstName + " " + usersData.students[i].lastName + "</td>" +
                "<td>" + usersData.students[i].email + "</td>" +
                "<td>" + usersData.students[i].facultyNumber + "</td>" +
                "<td class='edit' data-id='" + usersData.students[i].id + "'></td>" ;

                if(loginService.getRole() == "Администратор"){
                    table += "<td class='delete' data-id='" + usersData.students[i].id + "'></td>";
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
        loadStudentsPage: loadStudentsPage,
        initialize: initialize
    };
}());