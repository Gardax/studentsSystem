var studentsPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        var url = config.API_URL + "student/" + page;

        //if(filters) {
        //
        //}

        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());