jQuery(function($){
    var image_fields = $('input[name="image"]');
    var align_fields = $('input[name="align"]');
    var agreement_checkbox = $('#agreement');
    var scape_id_field = $('#scape_id');

    $('.wrap input').change(function () {
        if (!is_form_filled()) {
            $('#shortcode-panel').hide();
        } else {
            build_shortcode();
            $('#shortcode-panel').show();
        }
    });

    scape_id_field.keyup(function () {
        scape_id_field.trigger('change');
    });

    function is_form_filled()
    {
        if (image_fields.filter(':checked').length == 0) {
            return false;
        }

        if (align_fields.filter(':checked').length == 0) {
            return false;
        }

        if (agreement_checkbox.filter(':checked').length == 0) {
            return false;
        }

        if (!scape_id_field.val()) {
            return false;
        }

        return true;
    }

    function build_shortcode()
    {
        var image_index = image_fields.filter(':checked').val();
        var align = align_fields.filter(':checked').val();
        var scape_id = scape_id_field.val();

        var params = '';
        params = 'image="' + image_index + '"';
        params += ' scapeid="' + scape_id + '"';

        if (align != 'none') {
            params += ' align="' + align + '"';
        }

        var shortcode = '[wpscape ' + params + ']';
        $('#shortcode').val(shortcode);
    }
});