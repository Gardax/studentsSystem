var homePageService = (function(){
    function getStudents(page,order,filters,success,error,complete){
        var url = config.API_URL + "student/" + page + "?getFullInfo=1";

        if (Object.keys(filters).length !== 0) {
            url += "&" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getStudents : getStudents
    };

}());