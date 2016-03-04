var disciplinesPageService = (function(){

    function getDisciplines(page,order,filters,success,error,complete){
        var url = config.API_URL + "subject/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    function getAllDisciplines(success,error,complete){
        var url = config.API_URL+"subject/" + 1 ;

        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getDisciplines : getDisciplines,
        getAllDisciplines : getAllDisciplines
    };

}());