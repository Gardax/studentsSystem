var userPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var userCurrentPageContainer;
    var errorsContainer;
    var container;
    var userAddUsername ;
    var userAddFirstName ;
    var userAddFamilyName;
    var userAddPassword ;
    var userAddPasswordMatch ;
    var userAddEmail ;

    var userTable;
    var studentName;
    var studentEmail;
    var currentEditUserId;
    var addNewUser;
    var mainContainer;
    var addUserButton;

    var userFirstPageButton;
    var userPreviousPageButton;
    var userNextPageButton;
    var userLastPageButton;
    var userSearchButton;
    var pagingButtons;

    function initializeUserPage(containerElement) {
        studentName = $("#studentName");
        studentEmail = $("#studentEmail");
        userTable = $("#userTable");
        mainContainer = $("#mainContainer");
        container = containerElement;

        userCurrentPageContainer = $(".userCurrentPage");
        errorsContainer = $("#errorsContainer");
        errorsContainer.text("");

        pagingButtons = $(".paging");
        userSearchButton = $("#userSearchButton");
        addNewUser = $("#addNewUser");
        attachEvents();
    }

    function attachEvents(){
        userFirstPageButton = $(".userFirstPageButton");
        userPreviousPageButton = $(".userPreviousPageButton");
        userNextPageButton = $(".userNextPageButton");
        userLastPageButton = $(".userLastPageButton");


        userPreviousPageButton.on("click",function(){
            loadUserPage(currentPage - 1, currentOrder, currentFilters );
        });

        userNextPageButton.on("click",function(){
            loadUserPage(currentPage + 1, currentOrder, currentFilters );
        });

        userFirstPageButton.on("click",function(){
            loadUserPage(1, currentOrder, currentFilters );
        });

        userLastPageButton.on("click",function(){
            loadUserPage(lastPage, currentOrder, currentFilters );
        });

        userSearchButton.on("click", function(event){
            event.preventDefault();
            loadUserPage(1, [], getFilterValues());
        });
        addNewUser.on("click",function(){
            loadAddEditForm(addUserHandler);
        });

        userTable.on('click', function(e) {
            var element = $(e.target);
            var userId = element.attr('userId');
            if(element.hasClass('edit')) {
                currentEditUserId = userId;
                loadAddEditForm(editUserHandler);
            }
            else if(element.hasClass('delete')) {
                var response = confirm('Сигурен ли сте, че искате да изтриете този потребител?');
                if(response) {
                    userPageService.deleteUser(userId, function(){
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
        mainContainer.load("/pages/userAdd.html", function() {
            addUserButton = $("#addUserButton");
            userAddUsername = $("#userAddUsername");
            userAddFirstName = $("#userAddFirstName");
            userAddFamilyName = $("#userAddFamilyName");
            userAddPassword = $("#userAddPassword");
            userAddPasswordMatch = $("#userAddPasswordMatch");
            userAddEmail = $("#userAddEmail");


            handler();
        });
    }

    function addUserHandler() {
        addUserButton.on("click", function (event) {
            event.preventDefault();
            errorsContainer.text('');

            var data = getFormData();
            userPageService.addUser(data, function () {
                    uiController.loadUserPage();
                },
                function (error) {
                    printErrors(error.responseJSON.errors);
                }
            );
        });
    }

    function editUserHandler() {
        var userFormHeader = $("#userFormHeader");
        userFormHeader.text("Редактиране на потребител");
        addUserButton.val("Редактирай");

        userPageService.getUserById(currentEditUserId,function(data) {

                userAddUsername.val(data.username);
                userAddFirstName.val(data.firstName);
                userAddFamilyName.val(data.lastName);
                userAddEmail.val(data.email);

                addUserButton.on("click",function(event){
                    event.preventDefault();
                    var data = getFormData();
                    coursePageService.updateUser(currentEditUserId, data, function(){

                            uiController.loadUserPage();
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
            'username' : userAddUsername.val(),
            'firstName' : userAddFirstName.val(),
            'lastName' : userAddFamilyName.val(),
            'password' : userAddPassword.val(),
            'confirmPassword' : userAddPasswordMatch.val(),
            'email' : userAddEmail.val()
        };
    }

    function getFilterValues(){
        return {
            'username': studentName.val(),
            'email': studentEmail.val()
        };
    }

    function loadUserPage(page, order, filters) {
        userPageService.getAllUsers(page, order, filters,
            function(data){
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if(data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                manageButtonsState();
                userTable.show();
                pagingButtons.show();
                userCurrentPageContainer.show();

                userCurrentPageContainer.text(currentPage + " от " + lastPage);
                errorsContainer.text("");

                var table = populateUsersTable(data);
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



    function populateUsersTable(usersData){
        var table = "<table border='1'>" +
            "<thead>" +
            "<th> # </th>" +
            "<th> Потребителско име </th>" +
            "<th> E-mail </th>" +
            "<th> Роля </th>" +
            "<th colspan='2'>Операции</th>" +
            "</thead><tbody>";
        for(var i = 0; i < usersData.users.length; i++){
            table += "<tr>" +
                "<td>"+usersData.users[i].id + "</td>" +
                "<td>"+usersData.users[i].username + "</td>" +
                "<td>"+usersData.users[i].email + "</td>" +
                "<td>"+usersData.users[i].role.roleName + "</td>" +
                "<td class='edit' data-id='" + usersData.users[i].id + "'></td>" ;
                table += "<td class='delete' data-id='" + usersData.users[i].id + "'></td>";

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
        loadUserPage: loadUserPage,
        initializeUserPage: initializeUserPage
    };
}());