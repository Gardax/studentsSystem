var specialitiesPageController = (function(){
    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var $searchInput;
    var $specialitiesTable;

    var container;
    var $specialitiesCurrentPageContainer;
    var $errorsContainer;

    var $specialitiesSearchButton;
    var $pagingButtons;

    var specialitiesFirstPageButton;
    var specialitiesPreviousPageButton;
    var specialitiesNextPageButton;
    var specialitiesLastPageButton;

    function initializeSpecialitiesPage(containerElement) {
        container = containerElement;
        $errorsContainer = $("#errorsContainer");
        $searchInput = $("#disciplinesSearch");
        $specialitiesSearchButton = $("#specialitiesSearchButton");
        $pagingButtons = $(".paging");
        $specialitiesCurrentPageContainer = $(".specialitiesCurrentPage");
        $specialitiesTable = $("#specialitiesTable");
        $errorsContainer.text("");
        attachEvents();
    }

    function attachEvents(){
        specialitiesFirstPageButton = $(".specialitiesFirstPageButton");
        specialitiesPreviousPageButton = $(".specialitiesPreviousPageButton");
        specialitiesNextPageButton = $(".specialitiesNextPageButton");
        specialitiesLastPageButton = $(".specialitiesLastPageButton");

        specialitiesPreviousPageButton.on("click",function(){
            loadSpecialitiesPage(currentPage - 1, currentOrder, currentFilters );
        });

        specialitiesNextPageButton.on("click",function(){
            loadSpecialitiesPage(currentPage + 1, currentOrder, currentFilters );
        });

        specialitiesFirstPageButton.on("click",function(){
            loadSpecialitiesPage(1, currentOrder, currentFilters );
        });

        specialitiesLastPageButton.on("click",function(){
            loadSpecialitiesPage(lastPage, currentOrder, currentFilters );
        });

        $specialitiesSearchButton.on("click", function(event){
            event.preventDefault();
            loadSpecialitiesPage(1, [], getFilterValues());
        });

    }

    function loadSpecialitiesPage(page, order, filters) {
        specialitiesPageService.getSpecialities(page, order, filters,
            function(data){
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if(data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                $specialitiesCurrentPageContainer.text(currentPage);

                manageButtonsState();
                $pagingButtons.show();
                $specialitiesTable.show();
                $specialitiesCurrentPageContainer.show();
                $errorsContainer.text("");

                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                $errorsContainer.text(error.responseJSON.errorMessage);
                $pagingButtons.hide();
                $specialitiesTable.hide();
                $specialitiesCurrentPageContainer.hide();
            }
        );
    }

    function getFilterValues(){
        return {
            'longName': $searchInput.val()
        };
    }

    function manageButtonsState(){
        specialitiesFirstPageButton.prop('disabled', false);
        specialitiesPreviousPageButton.prop('disabled', false);
        specialitiesNextPageButton.prop('disabled', false);
        specialitiesLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            specialitiesFirstPageButton.prop('disabled', true);
            specialitiesPreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            specialitiesNextPageButton.prop('disabled', true);
            specialitiesLastPageButton.prop('disabled', true);
        }
    }

    function generateUsersTable(usersData){
        var table = "<table border='1'>" +
            "<thead>" +
            "<th>#</th>" +
            "<th>Пълно име</th>" +
            "<th>Абравиатура</th>" +
            "<th colspan='2'>Операции</th>" +
            "</thead><tbody>";
        for(var i = 0; i < usersData.specialities.length; i++){
            table += "<tr>" +
                "<td>" + usersData.specialities[i].id + "</td>" +
                "<td>" + usersData.specialities[i].specialityLongName + "</td>" +
                "<td>" + usersData.specialities[i].specialityShortName + "</td>" +
                "<td class='edit'></td>" +
                "<td class='delete'></td>";
        }
        table += "</tbody></table>";
        return table;
    }

    return {
        loadSpecialitiesPage: loadSpecialitiesPage,
        initializeSpecialitiesPage : initializeSpecialitiesPage
    };
}());