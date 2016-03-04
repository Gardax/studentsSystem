var disciplinesPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var subjectsSearch;
    var subjectsSearchButton;

    var subjectsTable;

    var container;
    var errorsContainer;
    var subjectsCurrentPageContainer;

    var pagingButtons;

    var subjectsFirstPageButton;
    var subjectsPreviousPageButton;
    var subjectsNextPageButton;
    var subjectsLastPageButton;

    function initializeSubjectPage(containerElement) {
        container = containerElement;
        errorsContainer = $("#errorsContainer");
        subjectsSearch = $("#subjectsSearch");
        subjectsCurrentPageContainer = $(".subjectCurrentPage");
        subjectsSearchButton = $("#subjectsSearchButton");
        pagingButtons = $(".paging");
        subjectsTable = $("#subjectsTable");
        errorsContainer.text("");
        attachEvents();
    }

    function attachEvents(){
        subjectsFirstPageButton = $(".subjectFirstPageButton");
        subjectsPreviousPageButton = $(".subjectPreviousPageButton");
        subjectsNextPageButton = $(".subjectNextPageButton");
        subjectsLastPageButton = $(".subjectLastPageButton");

        subjectsFirstPageButton.on("click",function(){
            loadSubjectsPage(1, currentOrder, currentFilters );
        });

        subjectsPreviousPageButton.on("click",function(){
            loadSubjectsPage(currentPage - 1, currentOrder, currentFilters );
        });

        subjectsNextPageButton.on("click",function(){
            loadSubjectsPage(currentPage + 1, currentOrder, currentFilters );
        });

        subjectsLastPageButton.on("click",function(){
            loadSubjectsPage(lastPage, currentOrder, currentFilters );
        });

        subjectsSearchButton.on("click", function(event){
            event.preventDefault();
            loadSubjectsPage(1, [], getFilterValues());
        });

    }

    function getFilterValues(){
        return {
            'name': subjectsSearch.val()
        };
    }

    function loadSubjectsPage(page, order, filters) {
        subjectsPageService.getSubjects(page, order, filters,
            function(data){
                currentPage = page;
                currentFilters = filters;
                currentOrder = order;

                lastPage = parseInt(data.totalCount / data.itemsPerPage);
                if(data.totalCount % data.itemsPerPage != 0) {
                    lastPage++;
                }

                subjectsCurrentPageContainer.text(currentPage);

                manageButtonsState();
                pagingButtons.show();
                subjectsCurrentPageContainer.show();
                subjectsTable.show();
                errorsContainer.text("");

                var table = generateSubjectsTable(data);
                container.html(table);
            },
            function(error){
                errorsContainer.text(error.responseJSON.errorMessage);
                pagingButtons.hide();
                subjectsTable.hide();
                subjectsCurrentPageContainer.hide();
            }
        );
    }



    function manageButtonsState(){
        pagingButtons.show();

        subjectsFirstPageButton.prop('disabled', false);
        subjectsPreviousPageButton.prop('disabled', false);
        subjectsNextPageButton.prop('disabled', false);
        subjectsLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            subjectsFirstPageButton.prop('disabled', true);
            subjectsPreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            subjectsNextPageButton.prop('disabled', true);
            subjectsLastPageButton.prop('disabled', true);
        }
    }


    function generateSubjectsTable(usersData){
        var table = "<table border='1'>" +
            "<thead>" +
            "<th>#</th>" +
            "<th>Име на дисциплината</th>" +
            "<th>Хорариум(Л)</th>" +
            "<th>Хорариум(У)</th>" +
            "<th colspan='2'>Операции</th>" +
            "</thead><tbody>";
        for(var i = 0; i < usersData.subjects.length; i++){
            table += "<tr>" +
                    "<td>" + usersData.subjects[i].id + "</td>" +
                    "<td>" + usersData.subjects[i].name + "</td>" +
                    "<td>" + usersData.subjects[i].workloadLectures + "</td>" +
                    "<td>" + usersData.subjects[i].workloadExercises + "</td>" +
                    "<td class='edit'></td>" +
                    "<td class='delete'></td>";
        }
        table += "</tbody></table>";
        return table;
    }

    return {
        loadSubjectsPage: loadSubjectsPage,
        initializeSubjectPage: initializeSubjectPage
    };
}());