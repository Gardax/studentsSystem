(function(){
    $(document).ready(function(){
        initializeNavigation();
    });

    function initializeNavigation(){
        var $homeButton = $("nav #homeButton");
        var $maincontainer = $("#mainContainer");
        $homeButton.on("click",function(){
            $maincontainer.load("/pages/home.html", function() {
                loadTable();
            });

        });
    }

    function loadTable(){
        var userTable = $("#userTable");
        homePageController.load(userTable);
    }
})();