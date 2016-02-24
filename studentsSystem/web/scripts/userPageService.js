var userPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        var url = config.API_URL+"users/"+page;
        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());