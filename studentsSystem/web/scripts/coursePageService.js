var coursePageService = (function(){
    function getCourses(page,order,filters,success,error,complete){
        var url = config.API_URL + "course/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    function getAllCourses(success,error,complete) {
        var url = config.API_URL + "course/all";

        httpRequester.getJSON(url,success,error,complete);
    }

    function addCourse(data, success, error, complete) {
        var url = config.API_URL + "add/course";

        httpRequester.postJSON(url, data, success, error, complete);
    }

    return {
        getCourses : getCourses,
        addCourse: addCourse,
        getAllCourses: getAllCourses
    };

}());

