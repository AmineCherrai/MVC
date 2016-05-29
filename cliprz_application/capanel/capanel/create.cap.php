<style type="text/css">
.capanel_field_width { width: 50%; }
.capanel_opacity { display: none; width: 100%; height: 100%; position: absolute; z-index: 99; background-color: #FFF; top: 0; left: 0; }
.capanel_alert { display: none; width: 300px; background-color: #FFF; color: #707070; position: absolute; z-index: 999; top: 0; left: 0; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; -moz-box-shadow: 0px 2px 5px #909090; -webkit-box-shadow: 0px 2px 5px #909090; box-shadow: 0px 2px 5px #909090; }
.capanel_alert_title { font-weight: bold; font-size: 15px; padding: 7px; border-bottom: 1px solid #DDD; }
.capanel_alert_message { padding: 10px; }
.capanel_alert_button { padding: 5px 10px; text-align: right; }
</style>

<div class="capanel_opacity"></div>
<div class="capanel_alert">
</div>

<form id="capanel_create_new_form" action="" method="POST">
<table id="capanel_create_new_table">
    <thead id="capanel_create_new_thead">
        <tr id="capanel_create_new_tr">
            <td colspan="2">Create new controller and forms.</td>
        </tr>
    </thead>
    <tbody id="capanel_create_new_tbody">
        <tr class="tbl1">
            <td class="capanel_field_width">Table</td>
            <td id="capanel_get_tables" class="capanel_field_width"></td>
        </tr>
        <tr id="capanel_use_primary_key" class="tbl2 hide">
            <td class="capanel_field_width">Do you want to use Primary key</td>
            <td class="capanel_field_width">
                <input type="radio" name="use_primary_key" value="1" /> Yes
                <input type="radio" name="use_primary_key" value="0" /> No
            </td>
        </tr>
        <tr id="capanel_select_primary_key" class="tbl1 hide">
            <td class="capanel_field_width">Select the Primary key</td>
            <td id="capanel_get_primary_key" class="capanel_field_width"></td>
        </tr>
        <tr id="capanel_use_add_action" class="tbl2 hide">
            <td class="capanel_field_width">Do you want use add action ?</td>
            <td class="capanel_field_width">
                <input type="radio" name="use_add_action" value="1" /> Yes
                <input type="radio" name="use_add_action" value="0" /> No
            </td>
        </tr>
        <tr id="capanel_use_edit_action" class="tbl1 hide">
            <td class="capanel_field_width">Do you want use edit action ?</td>
            <td class="capanel_field_width">
                <input type="radio" name="use_edit_action" value="1" /> Yes
                <input type="radio" name="use_edit_action" value="0" /> No
            </td>
        </tr>
        <tr id="capanel_use_delete_action" class="tbl2 hide">
            <td class="capanel_field_width">Do you want use delete action ?</td>
            <td class="capanel_field_width">
                <input type="radio" name="use_delete_action" value="1" /> Yes
                <input type="radio" name="use_delete_action" value="0" /> No
            </td>
        </tr>
        <tr id="capanel_use_repair_action" class="tbl1 hide">
            <td class="capanel_field_width">Do you want use repair table action ?</td>
            <td class="capanel_field_width">
                <input type="radio" name="use_repair_action" value="1" /> Yes
                <input type="radio" name="use_repair_action" value="0" /> No
            </td>
        </tr>
        <tr id="capanel_use_optimize_action" class="tbl2 hide">
            <td class="capanel_field_width">Do you want use optimize table action ?</td>
            <td class="capanel_field_width">
                <input type="radio" name="use_optimize_action" value="1" /> Yes
                <input type="radio" name="use_optimize_action" value="0" /> No
            </td>
        </tr>
    </tbody>
    <tfoot id="capanel_create_new_tfoot" class="hide">
        <tr>
            <td colspan="2" class="text-center">
                <input type="submit" id="start" value="Create" />
            </td>
        </tr>
    </tfoot>
</table>
<input type="hidden" name="create" value="new" />
</form>

<script type="text/javascript">
// Capanel create url.
var capanelCreateURL = '<?php echo cliprz::system(cap)->url(); ?>';

// CAPanel Language array.
var CAPlang = new Array();
CAPlang['loading_data'] = 'Please wait we are loading data ...';

/**
 * CAPanel jQuery plugin.
 *
 * @author Albert Nexgix.
 * This plugin used for Cliprz framework only in CAPanel system.
 */
(function ($){

    /**
     * Step 1
     * Get tables as a select tag via ajax and show #capanel_use_primary_key ID if table select change.
     */
    $.getTables = function ()
    {
        $.ajax({
            url : capanelCreateURL + 'get_tables',
            type :  'POST',
            data : {
                'create' : 'new'
            },
            beforeSend : function ()
            {
                $('#capanel_get_tables').text(CAPlang['loading_data']);
            },
            success : function (data)
            {
                // Show data in #capanel_get_tables
                $('#capanel_get_tables').html(data);

                // if change select table show #capanel_use_primary_key.
                $('#table').change(function (){
                    $('#capanel_use_primary_key').show();
                    return false;
                });

            }
        });
    };

    /**
     * Step 2.
     *  This function will check if use_primary_key input is true or false and show all actions fields step by step.
     */
    $.usePK = function ()
    {
        $("input[name=use_primary_key]").change(function (){

            if ($(this).val() == 1)
            {
                // Check create button if hidden.
                var checkCreateButtonIsHidden = $('#capanel_create_new_tfoot').is(':hidden');

                // If create button not hidden try to hide element.
                if (!checkCreateButtonIsHidden)
                {
                    $('#capanel_create_new_tfoot').hide();
                }

                // Show #capanel_select_primary_key id
                $('#capanel_select_primary_key').show();

                // Now get a select tag for #capanel_select_primary_key ID
                $.ajax({
                    url : capanelCreateURL + 'get_primary_key',
                    type :  'POST',
                    data : $('#capanel_create_new_form').serialize(),
                    beforeSend : function ()
                    {
                        $('#capanel_get_primary_key').text(CAPlang['loading_data']);
                    },
                    success : function (data)
                    {
                        $('#capanel_get_primary_key').html(data);

                        // If #capanel_get_primary_key ID change show #capanel_use_add_action ID
                        $('#capanel_get_primary_key').change(function (){
                            // Disabled table select tag now and input[name=use_primary_key].
                            $('select[name=table],input[name=use_primary_key]').attr('disabled','disabled');
                            //$('input[name=use_primary_key]').attr('disabled','disabled');
                            $('#capanel_use_add_action').show();
                            return false;
                        });

                        // If #capanel_use_add_action ID change show #capanel_use_edit_action ID
                        $('#capanel_use_add_action').change(function (){
                            $('#capanel_use_edit_action').show();
                            return false;
                        });

                        // If #capanel_use_edit_action ID change show #capanel_use_delete_action ID
                        $('#capanel_use_edit_action').change(function (){
                            $('#capanel_use_delete_action').show();
                            return false;
                        });

                        // If #capanel_use_delete_action ID change show #capanel_use_repair_action ID
                        $('#capanel_use_delete_action').change(function (){
                            $('#capanel_use_repair_action').show();
                            return false;
                        });

                        // If #capanel_use_repair_action ID change show #capanel_use_optimize_action ID
                        $('#capanel_use_repair_action').change(function (){
                            $('#capanel_use_optimize_action').show();
                            return false;
                        });

                        // If #capanel_use_optimize_action ID change show #capanel_list_columns_number ID
                        $('#capanel_use_optimize_action').change(function (){
                            $('#capanel_create_new_tfoot').show();
                            return false;
                        });


                    }
                });
            }
            else
            {
                // Hide #capanel_get_primary_key ID if not hidden.
                var checkPrimaryKeyIsHidden = $('#capanel_select_primary_key').is(':hidden');

                // Check if #capanel_select_primary_key ID not hidden if not hide and remove data from #capanel_get_primary_key ID.
                if (!checkPrimaryKeyIsHidden)
                {
                    $('#capanel_select_primary_key').hide();
                    $('#capanel_get_primary_key').text('');
                }

                // Show create button.
                $('#capanel_create_new_tfoot').show();
            }

            return false;
        });
    };

    /**
     * Step 3
     */
    $.startCreate = function ()
    {
        $('#start').click(function (){

            $('select[name=table],input[name=use_primary_key]').removeAttr('disabled');

            $.ajax({
                url : capanelCreateURL + 'create',
                type : 'POST',
                data : $('#capanel_create_new_form').serialize(),
                beforeSend : function ()
                {
                    $('input, textarea, select, button').attr('disabled','disabled');
                },
                success : function (data)
                {
                    $('input, textarea, select, button').removeAttr('disabled');
                    $('select[name=table],input[name=use_primary_key]').attr('disabled','disabled');
                    if (data == 1)
                    {
                        //$('body').prepend(data);
                        location.reload();
                        //window.setTimeout('location.reload()', 3000);
                    }
                    else
                    {
                        $.alertCAPanel('CAPanel',data,'OK');
                    }
                }
            });

            return false;
        });
    };

    /**
     * CAPanel alert box.
     */
    $.alertCAPanel = function (title,message,button)
    {
        $('.capanel_opacity').fadeTo(0,0.5);
        $(".capanel_alert").show();

        var html = '<div class="capanel_alert_title">'+title+'</div>';
        html += '<div class="capanel_alert_message">'+message+'</div>';
        html += '<div class="capanel_alert_button"><button>'+button+'</button></div>';

        $(".capanel_alert").offset({
            top: $(document).height()/2 -  $(".capanel_alert").height() - 200,
            left: $(document).width()/2 -  $(".capanel_alert").width()/2
        });

        $('.capanel_alert').append(html);

        $('.capanel_alert_button button').click(function (){
            $('.capanel_alert').fadeOut('fast');
            $('.capanel_opacity').fadeOut('fast');
            $('.capanel_alert').text('');
            return false;
        });
    };

    /**
     * Steps
     */
    $.createCAPanel = function ()
    {
        // Step 1
        $.getTables();
        // Step 2
        $.usePK();
        // Step 3
        $.startCreate();
    };

})(jQuery);


$.createCAPanel();
</script>

<div class="br">&nbsp;</div>
<h1 class="null">Read this</h1>
<div class="info">
This is a simple scaffolding system helps you to create a admin controller actions and edit or add forms.
<br />
<i>but</i> this not mean you can use it in live website,
you must modify files that created by this system to add some features or remove some features.
</div>

<div class="warning">
Created files by this system not secure, you are responsible to make it secure for real websites.
</div>

<div class="warning">
When you are finished, do not forget to convert $_config['cap']['enabled'] value to false.
</div>