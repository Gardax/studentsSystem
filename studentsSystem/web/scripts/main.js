(function(){
    $(document).ready(function(){
        initializeNavigation();

    });

    function initializeNavigation(){
        var $maincontainer = $("#mainContainer");
        var $homeButton = $("nav #homeButton");
        var $coursesButton = $("#coursesButton");
        var $specialitiesButton = $("#specialitiesButton");
        var $subjectsButton = $("#subjectsButton");
        var $students = $("#students");
        var $users = $("#users");
        var $grades = $("#grades");
        var $profileButton = $("#profileButton");
        var $exitButton = $("#exitButton");


        $homeButton.on("click",function(){
            $maincontainer.load("/pages/home.html", function() {
                loadTable();
            });

        });

        $users.on("click",function(){
            $maincontainer.load("/pages/user.html", function() {
                userTable();
            });

        });

        $coursesButton.on("click",function(){
            $maincontainer.load("/pages/courses.html", function() {
                loadCourseTable();
            });

        });

        $specialitiesButton.on("click",function(){
            $maincontainer.load("/pages/disciplines.html", function() {
                loadDisciplinesTable();
            });

        });

        $subjectsButton.on("click",function(){
            $maincontainer.load("/pages/specialities.html", function() {
                loadSpecialitiesTable();
            });

        });

        $students.on("click",function(){
            $maincontainer.load("/pages/students.html", function() {
                loadStudentsTable();
            });

        });




    }

    function userTable(){
        var userTable = $("#userTable");
        studentsPageController.load(userTable);
    }

    function loadStudentsTable(){
        var studentsTable = $("#studentsTable");
        studentsPageController.load(studentsTable);
    }

    function loadSpecialitiesTable(){
        var specialitiesTable = $("#specialitiesTable");
        specialitiesPageController.load(specialitiesTable);
    }


    function loadCourseTable(){
        var courseTable = $("#courseTable");
        coursePageController.load(courseTable);
    }

    function loadDisciplinesTable(){
        var disciplinesTable = $("#disciplinesTable");
        disciplinesPageController.load(disciplinesTable);
    }

    function loadTable(){
        var userTable = $("#userTable");
        homePageController.load(userTable);
    }

})();