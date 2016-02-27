var uiController = (function(){
    var $maincontainer;
    var $homeButton;
    var $coursesButton;
    var $specialitiesButton;
    var $subjectsButton;
    var $students;
    var $users;
    var $studentAssessment;
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
        $studentAssessment = $("#studentAssessment");
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

        $studentAssessment.on("click", function () {
            $maincontainer.load("/pages/assessments.html", function () {
                loadAssessment();
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
            $studentAssessment.hide();
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
            $studentAssessment.show();
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

        userPageController.initizlize(userTable);
        userPageController.loadPage(1, [], []);

    }

    function loadStudentsTable(){
        var studentsTable = $("#studentsTable");

        studentsPageController.initialize(studentsTable);
        studentsPageController.loadPage(1, [], []);
    }

    function loadSpecialitiesTable(){
        var specialitiesTable = $("#specialitiesTable");

        specialitiesPageController.initialize(specialitiesTable);
        specialitiesPageController.loadPage(1, [], []);

    }

    function loadCourseTable(){
        var courseTable = $("#courseTable");

        coursePageController.initialize(courseTable);
        coursePageController.loadPage(1, [], []);
    }

    function loadDisciplinesTable(){
        var disciplinesTable = $("#disciplinesTable");
        disciplinesPageController.initizlize(disciplinesTable);

        disciplinesPageController.loadPage(1, [], []);


    }
    function loadAssessment(){
        var studentAssessment = $("#assessmentTable");
        assessmentPageController.initialize(studentAssessment);

        assessmentPageController.loadPage(1, [], []);
    }

    function loadTable(){
        var userTable = $("#userTable");
        homePageController.initialize(userTable);

        homePageController.loadPage(1, [], []);
    }

    return {
        initializeNavigation: initializeNavigation,
        updateLayout: updateLayout,
        initialize: initialize
    };
}());