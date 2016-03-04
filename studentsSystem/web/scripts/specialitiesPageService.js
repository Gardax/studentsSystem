var specialitiesPageService = (function(){

    function getSpecialities(page, order, filters, success, error, complete){
        var url = config.API_URL + "speciality/" + page;

        if (Object.keys(filters).length !== 0) {
            url += "?" + $.param(filters);
        }

        httpRequester.getJSON(url, success, error, complete);
    }

    function updateSpeciality(specialityId, data, success, error, complete){
        var url = config.API_URL + "speciality/edit/" + specialityId;

        httpRequester.putJSON(url, data, success, error, complete)
    }

    function addSpeciality(data, success, error, complete) {
        var url = config.API_URL + "speciality/add";

        httpRequester.postJSON(url, data, success, error, complete);
    }

    function getSpecialityById(specialityId, success, error, complete){
        var url = config.API_URL + "speciality/single/" + specialityId;

        httpRequester.getJSON(url,success,error,complete);
    }

    function getAllSpecialities(success, error, complete){
        var url = config.API_URL + "speciality/" + 1;

        httpRequester.getJSON(url,success,error,complete);
    }

    function deleteSpeciality(specialityId, success, error, complete) {
        var url = config.API_URL + "speciality/delete/" + specialityId;

        httpRequester.deleteJSON(url, success, error, complete);
    }

    return {
        getSpecialities : getSpecialities,
        getAllSpecialities : getAllSpecialities,
        updateSpeciality : updateSpeciality,
        getSpecialityById : getSpecialityById,
        addSpeciality : addSpeciality,
        deleteSpeciality: deleteSpeciality
    };

}());