var httpRequester = (function () {
    function getJSON(url, success, error, complete) {
        $.ajax({
            url: url,
            type: "GET",
            timeout: 5000,
            contentType: "application/json",
            success: success,
            error: error,
            complete: complete
        });
    }

    function deleteJSON(url, success, error, complete) {
        $.ajax({
            url: url,
            type: "DELETE",
            timeout: 5000,
            contentType: "application/json",
            success: success,
            error: error,
            complete: complete
        });
    }

    function postJSON(url, data, success, error, complete) {
        $.ajax({
            url: url,
            type: "POST",
            contentType: "application/json",
            timeout: 5000,
            data: JSON.stringify(data),
            success: success,
            error: error,
            complete: complete
        });
    }

    function putJSON(url, data, success, error, complete) {
        $.ajax({
            url: url,
            type: "PUT",
            contentType: "application/json",
            timeout: 5000,
            data: JSON.stringify(data),
            success: success,
            error: error,
            complete: complete
        });
    }

    return {
        getJSON: getJSON,
        postJSON: postJSON,
        putJSON: putJSON,
        deleteJSON: deleteJSON
    };
}());