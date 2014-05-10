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

        $('#hadith-tools a, .bottom-links a').live('click', function(){

            var action = $(this).data('action');
            var hadith = $(this).data('id');

            var permalinkElement = $('#permalink-' + hadith);
            var footnoteElement = $('#hadith-' + hadith).find('.surah-footnote');
            var explanationElement = $('#hadith-' + hadith).find('.surah-explanation');

            var permalink = permalinkElement.attr("href");
            var title = permalinkElement.attr("title");

            switch (action) {
                case 'report'      :
                    $('#report-hadith #comments').val("Assalamualaikum, \nThis report is about "+ permalink + " \n");
                    $('#report-modal').reveal(); break;
                case 'footnote'    : footnoteElement.slideToggle(); break;
                case 'explanation' : explanationElement.slideToggle(); break;
                case 'print'       : window.open(permalink, 'print', 'width=800,height=600').print(); break;
                case 'facebook'    : window.open('https://www.facebook.com/sharer/sharer.php?s=100&p[url]=' + permalink + '&p[title]=' + title, 'sharer', 'width=626,height=436'); break;
                case 'twitter'     : window.open('https://twitter.com/share?url=' + permalink + '&text=' + title + '&hashtags=hadith,sunnah,islam,ihadis', 'sharer', 'width=626,height=436'); break;
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

        $('.utility-toolbar .tip').miniTip({
            position: 'left'
        });

    }

    var handleChapterSelection = function() {

        $('#chapter-selection').change(function(){
            var url = chapterUrl.replace('100', $(this).val());
            window.location.href = url;
        });

        $('#section-selection').change(function(){
            $('html, body').animate({
                scrollTop: $('#section-' + $(this).val()).offset().top - 90
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
    };

    var handleGoto = function() {
        $('#goto_form').submit(function(e) {
            e.preventDefault();
            var book = $(this).find("[name='goto_book']").val();
            var hadith = $(this).find("[name='goto_hadith']").val();
            window.location = '/goto/'+ book + '/'+ hadith;
        })
    };

    var handleSearch = function() {

        var search = function() {
            var q = $('#q').val();
            window.location = '/search/'+q;
        };

        $('#q').keypress(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode == '13'){
                search();
            }
        });

        $('#title-search').click(search);

    };

    var handleCopy = function() {
        console.log('in func');
        var client = new ZeroClipboard( $("a.copy"), {
            moviePath: '/bundles/ihadisweb/js/ZeroClipboard.swf'
        });
        client.on( "ready", function (event) {
            console.log('ready');
        });
        client.on( "copy", function (event) {
            console.log('in callback');
            event.preventDefault();
            var clipboard = event.clipboardData;
            var hadith_id = $(this).data('id');
            console.log($('#hadith-body-'+ hadith_id +'-bn').html());
            clipboard.setData( "text/plain", $('#hadith-body-'+ hadith_id +'-bn').text());
            clipboard.setData( "text/html", $('#hadith-body-'+ hadith_id +'-bn').html() );
        });
    };

    return {

        init: function() {
            /*initZeroClipboard();
            handleHadithCopy();*/
            handleLanguageToggle();
            handleTranslationToggle();
            handleAuthenticityToggle();
            handleHadithTools();
            handleChapterSelection();
            handleGoto();
            handleSearch();
            handleCopy();
        },

        initSearch: function() {
            handleSearch();
        }
    }

}();