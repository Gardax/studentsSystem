var studentsPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var container;

    var studentsFirstPageButton;
    var studentsPreviousPageButton;
    var studentsNextPageButton;
    var studentsLastPageButton;

    function initizlize(containerElement) {
        container = containerElement;
        atachEvents();
    }

    function atachEvents(){
        studentsFirstPageButton = $(".studentsFirstPageButton");
        studentsPreviousPageButton = $(".studentsPreviousPageButton");
        studentsNextPageButton = $(".studentsNextPageButton");
        studentsLastPageButton = $(".studentsLastPageButton");

        studentsPreviousPageButton.on("click",function(){
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

    }

    function manageButtonsState(){
        if(currentPage == 1) {
            studentsFirstPageButton.prop('disabled', true);
            studentsPreviousPageButton.prop('disabled', true);
            studentsNextPageButton.prop('disabled', false);
            studentsLastPageButton.prop('disabled', false);
        }
        else if(currentPage == lastPage) {
            studentsFirstPageButton.prop('disabled', false);
            studentsPreviousPageButton.prop('disabled', false);
            studentsNextPageButton.prop('disabled', true);
            studentsLastPageButton.prop('disabled', true);
        }
        else {
            studentsFirstPageButton.prop('disabled', false);
            studentsPreviousPageButton.prop('disabled', false);
            studentsNextPageButton.prop('disabled', false);
            studentsLastPageButton.prop('disabled', false);
        }
    }


    var $errorsContainer;

    //function initialize() {
    $errorsContainer = $("#errorsContainer");
    //}


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
                "<td class='edit'></td>"+
                "<td class='delete'></td>";
        }
        table += "</tbody></table>";
        return table;
    }

    return {
        loadPage: loadPage,
        initizlize: initizlize
    };
}());