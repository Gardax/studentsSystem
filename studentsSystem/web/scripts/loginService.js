var loginService = (function(){
    function login(formData,success,error,complete){
        var url = config.API_URL + "user/authenticate";
        httpRequester.postJSON(url, formData, function (data) {
            saveApiKey(data.apiKey);
            localStorage.setItem('username', data.username);
            localStorage.setItem('role', data.role.roleName);
            success(data);
        }, error, complete);
    }

    function saveApiKey(apiKey) {
        localStorage.setItem('apiKey', apiKey);
    }

    function getUserName(){
        return localStorage.getItem('username');
    }

    function getRole(){
        return localStorage.getItem('role');
    }

    function getApiKey() {
        return localStorage.getItem('apiKey');
    }

    function logout() {
        localStorage.removeItem('apiKey');
        localStorage.removeItem('role');
        localStorage.removeItem('username');
    }

    return {
        login : login,
        getApiKey : getApiKey,
        logout : logout,
        getRole : getRole,
        getUserName : getUserName
    };

}());