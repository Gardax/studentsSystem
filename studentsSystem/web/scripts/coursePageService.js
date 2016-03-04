var coursePageService = (function(){
    function getCourses(page,order,filters,success,error,complete){
        var url = config.API_URL + "course/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url,success,error,complete);
    }

    function updateCourse(courseId, data, success, error, complete){
        var url = config.API_URL + "course/edit/" + courseId;

        httpRequester.putJSON(url, data, success, error, complete)
    }

    function getCourseById(courseId, success, error, complete){
        var url = config.API_URL + "course/single/" + courseId;

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

    function deleteCourse(courseId, success, error, complete) {
        var url = config.API_URL + "course/delete/" + courseId;

        httpRequester.deleteJSON(url, success, error, complete);
    }

    return {
        getCourses : getCourses,
        addCourse: addCourse,
        getAllCourses: getAllCourses,
        deleteCourse: deleteCourse,
        getCourseById: getCourseById,
        updateCourse: updateCourse
    };

}());

