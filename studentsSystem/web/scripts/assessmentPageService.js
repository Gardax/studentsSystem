var assessmentPageService = (function(){

    function getAssessments(page,order,filters,success,error,complete){
        var url = config.API_URL+"assessment/"+page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getAssessments : getAssessments
    };

}());