var studentsPageService = (function(){

    function getUsers(page,order,filters,success,error,complete){
        httpRequester.getJSON("/mocks/students.json",success,error,complete);
    }

    return {
        getUsers : getUsers
    };

}());