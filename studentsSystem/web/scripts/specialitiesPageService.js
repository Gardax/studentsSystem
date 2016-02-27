var specialitiesPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        var url = config.API_URL + "speciality/" + page;
        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }
        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());