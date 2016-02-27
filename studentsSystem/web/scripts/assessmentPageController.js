var assessmentPageController = (function(){
    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var $errorsContainer;

    var container;

    var assessmentFirstPageButton;
    var assessmentPreviousPageButton;
    var assessmentNextPageButton;
    var assessmentLastPageButton;

    function initialize(containerElement) {
        container = containerElement;
        $errorsContainer = $("#errorsContainer");
        $errorsContainer.text("");
        atachEvents();
    }

    function atachEvents(){
        assessmentFirstPageButton = $(".assessmentFirstPageButton");
        assessmentPreviousPageButton = $(".assessmentPreviousPageButton");
        assessmentNextPageButton = $(".assessmentNextPageButton");
        assessmentLastPageButton = $(".assessmentLastPageButton");

        assessmentPreviousPageButton.on("click",function(){
            loadPage(currentPage - 1, currentOrder, currentFilters );
        });

        assessmentNextPageButton.on("click",function(){
            loadPage(currentPage + 1, currentOrder, currentFilters );
        });

        assessmentFirstPageButton.on("click",function(){
            loadPage(1, currentOrder, currentFilters );
        });

        assessmentLastPageButton.on("click",function(){
            loadPage(lastPage, currentOrder, currentFilters );
        });

    }

    function loadPage(page, order, filters) {
        assessmentPageService.getUsers(page, order, filters,
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
    }

    function manageButtonsState(){
        assessmentFirstPageButton.prop('disabled', false);
        assessmentPreviousPageButton.prop('disabled', false);
        assessmentNextPageButton.prop('disabled', false);
        assessmentLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            assessmentFirstPageButton.prop('disabled', true);
            assessmentPreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            assessmentNextPageButton.prop('disabled', true);
            assessmentLastPageButton.prop('disabled', true);
        }
    }

    function generateUsersTable(usersData){
        var table = "<table border='1'>"+
            "<thead>" +
            "<tr>" +
            "<th>#</th>"+
            "<th>Име, Фамилия</th>"+
            "<th>Дисциплина</th>"+
            "<th>Оценка</th>"+
            "<th colspan='2'>Операции</th>"+
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
        loadPage: loadPage,
        initialize: initialize
    };
}());