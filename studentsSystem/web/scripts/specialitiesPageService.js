var specialitiesPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        var url = config.API_URL + "speciality/" + page;
        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());