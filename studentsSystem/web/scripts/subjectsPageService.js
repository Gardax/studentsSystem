var subjectsPageService = (function(){

    function getSubjects(page,order,filters,success,error,complete){
        var url = config.API_URL + "subject/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    function getAllSubjects(success,error,complete){
        var url = config.API_URL+"subject/all";

        httpRequester.getJSON(url,success,error,complete);
    }

    function getSubjectById(subjectId, success, error, complete){
        var url = config.API_URL + "subject/single/" + subjectId;

        httpRequester.getJSON(url,success,error,complete);
    }

    function addSubject(data, success, error, complete) {
        var url = config.API_URL + "subject/add";

        httpRequester.postJSON(url, data, success, error, complete);
    }

    function deleteSubject(subjectId, success, error, complete) {
        var url = config.API_URL + "subject/delete/" + subjectId;

        httpRequester.deleteJSON(url, success, error, complete);
    }

    function updateSubject(subjectId, data, success, error, complete){
        var url = config.API_URL + "subject/edit/" + subjectId;

        httpRequester.putJSON(url, data, success, error, complete)
    }

    return {
        getSubjects : getSubjects,
        getAllSubjects : getAllSubjects,
        getSubjectById: getSubjectById,
        addSubject: addSubject,
        deleteSubject: deleteSubject,
        updateSubject: updateSubject
    };

}());