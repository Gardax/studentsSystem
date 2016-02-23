var homePageService = (function(){
    function getUsers(page,order,filters,success,error,complete){
        var url = config.API_URL + "student/" + page + "?getFullInfo=1";
        httpRequester.getJSON(url,success,error,complete);
    }

    return {
         getUsers : getUsers
    };

}());