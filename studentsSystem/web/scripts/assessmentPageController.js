var assessmentPageController = (function() {
    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage = 1;

    var errorsContainer;
    var assessmentStudentName;
    var assessmentDisciplineSelect;
    var container;
    var pagingButtons;
    var assessmentTable;

    var assessmentFirstPageButton;
    var assessmentPreviousPageButton;
    var assessmentNextPageButton;
    var assessmentLastPageButton;
    var assessmentSearchButton;

    function initialize(containerElement ,assessmentElement) {
        assessmentDisciplineSelect = assessmentElement;
        container = containerElement;
        errorsContainer = $("#errorsContainer");
        pagingButtons = $(".paging");
        assessmentTable = $("#assessmentTable");
        assessmentStudentName = $("assessmentStudentName");
        errorsContainer.text("");
        atachEvents();
    }

    function atachEvents() {
        assessmentFirstPageButton = $(".assessmentFirstPageButton");
        assessmentPreviousPageButton = $(".assessmentPreviousPageButton");
        assessmentNextPageButton = $(".assessmentNextPageButton");
        assessmentLastPageButton = $(".assessmentLastPageButton");
        assessmentSearchButton = $("#assessmentSearchButton");

        assessmentPreviousPageButton.on("click", function () {
            loadPage(currentPage - 1, currentOrder, currentFilters);
        });

        assessmentNextPageButton.on("click", function () {
            loadPage(currentPage + 1, currentOrder, currentFilters);
        });

        assessmentFirstPageButton.on("click", function () {
            loadPage(1, currentOrder, currentFilters);
        });

        assessmentLastPageButton.on("click", function () {
            loadPage(lastPage, currentOrder, currentFilters);
        });
        assessmentSearchButton.on("click", function(event){
            event.preventDefault();
            loadAssessments(1, [], getFilterValues());
        });

    }

    function getFilterValues(){
        return {
            //'name' : assessmentsName.val(),
            'subjectId' : assessmentDisciplineSelect.val()
        };
    }

    function loadPage(page, order, filters) {
        loadAssessments(page, order, filters);

        disciplinesPageService.getAllDisciplines(
            function(data) {
                var option = generateAssessmentsOptions(data);
                assessmentDisciplineSelect.html(option);
            }
        );
    }

    function loadAssessments(page, order, filters) {
        assessmentPageService.getUsers(page, order, filters,
            function (data) {
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if (data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                manageButtonsState();

                var table = generateUsersTable(data);
                container.html(table);
            },
            function (error) {
                errorsContainer.text(error.responseJSON.errorMessage);
                pagingButtons.hide();
                assessmentTable.hide();
            }
        );
    }

    function generateAssessmentsOptions(data){
        var option = "";
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
    function generateUsersTable(usersData) {
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
                "<td class='edit'></td>" +
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