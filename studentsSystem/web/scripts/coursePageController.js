var coursePageController = (function(){

    var currentPage = 1;
    var currentFilters = [];
    var currentOrder = [];
    var lastPage =1;

    var errorsContainer;
    var searchInput;
    var searchButton;
    var pagingButtons;

    var addNewCourse;
    var courseAddCourseNameInput;
    var addCourseButton;

    var container;
    var $maincontainer;

    var courseFirstPageButton;
    var coursePreviousPageButton;
    var courseNextPageButton;
    var courseLastPageButton;


    function initizlize(containerElement) {
        $maincontainer = $("#mainContainer");
        container = containerElement;
        errorsContainer = $("#errorsContainer");
        searchInput = $("#nameSearch");
        searchButton = $("#searchButton");
        pagingButtons = $(".paging");
        errorsContainer.text("");
        addNewCourse = $("#addNewCourse");
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

        searchButton.on("click", function(event){
            event.preventDefault();
            loadPage(1, [], getFilterValues());
        });

        addNewCourse.on("click",function(){
            $maincontainer.load("/pages/coursesAdd.html", function(){
                addCourseButton = $("#addCourseButton");
                courseAddCourseNameInput = $("#courseAddCourseNameInput");
                addCourseButton.on("click",function(event){
                    event.preventDefault();
                    var data = getFormData();

                    coursePageService.addCourse(data, function(){
                        //TODO: Load table with all courses.
                        alert("added");
                    },
                    function(){
                        //TODO: sHOw error
                        alert("error");
                    });

                })
            });

        });


    }

    function getFilterValues(){
        return {
            'name': searchInput.val()
        };
    }

    function getFormData(){
        return {
            'name': courseAddCourseNameInput.val()
        };
    }


    function manageButtonsState(){
        pagingButtons.show();

        courseFirstPageButton.prop('disabled', false);
        coursePreviousPageButton.prop('disabled', false);
        courseNextPageButton.prop('disabled', false);
        courseLastPageButton.prop('disabled', false);

        if(currentPage == 1) {
            courseFirstPageButton.prop('disabled', true);
            coursePreviousPageButton.prop('disabled', true);
        }

        if(currentPage == lastPage) {
            courseNextPageButton.prop('disabled', true);
            courseLastPageButton.prop('disabled', true);
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
                container.text(error.responseJSON.errorMessage);
                $pagingButtons.hide();
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
                var student = usersData.courses[i];
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