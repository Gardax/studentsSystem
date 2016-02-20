var specialitiesPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        httpRequester.getJSON("/mocks/specialities.json",success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());