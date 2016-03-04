var studentsPageService = (function(){

    function getAllStudents(page,order,filters,success,error,complete){
        var url = config.API_URL + "student/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }
        httpRequester.getJSON(url,success,error,complete);
    }

    return {
        getAllStudents : getAllStudents
    };

}());