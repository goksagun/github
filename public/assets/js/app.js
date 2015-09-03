! function($) {

    $(function() {

        $('.disabled a').click(function (e) {
            e.preventDefault();
            return false;
        })

    })

}(jQuery)