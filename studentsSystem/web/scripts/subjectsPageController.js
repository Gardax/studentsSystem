var disciplinesPageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var currentEditSubjectId;

    var subjectsSearch;
    var subjectsSearchButton;
    var $deleteButton;

    var subjectsTable;
    var reject;
    var results;
    var from = 0;
    var to = 0;

    var mainContainer;
    var container;
    var errorsContainer;
    var subjectsCurrentPageContainer;

    var pagingButtons;

    var subjectsFirstPageButton;
    var subjectsPreviousPageButton;
    var subjectsNextPageButton;
    var subjectsLastPageButton;

    var addNewSubjectButton;

    var addSubjectButton;
    var subjectNameInput;
    var subjectWorkLoadLecturesInput;
    var subjectWorkLoadExercisesInput

    function initializeSubjectPage(containerElement) {
        mainContainer = $("#mainContainer");
        container = containerElement;
        errorsContainer = $("#errorsContainer");
        subjectsSearch = $("#subjectsSearch");
        subjectsCurrentPageContainer = $(".subjectCurrentPage");
        subjectsSearchButton = $("#subjectsSearchButton");
        pagingButtons = $(".paging");
        subjectsTable = $("#subjectsTable");
        addNewSubjectButton = $("#addNewSubject");
        results = $(".results");

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

        addNewSubjectButton.on("click",function(){
            loadAddEditForm(addSubjectHandler);
        });

        subjectsTable.on('click', function(e) {
            var element = $(e.target);
            var subjectId = element.attr('data-id');
            if(element.hasClass('edit')) {
                currentEditSubjectId = subjectId;
                loadAddEditForm(editSubjectHandler);
            }
            else if(element.hasClass('delete')) {
                var response = confirm('Сигурен ли сте, че искате да изтриете тази дисциплина?');
                if(response) {
                    subjectsPageService.deleteSubject(subjectId, function(){
                            var pageToGo = (currentPage == lastPage) ? --currentPage : currentPage;
                            if(pageToGo < 1) {
                                pageToGo = 1;
                            }
                            loadSubjectsPage(pageToGo, currentOrder, currentFilters );
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
        mainContainer.load("/pages/subjectsAdd.html", function() {
            addSubjectButton = $("#addSubjectButton");
            subjectNameInput = $("#disciplineNameInput");
            subjectWorkLoadLecturesInput = $("#disciplineWorkLoadLecturesInput");
            subjectWorkLoadExercisesInput = $("#disciplineWorkLoadExerciseInput");

            handler();
        });
    }

    function addSubjectHandler() {
        addSubjectButton.on('click', function(event) {
            event.preventDefault();
            errorsContainer.text('');

            var data = getFormData();
            subjectsPageService.addSubject(data, function () {
                    uiController.loadSubjectsPage();
                },
                function (error) {
                    printErrors(error.responseJSON.errors);
                }
            );
        });
    }

    function editSubjectHandler() {
        var subjectFormHeader = $("#subjectFormHeader");
        subjectFormHeader.text("Редактиране на дисциплина");
        addSubjectButton.val("Редактирай");
        reject = $("#reject");

        reject.on("click",function(event){
            event.preventDefault();
            uiController.loadSubjectsPage();
        });

        subjectsPageService.getSubjectById(currentEditSubjectId,
            function(data) {
                subjectNameInput.val(data.name);
                subjectWorkLoadLecturesInput.val(data.workloadLectures);
                subjectWorkLoadExercisesInput.val(data.workloadExercises);

                addSubjectButton.on("click",function(event){
                    event.preventDefault();

                    var data = getFormData();
                    subjectsPageService.updateSubject(currentEditSubjectId, data,
                        function(){
                            uiController.loadSubjectsPage();
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

    function getFormData() {
        return {
            'name' : subjectNameInput.val(),
            'workloadLectures': subjectWorkLoadLecturesInput.val(),
            'workloadExercises': subjectWorkLoadExercisesInput.val()
        };
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

                subjectsCurrentPageContainer.text(currentPage + " от " + lastPage);

                if(currentPage == 1){
                    from = 1;
                }else{
                    from = (currentPage-1)* data.itemsPerPage+1;
                }

                if(data.totalCount < data.itemsPerPage){
                    to = data.totalCount;
                }else {
                    to = currentPage * data.itemsPerPage;
                }

                if(to > data.totalCount){
                    to = data.totalCount;
                }
                results.text("Резултати " +from +  " - " + to  + " от " + data.totalCount);

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
        $deleteButton = $(".delete");

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
                    "<td class='edit' data-id='" + usersData.subjects[i].id + "'></td>" ;

                    if(loginService.getRole() == "Администратор"){
                        table += "<td class='delete' data-id='" + usersData.subjects[i].id + "'></td>";
                    }else if(loginService.getRole() != "Администратор"){
                        $deleteButton.hide();
                    }
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
        loadSubjectsPage: loadSubjectsPage,
        initializeSubjectPage: initializeSubjectPage
    };
}());