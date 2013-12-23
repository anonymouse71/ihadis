var IHadis = function () {

    var clip;

    var handleTranslationToggle = function() {

        $(".utility-toolbar a").live('click', function(){

            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');

            $(this).parent().parent().parent().parent().find(".surah").hide();
            $(this).parent().parent().parent().parent().find("." + $(this).data('id')).show();

        });

    }

    var handleLanguageToggle = function() {

        $('.translation-panel a').click(function(){

            var lang = $(this).data('id');
            $.cookie('lang', lang, { expires: 365, path: '/' });
            window.location.reload();

        });

    }

    var initZeroClipboard = function() {
        ZeroClipboard.setDefaults( { moviePath: '/bundles/ihadiscore/js/ZeroClipboard.swf' } );
        clip = new ZeroClipboard();
    }

    var handleHadithCopy = function() {
        $('.copy-hadith').click(function(){
            var hadithNum = $(this).data('id');
            var lang = $(this).parent().parent().find('.translation a.active').data('id');
            var content = $('#hadith-body-' + hadithNum + '-' + lang).text();
            console.log(content);
            clip.setText(content);
        })
    }

    return {

        init: function() {
            /*initZeroClipboard();
            handleHadithCopy();*/
            handleLanguageToggle();
            handleTranslationToggle();
        }

    }

}();