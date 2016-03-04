var userPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;
    var errorsContainer;
    var pagingButtons;
    var container;
    var userTable;
    var studentName;
    var studentEmail;
    var userSearchButton;
    var userCurrentPageContainer;

    var userFirstPageButton;
    var userPreviousPageButton;
    var userNextPageButton;
    var userLastPageButton;

    function initialize(containerElement) {
        container = containerElement;
        pagingButtons = $(".paging");
        userSearchButton = $("#userSearchButton");
        errorsContainer = $("#errorsContainer");
        studentName = $("#studentName");
        userCurrentPageContainer = $(".userCurrentPage");
        studentEmail = $("#studentEmail");
        userTable = $("#userTable");
        errorsContainer.text("");
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

        userSearchButton.on("click", function(event){
            event.preventDefault();
            loadPage(1, [], getFilterValues());
        });

    }

    function getFilterValues(){
        return {
            'username': studentName.val(),
            'email': studentEmail.val()
        };
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

                userCurrentPageContainer.text(currentPage);

                manageButtonsState();
                userTable.show();
                pagingButtons.show();
                userCurrentPageContainer.show();
                errorsContainer.text("");
                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
                userTable.hide();
                pagingButtons.hide();
                userCurrentPageContainer.hide();
            }
        );
    }


    function manageButtonsState(){
        userFirstPageButton.prop('disabled', false);
        userPreviousPageButton.prop('disabled', false);
        userNextPageButton.prop('disabled', false);
        userLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            userFirstPageButton.prop('disabled', true);
            userPreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            userNextPageButton.prop('disabled', true);
            userLastPageButton.prop('disabled', true);
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
                "<td>"+usersData.users[i].id+"</td>"+
                "<td>"+usersData.users[i].username+"</td>"+
                "<td>"+usersData.users[i].email+"</td>"+
                "<td>"+usersData.users[i].roleName+"</td>"+
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