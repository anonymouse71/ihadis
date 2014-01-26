var IHadis = function () {

    var clip;

    var handleTranslationToggle = function() {

        $("#language-toggle").find("a").live('click', function(){
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

    var handleAuthenticityToggle = function() {

        $('.authenticity-selector a').click(function(){
            var selected = $(this).parent().hasClass('selected');
            var authType = $(this).data('id');
            $.cookie('auth-' + authType, (selected) ? 0 : 1, { expires: 365, path: '/' });
            window.location.reload();
        });

    }

    var handleHadithTools = function() {

        $('#hadith-tools').find('a').live('click', function(){

            var action = $(this).data('action');
            var hadith = $(this).data('id');

            var permalinkElement = $('#permalink-' + hadith);
            var permalink = permalinkElement.attr("href");
            var title = permalinkElement.attr("title");

            switch (action) {
                case 'report'   : $('#report-modal').reveal(); break;
                case 'print'    : window.open(permalink, 'print', 'width=800,height=600').print(); break;
                case 'facebook' : window.open('https://www.facebook.com/sharer/sharer.php?s=100&p[url]=' + permalink + '&p[title]=' + title, 'sharer', 'width=626,height=436'); break;
                case 'twitter'  : window.open('https://twitter.com/share?url=' + permalink + '&text=' + title + '&hashtags=hadith,sunnah,islam,ihadis', 'sharer', 'width=626,height=436'); break;
            }

        });

        $('#report-hadith').submit(function(e){

            e.preventDefault();
            $('#report-submit-progress').show();

            $.ajax({
                url: '/hadith/report',
                method: 'POST',
                data: $('#report-hadith').serialize(),
                success: function(res) {
                    if (res == 'OK') {
                        $('#report-submit-progress').hide();
                        $('#email, #comments').val('');
                        $('#report-modal').trigger('reveal:close');
                    }
                }
            });

        });

    }

    var handleChapterSelection = function() {

        $('#chapter-selection').select2();
        $('#section-selection').select2();

        $('#chapter-selection').change(function(){
            var url = chapterUrl.replace('100', $(this).val());
            window.location.href = url;
        });

        $('#section-selection').change(function(){
            $('html, body').animate({
                scrollTop: $('#section-' + $(this).val()).offset().top - 140
            }, 2000);
        });

    }

    var initZeroClipboard = function() {
        ZeroClipboard.setDefaults( { moviePath: '/bundles/ihadiscore/js/ZeroClipboard.swf' } );
        this.clip = new ZeroClipboard();
    }

    var handleHadithCopy = function() {
        $('.copy-hadith').click(function(){
            var hadithNum = $(this).data('id');
            var lang = $(this).parent().parent().find('.translation a.active').data('id');
            var content = $('#hadith-body-' + hadithNum + '-' + lang).text();
            console.log(content);
            this.clip.setText(content);
        })
    }

    return {

        init: function() {
            /*initZeroClipboard();
            handleHadithCopy();*/
            handleLanguageToggle();
            handleTranslationToggle();
            handleAuthenticityToggle();
            handleHadithTools();
            handleChapterSelection();
        }

    }

}();