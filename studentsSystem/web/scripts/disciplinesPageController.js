var disciplinesPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;
    var errorsContainer;

    var disciplinesSearch;
    var disciplinesSearchButton;
    var pagingButtons;
    var disciplinesTable;

    var container;

    var disciplineFirstPageButton;
    var disciplinePreviousPageButton;
    var disciplineNextPageButton;
    var disciplineLastPageButton;

    function initizlize(containerElement) {
        container = containerElement;
        errorsContainer = $("#errorsContainer");
        disciplinesSearch = $("#disciplinesSearch");
        disciplinesSearchButton = $("#disciplinesSearchButton");
        pagingButtons = $(".paging");
        disciplinesTable = $("#disciplinesTable");
        errorsContainer.text("");
        atachEvents();
    }

    function atachEvents(){
        disciplineFirstPageButton = $(".disciplineFirstPageButton");
        disciplinePreviousPageButton = $(".disciplinePreviousPageButton");
        disciplineNextPageButton = $(".disciplineNextPageButton");
        disciplineLastPageButton = $(".disciplineLastPageButton");

        disciplinePreviousPageButton.on("click",function(){
            loadPage(currentPage - 1, currentOrder, currentFilters );
        });

        disciplineNextPageButton.on("click",function(){
            loadPage(currentPage + 1, currentOrder, currentFilters );
        });

        disciplineFirstPageButton.on("click",function(){
            loadPage(1, currentOrder, currentFilters );
        });

        disciplineLastPageButton.on("click",function(){
            loadPage(lastPage, currentOrder, currentFilters );
        });

        disciplinesSearchButton.on("click", function(event){
            event.preventDefault();
            loadPage(1, [], getFilterValues());
        });

    }

    function getFilterValues(){
        return {
            'name': disciplinesSearch.val()
        };
    }

    function loadPage(page, order, filters) {
        disciplinesPageService.getUsers(page, order, filters,
            function(data){
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if(data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                manageButtonsState();
                pagingButtons.show();
                disciplinesTable.show();
                errorsContainer.text("");
                var table = generateUsersTable(data);
                container.html(table);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
                pagingButtons.hide();
                disciplinesTable.hide();
            }
        );
    }



    function manageButtonsState(){
        pagingButtons.show();

        disciplineFirstPageButton.prop('disabled', false);
        disciplinePreviousPageButton.prop('disabled', false);
        disciplineNextPageButton.prop('disabled', false);
        disciplineLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            disciplineFirstPageButton.prop('disabled', true);
            disciplinePreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            disciplineNextPageButton.prop('disabled', true);
            disciplineLastPageButton.prop('disabled', true);
        }
    }


    function generateUsersTable(usersData){
        var table = "<table border='1'>" +
            "<thead>" +
            "<th>#</th>"+
            "<th>Име на дисциплината</th>"+
            "<th>Хорариум(Л)</th>"+
            "<th>Хорариум(У)</th>"+
            "<th colspan='2'>Операции</th>"+
            "</thead><tbody>";
        for(var i = 0; i < usersData.subjects.length; i++){
            table += "<tr>"+
                    "<td>"+usersData.subjects[i].id+"</td>"+
                    "<td>"+usersData.subjects[i].name+"</td>"+
                    "<td>"+usersData.subjects[i].workloadLectures+"</td>"+
                    "<td>"+usersData.subjects[i].workloadExercises+"</td>"+
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