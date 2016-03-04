var userPageService = (function(){

    function getAllUsers(page ,order ,filters ,success ,error ,complete){

        var url = config.API_URL+"user/" + page ;

        if (Object.keys(filters).length !== 0) {

            url += "?" + $.param(filters);

        }

        httpRequester.getJSON(url ,success ,error, complete);
    }

    return {
        getAllUsers : getAllUsers
    };

}());