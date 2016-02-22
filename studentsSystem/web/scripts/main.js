(function(){
    $(document).ready(function(){
        initializeNavigation();

    });

    function initializeNavigation(){
        var $maincontainer = $("#mainContainer");
        var $homeButton = $("#homeButton");
        var $coursesButton = $("#coursesButton");
        var $specialitiesButton = $("#specialitiesButton");
        var $subjectsButton = $("#subjectsButton");
        var $students = $("#students");
        var $users = $("#users");
        var $grades = $("#grades");
        var $profileButton = $("#profileButton");
        var $exitButton = $("#exitButton");
        var $loginButton = $("#loginButton");

        var isUserLoggedIn = loginService.getApiKey();

        if(!isUserLoggedIn) {
            $coursesButton.hide();
            $specialitiesButton.hide();
            $subjectsButton.hide();
            $students.hide();
            $users.hide();
            $grades.hide();
            $profileButton.hide();
            $exitButton.hide();
        }

        $homeButton.on("click",function(){
            $maincontainer.load("/pages/home.html", function() {
                loadTable();
            });
        });

        $loginButton.on("click",function(){
            $maincontainer.load("/pages/loginForm.html", function() {
                loginController.initialize();
            });
        });

        if(isUserLoggedIn) {
            $users.on("click", function () {
                $maincontainer.load("/pages/user.html", function () {
                    userTable();
                });

            });

            $coursesButton.on("click", function () {
                $maincontainer.load("/pages/courses.html", function () {
                    loadCourseTable();
                });

            });

            $specialitiesButton.on("click", function () {
                $maincontainer.load("/pages/disciplines.html", function () {
                    loadDisciplinesTable();
                });

            });

            $subjectsButton.on("click", function () {
                $maincontainer.load("/pages/specialities.html", function () {
                    loadSpecialitiesTable();
                });

            });

            $students.on("click", function () {
                $maincontainer.load("/pages/students.html", function () {
                    loadStudentsTable();
                });
            });

            $exitButton.on("click", function () {
                //TODO: Refresh page. Reload navigation.
                loginController.logout();
                alert('Success');
            })
        }

    }

    function userTable(){
        var userTable = $("#userTable");
        studentsPageController.load(userTable);
    }

    function loadStudentsTable(){
        var studentsTable = $("#studentsTable");
        studentsPageController.initialize();
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