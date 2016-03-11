var specialitiesPageController = (function(){
    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var $searchInput;
    var specialitiesTable;

    var container;
    var $specialitiesCurrentPageContainer;
    var errorsContainer;
    var mainContainer;
    var addNewSpeciality;

    var $specialitiesSearchButton;
    var $pagingButtons;
    var addSpecialityButton;
    var specialityAddSpecialityNameInput;
    var specialitiesAddShortName;

    var specialitiesFirstPageButton;
    var specialitiesPreviousPageButton;
    var specialitiesNextPageButton;
    var specialitiesLastPageButton;

    var currentEditSpecialityId;

    function initializeSpecialitiesPage(containerElement) {
        mainContainer = $("#mainContainer");

        container = containerElement;

        addNewSpeciality = $("#addNewSpeciality");
        errorsContainer = $("#errorsContainer");
        $searchInput = $("#disciplinesSearch");
        $specialitiesSearchButton = $("#specialitiesSearchButton");
        $pagingButtons = $(".paging");
        $specialitiesCurrentPageContainer = $(".specialitiesCurrentPage");
        specialitiesTable = $("#specialitiesTable");
        errorsContainer.text("");
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

        addNewSpeciality.on("click", function(){
            loadAddEditForm(addSpecialityHandler);
        });

        specialitiesTable.on('click', function(e) {
            var element = $(e.target);
            var specialityId = element.attr('data-id');
            if(element.hasClass('edit')) {
                currentEditSpecialityId = specialityId;
                loadAddEditForm(editSpecialityHandler);
            }
            else if(element.hasClass('delete')) {
                var response = confirm('Сигурен ли сте, че искате да изтриете тази специалност?');
                if(response) {
                    specialitiesPageService.deleteSpeciality(specialityId, function(){
                            var pageToGo = (currentPage == lastPage) ? --currentPage : currentPage;
                            if(pageToGo < 1) {
                                pageToGo = 1;
                            }
                            loadSpecialitiesPage(pageToGo, currentOrder, currentFilters);
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
        mainContainer.load("/pages/specialitiesAdd.html", function() {
            addSpecialityButton = $("#addSpecialityButton");
            specialityAddSpecialityNameInput = $("#specialitiesAddFullName");
            specialitiesAddShortName = $("#specialitiesAddShortName");

            handler();
        });
    }

    function addSpecialityHandler() {
        addSpecialityButton.on("click", function (event) {
            event.preventDefault();
            errorsContainer.text('');

            var data = getFormData();
            specialitiesPageService.addSpeciality(data, function () {
                    uiController.loadSpecialitiesPage();
                },
                function (error) {
                    printErrors(error.responseJSON.errors);
                });
        });
    }

    function editSpecialityHandler() {
        var specialityFormHeader = $("#specialityFormHeader");
        specialityFormHeader.text("Редактиране на специалност");
        addSpecialityButton.val("Редактирай");

        specialitiesPageService.getSpecialityById(currentEditSpecialityId, function(data) {
                specialityAddSpecialityNameInput.val(data.specialityLongName);
                specialitiesAddShortName.val(data.specialityShortName);

                addSpecialityButton.on("click",function(event){
                    event.preventDefault();

                    var data = getFormData();
                    specialitiesPageService.updateSpeciality(currentEditSpecialityId, data, function(){
                            uiController.loadSpecialitiesPage();
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

                $specialitiesCurrentPageContainer.text(currentPage + " от " + lastPage);

                manageButtonsState();
                $pagingButtons.show();
                specialitiesTable.show();
                $specialitiesCurrentPageContainer.show();
                errorsContainer.text("");

                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
                $pagingButtons.hide();
                specialitiesTable.hide();
                $specialitiesCurrentPageContainer.hide();
            }
        );
    }


    function getFormData(){
        return {
            'longName': specialityAddSpecialityNameInput.val(),
            'shortName' : specialitiesAddShortName.val()
        };
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
                "<td class='edit' data-id='" + usersData.specialities[i].id + "'></td>" +
                "<td class='delete' data-id='" + usersData.specialities[i].id + "'></td>";
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
        loadSpecialitiesPage: loadSpecialitiesPage,
        initializeSpecialitiesPage : initializeSpecialitiesPage
    };
}());