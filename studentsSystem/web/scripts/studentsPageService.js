var studentsPageService = (function(){

    function getAllStudents(page,order,filters,success,error,complete){
        var url = config.API_URL + "student/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }
        httpRequester.getJSON(url,success,error,complete);
    }

    function getStudentById(studentId, success, error, complete){
        var url = config.API_URL + "student/single/" + studentId;

        httpRequester.getJSON(url,success,error,complete);
    }

    function addStudent(data, success, error, complete) {
        var url = config.API_URL + "student/add";

        httpRequester.postJSON(url, data, success, error, complete);
    }

    function updateStudent(studentId, data, success, error, complete){
        var url = config.API_URL + "student/edit/" + studentId;

        httpRequester.putJSON(url, data, success, error, complete)
    }

    function deleteStudent(studentId, success, error, complete) {
        var url = config.API_URL + "student/delete/" + studentId;

        httpRequester.deleteJSON(url, success, error, complete);
    }



    return {
        getAllStudents : getAllStudents,
        deleteStudent : deleteStudent,
        addStudent : addStudent,
        getStudentById : getStudentById,
        updateStudent : updateStudent
    };

}());