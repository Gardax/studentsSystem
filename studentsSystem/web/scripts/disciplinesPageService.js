var disciplinesPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        httpRequester.getJSON("/mocks/disiplines.json",success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());