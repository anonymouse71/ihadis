var IHadis = function () {

    var handleTranslationToggle = function() {

        $(".translation a").live('click', function(){

            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');

            $(this).parent().parent().parent().parent().find(".surah").hide();
            $(this).parent().parent().parent().parent().find("." + $(this).data('id')).show();

        });

    }

    return {

        init: function() {
            handleTranslationToggle();
        }

    }

}();