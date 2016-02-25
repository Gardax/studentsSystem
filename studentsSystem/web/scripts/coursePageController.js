var coursePageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var container;

    var courseFirstPageButton;
    var coursePreviousPageButton;
    var courseNextPageButton;
    var courseLastPageButton;

    function initizlize(containerElement) {
        container = containerElement;
        atachEvents();
    }

    function atachEvents(){
        courseFirstPageButton = $(".courseFirstPageButton");
        coursePreviousPageButton = $(".coursePreviousPageButton");
        courseNextPageButton = $(".courseNextPageButton");
        courseLastPageButton = $(".courseLastPageButton");

        coursePreviousPageButton.on("click",function(){
            loadPage(currentPage - 1, currentOrder, currentFilters );
        });

        courseNextPageButton.on("click",function(){
            loadPage(currentPage + 1, currentOrder, currentFilters );
        });

        courseFirstPageButton.on("click",function(){
            loadPage(1, currentOrder, currentFilters );
        });

        courseLastPageButton.on("click",function(){
            loadPage(lastPage, currentOrder, currentFilters );
        });

    }

    function manageButtonsState(){
        if(currentPage == 1) {
            courseFirstPageButton.prop('disabled', true);
            coursePreviousPageButton.prop('disabled', true);
            courseNextPageButton.prop('disabled', false);
            courseLastPageButton.prop('disabled', false);
        }
        else if(currentPage == lastPage) {
            courseFirstPageButton.prop('disabled', false);
            coursePreviousPageButton.prop('disabled', false);
            courseNextPageButton.prop('disabled', true);
            courseLastPageButton.prop('disabled', true);
        }
        else {
            courseFirstPageButton.prop('disabled', false);
            coursePreviousPageButton.prop('disabled', false);
            courseNextPageButton.prop('disabled', false);
            courseLastPageButton.prop('disabled', false);
        }
    }

    function loadPage(page, order, filters) {
        coursePageService.getUsers(page, order, filters,
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
        var table = "<table border='1'>"+
            "<thead>" +
            "<tr>" +
            "<th>#</th>"+
            "<th>Курс</th>"+
            "<th>Име</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
            for(var i = 0; i < usersData.courses.length; i++){
                student = usersData.courses[i];
                table += "<tr>"+
                "<td>"+student.id+"</td>"+
                "<td>"+student.name+"</td>"+
                "<td class='edit'></td>"+
                "<td class='delete'></td>";
            }


        table += "</tbody></table>";
        return table;
    }


    return {
        loadPage: loadPage,
        initialize: initizlize
    };
}());