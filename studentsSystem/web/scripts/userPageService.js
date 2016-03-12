var userPageService = (function(){

    function getAllUsers(page ,order ,filters ,success ,error ,complete){

        var url = config.API_URL+"user/" + page ;

        if (Object.keys(filters).length !== 0) {

            url += "?" + $.param(filters);

        }

        httpRequester.getJSON(url ,success ,error, complete);
    }

    function getUserById(userId, success, error, complete){
        var url = config.API_URL + "user/single/" + userId;

        httpRequester.getJSON(url,success,error,complete);
    }

    function addUser(data, success, error, complete) {
        var url = config.API_URL + "user/add";

        httpRequester.postJSON(url, data, success, error, complete);
    }

    function updateUser(userId, data, success, error, complete){
        var url = config.API_URL + "user/edit/" + userId;

        httpRequester.putJSON(url, data, success, error, complete)
    }

    function deleteUser(userId, success, error, complete) {
        var url = config.API_URL + "user/delete/" + userId;

        httpRequester.deleteJSON(url, success, error, complete);
    }

    return {
        getAllUsers : getAllUsers,
        getUserById : getUserById,
        addUser : addUser,
        updateUser : updateUser,
        deleteUser : deleteUser
    };

}());