var userPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var container;

    var userFirstPageButton;
    var userPreviousPageButton;
    var userNextPageButton;
    var userLastPageButton;

    function initizlize(containerElement) {
        container = containerElement;
        atachEvents();
    }

    function atachEvents(){
        userFirstPageButton = $(".userFirstPageButton");
        userPreviousPageButton = $(".userPreviousPageButton");
        userNextPageButton = $(".userNextPageButton");
        userLastPageButton = $(".userLastPageButton");

        userPreviousPageButton.on("click",function(){
            loadPage(currentPage - 1, currentOrder, currentFilters );
        });

        userNextPageButton.on("click",function(){
            loadPage(currentPage + 1, currentOrder, currentFilters );
        });

        userFirstPageButton.on("click",function(){
            loadPage(1, currentOrder, currentFilters );
        });

        userLastPageButton.on("click",function(){
            loadPage(lastPage, currentOrder, currentFilters );
        });

    }

    function loadPage(page, order, filters) {
        userPageService.getUsers(page, order, filters,
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
        if(currentPage == 1) {
            userFirstPageButton.prop('disabled', true);
            userPreviousPageButton.prop('disabled', true);
            userNextPageButton.prop('disabled', false);
            userLastPageButton.prop('disabled', false);
        }
        else if(currentPage == lastPage) {
            userFirstPageButton.prop('disabled', false);
            userPreviousPageButton.prop('disabled', false);
            userNextPageButton.prop('disabled', true);
            userLastPageButton.prop('disabled', true);
        }
        else {
            userFirstPageButton.prop('disabled', false);
            userPreviousPageButton.prop('disabled', false);
            userNextPageButton.prop('disabled', false);
            userLastPageButton.prop('disabled', false);
        }
    }

    function generateUsersTable(usersData){
        var table = "<table border='1'>" +
            "<thead>" +
            "<th>#</th>"+
            "<th>Потребителско име</th>"+
            "<th>E-mail</th>"+
            "<th>Роля</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
        for(var i = 0; i < usersData.users.length; i++){
            table += "<tr>"+
                "<td>"+usersData.users[i].user_id+"</td>"+
                "<td>"+usersData.users[i].username+"</td>"+
                "<td>"+usersData.users[i].email+"</td>"+
                "<td>"+usersData.users[i].role+"</td>"+
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