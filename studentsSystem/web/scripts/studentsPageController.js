var studentsPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;
    var $errorsContainer;
    var filterByName;
    var filterByEmail;
    var filterByFacultyNumber;
    var studentSearchButton;

    var container;
    var coursesContainer;
    var specialitiesContainer;

    var studentsFirstPageButton;
    var studentsPreviousPageButton;
    var studentsNextPageButton;
    var studentsLastPageButton;

    function initialize(containerElement, coursesElement, specialitiesElement) {
        filterByName = $("#studentName");
        filterByEmail =$("#studentEmail");
        filterByFacultyNumber = $("#studentFacultyNumber");
        studentSearchButton = $("#studentSearchButton");

        container = containerElement;
        coursesContainer = coursesElement;
        specialitiesContainer = specialitiesElement;

        $errorsContainer = $("#errorsContainer");
        $errorsContainer.text("");
        atachEvents();
    }

    function atachEvents(){
        studentsFirstPageButton = $(".studentsFirstPageButton");
        studentsPreviousPageButton = $(".studentsPreviousPageButton");
        studentsNextPageButton = $(".studentsNextPageButton");
        studentsLastPageButton = $(".studentsLastPageButton");

        studentsPreviousPageButton.on("click",function(event){
            loadPage(currentPage - 1, currentOrder, currentFilters );
        });

        studentsNextPageButton.on("click",function(){
            loadPage(currentPage + 1, currentOrder, currentFilters );
        });

        studentsFirstPageButton.on("click",function(){
            loadPage(1, currentOrder, currentFilters );
        });

        studentsLastPageButton.on("click",function(){
            loadPage(lastPage, currentOrder, currentFilters );
        });

        studentSearchButton.on("click", function(event){
            event.preventDefault();
            loadPage(1, [], getFilterValues());
        });

    }

    function getFilterValues(){
        return {
            'name': filterByName.val(),
            'facultyNumber': filterByFacultyNumber.val(),
            'email' : filterByEmail.val()
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

    function loadPage(page, order, filters) {
        studentsPageService.getUsers(page, order, filters,
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
                $errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

        coursePageService.getAllCourses(
            function(data){
                var options = generateCourseOptions(data);
                coursesContainer.html(options);
            },
            function(error){
                $errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

        specialitiesPageService.getAllSpecialities(
            function(data){
                var options = generateSpecialitiesOptions(data);
                specialitiesContainer.html(options);
            },
            function(error){
                $errorsContainer.text(error.responseJSON.errorMessage);
            }
        );

    }

    function generateSpecialitiesOptions(data){
        var specialitiesOptions = "";
        for(var i = 0; i < data.specialities.length; i++){
            specialitiesOptions += "<option value='"+data.specialities[i].id+"'>"+data.specialities[i].specialityLongName +"</option>";
        }
        return specialitiesOptions;
    }

    function generateCourseOptions(data){
        var options = "";
        for(var i =0; i < data.courses.length ; i++){
             options += "<option value='"+data.courses[i].id+"'>"+data.courses[i].name +"</option>";
        }
        return options;
    }

    function generateUsersTable(usersData){
        var table =
                "<table border='1'>" +
                "<thead>" +
                "<th>#</th>"+
                "<th>Име</th>"+
                "<th>E-mail</th>"+
                "<th>Факултетен номер</th>"+
                "<th colspan='2'>Операции</th>"+
                "</thead><tbody>";
        for(var i = 0; i < usersData.students.length; i++){
            table += "<tr>"+
                "<td>"+usersData.students[i].id+"</td>"+
                "<td>"+usersData.students[i].firstName+" "+usersData.students[i].lastName+"</td>"+
                "<td>"+usersData.students[i].email+"</td>"+
                "<td>"+usersData.students[i].facultyNumber+"</td>"+
                "<td class='edit' data-id='" + usersData.students[i].id + "'></td>"+
                "<td class='delete'></td>";
        }
        table += "</tbody></table>";
        return table;
    }

    return {
        loadPage: loadPage,
        initialize: initialize
    };
}());