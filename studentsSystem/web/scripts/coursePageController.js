var coursePageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var errorsContainer;
    var searchInput;
    var searchButton;
    var courseCurrentPageContainer;

    var pagingButtons;
    var courseTable;
    var reject;

    var addNewCourse;
    var courseAddCourseNameInput;
    var addCourseButton;

    var container;
    var mainContainer;
    var $deleteButton;

    var courseFirstPageButton;
    var coursePreviousPageButton;
    var courseNextPageButton;
    var courseLastPageButton;

    var currentEditCourseId;


    function initializeCoursePage(containerElement) {
        mainContainer = $("#mainContainer");
        container = containerElement;
        errorsContainer = $("#errorsContainer");
        searchInput = $("#nameSearch");
        courseCurrentPageContainer = $(".courseCurrentPage");
        searchButton = $("#searchButton");
        pagingButtons = $(".paging");
        errorsContainer.text("");
        addNewCourse = $("#addNewCourse");
        courseTable = $(".courseTable");
        attachEvents();
    }

    function attachEvents(){
        courseFirstPageButton = $(".courseFirstPageButton");
        coursePreviousPageButton = $(".coursePreviousPageButton");
        courseNextPageButton = $(".courseNextPageButton");
        courseLastPageButton = $(".courseLastPageButton");

        coursePreviousPageButton.on("click",function(){
            populateCoursePage(currentPage - 1, currentOrder, currentFilters );
        });

        courseNextPageButton.on("click",function(){
            populateCoursePage(currentPage + 1, currentOrder, currentFilters );
        });

        courseFirstPageButton.on("click",function(){
            populateCoursePage(1, currentOrder, currentFilters );
        });

        courseLastPageButton.on("click",function(){
            populateCoursePage(lastPage, currentOrder, currentFilters );
        });

        searchButton.on("click", function(event){
            event.preventDefault();
            populateCoursePage(1, [], getFilterValues());
        });

        addNewCourse.on("click",function(){
            loadAddEditForm(addCourseHandler);
        });

        courseTable.on('click', function(e) {
            var element = $(e.target);
            var courseId = element.attr('data-id');
            if(element.hasClass('edit')) {
                currentEditCourseId = courseId;
                loadAddEditForm(editCourseHandler);
            }
            else if(element.hasClass('delete')) {
                var response = confirm('Сигурен ли сте, че искате да изтриете този курс?');
                if(response) {
                    coursePageService.deleteCourse(courseId, function(){
                            var pageToGo = (currentPage == lastPage) ? --currentPage : currentPage;
                            if(pageToGo < 1) {
                                pageToGo = 1;
                            }
                            populateCoursePage(pageToGo, currentOrder, currentFilters );
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
        mainContainer.load("/pages/coursesAdd.html", function() {
            addCourseButton = $("#addCourseButton");
            courseAddCourseNameInput = $("#courseAddCourseNameInput");

            handler();
        });
    }

    function addCourseHandler() {
        addCourseButton.on("click", function (event) {
            event.preventDefault();
            errorsContainer.text('');

            var data = getFormData();
            coursePageService.addCourse(data, function () {
                    uiController.loadCoursePage();
                },
                function (error) {
                    printErrors(error.responseJSON.errors);
                }
            );
        });
    }

    function editCourseHandler() {
        var courseFormHeader = $("#courseFormHeader");
        courseFormHeader.text("Редактиране на курс");
        addCourseButton.val("Редактирай");

        reject = $("#reject");

        reject.on("click",function(event){
            event.preventDefault();
            uiController.loadCoursePage();
        });

        coursePageService.getCourseById(currentEditCourseId,function(data) {
                courseAddCourseNameInput.val(data.name);
                addCourseButton.on("click",function(event){
                    event.preventDefault();
                    var data = getFormData();
                    coursePageService.updateCourse(currentEditCourseId, data, function(){

                        uiController.loadCoursePage();
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

    function getFilterValues(){
        return {
            'name': searchInput.val()
        };
    }

    function getFormData(){
        return {
            'name': courseAddCourseNameInput.val()
        };
    }


    function manageButtonsState(){
        pagingButtons.show();

        courseFirstPageButton.prop('disabled', false);
        coursePreviousPageButton.prop('disabled', false);
        courseNextPageButton.prop('disabled', false);
        courseLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            courseFirstPageButton.prop('disabled', true);
            coursePreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            courseNextPageButton.prop('disabled', true);
            courseLastPageButton.prop('disabled', true);
        }
    }

    function populateCoursePage(page, order, filters) {
        coursePageService.getCourses(page, order, filters,
            function(data){
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if(data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                courseCurrentPageContainer.text(currentPage);
                errorsContainer.text('');

                courseCurrentPageContainer.show();
                manageButtonsState();

                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
                pagingButtons.hide();
                addNewCourse.hide();
                courseTable.hide();
                courseCurrentPageContainer.hide();
            }
        );
    }



    function generateUsersTable(usersData){
        $deleteButton = $(".delete");
        var table = "<table border='1'>"+
            "<thead>" +
            "<tr>" +
            "<th>#</th>" +
            "<th>Име</th>" +
            "<th colspan='2'>Операции</th>" +
            "</thead><tbody>";
            for(var i = 0; i < usersData.courses.length; i++){
                var student = usersData.courses[i];
                table += "<tr>" +
                "<td>" + student.id + "</td>" +
                "<td>" + student.name + "</td>" +
                "<td class='edit' data-id='" + student.id + "'></td>" ;
                if(loginService.getRole() == "Администратор"){
                    table += "<td class='delete' data-id='" + student.id + "'></td>";
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
        populateCoursePage: populateCoursePage,
        initializeCoursePage: initializeCoursePage
    };
}());