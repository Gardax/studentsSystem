var coursePageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        var url = config.API_URL+"course/"+page

        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());