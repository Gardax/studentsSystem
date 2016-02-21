var userPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        httpRequester.getJSON("/mocks/user.json",success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());