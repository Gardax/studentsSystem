var assessmentPageService = (function(){

    function getAssessments(page,order,filters,success,error,complete){
        var url = config.API_URL+"assessment/"+page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    function getAssessmentById(assessmentId, success, error, complete){
        var url = config.API_URL + "assessment/single/" + assessmentId;

        httpRequester.getJSON(url,success,error,complete);
    }

    function addAssessment(data, success, error, complete) {
        var url = config.API_URL + "assessment/add";

        httpRequester.postJSON(url, data, success, error, complete);
    }

    function updateAssessment(assessmentId, data, success, error, complete){
        var url = config.API_URL + "assessment/edit/" + assessmentId;

        httpRequester.putJSON(url, data, success, error, complete)
    }


    function deleteAssessment(assessmentId, success, error, complete) {
        var url = config.API_URL + "assessment/delete/" + assessmentId;

        httpRequester.deleteJSON(url, success, error, complete);
    }




    return {
        getAssessments : getAssessments,
        getAssessmentById : getAssessmentById,
        addAssessment : addAssessment,
        updateAssessment : updateAssessment,
        deleteAssessment : deleteAssessment

    };

}());