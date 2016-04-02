var IHadis = function () {

    var handleHadithTools = function() {

        $('.hadis-tools li.explanation a').click(function(e) {
            e.preventDefault();
            $(this).closest('.hadith').find('.hadis-extra.explanation').slideToggle();
        });
        var tools= $('.social-lists li');

        $(tools).tooltip({});
        $(tools).live('click', function(){

            var action = $(this).data('action');

            if(action == undefined) {
                return;
            }

            var box = $(this).closest('.hadith');
            var hadithId = $(box).data('id');
            var title = $(box).data('title');

            var permalink = $(box).find('.permalink').attr('href');
            var content = box.find(".had > p").append(" ").text();
            var windowFeatures = 'width=626,height=436,menubar=no,toolbar=no,resizable=yes,scrollbars=yes';

           switch (action) {
               case 'report'      :
                   $('#report-hadith #comments').val("Assalamualaikum, \nThis report is about "+ permalink + " \n");
                   $('#report-modal').reveal(); break;
               case 'print'       : window.open(permalink, 'print', 'width=800,height=600').print(); break;
               case 'facebook'    : window.open('https://web.facebook.com/dialog/feed?link='+ permalink +'&name='+ title +'&description='+ content +'&redirect_uri=http%3A%2F%2Ffacebook.com%2F&_rdr', 'sharer', windowFeatures); break;
               case 'twitter'     : window.open('https://twitter.com/share?url=' + permalink + '&text=' + content.substr(0, 80) + '...\n&hashtags=hadith,sunnah,ihadis', 'sharer', windowFeatures); break;
           }

        });


        //$('#report-hadith').submit(function(e){
        //
        //    e.preventDefault();
        //    $('#report-submit-progress').show();
        //
        //    $.ajax({
        //        url: '/hadith/report',
        //        method: 'POST',
        //        data: $('#report-hadith').serialize(),
        //        success: function(res) {
        //            if (res == 'OK') {
        //                $('#report-submit-progress').hide();
        //                $('#email, #comments').val('');
        //                $('#report-modal').trigger('reveal:close');
        //            }
        //        }
        //    });
        //
        //});

    };

    var handleGoto = function() {
        $('#goto-submit').click(function(e) {
            e.preventDefault();

            var book = $('#goto-book').val();
            var hadis = $('#goto-hadis').val();
            if(hadis == false) {
                $('#goto-hadis').focus();
            } else {
                window.location = '/books/'+ book + '/hadis/'+ hadis;
            }
        })
    };

    var handleSearch = function() {

        var search = function(searchField) {
            console.log(searchField);

            var q = searchField.val();
            if(q == '') {
                searchField.focus();
            } else {
                window.location = '/search/'+ encodeURI(q);
            }
        };


        $('#q, #search2').keypress(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode == '13'){
                e.preventDefault();
                search($(this));
            }
        });

        $('#title-search').click(function (e) { search($('#q')) });
        $('#home-search').click(function (e) { search($('#search2')) });

        // Highlight search result
        var searchKeyword = window.searchKeyword || 'not-in-search-page';
        $(".hadith-des:contains("+ searchKeyword +")").each(function(){
            $(this).html(
                $(this).html().replace(searchKeyword, "<span class='highlighted'>"+ searchKeyword +"</span>")
            );
        });

    };

    var handleScrollEvents = function() {

        $(window).scroll(function() {
            if ($(window).scrollTop() > 750) $("#back-to-top").addClass('bttenabled');
            else $("#back-to-top").removeClass('bttenabled');

            if ($(window).scrollTop() > 25) { // this number is height of short banner + breadcrumbs - 40

                $(".fl").css({'margin-top': '60px'});
                $("#header").css('position', 'fixed');
            }
            else {
                $(".fl").css({'margin-top': '43px'});
                $("#header").css('position', 'relative');
            }
        });
    };

    var markdownToHtml = function(selector) {
        if('object' != typeof(markdown)) {
            console.error('Markdown parser markdown.js is not loaded');
        }

        var els = selector ? $(selector) : $('.markdown');
        els.each(function(i, el){
            $(el).html(markdown.toHTML($(el).text()));
        });
    };

    return {

        init: function() {
            $("html").niceScroll();  // The document page (body)
            $('.selectpicker').selectpicker();

            // markdownToHtml();
            handleHadithTools();
            handleGoto();
            handleSearch();
            handleScrollEvents();
        }
    }

}();