var IHadisBackend = function () {

    var hadithCounter = 1;

    var handleShowHide = function() {

        $(".show-hide a").live('click', function(){
            $(this).parent().find(".form-group").slideToggle();
        });

    }

    var addMoreHadith = function() {

        var hadithFormContainer = $('#hadith-form-container');

        hadithFormContainer.append($('.hadith-form').html());
        hadithFormContainer.append('<iframe style="display: none;" name="iframe-' + hadithCounter + '"></iframe>');

        hadithFormContainer.find('.portlet').last().attr('id', 'portlet-' + hadithCounter);
        hadithFormContainer.find('form').last().attr('target', 'iframe-' + hadithCounter);
        hadithFormContainer.find('.caption').last().html('<i class="fa fa-reorder"></i> Hadith #' + hadithCounter);

        hadithCounter++;

        for (var i = 1; i < hadithCounter - 1; i++) {
            $('#portlet-' + i + '> .portlet-title > .tools > .collapse').click();
        }

    }

    var saveAllHadith = function() {

        var valid = true;

        $('#hadith-form-container [required]').each(function() {
            if ($(this).val() == ''){
                $(this).parent().addClass('has-error');
                valid = false;
            } else {
                $(this).parent().removeClass('has-error');
            }
        });

        if (valid) {

            $('#hadith-form-container form').submit();
            $.gritter.add('Saving all Hadiths.');
            setInterval(checkSaveCompletion, 5000);

        } else {

            bootbox.alert("Please enter all required fields marked in red.");

        }

    }

    var checkSaveCompletion = function() {

        var completed = 0;

        $('#hadith-form-container').find('iframe').each(function(){
            if ($(this).contents().find('body').text() == 'OK') {
                completed++;
            }
        });

        if (completed == hadithCounter - 1) {
            bootbox.alert("All the hadiths have been saved.");
            location.href = $('#cancel-btn').attr('href');
        }
    };

    var handleAddMore = function() {
        $('#add-more-hadith').click(function(){
           addMoreHadith();
        });
    };

    var handleSaveAll = function() {
        $('#save-btn').click(function(){
            saveAllHadith();
        });
    };

    var prepareConfirmationModal = function() {
        $(document).on('click', 'a.remove', function(e) {
            e.preventDefault();
            var link = this;

            $('#confirmation-msg').html($(this).data('message'));
            $('#confirmation-yes').on('click', function() {
                var callback = $(link).data('callback');
                window[callback](link);

                $('#confirmation').modal('hide');
            });

            $('#confirmation').modal('show');
        });

        // While the modal is hiding, nedd to clear message and event
        $('#confirmation').on('hidden.bs.modal', function (e) {
            $('#confirmation-msg').empty();
            $('#confirmation-yes').off();
        });
    };


    return {

        init: function() {
            handleShowHide();
            handleAddMore();
            handleSaveAll();
            prepareConfirmationModal();
        },

        addMoreHadtih: function() {
            addMoreHadith();
        },

        saveAllHadith: function() {
            saveAllHadith();
        }

    }

}();

// Some common callbacks
function forwardToUrl(link) {
    window.location = $(link).data('url');
}