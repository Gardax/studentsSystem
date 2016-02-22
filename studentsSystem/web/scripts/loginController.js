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
                alert("wohoo");
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
    }

    return {
        initialize: initialize,
        logout: logout
    };
}());