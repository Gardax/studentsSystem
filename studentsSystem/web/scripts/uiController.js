var uiController = (function(){
    var $mainContainer;
    var $homeButton;
    var $coursesButton;
    var $specialitiesButton;
    var $subjectsButton;
    var $students;
    var $users;
    var $studentAssessment;
    var $exitButton;
    var $loginButton;
    var $usernameSpan;

    function initialize() {
        $mainContainer = $("#mainContainer");
        $homeButton = $("#homeButton");
        $coursesButton = $("#coursesButton");
        $specialitiesButton = $("#specialitiesButton");
        $subjectsButton = $("#subjectsButton");
        $students = $("#students");
        $users = $("#users");
        $studentAssessment = $("#studentAssessment");
        $exitButton = $("#exitButton");
        $loginButton = $("#loginButton");

        $usernameSpan = $("#usernameSpan");

        loadHomePage();
    }

    function initializeNavigation() {
        $homeButton.on("click", loadHomePage);

        $loginButton.on("click", function () {
            $mainContainer.load("/pages/loginForm.html", function () {
                loginController.initialize();
            });
        });


        $users.on("click", function () {
            $mainContainer.load("/pages/user.html", function () {
                userTable();
            });

        });

        $studentAssessment.on("click", function () {
            $mainContainer.load("/pages/assessments.html", function () {
                loadAssessment();
            });

        });

        $coursesButton.on("click", loadCoursePage);

        $specialitiesButton.on("click", loadSubjectsPage);

        $subjectsButton.on("click", function () {
            $mainContainer.load("/pages/specialities.html", function () {
                loadSpecialitiesTable();
            });

        });

        $students.on("click", loadStudentPage);

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
            $exitButton.hide();

            $usernameSpan.parent().hide();
        }
        else {
            $loginButton.hide();
            $coursesButton.show();
            $specialitiesButton.show();
            $subjectsButton.show();
            $students.show();
            //TODO: Extract this as constant.
            if(loginService.getRole() == "Admin") {
                $users.show();
            }

            $studentAssessment.show();
            $exitButton.show();

            $usernameSpan.text(loginService.getUserName());
            $usernameSpan.parent().show();
        }
    }

    function loadHomePage() {
        $mainContainer.load("/pages/home.html", function () {
            loadTable();
        });
    }

    function loadCoursePage() {
        $mainContainer.load("/pages/courses.html", function () {
            loadCourseTable();
        });
    }

    function loadSubjectsPage() {
        $mainContainer.load("/pages/subjects.html", function () {
            loadSubjectTable();
        });
    }

    function loadSpecialityPage() {
        $mainContainer.load("/pages/specialities.html", function () {
            loadSpecialitiesTable();
        });

    }

    function loadStudentPage() {
        $mainContainer.load("/pages/students.html", function () {
            loadStudentsTable();
        });
    }

    function userTable(){
        var userTable = $("#userTable");

        userPageController.initializeUserPage(userTable);
        userPageController.loadUserPage(1, [], []);

    }

    function loadStudentsTable(){
        var studentsCoursesSelect = $("#studentCourse");
        var studentsTable = $("#studentsTable");
        var studentSpecialitiesSelect = $("#studentSpecialities");

        studentsPageController.initialize(studentsTable, studentsCoursesSelect, studentSpecialitiesSelect);


        studentsPageController.loadStudentsPage(1, [], []);
    }

    function loadSpecialitiesTable(){
        var specialitiesTable = $("#specialitiesTable");

        specialitiesPageController.initializeSpecialitiesPage(specialitiesTable);
        specialitiesPageController.loadSpecialitiesPage(1, [], []);

    }

    function loadCourseTable(){
        var courseTable = $("#courseTable");

        coursePageController.initializeCoursePage(courseTable);
        coursePageController.populateCoursePage(1, [], []);
    }

    function loadSubjectTable(){
        var subjectsTable = $("#subjectsTable");
        disciplinesPageController.initializeSubjectPage(subjectsTable);

        disciplinesPageController.loadSubjectsPage(1, [], []);


    }
    function loadAssessment(){
        var studentAssessment = $("#assessmentTable");
        var assessmentDisciplineSelect = $("#disciplineAssessment");

        assessmentPageController.initializeAssessmentsPage(studentAssessment ,assessmentDisciplineSelect);

        assessmentPageController.loadAssessmentsPage(1, [], []);
    }

    function loadTable(){
        var userTable = $("#userTable");
        var subjectsContainerElement = $("#subjectsContainer");
        homePageController.initializeHomePage(userTable, subjectsContainerElement);

        homePageController.loadPage(1, [], []);
    }

    return {
        initializeNavigation: initializeNavigation,
        updateLayout: updateLayout,
        initialize: initialize,
        loadCoursePage: loadCoursePage,
        loadSpecialitiesPage: loadSpecialityPage,
        loadSubjectsPage: loadSubjectsPage,
        loadStudentPage: loadStudentPage
    };
}());