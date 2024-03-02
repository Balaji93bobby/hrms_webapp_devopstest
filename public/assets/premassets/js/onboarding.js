$(document).ready(function() {


    // $('input[type="file"]').click(function() {
    //     console.log("here");
        // $('input[type="file"]').each(function() {
        //     if ($(this).attr('required') && $(this).val() == '') {
        //         var attr = $(this).attr('id');
        //         $('.'+attr+'_label').show();
        //     } else {
        //         var attr = $(this).attr('id');
        //         $('.'+attr+'_label').hide();
        //     }
        // });
    // });

    // $(".files").on('change',function(){
    //     //do whatever you want
    //     var val = $(this).val();
    //     var id = $(this).attr('id');
    //     $('#'+id+'_label').html(val);
    // });


    // $('.addfiles').on('click', function() {
    //     var attr = $(this).attr('data');
    //     $(attr).click();
    //     return false;
    // });

    $('body').on('click', '.validate', function() {
        $(this).removeClass('not-required');
    });

    $('body').on('keyup', '.validate', function() {
        var data = $(this).attr('name');
        if ($(this).val() == '') {
            $('.' + data + '_label').removeClass('patternErr');
        }
    });

    $('body').on('blur', '.validate', function() {
        if ($(this).val() == '') {
            $(this).addClass('not-required');
        } else {
            $(this).removeClass('not-required');
        }
    });


    // var current_fs, next_fs, previous_fs; //fieldsets
    // var opacity;
    // var current = 1;
    // var steps = $("fieldset").length;
    // setProgressBar(current);

});


$(function(){
    // Wrap your File input in a wrapper <div>
    var wrapper = $('<div/>').css({height:0,width:0,'overflow':'hidden'});
    var fileInput = $(':file').wrap(wrapper);

    // When your file input changes, update the text for your button
    fileInput.change(function(){
        $this = $(this);
        var attr = $(this).attr('id');
        // If the selection is empty, reset it
        if ($this.val().length == 0) {
            // var text = "Choose aadhar card";
            $('.'+attr+'_label').text(text);
            if ($(this).attr('vali') == 'required') {
                $('.'+attr+'_label').show();
            } else {
                $('.'+attr+'_label').hide();
            }
        } else {
            $('#'+attr+'_label').find('span').text($this.val());
        }
        //get the file.
        var file = $this[0].files[0];
        //transfer the file to the MVC/API controller via FormData.
    })

    //get the file.
    // var file = $this[0].files[0];
    //transfer the file to the MVC/API controller via FormData.

    // When your fake button is clicked, simulate a click of the file button
    $('.addfiles').click(function(){
        var data = $(this).attr('data');
      $(data).click();
    }).show();
});
