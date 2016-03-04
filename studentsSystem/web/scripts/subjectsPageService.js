var subjectsPageService = (function(){

    function getSubjects(page,order,filters,success,error,complete){
        var url = config.API_URL + "subject/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    function getAllSubjects(success,error,complete){
        var url = config.API_URL+"subject/all" ;

        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getSubjects : getSubjects,
        getAllSubjects : getAllSubjects
    };

}());