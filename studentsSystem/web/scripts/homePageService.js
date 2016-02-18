var homePageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        httpRequester.getJSON("/mocks/users.json",success,error,complete);
    }

    return {
         getUsers : getUsers
    };

}());