var loginService = (function(){
    function login(formData,success,error,complete){
        var url = config.API_URL + "user/authenticate";
        httpRequester.postJSON(url, formData, function (data) {
            saveApiKey(data.apiKey);
            success(data);
        }, error, complete);
    }

    function saveApiKey(apiKey) {
        localStorage.setItem('apiKey', apiKey);
    }

    function getApiKey() {
        return localStorage.getItem('apiKey');
    }

    function logout() {
        //TODO: Send request to the back end
        localStorage.removeItem('apiKey');
    }

    return {
        login : login,
        getApiKey: getApiKey,
        logout: logout
    };

}());