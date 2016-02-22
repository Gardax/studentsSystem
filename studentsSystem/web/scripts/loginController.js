var loginController = (function(){
    function initialize(containerElement) {
        attachLoginFormEvents();
    }

    function attachLoginFormEvents() {
        var $loginForm = $('#loginForm');

        $loginForm.on('submit', function(event) {
            event.preventDefault();

            var data = getFormData();
            loginService.login(data, function() {
                uiController.updateLayout();
            })

        })
    }

    function getFormData() {
        return {
            email: $('#emailInput').val(),
            password: $('#passwordInput').val()
        }
    }

    function logout() {
        loginService.logout();
        uiController.updateLayout();
    }

    return {
        initialize: initialize,
        logout: logout
    };
}());