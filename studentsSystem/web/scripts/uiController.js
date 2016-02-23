var uiController = (function(){
    var $maincontainer;
    var $homeButton;
    var $coursesButton;
    var $specialitiesButton;
    var $subjectsButton;
    var $students;
    var $users;
    var $grades;
    var $profileButton;
    var $exitButton;
    var $loginButton;

    function initialize() {
        $maincontainer = $("#mainContainer");
        $homeButton = $("#homeButton");
        $coursesButton = $("#coursesButton");
        $specialitiesButton = $("#specialitiesButton");
        $subjectsButton = $("#subjectsButton");
        $students = $("#students");
        $users = $("#users");
        $grades = $("#grades");
        $profileButton = $("#profileButton");
        $exitButton = $("#exitButton");
        $loginButton = $("#loginButton");

        loadHomePage();
    }

    function initializeNavigation() {
        $homeButton.on("click", loadHomePage);

        $loginButton.on("click", function () {
            $maincontainer.load("/pages/loginForm.html", function () {
                loginController.initialize();
            });
        });


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
            loginController.logout();
        });

        updateAvailableButtons();
    }

    function updateLayout() {
        updateAvailableButtons();
        loadHomePage();
    }

    function updateAvailableButtons() {
        var isUserLoggedIn = loginService.getApiKey();

        if (!isUserLoggedIn) {
            $loginButton.show();
            $coursesButton.hide();
            $specialitiesButton.hide();
            $subjectsButton.hide();
            $students.hide();
            $users.hide();
            $grades.hide();
            $profileButton.hide();
            $exitButton.hide();
        }
        else {
            $loginButton.hide();
            $coursesButton.show();
            $specialitiesButton.show();
            $subjectsButton.show();
            $students.show();
            $users.show();
            $grades.show();
            $profileButton.show();
            $exitButton.show();
        }
    }

    function loadHomePage() {
        $maincontainer.load("/pages/home.html", function () {
            loadTable();
        });
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

    return {
        initializeNavigation: initializeNavigation,
        updateLayout: updateLayout,
        initialize: initialize
    };
}());