/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @fileoverview    function used in table data manipulation pages
 *
 * @requires    jQuery
 * @requires    jQueryUI
 * @requires    js/functions.js
 *
 */

/**
 * Modify form controls when the "NULL" checkbox is checked
 *
 * @param theType     string   the MySQL field type
 * @param urlField    string   the urlencoded field name - OBSOLETE
 * @param md5Field    string   the md5 hashed field name
 * @param multi_edit  string   the multi_edit row sequence number
 *
 * @return boolean  always true
 */
function nullify(theType, urlField, md5Field, multi_edit)
{
    var rowForm = document.forms['insertForm'];

    if (typeof(rowForm.elements['funcs' + multi_edit + '[' + md5Field + ']']) != 'undefined') {
        rowForm.elements['funcs' + multi_edit + '[' + md5Field + ']'].selectedIndex = -1;
    }

    // "ENUM" field with more than 20 characters
    if (theType == 1) {
        rowForm.elements['fields' + multi_edit + '[' + md5Field +  ']'][1].selectedIndex = -1;
    }
    // Other "ENUM" field
    else if (theType == 2) {
        var elts     = rowForm.elements['fields' + multi_edit + '[' + md5Field + ']'];
        // when there is just one option in ENUM:
        if (elts.checked) {
            elts.checked = false;
        } else {
            var elts_cnt = elts.length;
            for (var i = 0; i < elts_cnt; i++ ) {
                elts[i].checked = false;
            } // end for

        } // end if
    }
    // "SET" field
    else if (theType == 3) {
        rowForm.elements['fields' + multi_edit + '[' + md5Field +  '][]'].selectedIndex = -1;
    }
    // Foreign key field (drop-down)
    else if (theType == 4) {
        rowForm.elements['fields' + multi_edit + '[' + md5Field +  ']'].selectedIndex = -1;
    }
    // foreign key field (with browsing icon for foreign values)
    else if (theType == 6) {
        rowForm.elements['fields' + multi_edit + '[' + md5Field + ']'].value = '';
    }
    // Other field types
    else /*if (theType == 5)*/ {
        rowForm.elements['fields' + multi_edit + '[' + md5Field + ']'].value = '';
    } // end if... else if... else

    return true;
} // end of the 'nullify()' function


/**
 * javascript DateTime format validation.
 * its used to prevent adding default (0000-00-00 00:00:00) to database when user enter wrong values
 * Start of validation part
 */
//function checks the number of days in febuary
function daysInFebruary (year)
{
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
//function to convert single digit to double digit
function fractionReplace(num)
{
    num = parseInt(num);
    return num >= 1 && num <= 9 ? '0' + num : '00';
}

/* function to check the validity of date
* The following patterns are accepted in this validation (accepted in mysql as well)
* 1) 2001-12-23
* 2) 2001-1-2
* 3) 02-12-23
* 4) And instead of using '-' the following punctuations can be used (+,.,*,^,@,/) All these are accepted by mysql as well. Therefore no issues
*/
function isDate(val,tmstmp)
{
    val = val.replace(/[.|*|^|+|//|@]/g,'-');
    var arrayVal = val.split("-");
    for (var a=0;a<arrayVal.length;a++) {
        if (arrayVal[a].length==1) {
            arrayVal[a]=fractionReplace(arrayVal[a]);
        }
    }
    val=arrayVal.join("-");
    var pos=2;
    var dtexp=new RegExp(/^([0-9]{4})-(((01|03|05|07|08|10|12)-((0[0-9])|([1-2][0-9])|(3[0-1])))|((02|04|06|09|11)-((0[0-9])|([1-2][0-9])|30)))$/);
    if (val.length == 8) {
        pos=0;
    }
    if (dtexp.test(val)) {
        var month=parseInt(val.substring(pos+3,pos+5));
        var day=parseInt(val.substring(pos+6,pos+8));
        var year=parseInt(val.substring(0,pos+2));
        if (month == 2 && day > daysInFebruary(year)) {
            return false;
        }
        if (val.substring(0, pos + 2).length == 2) {
            year = parseInt("20" + val.substring(0,pos+2));
        }
        if (tmstmp == true) {
            if (year < 1978) {
                return false;
            }
            if (year > 2038 || (year > 2037 && day > 19 && month >= 1) || (year > 2037 && month > 1)) {
                return false;
            }
        }
    } else {
        return false;
    }
    return true;
}

/* function to check the validity of time
* The following patterns are accepted in this validation (accepted in mysql as well)
* 1) 2:3:4
* 2) 2:23:43
*/
function isTime(val)
{
    var arrayVal = val.split(":");
    for (var a = 0, l = arrayVal.length; a < l; a++) {
        if (arrayVal[a].length == 1) {
            arrayVal[a] = fractionReplace(arrayVal[a]);
        }
    }
    val = arrayVal.join(":");
    var tmexp = new RegExp(/^(([0-1][0-9])|(2[0-3])):((0[0-9])|([1-5][0-9])):((0[0-9])|([1-5][0-9]))$/);
    return tmexp.test(val);
}

function verificationsAfterFieldChange(urlField, multi_edit, theType)
{
    var evt = window.event || arguments.callee.caller.arguments[0];
    var target = evt.target || evt.srcElement;

    // Unchecks the corresponding "NULL" control
    $("input[name='fields_null[multi_edit][" + multi_edit + "][" + urlField + "]']").prop('checked', false);

    // Unchecks the Ignore checkbox for the current row
    $("input[name='insert_ignore_" + multi_edit + "']").prop('checked', false);
    var $this_input = $("input[name='fields[multi_edit][" + multi_edit + "][" + urlField + "]']");

    // Does this field come from datepicker?
    if ($this_input.data('comes_from') == 'datepicker') {
        // Yes, so do not validate because the final value is not yet in
        // the field and hopefully the datepicker returns a valid date+time
        $this_input.removeClass("invalid_value");
        return true;
    }

    if (target.name.substring(0,6)=="fields") {
        // validate for date time
        if (theType=="datetime"||theType=="time"||theType=="date"||theType=="timestamp") {
            $this_input.removeClass("invalid_value");
            var dt_value = $this_input.val();
            if (theType=="date"){
                if (! isDate(dt_value)) {
                    $this_input.addClass("invalid_value");
                    return false;
                }
            } else if (theType=="time") {
                if (! isTime(dt_value)) {
                    $this_input.addClass("invalid_value");
                    return false;
                }
            } else if (theType=="datetime"||theType=="timestamp") {
                var tmstmp=false;
                if (dt_value == "CURRENT_TIMESTAMP") {
                    return true;
                }
                if (theType=="timestamp") {
                    tmstmp=true;
                }
                if (dt_value=="0000-00-00 00:00:00") {
                    return true;
                }
                var dv=dt_value.indexOf(" ");
                if (dv==-1) {
                    $this_input.addClass("invalid_value");
                    return false;
                } else {
                    if (! (isDate(dt_value.substring(0,dv),tmstmp) && isTime(dt_value.substring(dv+1)))) {
                        $this_input.addClass("invalid_value");
                        return false;
                    }
                }
            }
        }
        //validate for integer type
        if (theType.substring(0,3) == "int"){
            $this_input.removeClass("invalid_value");
            if (isNaN($this_input.val())){
                $this_input.addClass("invalid_value");
                return false;
            }
        }
    }
 }
 /* End of datetime validation*/


/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('tbl_change.js', function() {
    $('span.open_gis_editor').die('click');
    $("input[name='gis_data[save]']").die('click');
    $('input.checkbox_null').die('click');
    $('select[name="submit_type"]').unbind('change');
    $("#insert_rows").die('change');
});

/**
 * Ajax handlers for Change Table page
 *
 * Actions Ajaxified here:
 * Submit Data to be inserted into the table.
 * Restart insertion with 'N' rows.
 */
AJAX.registerOnload('tbl_change.js', function() {
    $.datepicker.initialized = false;

    $('span.open_gis_editor').live('click', function(event) {
        event.preventDefault();

        var $span = $(this);
        // Current value
        var value = $span.parent('td').children("input[type='text']").val();
        // Field name
        var field = $span.parents('tr').children('td:first').find("input[type='hidden']").val();
        // Column type
        var type = $span.parents('tr').find('span.column_type').text();
        // Names of input field and null checkbox
        var input_name = $span.parent('td').children("input[type='text']").attr('name');
        //Token
        var token = $("input[name='token']").val();

        openGISEditor();
        if (!gisEditorLoaded) {
            loadJSAndGISEditor(value, field, type, input_name, token);
        } else {
            loadGISEditor(value, field, type, input_name, token);
        }
    });

    /**
     * Uncheck the null checkbox as geometry data is placed on the input field
     */
    $("input[name='gis_data[save]']").live('click', function(event) {
        var input_name = $('form#gis_data_editor_form').find("input[name='input_name']").val();
        var $null_checkbox = $("input[name='" + input_name + "']").parents('tr').find('.checkbox_null');
        $null_checkbox.prop('checked', false);
    });

    /**
     * Handles all current checkboxes for Null; this only takes care of the
     * checkboxes on currently displayed rows as the rows generated by
     * "Continue insertion" are handled in the "Continue insertion" code
     *
     */
    $('input.checkbox_null').live('click', function(e) {
            nullify(
                // use hidden fields populated by tbl_change.php
                $(this).siblings('.nullify_code').val(),
                $(this).closest('tr').find('input:hidden').first().val(),
                $(this).siblings('.hashed_field').val(),
                $(this).siblings('.multi_edit').val()
            );
    });


    /**
     * Reset the auto_increment column to 0 when selecting any of the
     * insert options in submit_type-dropdown. Only perform the reset
     * when we are in edit-mode, and not in insert-mode(no previous value
     * available).
     */
    $('select[name="submit_type"]').bind('change', function (e) {
        var $table = $('table.insertRowTable');
        var auto_increment_column = $table.find('input[name^="auto_increment"]').attr('name');
        if (auto_increment_column) {
            var prev_value_field = $table.find('input[name="' + auto_increment_column.replace('auto_increment', 'fields_prev') + '"]');
            var value_field = $table.find('input[name="' + auto_increment_column.replace('auto_increment', 'fields') + '"]');
            var previous_value = $(prev_value_field).val();
            if (previous_value !== undefined) {
                if ($(this).val() == 'insert' || $(this).val() == 'insertignore' || $(this).val() == 'showinsert' ) {
                    $(value_field).val(0);
                } else {
                    $(value_field).val(previous_value);
                }
            }
        }
    });

    /**
     * Continue Insertion form
     */
    $("#insert_rows").live('change', function(event) {
        event.preventDefault();

        /**
         * @var curr_rows   Number of current insert rows already on page
         */
        var curr_rows = $("table.insertRowTable").length;
        /**
         * @var target_rows Number of rows the user wants
         */
        var target_rows = $("#insert_rows").val();

        // remove all datepickers
        $('input.datefield, input.datetimefield').each(function(){
            $(this).datepicker('destroy');
        });

        if (curr_rows < target_rows ) {
            while( curr_rows < target_rows ) {

                /**
                 * @var $last_row    Object referring to the last row
                 */
                var $last_row = $("#insertForm").find(".insertRowTable:last");

                // need to access this at more than one level
                // (also needs improvement because it should be calculated
                //  just once per cloned row, not once per column)
                var new_row_index = 0;

                //Clone the insert tables
                $last_row
                .clone()
                .insertBefore("#actions_panel")
                .find('input[name*=multi_edit],select[name*=multi_edit],textarea[name*=multi_edit]')
                .each(function() {

                    var $this_element = $(this);
                    /**
                     * Extract the index from the name attribute for all input/select fields and increment it
                     * name is of format funcs[multi_edit][10][<long random string of alphanum chars>]
                     */

                    /**
                     * @var this_name   String containing name of the input/select elements
                     */
                    var this_name = $this_element.attr('name');
                    /** split {@link this_name} at [10], so we have the parts that can be concatenated later */
                    var name_parts = this_name.split(/\[\d+\]/);
                    /** extract the [10] from  {@link name_parts} */
                    var old_row_index_string = this_name.match(/\[\d+\]/)[0];
                    /** extract 10 - had to split into two steps to accomodate double digits */
                    var old_row_index = parseInt(old_row_index_string.match(/\d+/)[0]);

                    /** calculate next index i.e. 11 */
                    new_row_index = old_row_index + 1;
                    /** generate the new name i.e. funcs[multi_edit][11][foobarbaz] */
                    var new_name = name_parts[0] + '[' + new_row_index + ']' + name_parts[1];

                    var hashed_field = name_parts[1].match(/\[(.+)\]/)[1];
                    $this_element.attr('name', new_name);

                    if ($this_element.is('.textfield')) {
                        // do not remove the 'value' attribute for ENUM columns
                        if ($this_element.closest('tr').find('span.column_type').html() != 'enum') {
                            $this_element.val($this_element.closest('tr').find('span.default_value').html());
                        }
                        $this_element
                        .unbind('change')
                        // Remove onchange attribute that was placed
                        // by tbl_change.php; it refers to the wrong row index
                        .attr('onchange', null)
                        // Keep these values to be used when the element
                        // will change
                        .data('hashed_field', hashed_field)
                        .data('new_row_index', new_row_index)
                        .bind('change', function(e) {
                            var $changed_element = $(this);
                            verificationsAfterFieldChange(
                                $changed_element.data('hashed_field'),
                                $changed_element.data('new_row_index'),
                                $changed_element.closest('tr').find('span.column_type').html()
                            );
                        });
                    }

                    if ($this_element.is('.checkbox_null')) {
                        $this_element
                        // this event was bound earlier by jQuery but
                        // to the original row, not the cloned one, so unbind()
                        .unbind('click')
                        // Keep these values to be used when the element
                        // will be clicked
                        .data('hashed_field', hashed_field)
                        .data('new_row_index', new_row_index)
                        .bind('click', function(e) {
                                var $changed_element = $(this);
                                nullify(
                                    $changed_element.siblings('.nullify_code').val(),
                                    $this_element.closest('tr').find('input:hidden').first().val(),
                                    $changed_element.data('hashed_field'),
                                    '[multi_edit][' + $changed_element.data('new_row_index') + ']'
                                );
                        });
                    }
                }) // end each
                .end()
                .find('.foreign_values_anchor')
                .each(function() {
                        var $anchor = $(this);
                        var new_value = 'rownumber=' + new_row_index;
                        // needs improvement in case something else inside
                        // the href contains this pattern
                        var new_href = $anchor.attr('href').replace(/rownumber=\d+/, new_value);
                        $anchor.attr('href', new_href );
                    });

                //Insert/Clone the ignore checkboxes
                if (curr_rows == 1 ) {
                    $('<input id="insert_ignore_1" type="checkbox" name="insert_ignore_1" checked="checked" />')
                    .insertBefore("table.insertRowTable:last")
                    .after('<label for="insert_ignore_1">' + PMA_messages['strIgnore'] + '</label>');
                }
                else {

                    /**
                     * @var $last_checkbox   Object reference to the last checkbox in #insertForm
                     */
                    var $last_checkbox = $("#insertForm").children('input:checkbox:last');

                    /** name of {@link $last_checkbox} */
                    var last_checkbox_name = $last_checkbox.attr('name');
                    /** index of {@link $last_checkbox} */
                    var last_checkbox_index = parseInt(last_checkbox_name.match(/\d+/));
                    /** name of new {@link $last_checkbox} */
                    var new_name = last_checkbox_name.replace(/\d+/,last_checkbox_index+1);

                    $last_checkbox
                    .clone()
                    .attr({'id':new_name, 'name': new_name})
                    .prop('checked', true)
                    .add('label[for^=insert_ignore]:last')
                    .clone()
                    .attr('for', new_name)
                    .before('<br />')
                    .insertBefore("table.insertRowTable:last");
                }
                curr_rows++;
            }
        // recompute tabindex for text fields and other controls at footer;
        // IMO it's not really important to handle the tabindex for
        // function and Null
        var tabindex = 0;
        $('.textfield, .char')
        .each(function() {
                tabindex++;
                $(this).attr('tabindex', tabindex);
                // update the IDs of textfields to ensure that they are unique
                $(this).attr('id', "field_" + tabindex + "_3");
            });
        $('.control_at_footer')
        .each(function() {
                tabindex++;
                $(this).attr('tabindex', tabindex);
            });
        // Add all the required datepickers back
        $('input.datefield, input.datetimefield').each(function(){
            PMA_addDatepicker($(this));
            });
        } else if ( curr_rows > target_rows) {
            while(curr_rows > target_rows) {
                $("input[id^=insert_ignore]:last")
                .nextUntil("fieldset")
                .andSelf()
                .remove();
                curr_rows--;
            }
        }
    })
});
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @fileoverview    functions used on the table structure page
 * @name            Table Structure
 *
 * @requires    jQuery
 * @requires    jQueryUI
 * @required    js/functions.js
 */

/**
 * AJAX scripts for tbl_structure.php
 *
 * Actions ajaxified here:
 * Drop Column
 * Add Primary Key
 * Drop Primary Key/Index
 *
 */

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('tbl_structure.js', function() {
    $("a.change_column_anchor.ajax").die('click');
    $("button.change_columns_anchor.ajax, input.change_columns_anchor.ajax").die('click');
    $("a.drop_column_anchor.ajax").die('click');
    $("a.add_primary_key_anchor.ajax").die('click');
    $("#move_columns_anchor").die('click');
    $(".append_fields_form.ajax").unbind('submit');
});

AJAX.registerOnload('tbl_structure.js', function() {

    /**
     *Ajax action for submitting the "Column Change" and "Add Column" form
     */
    $(".append_fields_form.ajax").die().live('submit', function(event) {
        event.preventDefault();
        /**
         * @var    the_form    object referring to the export form
         */
        var $form = $(this);

        /*
         * First validate the form; if there is a problem, avoid submitting it
         *
         * checkTableEditForm() needs a pure element and not a jQuery object,
         * this is why we pass $form[0] as a parameter (the jQuery object
         * is actually an array of DOM elements)
         */
        if (checkTableEditForm($form[0], $form.find('input[name=orig_num_fields]').val())) {
            // OK, form passed validation step
            PMA_prepareForAjaxRequest($form);
            //User wants to submit the form
            $msg = PMA_ajaxShowMessage();
            $.post($form.attr('action'), $form.serialize() + '&do_save_data=1', function(data) {
                if ($("#sqlqueryresults").length != 0) {
                    $("#sqlqueryresults").remove();
                } else if ($(".error:not(.tab)").length != 0) {
                    $(".error:not(.tab)").remove();
                }
                if (data.success == true) {
                    $("#page_content")
                        .empty()
                        .append(data.message)
                        .append(data.sql_query)
                        .show();
                    $("#result_query .notice").remove();
                    reloadFieldForm();
                    $form.remove();
                    PMA_ajaxRemoveMessage($msg);
                    PMA_reloadNavigation();
                } else {
                    PMA_ajaxShowMessage(data.error, false);
                }
            }); // end $.post()
        }
    }); // end change table button "do_save_data"

    /**
     * Attach Event Handler for 'Change Column'
     */
    $("a.change_column_anchor.ajax").live('click', function(event) {
        event.preventDefault();
        var $msg = PMA_ajaxShowMessage();
        $('#page_content').hide();
        $.get($(this).attr('href'), {'ajax_request': true}, function (data) {
            PMA_ajaxRemoveMessage($msg);
            if (data.success) {
                $('<div id="change_column_dialog" class="margin"></div>')
                    .html(data.message)
                    .insertBefore('#page_content');
                PMA_showHints();
                PMA_verifyColumnsProperties();
            } else {
                PMA_ajaxShowMessage(PMA_messages['strErrorProcessingRequest'] + " : " + data.error, false);
            }
        });
    });

    /**
     * Attach Event Handler for 'Change multiple columns'
     */
    $("button.change_columns_anchor.ajax, input.change_columns_anchor.ajax").live('click', function(event) {
        event.preventDefault();
        var $msg = PMA_ajaxShowMessage();
        $('#page_content').hide();
        var $form = $(this).closest('form');
        var params = $form.serialize() + "&ajax_request=true&submit_mult=change";
        $.post($form.prop("action"), params, function (data) {
            PMA_ajaxRemoveMessage($msg);
            if (data.success) {
                $('#page_content')
                    .empty()
                    .append(
                        $('<div id="change_column_dialog"></div>')
                            .html(data.message)
                    )
                    .show();
                PMA_showHints();
                PMA_verifyColumnsProperties();
            } else {
                $('#page_content').show();
                PMA_ajaxShowMessage(data.error);
            }
        });
    });

    /**
     * Attach Event Handler for 'Drop Column'
     */
    $("a.drop_column_anchor.ajax").live('click', function(event) {
        event.preventDefault();
        /**
         * @var curr_table_name String containing the name of the current table
         */
        var curr_table_name = $(this).closest('form').find('input[name=table]').val();
        /**
         * @var curr_row    Object reference to the currently selected row (i.e. field in the table)
         */
        var $curr_row = $(this).parents('tr');
        /**
         * @var curr_column_name    String containing name of the field referred to by {@link curr_row}
         */
        var curr_column_name = $curr_row.children('th').children('label').text();
        /**
         * @var $after_field_item    Corresponding entry in the 'After' field.
         */
        var $after_field_item = $("select[name='after_field'] option[value='" + curr_column_name + "']");
        /**
         * @var question    String containing the question to be asked for confirmation
         */
        var question = $.sprintf(PMA_messages['strDoYouReally'], 'ALTER TABLE `' + escapeHtml(curr_table_name) + '` DROP `' + escapeHtml(curr_column_name) + '`;');
        $(this).PMA_confirm(question, $(this).attr('href'), function(url) {
            var $msg = PMA_ajaxShowMessage(PMA_messages['strDroppingColumn'], false);
            $.get(url, {'is_js_confirmed' : 1, 'ajax_request' : true, 'ajax_page_request' : true}, function (data) {
                if (data.success == true) {
                    PMA_ajaxRemoveMessage($msg);
                    if ($('#result_query').length) {
                        $('#result_query').remove();
                    }
                    if (data.sql_query) {
                        $('<div id="result_query"></div>')
                            .html(data.sql_query)
                            .prependTo('#page_content');
                    }
                    toggleRowColors($curr_row.next());
                    // Adjust the row numbers
                    for (var $row = $curr_row.next(); $row.length > 0; $row = $row.next()) {
                        var new_val = parseInt($row.find('td:nth-child(2)').text()) - 1;
                        $row.find('td:nth-child(2)').text(new_val);
                    }
                    $after_field_item.remove();
                    $curr_row.hide("medium").remove();
                    //refresh table stats
                    if (data.tableStat) {
                        $('#tablestatistics').html(data.tableStat);
                    }
                    // refresh the list of indexes (comes from sql.php)
                    $('.index_info').replaceWith(data.indexes_list);
                    PMA_reloadNavigation();
                } else {
                    PMA_ajaxShowMessage(PMA_messages['strErrorProcessingRequest'] + " : " + data.error, false);
                }
            }); // end $.get()
        }); // end $.PMA_confirm()
    }) ; //end of Drop Column Anchor action

    /**
     * Ajax Event handler for 'Add Primary Key'
     */
    $("a.add_primary_key_anchor.ajax").live('click', function(event) {
        event.preventDefault();
        /**
         * @var curr_table_name String containing the name of the current table
         */
        var curr_table_name = $(this).closest('form').find('input[name=table]').val();
        /**
         * @var curr_column_name    String containing name of the field referred to by {@link curr_row}
         */
        var curr_column_name = $(this).parents('tr').children('th').children('label').text();
        /**
         * @var question    String containing the question to be asked for confirmation
         */
        var question = $.sprintf(PMA_messages['strDoYouReally'], 'ALTER TABLE `' + escapeHtml(curr_table_name) + '` ADD PRIMARY KEY(`' + escapeHtml(curr_column_name) + '`);');
        $(this).PMA_confirm(question, $(this).attr('href'), function(url) {
            var $msg = PMA_ajaxShowMessage(PMA_messages['strAddingPrimaryKey'], false);
            $.get(url, {'is_js_confirmed' : 1, 'ajax_request' : true}, function(data) {
                if (data.success == true) {
                    PMA_ajaxRemoveMessage($msg);
                    $(this).remove();
                    if (typeof data.reload != 'undefined') {
                        PMA_commonActions.refreshMain(false, function () {
                            if ($('#result_query').length) {
                                $('#result_query').remove();
                            }
                            if (data.sql_query) {
                                $('<div id="result_query"></div>')
                                    .html(data.sql_query)
                                    .prependTo('#page_content');
                            }
                        });
                        PMA_reloadNavigation();
                    }
                } else {
                    PMA_ajaxShowMessage(PMA_messages['strErrorProcessingRequest'] + " : " + data.error, false);
                }
            }); // end $.get()
        }); // end $.PMA_confirm()
    }); //end Add Primary Key

    /**
     * Inline move columns
    **/
    $("#move_columns_anchor").live('click', function(e) {
        e.preventDefault();

        if ($(this).hasClass("move-active")) {
            return;
        }

        /**
         * @var    button_options  Object that stores the options passed to jQueryUI
         *                          dialog
         */
        var button_options = {};

        button_options[PMA_messages['strGo']] = function(event) {
            event.preventDefault();
            var $msgbox = PMA_ajaxShowMessage();
            var $this = $(this);
            var $form = $this.find("form");
            var serialized = $form.serialize();

            // check if any columns were moved at all
            if (serialized == $form.data("serialized-unmoved")) {
                PMA_ajaxRemoveMessage($msgbox);
                $this.dialog('close');
                return;
            }

            $.post($form.prop("action"), serialized + "&ajax_request=true", function (data) {
                if (data.success == false) {
                    PMA_ajaxRemoveMessage($msgbox);
                    $this
                    .clone()
                    .html(data.error)
                    .dialog({
                        title: $(this).prop("title"),
                        height: 230,
                        width: 900,
                        modal: true,
                        buttons: button_options_error
                    }); // end dialog options
                } else {
                    $('#fieldsForm ul.table-structure-actions').menuResizer('destroy');
                    // sort the fields table
                    var $fields_table = $("table#tablestructure tbody");
                    // remove all existing rows and remember them
                    var $rows = $fields_table.find("tr").remove();
                    // loop through the correct order
                    for (var i in data.columns) {
                        var the_column = data.columns[i];
                        var $the_row = $rows
                            .find("input:checkbox[value=" + the_column + "]")
                            .closest("tr");
                        // append the row for this column to the table
                        $fields_table.append($the_row);
                    }
                    var $firstrow = $fields_table.find("tr").eq(0);
                    // Adjust the row numbers and colors
                    for (var $row = $firstrow; $row.length > 0; $row = $row.next()) {
                        $row
                        .find('td:nth-child(2)')
                        .text($row.index() + 1)
                        .end()
                        .removeClass("odd even")
                        .addClass($row.index() % 2 == 0 ? "odd" : "even");
                    }
                    PMA_ajaxShowMessage(data.message);
                    $this.dialog('close');
                    $('#fieldsForm ul.table-structure-actions').menuResizer(PMA_tbl_structure_menu_resizer_callback);
                }
            });
        };
        button_options[PMA_messages['strCancel']] = function() {
            $(this).dialog('close');
        };

        var button_options_error = {};
        button_options_error[PMA_messages['strOK']] = function() {
            $(this).dialog('close').remove();
        };

        var columns = [];

        $("#tablestructure tbody tr").each(function () {
            var col_name = $(this).find("input:checkbox").eq(0).val();
            var hidden_input = $("<input/>")
                .prop({
                    name: "move_columns[]",
                    type: "hidden"
                })
                .val(col_name);
            columns[columns.length] = $("<li/>")
                .addClass("placeholderDrag")
                .text(col_name)
                .append(hidden_input);
        });

        var col_list = $("#move_columns_dialog ul")
            .find("li").remove().end();
        for (var i in columns) {
            col_list.append(columns[i]);
        }
        col_list.sortable({
            axis: 'y',
            containment: $("#move_columns_dialog div")
        }).disableSelection();
        var $form = $("#move_columns_dialog form");
        $form.data("serialized-unmoved", $form.serialize());

        $("#move_columns_dialog").dialog({
            modal: true,
            buttons: button_options,
            beforeClose: function () {
                $("#move_columns_anchor").removeClass("move-active");
            }
        });
    });
});

/**
 * Reload fields table
 */
function reloadFieldForm() {
    $.post($("#fieldsForm").attr('action'), $("#fieldsForm").serialize()+"&ajax_request=true", function(form_data) {
        var $temp_div = $("<div id='temp_div'><div>").append(form_data.message);
        $("#fieldsForm").replaceWith($temp_div.find("#fieldsForm"));
        $("#addColumns").replaceWith($temp_div.find("#addColumns"));
        $('#move_columns_dialog ul').replaceWith($temp_div.find("#move_columns_dialog ul"));
        $("#moveColumns").removeClass("move-active");
        /* reinitialise the more options in table */
        $('#fieldsForm ul.table-structure-actions').menuResizer(PMA_tbl_structure_menu_resizer_callback);
    });
    $('#page_content').show();
}

/**
 * This function returns the horizontal space available for the menu in pixels.
 * To calculate this value we start we the width of the main panel, then we
 * substract the margin of the page content, then we substract any cellspacing
 * that the table may have (original theme only) and finally we substract the
 * width of all columns of the table except for the last one (which is where
 * the menu will go). What we should end up with is the distance between the
 * start of the last column on the table and the edge of the page, again this
 * is the space available for the menu.
 *
 * In the case where the table cell where the menu will be displayed is already
 * off-screen (the table is wider than the page), a negative value will be returned,
 * but this will be treated as a zero by the menuResizer plugin.
 *
 * @return int
 */
function PMA_tbl_structure_menu_resizer_callback() {
    var pagewidth = $('body').width();
    var $page = $('#page_content');
    pagewidth -= $page.outerWidth(true) - $page.outerWidth();
    var columnsWidth = 0;
    var $columns = $('#tablestructure').find('tr:eq(1)').find('td,th');
    $columns.not(':last').each(function (){
        columnsWidth += $(this).outerWidth(true)
    });
    var totalCellSpacing = $('#tablestructure').width();
    $columns.each(function (){
        totalCellSpacing -= $(this).outerWidth(true);
    });
    return pagewidth - columnsWidth - totalCellSpacing - 15; // 15px extra margin
}

/** Handler for "More" dropdown in structure table rows */
AJAX.registerOnload('tbl_structure.js', function() {
    if ($('#fieldsForm').hasClass('HideStructureActions')) {
        $('#fieldsForm ul.table-structure-actions').menuResizer(PMA_tbl_structure_menu_resizer_callback);
    }
});
AJAX.registerTeardown('tbl_structure.js', function() {
    $('#fieldsForm ul.table-structure-actions').menuResizer('destroy');
});
$(function () {
    $(window).resize($.throttle(function () {
        var $list = $('#fieldsForm ul.table-structure-actions');
        if ($list.length) {
            $list.menuResizer('resize');
        }
    }));
});
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @fileoverview    functions used in GIS data editor
 *
 * @requires    jQuery
 *
 */

var gisEditorLoaded = false;

/**
 * Closes the GIS data editor and perform necessary clean up work.
 */
function closeGISEditor(){
    $("#popup_background").fadeOut("fast");
    $("#gis_editor").fadeOut("fast", function () {
        $(this).empty();
    });
}

/**
 * Prepares the HTML recieved via AJAX.
 */
function prepareJSVersion() {
    // Change the text on the submit button
    $("#gis_editor input[name='gis_data[save]']")
        .val(PMA_messages['strCopy'])
        .insertAfter($('#gis_data_textarea'))
        .before('<br/><br/>');

    // Add close and cancel links
    $('#gis_data_editor').prepend('<a class="close_gis_editor" href="#">' + PMA_messages['strClose'] + '</a>');
    $('<a class="cancel_gis_editor" href="#"> ' + PMA_messages['strCancel'] + '</a>')
        .insertAfter($("input[name='gis_data[save]']"));

    // Remove the unnecessary text
    $('div#gis_data_output p').remove();

    // Remove 'add' buttons and add links
    $('#gis_editor input.add').each(function(e) {
        var $button = $(this);
        $button.addClass('addJs').removeClass('add');
        var classes = $button.attr('class');
        $button.replaceWith(
            '<a class="' + classes + '" name="' + $button.attr('name')
                + '" href="#">+ ' + $button.val() + '</a>'
        );
    });
}

/**
 * Returns the HTML for a data point.
 *
 * @param pointNumber point number
 * @param prefix      prefix of the name
 * @returns the HTML for a data point
 */
function addDataPoint(pointNumber, prefix) {
    return '<br/>' + $.sprintf(PMA_messages['strPointN'], (pointNumber + 1)) + ': '
        + '<label for="x">' + PMA_messages['strX'] + '</label>'
        + '<input type="text" name="' + prefix + '[' + pointNumber + '][x]" value=""/>'
        + '<label for="y">' + PMA_messages['strY'] + '</label>'
        + '<input type="text" name="' + prefix + '[' + pointNumber + '][y]" value=""/>';
}

/**
 * Initialize the visualization in the GIS data editor.
 */
function initGISEditorVisualization() {
    // Loads either SVG or OSM visualization based on the choice
    selectVisualization();
    // Adds necessary styles to the div that coontains the openStreetMap
    styleOSM();
    // Loads the SVG element and make a reference to it
    loadSVG();
    // Adds controllers for zooming and panning
    addZoomPanControllers();
    zoomAndPan();
}

/**
 * Loads JavaScript files and the GIS editor.
 *
 * @param value      current value of the geometry field
 * @param field      field name
 * @param type       geometry type
 * @param input_name name of the input field
 * @param token      token
 */
function loadJSAndGISEditor(value, field, type, input_name, token) {
    var head = document.getElementsByTagName('head')[0];
    var script;

    // Loads a set of small JS file needed for the GIS editor
    var smallScripts = [ 'js/jquery/jquery.svg.js',
                     'js/jquery/jquery.mousewheel.js',
                     'js/jquery/jquery.event.drag-2.2.js',
                     'js/tbl_gis_visualization.js' ];

    for (var i = 0; i < smallScripts.length; i++) {
        script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = smallScripts[i];
        head.appendChild(script);
    }

    // OpenLayers.js is BIG and takes time. So asynchronous loading would not work.
    // Load the JS and do a callback to load the content for the GIS Editor.
    script = document.createElement('script');
    script.type = 'text/javascript';

    script.onreadystatechange = function() {
        if (this.readyState == 'complete') {
            loadGISEditor(value, field, type, input_name, token);
        }
    };
    script.onload = function() {
        loadGISEditor(value, field, type, input_name, token);
    };

    script.src = 'js/openlayers/OpenLayers.js';
    head.appendChild(script);

    gisEditorLoaded = true;
}

/**
 * Loads the GIS editor via AJAX
 *
 * @param value      current value of the geometry field
 * @param field      field name
 * @param type       geometry type
 * @param input_name name of the input field
 * @param token      token
 */
function loadGISEditor(value, field, type, input_name, token) {

    var $gis_editor = $("#gis_editor");
    $.post('gis_data_editor.php', {
        'field' : field,
        'value' : value,
        'type' : type,
        'input_name' : input_name,
        'get_gis_editor' : true,
        'token' : token,
        'ajax_request': true
    }, function(data) {
        if (data.success == true) {
            $gis_editor.html(data.gis_editor);
            initGISEditorVisualization();
            prepareJSVersion();
        } else {
            PMA_ajaxShowMessage(data.error, false);
        }
    }, 'json');
}

/**
 * Opens up the dialog for the GIS data editor.
 */
function openGISEditor() {

    // Center the popup
    var windowWidth = document.documentElement.clientWidth;
    var windowHeight = document.documentElement.clientHeight;
    var popupWidth = windowWidth * 0.9;
    var popupHeight = windowHeight * 0.9;
    var popupOffsetTop = windowHeight / 2 - popupHeight / 2;
    var popupOffsetLeft = windowWidth / 2 - popupWidth / 2;

    var $gis_editor = $("#gis_editor");
    var $backgrouond = $("#popup_background");

    $gis_editor.css({"top": popupOffsetTop, "left": popupOffsetLeft, "width": popupWidth, "height": popupHeight});
    $backgrouond.css({"opacity":"0.7"});

    $gis_editor.append('<div id="gis_data_editor"><img class="ajaxIcon" id="loadingMonitorIcon" src="'
            + pmaThemeImage + 'ajax_clock_small.gif" alt=""/></div>'
    );

    // Make it appear
    $backgrouond.fadeIn("fast");
    $gis_editor.fadeIn("fast");
}

/**
 * Prepare and insert the GIS data in Well Known Text format
 * to the input field.
 */
function insertDataAndClose() {
    var $form = $('form#gis_data_editor_form');
    var input_name = $form.find("input[name='input_name']").val();

    $.post('gis_data_editor.php', $form.serialize() + "&generate=true&ajax_request=true", function(data) {
        if (data.success == true) {
            $("input[name='" + input_name + "']").val(data.result);
        } else {
            PMA_ajaxShowMessage(data.error, false);
        }
    }, 'json');
    closeGISEditor();
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('gis_data_editor.js', function() {
    $("#gis_editor input[name='gis_data[save]']").die('click');
    $('#gis_editor').die('submit');
    $('#gis_editor').find("input[type='text']").die('change');
    $("#gis_editor select.gis_type").die('change');
    $('#gis_editor a.close_gis_editor, #gis_editor a.cancel_gis_editor').die('click');
    $('#gis_editor a.addJs.addPoint').die('click');
    $('#gis_editor a.addLine.addJs').die('click');
    $('#gis_editor a.addJs.addPolygon').die('click');
    $('#gis_editor a.addJs.addGeom').die('click');
});

AJAX.registerOnload('gis_data_editor.js', function() {

    // Remove the class that is added due to the URL being too long.
    $('span.open_gis_editor a').removeClass('formLinkSubmit');

    /**
     * Prepares and insert the GIS data to the input field on clicking 'copy'.
     */
    $("#gis_editor input[name='gis_data[save]']").live('click', function(event) {
        event.preventDefault();
        insertDataAndClose();
    });

    /**
     * Prepares and insert the GIS data to the input field on pressing 'enter'.
     */
    $('#gis_editor').live('submit', function(event) {
        event.preventDefault();
        insertDataAndClose();
    });

    /**
     * Trigger asynchronous calls on data change and update the output.
     */
    $('#gis_editor').find("input[type='text']").live('change', function() {
        var $form = $('form#gis_data_editor_form');
        $.post('gis_data_editor.php', $form.serialize() + "&generate=true&ajax_request=true", function(data) {
            if (data.success == true) {
                $('#gis_data_textarea').val(data.result);
                $('#placeholder').empty().removeClass('hasSVG').html(data.visualization);
                $('#openlayersmap').empty();
                eval(data.openLayers);
                initGISEditorVisualization();
            } else {
                PMA_ajaxShowMessage(data.error, false);
            }
        }, 'json');
    });

    /**
     * Update the form on change of the GIS type.
     */
    $("#gis_editor select.gis_type").live('change', function(event) {
        var $gis_editor = $("#gis_editor");
        var $form = $('form#gis_data_editor_form');

        $.post('gis_data_editor.php', $form.serialize() + "&get_gis_editor=true&ajax_request=true", function(data) {
            if (data.success == true) {
                $gis_editor.html(data.gis_editor);
                initGISEditorVisualization();
                prepareJSVersion();
            } else {
                PMA_ajaxShowMessage(data.error, false);
            }
        }, 'json');
    });

    /**
     * Handles closing of the GIS data editor.
     */
    $('#gis_editor a.close_gis_editor, #gis_editor a.cancel_gis_editor').live('click', function() {
        closeGISEditor();
    });

    /**
     * Handles adding data points
     */
    $('#gis_editor a.addJs.addPoint').live('click', function() {
        var $a = $(this);
        var name = $a.attr('name');
        // Eg. name = gis_data[0][MULTIPOINT][add_point] => prefix = gis_data[0][MULTIPOINT]
        var prefix = name.substr(0, name.length - 11);
        // Find the number of points
        var $noOfPointsInput = $("input[name='" + prefix + "[no_of_points]" + "']");
        var noOfPoints = parseInt($noOfPointsInput.val());
        // Add the new data point
        var html = addDataPoint(noOfPoints, prefix);
        $a.before(html);
        $noOfPointsInput.val(noOfPoints + 1);
    });

    /**
     * Handles adding linestrings and inner rings
     */
    $('#gis_editor a.addLine.addJs').live('click', function() {
        var $a = $(this);
        var name = $a.attr('name');

        // Eg. name = gis_data[0][MULTILINESTRING][add_line] => prefix = gis_data[0][MULTILINESTRING]
        var prefix = name.substr(0, name.length - 10);
        var type = prefix.slice(prefix.lastIndexOf('[') + 1, prefix.lastIndexOf(']'));

        // Find the number of lines
        var $noOfLinesInput = $("input[name='" + prefix + "[no_of_lines]" + "']");
        var noOfLines = parseInt($noOfLinesInput.val());

        // Add the new linesting of inner ring based on the type
        var html = '<br/>';
        if (type == 'MULTILINESTRING') {
            html += PMA_messages['strLineString'] + ' ' + (noOfLines + 1) + ':';
            var noOfPoints = 2;
        } else {
            html += PMA_messages['strInnerRing'] + ' ' + noOfLines + ':';
            var noOfPoints = 4;
        }
        html += '<input type="hidden" name="' + prefix + '[' + noOfLines + '][no_of_points]" value="' + noOfPoints + '"/>';
        for (var i = 0; i < noOfPoints; i++) {
            html += addDataPoint(i, (prefix + '[' + noOfLines + ']'));
        }
        html += '<a class="addPoint addJs" name="' + prefix + '[' + noOfLines + '][add_point]" href="#">+ '
            + PMA_messages['strAddPoint'] + '</a><br/>';

        $a.before(html);
        $noOfLinesInput.val(noOfLines + 1);
    });

    /**
     * Handles adding polygons
     */
    $('#gis_editor a.addJs.addPolygon').live('click', function() {
        var $a = $(this);
        var name = $a.attr('name');
        // Eg. name = gis_data[0][MULTIPOLYGON][add_polygon] => prefix = gis_data[0][MULTIPOLYGON]
        var prefix = name.substr(0, name.length - 13);
        // Find the number of polygons
        var $noOfPolygonsInput = $("input[name='" + prefix + "[no_of_polygons]" + "']");
        var noOfPolygons = parseInt($noOfPolygonsInput.val());

        // Add the new polygon
        var html = PMA_messages['strPolygon'] + ' ' + (noOfPolygons + 1) + ':<br/>';
        html += '<input type="hidden" name="' + prefix + '[' + noOfPolygons + '][no_of_lines]" value="1"/>'
            + '<br/>' + PMA_messages['strOuterRing'] + ':'
            + '<input type="hidden" name="' + prefix + '[' + noOfPolygons + '][0][no_of_points]" value="4"/>';
        for (var i = 0; i < 4; i++) {
            html += addDataPoint(i, (prefix + '[' + noOfPolygons + '][0]'));
        }
        html += '<a class="addPoint addJs" name="' + prefix + '[' + noOfPolygons + '][0][add_point]" href="#">+ '
            + PMA_messages['strAddPoint'] + '</a><br/>'
            + '<a class="addLine addJs" name="' + prefix + '[' + noOfPolygons + '][add_line]" href="#">+ '
            + PMA_messages['strAddInnerRing'] + '</a><br/><br/>';

        $a.before(html);
        $noOfPolygonsInput.val(noOfPolygons + 1);
    });

    /**
     * Handles adding geoms
     */
    $('#gis_editor a.addJs.addGeom').live('click', function() {
        var $a = $(this);
        var prefix = 'gis_data[GEOMETRYCOLLECTION]';
        // Find the number of geoms
        var $noOfGeomsInput = $("input[name='" + prefix + "[geom_count]" + "']");
        var noOfGeoms = parseInt($noOfGeomsInput.val());

        var html1 = PMA_messages['strGeometry'] + ' ' + (noOfGeoms + 1) + ':<br/>';
        var $geomType = $("select[name='gis_data[" + (noOfGeoms - 1) + "][gis_type]']").clone();
        $geomType.attr('name', 'gis_data[' + noOfGeoms + '][gis_type]').val('POINT');
        var html2 = '<br/>' + PMA_messages['strPoint'] + ' :'
            + '<label for="x"> ' + PMA_messages['strX'] + ' </label>'
            + '<input type="text" name="gis_data[' + noOfGeoms + '][POINT][x]" value=""/>'
            + '<label for="y"> ' + PMA_messages['strY'] + ' </label>'
            + '<input type="text" name="gis_data[' + noOfGeoms + '][POINT][y]" value=""/>'
            + '<br/><br/>';

        $a.before(html1); $geomType.insertBefore($a); $a.before(html2);
        $noOfGeomsInput.val(noOfGeoms + 1);
    });
});
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Create advanced table (resize, reorder, and show/hide columns; and also grid editing).
 * This function is designed mainly for table DOM generated from browsing a table in the database.
 * For using this function in other table DOM, you may need to:
 * - add "draggable" class in the table header <th>, in order to make it resizable, sortable or hidable
 * - have at least one non-"draggable" header in the table DOM for placing column visibility drop-down arrow
 * - pass the value "false" for the parameter "enableGridEdit"
 * - adjust other parameter value, to select which features that will be enabled
 *
 * @param t the table DOM element
 * @param enableResize Optional, if false, column resizing feature will be disabled
 * @param enableReorder Optional, if false, column reordering feature will be disabled
 * @param enableVisib Optional, if false, show/hide column feature will be disabled
 * @param enableGridEdit Optional, if false, grid editing feature will be disabled
 */
function PMA_makegrid(t, enableResize, enableReorder, enableVisib, enableGridEdit) {
    var g = {
        /***********
         * Constant
         ***********/
        minColWidth: 15,


        /***********
         * Variables, assigned with default value, changed later
         ***********/
        actionSpan: 5,              // number of colspan in Actions header in a table
        tableCreateTime: null,      // table creation time, used for saving column order and visibility to server, only available in "Browse tab"

        // Column reordering variables
        colOrder: [],      // array of column order

        // Column visibility variables
        colVisib: [],      // array of column visibility
        showAllColText: '',         // string, text for "show all" button under column visibility list
        visibleHeadersCount: 0,     // number of visible data headers

        // Table hint variables
        reorderHint: '',            // string, hint for column reordering
        sortHint: '',               // string, hint for column sorting
        markHint: '',               // string, hint for column marking
        copyHint: '',               // string, hint for copy column name
        showReorderHint: false,
        showSortHint: false,
        showMarkHint: false,

        // Grid editing
        isCellEditActive: false,    // true if current focus is in edit cell
        isEditCellTextEditable: false,  // true if current edit cell is editable in the text input box (not textarea)
        currentEditCell: null,      // reference to <td> that currently being edited
        cellEditHint: '',           // hint shown when doing grid edit
        gotoLinkText: '',           // "Go to link" text
        wasEditedCellNull: false,   // true if last value of the edited cell was NULL
        maxTruncatedLen: 0,         // number of characters that can be displayed in a cell
        saveCellsAtOnce: false,     // $cfg[saveCellsAtOnce]
        isCellEdited: false,        // true if at least one cell has been edited
        saveCellWarning: '',        // string, warning text when user want to leave a page with unsaved edited data
        lastXHR : null,             // last XHR object used in AJAX request
        isSaving: false,            // true when currently saving edited data, used to handle double posting caused by pressing ENTER in grid edit text box in Chrome browser
        alertNonUnique: '',         // string, alert shown when saving edited nonunique table

        // Common hidden inputs
        token: null,
        server: null,
        db: null,
        table: null,


        /************
         * Functions
         ************/

        /**
         * Start to resize column. Called when clicking on column separator.
         *
         * @param e event
         * @param obj dragged div object
         */
        dragStartRsz: function(e, obj) {
            var n = $(g.cRsz).find('div').index(obj);    // get the index of separator (i.e., column index)
            $(obj).addClass('colborder_active');
            g.colRsz = {
                x0: e.pageX,
                n: n,
                obj: obj,
                objLeft: $(obj).position().left,
                objWidth: $(g.t).find('th.draggable:visible:eq(' + n + ') span').outerWidth()
            };
            $(document.body).css('cursor', 'col-resize').noSelect();
            if (g.isCellEditActive) {
                g.hideEditCell();
            }
        },

        /**
         * Start to reorder column. Called when clicking on table header.
         *
         * @param e event
         * @param obj table header object
         */
        dragStartReorder: function(e, obj) {
            // prepare the cCpy (column copy) and cPointer (column pointer) from the dragged column
            $(g.cCpy).text($(obj).text());
            var objPos = $(obj).position();
            $(g.cCpy).css({
                top: objPos.top + 20,
                left: objPos.left,
                height: $(obj).height(),
                width: $(obj).width()
            });
            $(g.cPointer).css({
                top: objPos.top
            });

            // get the column index, zero-based
            var n = g.getHeaderIdx(obj);

            g.colReorder = {
                x0: e.pageX,
                y0: e.pageY,
                n: n,
                newn: n,
                obj: obj,
                objTop: objPos.top,
                objLeft: objPos.left
            };

            $(document.body).css('cursor', 'move').noSelect();
            if (g.isCellEditActive) {
                g.hideEditCell();
            }
        },

        /**
         * Handle mousemove event when dragging.
         *
         * @param e event
         */
        dragMove: function(e) {
            if (g.colRsz) {
                var dx = e.pageX - g.colRsz.x0;
                if (g.colRsz.objWidth + dx > g.minColWidth) {
                    $(g.colRsz.obj).css('left', g.colRsz.objLeft + dx + 'px');
                }
            } else if (g.colReorder) {
                // dragged column animation
                var dx = e.pageX - g.colReorder.x0;
                $(g.cCpy)
                    .css('left', g.colReorder.objLeft + dx)
                    .show();

                // pointer animation
                var hoveredCol = g.getHoveredCol(e);
                if (hoveredCol) {
                    var newn = g.getHeaderIdx(hoveredCol);
                    g.colReorder.newn = newn;
                    if (newn != g.colReorder.n) {
                        // show the column pointer in the right place
                        var colPos = $(hoveredCol).position();
                        var newleft = newn < g.colReorder.n ?
                                      colPos.left :
                                      colPos.left + $(hoveredCol).outerWidth();
                        $(g.cPointer)
                            .css({
                                left: newleft,
                                visibility: 'visible'
                            });
                    } else {
                        // no movement to other column, hide the column pointer
                        $(g.cPointer).css('visibility', 'hidden');
                    }
                }
            }
        },

        /**
         * Stop the dragging action.
         *
         * @param e event
         */
        dragEnd: function(e) {
            if (g.colRsz) {
                var dx = e.pageX - g.colRsz.x0;
                var nw = g.colRsz.objWidth + dx;
                if (nw < g.minColWidth) {
                    nw = g.minColWidth;
                }
                var n = g.colRsz.n;
                // do the resizing
                g.resize(n, nw);

                g.reposRsz();
                g.reposDrop();
                g.colRsz = false;
                $(g.cRsz).find('div').removeClass('colborder_active');
            } else if (g.colReorder) {
                // shift columns
                if (g.colReorder.newn != g.colReorder.n) {
                    g.shiftCol(g.colReorder.n, g.colReorder.newn);
                    // assign new position
                    var objPos = $(g.colReorder.obj).position();
                    g.colReorder.objTop = objPos.top;
                    g.colReorder.objLeft = objPos.left;
                    g.colReorder.n = g.colReorder.newn;
                    // send request to server to remember the column order
                    if (g.tableCreateTime) {
                        g.sendColPrefs();
                    }
                    g.refreshRestoreButton();
                }

                // animate new column position
                $(g.cCpy).stop(true, true)
                    .animate({
                        top: g.colReorder.objTop,
                        left: g.colReorder.objLeft
                    }, 'fast')
                    .fadeOut();
                $(g.cPointer).css('visibility', 'hidden');

                g.colReorder = false;
            }
            $(document.body).css('cursor', 'inherit').noSelect(false);
        },

        /**
         * Resize column n to new width "nw"
         *
         * @param n zero-based column index
         * @param nw new width of the column in pixel
         */
        resize: function(n, nw) {
            $(g.t).find('tr').each(function() {
                $(this).find('th.draggable:visible:eq(' + n + ') span,' +
                             'td:visible:eq(' + (g.actionSpan + n) + ') span')
                       .css('width', nw);
            });
        },

        /**
         * Reposition column resize bars.
         */
        reposRsz: function() {
            $(g.cRsz).find('div').hide();
            var $firstRowCols = $(g.t).find('tr:first th.draggable:visible');
            var $resizeHandles = $(g.cRsz).find('div').removeClass('condition');
            $('table.pma_table').find('thead th:first').removeClass('before-condition');
            for (var n = 0, l = $firstRowCols.length; n < l; n++) {
                var $col = $($firstRowCols[n]);
                $($resizeHandles[n]).css('left', $col.position().left + $col.outerWidth(true))
                   .show();
                if ($col.hasClass('condition')) {
                    $($resizeHandles[n]).addClass('condition');
                    if (n > 0) {
                        $($resizeHandles[n-1]).addClass('condition');
                    }
                }
            }
            if ($($resizeHandles[0]).hasClass('condition')) {
                $('table.pma_table').find('thead th:first').addClass('before-condition');
            }
            $(g.cRsz).css('height', $(g.t).height());
        },

        /**
         * Shift column from index oldn to newn.
         *
         * @param oldn old zero-based column index
         * @param newn new zero-based column index
         */
        shiftCol: function(oldn, newn) {
            $(g.t).find('tr').each(function() {
                if (newn < oldn) {
                    $(this).find('th.draggable:eq(' + newn + '),' +
                                 'td:eq(' + (g.actionSpan + newn) + ')')
                           .before($(this).find('th.draggable:eq(' + oldn + '),' +
                                                'td:eq(' + (g.actionSpan + oldn) + ')'));
                } else {
                    $(this).find('th.draggable:eq(' + newn + '),' +
                                 'td:eq(' + (g.actionSpan + newn) + ')')
                           .after($(this).find('th.draggable:eq(' + oldn + '),' +
                                               'td:eq(' + (g.actionSpan + oldn) + ')'));
                }
            });
            // reposition the column resize bars
            g.reposRsz();

            // adjust the column visibility list
            if (newn < oldn) {
                $(g.cList).find('.lDiv div:eq(' + newn + ')')
                          .before($(g.cList).find('.lDiv div:eq(' + oldn + ')'));
            } else {
                $(g.cList).find('.lDiv div:eq(' + newn + ')')
                          .after($(g.cList).find('.lDiv div:eq(' + oldn + ')'));
            }
            // adjust the colOrder
            var tmp = g.colOrder[oldn];
            g.colOrder.splice(oldn, 1);
            g.colOrder.splice(newn, 0, tmp);
            // adjust the colVisib
            if (g.colVisib.length > 0) {
                tmp = g.colVisib[oldn];
                g.colVisib.splice(oldn, 1);
                g.colVisib.splice(newn, 0, tmp);
            }
        },

        /**
         * Find currently hovered table column's header (excluding actions column).
         *
         * @param e event
         * @return the hovered column's th object or undefined if no hovered column found.
         */
        getHoveredCol: function(e) {
            var hoveredCol;
            $headers = $(g.t).find('th.draggable:visible');
            $headers.each(function() {
                var left = $(this).offset().left;
                var right = left + $(this).outerWidth();
                if (left <= e.pageX && e.pageX <= right) {
                    hoveredCol = this;
                }
            });
            return hoveredCol;
        },

        /**
         * Get a zero-based index from a <th class="draggable"> tag in a table.
         *
         * @param obj table header <th> object
         * @return zero-based index of the specified table header in the set of table headers (visible or not)
         */
        getHeaderIdx: function(obj) {
            return $(obj).parents('tr').find('th.draggable').index(obj);
        },

        /**
         * Reposition the columns back to normal order.
         */
        restoreColOrder: function() {
            // use insertion sort, since we already have shiftCol function
            for (var i = 1; i < g.colOrder.length; i++) {
                var x = g.colOrder[i];
                var j = i - 1;
                while (j >= 0 && x < g.colOrder[j]) {
                    j--;
                }
                if (j != i - 1) {
                    g.shiftCol(i, j + 1);
                }
            }
            if (g.tableCreateTime) {
                // send request to server to remember the column order
                g.sendColPrefs();
            }
            g.refreshRestoreButton();
        },

        /**
         * Send column preferences (column order and visibility) to the server.
         */
        sendColPrefs: function() {
            if ($(g.t).is('.ajax')) {   // only send preferences if ajax class
                var post_params = {
                    ajax_request: true,
                    db: g.db,
                    table: g.table,
                    token: g.token,
                    server: g.server,
                    set_col_prefs: true,
                    table_create_time: g.tableCreateTime
                };
                if (g.colOrder.length > 0) {
                    $.extend(post_params, {col_order: g.colOrder.toString()});
                }
                if (g.colVisib.length > 0) {
                    $.extend(post_params, {col_visib: g.colVisib.toString()});
                }
                $.post('sql.php', post_params, function(data) {
                    if (data.success != true) {
                        var $temp_div = $(document.createElement('div'));
                        $temp_div.html(data.error);
                        $temp_div.addClass("error");
                        PMA_ajaxShowMessage($temp_div, false);
                    }
                });
            }
        },

        /**
         * Refresh restore button state.
         * Make restore button disabled if the table is similar with initial state.
         */
        refreshRestoreButton: function() {
            // check if table state is as initial state
            var isInitial = true;
            for (var i = 0; i < g.colOrder.length; i++) {
                if (g.colOrder[i] != i) {
                    isInitial = false;
                    break;
                }
            }
            // check if only one visible column left
            var isOneColumn = g.visibleHeadersCount == 1;
            // enable or disable restore button
            if (isInitial || isOneColumn) {
                $('div.restore_column').hide();
            } else {
                $('div.restore_column').show();
            }
        },

        /**
         * Update current hint using the boolean values (showReorderHint, showSortHint, etc.).
         *
         */
        updateHint: function() {
            var text = '';
            if (!g.colRsz && !g.colReorder) {     // if not resizing or dragging
                if (g.visibleHeadersCount > 1) {
                    g.showReorderHint = true;
                }
                if ($(t).find('th.marker').length > 0) {
                    g.showMarkHint = true;
                }

                if (g.showReorderHint && g.reorderHint) {
                    text += g.reorderHint;
                }
                if (g.showSortHint && g.sortHint) {
                    text += text.length > 0 ? '<br />' : '';
                    text += g.sortHint;
                }
                if (g.showMarkHint && g.markHint &&
                    !g.showSortHint      // we do not show mark hint, when sort hint is shown
                ) {
                    text += text.length > 0 ? '<br />' : '';
                    text += g.markHint;
                    text += text.length > 0 ? '<br />' : '';
                    text += g.copyHint;
                }
            }
            return text;
        },

        /**
         * Toggle column's visibility.
         * After calling this function and it returns true, afterToggleCol() must be called.
         *
         * @return boolean True if the column is toggled successfully.
         */
        toggleCol: function(n) {
            if (g.colVisib[n]) {
                // can hide if more than one column is visible
                if (g.visibleHeadersCount > 1) {
                    $(g.t).find('tr').each(function() {
                        $(this).find('th.draggable:eq(' + n + '),' +
                                     'td:eq(' + (g.actionSpan + n) + ')')
                               .hide();
                    });
                    g.colVisib[n] = 0;
                    $(g.cList).find('.lDiv div:eq(' + n + ') input').prop('checked', false);
                } else {
                    // cannot hide, force the checkbox to stay checked
                    $(g.cList).find('.lDiv div:eq(' + n + ') input').prop('checked', true);
                    return false;
                }
            } else {    // column n is not visible
                $(g.t).find('tr').each(function() {
                    $(this).find('th.draggable:eq(' + n + '),' +
                                 'td:eq(' + (g.actionSpan + n) + ')')
                           .show();
                });
                g.colVisib[n] = 1;
                $(g.cList).find('.lDiv div:eq(' + n + ') input').prop('checked', true);
            }
            return true;
        },

        /**
         * This must be called if toggleCol() returns is true.
         *
         * This function is separated from toggleCol because, sometimes, we want to toggle
         * some columns together at one time and do just one adjustment after it, e.g. in showAllColumns().
         */
        afterToggleCol: function() {
            // some adjustments after hiding column
            g.reposRsz();
            g.reposDrop();
            g.sendColPrefs();

            // check visible first row headers count
            g.visibleHeadersCount = $(g.t).find('tr:first th.draggable:visible').length;
            g.refreshRestoreButton();
        },

        /**
         * Show columns' visibility list.
         *
         * @param obj The drop down arrow of column visibility list
         */
        showColList: function(obj) {
            // only show when not resizing or reordering
            if (!g.colRsz && !g.colReorder) {
                var pos = $(obj).position();
                // check if the list position is too right
                if (pos.left + $(g.cList).outerWidth(true) > $(document).width()) {
                    pos.left = $(document).width() - $(g.cList).outerWidth(true);
                }
                $(g.cList).css({
                        left: pos.left,
                        top: pos.top + $(obj).outerHeight(true)
                    })
                    .show();
                $(obj).addClass('coldrop-hover');
            }
        },

        /**
         * Hide columns' visibility list.
         */
        hideColList: function() {
            $(g.cList).hide();
            $(g.cDrop).find('.coldrop-hover').removeClass('coldrop-hover');
        },

        /**
         * Reposition the column visibility drop-down arrow.
         */
        reposDrop: function() {
            var $th = $(t).find('th:not(.draggable)');
            for (var i = 0; i < $th.length; i++) {
                var $cd = $(g.cDrop).find('div:eq(' + i + ')');   // column drop-down arrow
                var pos = $($th[i]).position();
                $cd.css({
                        left: pos.left + $($th[i]).width() - $cd.width(),
                        top: pos.top
                    });
            }
        },

        /**
         * Show all hidden columns.
         */
        showAllColumns: function() {
            for (var i = 0; i < g.colVisib.length; i++) {
                if (!g.colVisib[i]) {
                    g.toggleCol(i);
                }
            }
            g.afterToggleCol();
        },

        /**
         * Show edit cell, if it can be shown
         *
         * @param cell <td> element to be edited
         */
        showEditCell: function(cell) {
            if ($(cell).is('.grid_edit') &&
                !g.colRsz && !g.colReorder)
            {
                if (!g.isCellEditActive) {
                    var $cell = $(cell);
                    // remove all edit area and hide it
                    $(g.cEdit).find('.edit_area').empty().hide();
                    // reposition the cEdit element
                    $(g.cEdit).css({
                            top: $cell.position().top,
                            left: $cell.position().left
                        })
                        .show()
                        .find('.edit_box')
                        .css({
                            width: $cell.outerWidth(),
                            height: $cell.outerHeight()
                        });
                    // fill the cell edit with text from <td>
                    var value = PMA_getCellValue(cell);
                    $(g.cEdit).find('.edit_box').val(value);

                    g.currentEditCell = cell;
                    $(g.cEdit).find('.edit_box').focus();
                    $(g.cEdit).find('*').removeProp('disabled');
                }
            }
        },

        /**
         * Remove edit cell and the edit area, if it is shown.
         *
         * @param force Optional, force to hide edit cell without saving edited field.
         * @param data  Optional, data from the POST AJAX request to save the edited field
         *              or just specify "true", if we want to replace the edited field with the new value.
         * @param field Optional, the edited <td>. If not specified, the function will
         *              use currently edited <td> from g.currentEditCell.
         */
        hideEditCell: function(force, data, field) {
            if (g.isCellEditActive && !force) {
                // cell is being edited, save or post the edited data
                g.saveOrPostEditedCell();
                return;
            }

            // cancel any previous request
            if (g.lastXHR != null) {
                g.lastXHR.abort();
                g.lastXHR = null;
            }

            if (data) {
                if (g.currentEditCell) {    // save value of currently edited cell
                    // replace current edited field with the new value
                    var $this_field = $(g.currentEditCell);
                    var is_null = $this_field.data('value') == null;
                    if (is_null) {
                        $this_field.find('span').html('NULL');
                        $this_field.addClass('null');
                    } else {
                        $this_field.removeClass('null');
                        var new_html = data.isNeedToRecheck
                            ? data.truncatableFieldValue
                            : $this_field.data('value');
                        if ($this_field.is('.truncated')) {
                            if (new_html.length > g.maxTruncatedLen) {
                                new_html = new_html.substring(0, g.maxTruncatedLen) + '...';
                            }
                        }
                        $this_field.find('span').text(new_html);
                    }
                }
                if (data.transformations != undefined) {
                    $.each(data.transformations, function(cell_index, value) {
                        var $this_field = $(g.t).find('.to_be_saved:eq(' + cell_index + ')');
                        $this_field.find('span').html(value);
                    });
                }
                if (data.relations != undefined) {
                    $.each(data.relations, function(cell_index, value) {
                        var $this_field = $(g.t).find('.to_be_saved:eq(' + cell_index + ')');
                        $this_field.find('span').html(value);
                    });
                }

                // refresh the grid
                g.reposRsz();
                g.reposDrop();
            }

            // hide the cell editing area
            $(g.cEdit).hide();
            $(g.cEdit).find('.edit_box').blur();
            g.isCellEditActive = false;
            g.currentEditCell = null;
            // destroy datepicker in edit area, if exist
            var $dp = $(g.cEdit).find('.hasDatepicker');
            if ($dp.length > 0) {
                $dp.datepicker('destroy');
                // change the cursor in edit box back to normal
                // (the cursor become a hand pointer when we add datepicker)
                $(g.cEdit).find('.edit_box').css('cursor', 'inherit');
            }
        },

        /**
         * Show drop-down edit area when edit cell is focused.
         */
        showEditArea: function() {
            if (!g.isCellEditActive) {   // make sure the edit area has not been shown
                g.isCellEditActive = true;
                g.isEditCellTextEditable = false;
                /**
                 * @var $td current edited cell
                 */
                var $td = $(g.currentEditCell);
                /**
                 * @var $editArea the editing area
                 */
                var $editArea = $(g.cEdit).find('.edit_area');
                /**
                 * @var where_clause WHERE clause for the edited cell
                 */
                var where_clause = $td.parent('tr').find('.where_clause').val();
                /**
                 * @var field_name  String containing the name of this field.
                 * @see getFieldName()
                 */
                var field_name = getFieldName($td);
                /**
                 * @var relation_curr_value String current value of the field (for fields that are foreign keyed).
                 */
                var relation_curr_value = $td.text();
                /**
                 * @var relation_key_or_display_column String relational key if in 'Relational display column' mode,
                 * relational display column if in 'Relational key' mode (for fields that are foreign keyed).
                 */
                var relation_key_or_display_column = $td.find('a').attr('title');
                /**
                 * @var curr_value String current value of the field (for fields that are of type enum or set).
                 */
                var curr_value = $td.find('span').text();

                // empty all edit area, then rebuild it based on $td classes
                $editArea.empty();

                // add show data row link if the data resulted by 'browse distinct values' in table structure
                if ($td.find('input').hasClass('data_browse_link')) {
                    var showDataRowLink = document.createElement('div');
                    showDataRowLink.className = 'goto_link';
                    $(showDataRowLink).append("<a href='" + $td.find('.data_browse_link').val() + "'>" + g.showDataRowLinkText + "</a>");
                    $editArea.append(showDataRowLink);
                }

                // add goto link, if this cell contains a link
                if ($td.find('a').length > 0) {
                    var gotoLink = document.createElement('div');
                    gotoLink.className = 'goto_link';
                    $(gotoLink).append(g.gotoLinkText + ': ').append($td.find('a').clone());
                    $editArea.append(gotoLink);
                }

                g.wasEditedCellNull = false;
                if ($td.is(':not(.not_null)')) {
                    // append a null checkbox
                    $editArea.append('<div class="null_div">Null :<input type="checkbox"></div>');
                    var $checkbox = $editArea.find('.null_div input');
                    // check if current <td> is NULL
                    if ($td.is('.null')) {
                        $checkbox.prop('checked', true);
                        g.wasEditedCellNull = true;
                    }

                    // if the select/editor is changed un-check the 'checkbox_null_<field_name>_<row_index>'.
                    if ($td.is('.enum, .set')) {
                        $editArea.find('select').live('change', function(e) {
                            $checkbox.prop('checked', false);
                        });
                    } else if ($td.is('.relation')) {
                        $editArea.find('select').live('change', function(e) {
                            $checkbox.prop('checked', false);
                        });
                        $editArea.find('.browse_foreign').live('click', function(e) {
                            $checkbox.prop('checked', false);
                        });
                    } else {
                        $(g.cEdit).find('.edit_box').live('keypress change', function(e) {
                            $checkbox.prop('checked', false);
                        });
                        // Capture ctrl+v (on IE and Chrome)
                        $(g.cEdit).find('.edit_box').live('keydown', function(e) {
                            if (e.ctrlKey && e.which == 86) {
                                $checkbox.prop('checked', false);
                            }
                        });
                        $editArea.find('textarea').live('keydown', function(e) {
                            $checkbox.prop('checked', false);
                        });
                    }

                    // if null checkbox is clicked empty the corresponding select/editor.
                    $checkbox.click(function(e) {
                        if ($td.is('.enum')) {
                            $editArea.find('select').val('');
                        } else if ($td.is('.set')) {
                            $editArea.find('select').find('option').each(function() {
                                var $option = $(this);
                                $option.prop('selected', false);
                            });
                        } else if ($td.is('.relation')) {
                            // if the dropdown is there to select the foreign value
                            if ($editArea.find('select').length > 0) {
                                $editArea.find('select').val('');
                            }
                        } else {
                            $editArea.find('textarea').val('');
                        }
                        $(g.cEdit).find('.edit_box').val('');
                    });
                }

                if ($td.is('.relation')) {
                    //handle relations
                    $editArea.addClass('edit_area_loading');

                    // initialize the original data
                    $td.data('original_data', null);

                    /**
                     * @var post_params Object containing parameters for the POST request
                     */
                    var post_params = {
                        'ajax_request' : true,
                        'get_relational_values' : true,
                        'server' : g.server,
                        'db' : g.db,
                        'table' : g.table,
                        'column' : field_name,
                        'token' : g.token,
                        'curr_value' : relation_curr_value,
                        'relation_key_or_display_column' : relation_key_or_display_column
                    };

                    g.lastXHR = $.post('sql.php', post_params, function(data) {
                        g.lastXHR = null;
                        $editArea.removeClass('edit_area_loading');
                        if ($(data.dropdown).is('select')) {
                            // save original_data
                            var value = $(data.dropdown).val();
                            $td.data('original_data', value);
                            // update the text input field, in case where the "Relational display column" is checked
                            $(g.cEdit).find('.edit_box').val(value);
                        }

                        $editArea.append(data.dropdown);
                        $editArea.append('<div class="cell_edit_hint">' + g.cellEditHint + '</div>');

                        // for 'Browse foreign values' options,
                        // hide the value next to 'Browse foreign values' link
                        $editArea.find('span.curr_value').hide();
                        // handle update for new values selected from new window
                        $editArea.find('span.curr_value').change(function() {
                            $(g.cEdit).find('.edit_box').val($(this).text());
                        });
                    }); // end $.post()

                    $editArea.show();
                    $editArea.find('select').live('change', function(e) {
                        $(g.cEdit).find('.edit_box').val($(this).val());
                    });
                    g.isEditCellTextEditable = true;
                }
                else if ($td.is('.enum')) {
                    //handle enum fields
                    $editArea.addClass('edit_area_loading');

                    /**
                     * @var post_params Object containing parameters for the POST request
                     */
                    var post_params = {
                            'ajax_request' : true,
                            'get_enum_values' : true,
                            'server' : g.server,
                            'db' : g.db,
                            'table' : g.table,
                            'column' : field_name,
                            'token' : g.token,
                            'curr_value' : curr_value
                    };
                    g.lastXHR = $.post('sql.php', post_params, function(data) {
                        g.lastXHR = null;
                        $editArea.removeClass('edit_area_loading');
                        $editArea.append(data.dropdown);
                        $editArea.append('<div class="cell_edit_hint">' + g.cellEditHint + '</div>');
                    }); // end $.post()

                    $editArea.show();
                    $editArea.find('select').live('change', function(e) {
                        $(g.cEdit).find('.edit_box').val($(this).val());
                    });
                }
                else if ($td.is('.set')) {
                    //handle set fields
                    $editArea.addClass('edit_area_loading');

                    /**
                     * @var post_params Object containing parameters for the POST request
                     */
                    var post_params = {
                            'ajax_request' : true,
                            'get_set_values' : true,
                            'server' : g.server,
                            'db' : g.db,
                            'table' : g.table,
                            'column' : field_name,
                            'token' : g.token,
                            'curr_value' : curr_value
                    };

                    g.lastXHR = $.post('sql.php', post_params, function(data) {
                        g.lastXHR = null;
                        $editArea.removeClass('edit_area_loading');
                        $editArea.append(data.select);
                        $editArea.append('<div class="cell_edit_hint">' + g.cellEditHint + '</div>');
                    }); // end $.post()

                    $editArea.show();
                    $editArea.find('select').live('change', function(e) {
                        $(g.cEdit).find('.edit_box').val($(this).val());
                    });
                }
                else if ($td.is('.truncated, .transformed')) {
                    if ($td.is('.to_be_saved')) {   // cell has been edited
                        var value = $td.data('value');
                        $(g.cEdit).find('.edit_box').val(value);
                        $editArea.append('<textarea></textarea>');
                        $editArea.find('textarea')
                            .val(value)
                            .live('keyup', function(e) {
                                $(g.cEdit).find('.edit_box').val($(this).val());
                            });
                        $(g.cEdit).find('.edit_box').live('keyup', function(e) {
                            $editArea.find('textarea').val($(this).val());
                        });
                        $editArea.append('<div class="cell_edit_hint">' + g.cellEditHint + '</div>');
                    } else {
                        //handle truncated/transformed values values
                        $editArea.addClass('edit_area_loading');

                        // initialize the original data
                        $td.data('original_data', null);

                        /**
                         * @var sql_query   String containing the SQL query used to retrieve value of truncated/transformed data
                         */
                        var sql_query = 'SELECT `' + field_name + '` FROM `' + g.table + '` WHERE ' + PMA_urldecode(where_clause);

                        // Make the Ajax call and get the data, wrap it and insert it
                        g.lastXHR = $.post('sql.php', {
                            'token' : g.token,
                            'server' : g.server,
                            'db' : g.db,
                            'ajax_request' : true,
                            'sql_query' : sql_query,
                            'grid_edit' : true
                        }, function(data) {
                            g.lastXHR = null;
                            $editArea.removeClass('edit_area_loading');
                            if (data.success == true) {
                                if ($td.is('.truncated')) {
                                    // get the truncated data length
                                    g.maxTruncatedLen = $(g.currentEditCell).text().length - 3;
                                }

                                $td.data('original_data', data.value);
                                $(g.cEdit).find('.edit_box').val(data.value);
                                $editArea.append('<textarea></textarea>');
                                $editArea.find('textarea')
                                    .val(data.value)
                                    .live('keyup', function(e) {
                                        $(g.cEdit).find('.edit_box').val($(this).val());
                                    });
                                $(g.cEdit).find('.edit_box').live('keyup', function(e) {
                                    $editArea.find('textarea').val($(this).val());
                                });
                                $editArea.append('<div class="cell_edit_hint">' + g.cellEditHint + '</div>');
                            } else {
                                PMA_ajaxShowMessage(data.error, false);
                            }
                        }); // end $.post()
                        $editArea.show();
                    }
                    g.isEditCellTextEditable = true;
                } else if ($td.is('.datefield, .datetimefield, .timestampfield')) {
                    var $input_field = $(g.cEdit).find('.edit_box');

                    // remember current datetime value in $input_field, if it is not null
                    var is_null = $td.is('.null');
                    var current_datetime_value = !is_null ? $input_field.val() : '';

                    var showTimeOption = true;
                    if ($td.is('.datefield')) {
                        showTimeOption = false;
                    }
                    PMA_addDatepicker($editArea, {
                        altField: $input_field,
                        showTimepicker: showTimeOption,
                        onSelect: function(dateText, inst) {
                            // remove null checkbox if it exists
                            $(g.cEdit).find('.null_div input[type=checkbox]').prop('checked', false);
                        }
                    });

                    // cancel any click on the datepicker element
                    $editArea.find('> *').click(function(e) {
                        e.stopPropagation();
                    });

                    // force to restore modified $input_field value after adding datepicker
                    // (after adding a datepicker, the input field doesn't display the time anymore, only the date)
                    if (is_null
                        || current_datetime_value == '0000-00-00'
                        || current_datetime_value == '0000-00-00 00:00:00'
                    ) {
                        $input_field.val(current_datetime_value);
                    } else {
                        $editArea.datetimepicker('setDate', current_datetime_value);
                    }
                    $editArea.append('<div class="cell_edit_hint">' + g.cellEditHint + '</div>');

                    // remove {cursor: 'pointer'} added inside
                    // jquery-ui-timepicker-addon.js
                    $input_field.css('cursor', '');
                    // make the cell editable, so one can can bypass the timepicker
                    // and enter date/time value manually
                    g.isEditCellTextEditable = true;
                } else {
                    g.isEditCellTextEditable = true;
                    // only append edit area hint if there is a null checkbox
                    if ($editArea.children().length > 0) {
                        $editArea.append('<div class="cell_edit_hint">' + g.cellEditHint + '</div>');
                    }
                }
                if ($editArea.children().length > 0) {
                    $editArea.show();
                }
            }
        },

        /**
         * Post the content of edited cell.
         */
        postEditedCell: function() {
            if (g.isSaving) {
                return;
            }
            g.isSaving = true;

            /**
             * @var relation_fields Array containing the name/value pairs of relational fields
             */
            var relation_fields = {};
            /**
             * @var relational_display string 'K' if relational key, 'D' if relational display column
             */
            var relational_display = $("#relational_display_K").prop('checked') ? 'K' : 'D';
            /**
             * @var transform_fields    Array containing the name/value pairs for transformed fields
             */
            var transform_fields = {};
            /**
             * @var transformation_fields   Boolean, if there are any transformed fields in the edited cells
             */
            var transformation_fields = false;
            /**
             * @var full_sql_query String containing the complete SQL query to update this table
             */
            var full_sql_query = '';
            /**
             * @var rel_fields_list  String, url encoded representation of {@link relations_fields}
             */
            var rel_fields_list = '';
            /**
             * @var transform_fields_list  String, url encoded representation of {@link transform_fields}
             */
            var transform_fields_list = '';
            /**
             * @var where_clause Array containing where clause for updated fields
             */
            var full_where_clause = [];
            /**
             * @var is_unique   Boolean, whether the rows in this table is unique or not
             */
            var is_unique = $('td.edit_row_anchor').is('.nonunique') ? 0 : 1;
            /**
             * multi edit variables
             */
            var me_fields_name = [];
            var me_fields = [];
            var me_fields_null = [];

            // alert user if edited table is not unique
            if (!is_unique) {
                alert(g.alertNonUnique);
            }

            // loop each edited row
            $('td.to_be_saved').parents('tr').each(function() {
                var $tr = $(this);
                var where_clause = $tr.find('.where_clause').val();
                full_where_clause.push(PMA_urldecode(where_clause));
                var condition_array = jQuery.parseJSON($tr.find('.condition_array').val());

                /**
                 * multi edit variables, for current row
                 * @TODO array indices are still not correct, they should be md5 of field's name
                 */
                var fields_name = [];
                var fields = [];
                var fields_null = [];

                // loop each edited cell in a row
                $tr.find('.to_be_saved').each(function() {
                    /**
                     * @var $this_field    Object referring to the td that is being edited
                     */
                    var $this_field = $(this);

                    /**
                     * @var field_name  String containing the name of this field.
                     * @see getFieldName()
                     */
                    var field_name = getFieldName($this_field);

                    /**
                     * @var this_field_params   Array temporary storage for the name/value of current field
                     */
                    var this_field_params = {};

                    if ($this_field.is('.transformed')) {
                        transformation_fields =  true;
                    }
                    this_field_params[field_name] = $this_field.data('value');

                    /**
                     * @var is_null String capturing whether 'checkbox_null_<field_name>_<row_index>' is checked.
                     */
                    var is_null = this_field_params[field_name] === null;

                    fields_name.push(field_name);

                    if (is_null) {
                        fields_null.push('on');
                        fields.push('');
                    } else {
                        fields_null.push('');
                        fields.push($this_field.data('value'));

                        var cell_index = $this_field.index('.to_be_saved');
                        if ($this_field.is(":not(.relation, .enum, .set, .bit)")) {
                            if ($this_field.is('.transformed')) {
                                transform_fields[cell_index] = {};
                                $.extend(transform_fields[cell_index], this_field_params);
                            }
                        } else if ($this_field.is('.relation')) {
                            relation_fields[cell_index] = {};
                            $.extend(relation_fields[cell_index], this_field_params);
                        }
                    }
                    // check if edited field appears in WHERE clause
                    if (where_clause.indexOf(PMA_urlencode(field_name)) > -1) {
                        var field_str = '`' + g.table + '`.' + '`' + field_name + '`';
                        for (var field in condition_array) {
                            if (field.indexOf(field_str) > -1) {
                                condition_array[field] = is_null ? 'IS NULL' : "= '" + this_field_params[field_name].replace(/'/g,"''") + "'";
                                break;
                            }
                        }
                    }

                }); // end of loop for every edited cells in a row

                // save new_clause
                var new_clause = '';
                for (var field in condition_array) {
                    new_clause += field + ' ' + condition_array[field] + ' AND ';
                }
                new_clause = new_clause.substring(0, new_clause.length - 5); // remove the last AND
                new_clause = PMA_urlencode(new_clause);
                $tr.data('new_clause', new_clause);
                // save condition_array
                $tr.find('.condition_array').val(JSON.stringify(condition_array));

                me_fields_name.push(fields_name);
                me_fields.push(fields);
                me_fields_null.push(fields_null);

            }); // end of loop for every edited rows

            rel_fields_list = $.param(relation_fields);
            transform_fields_list = $.param(transform_fields);

            // Make the Ajax post after setting all parameters
            /**
             * @var post_params Object containing parameters for the POST request
             */
            var post_params = {'ajax_request' : true,
                            'sql_query' : full_sql_query,
                            'token' : g.token,
                            'server' : g.server,
                            'db' : g.db,
                            'table' : g.table,
                            'clause_is_unique' : is_unique,
                            'where_clause' : full_where_clause,
                            'fields[multi_edit]' : me_fields,
                            'fields_name[multi_edit]' : me_fields_name,
                            'fields_null[multi_edit]' : me_fields_null,
                            'rel_fields_list' : rel_fields_list,
                            'do_transformations' : transformation_fields,
                            'transform_fields_list' : transform_fields_list,
                            'relational_display' : relational_display,
                            'goto' : 'sql.php',
                            'submit_type' : 'save'
                          };

            if (!g.saveCellsAtOnce) {
                $(g.cEdit).find('*').prop('disabled', true);
                $(g.cEdit).find('.edit_box').addClass('edit_box_posting');
            } else {
                $('div.save_edited').addClass('saving_edited_data')
                    .find('input').prop('disabled', true);    // disable the save button
            }

            $.ajax({
                type: 'POST',
                url: 'tbl_replace.php',
                data: post_params,
                success:
                    function(data) {
                        g.isSaving = false;
                        if (!g.saveCellsAtOnce) {
                            $(g.cEdit).find('*').removeProp('disabled');
                            $(g.cEdit).find('.edit_box').removeClass('edit_box_posting');
                        } else {
                            $('div.save_edited').removeClass('saving_edited_data')
                                .find('input').removeProp('disabled');  // enable the save button back
                        }
                        if (data.success == true) {
                            PMA_ajaxShowMessage(data.message);

                            // update where_clause related data in each edited row
                            $('td.to_be_saved').parents('tr').each(function() {
                                var new_clause = $(this).data('new_clause');
                                var $where_clause = $(this).find('.where_clause');
                                var old_clause = $where_clause.val();
                                var decoded_old_clause = PMA_urldecode(old_clause);
                                var decoded_new_clause = PMA_urldecode(new_clause);

                                $where_clause.val(new_clause);
                                // update Edit, Copy, and Delete links also
                                $(this).find('a').each(function() {
                                    $(this).attr('href', $(this).attr('href').replace(old_clause, new_clause));
                                    // update delete confirmation in Delete link
                                    if ($(this).attr('href').indexOf('DELETE') > -1) {
                                        $(this).removeAttr('onclick')
                                            .unbind('click')
                                            .bind('click', function() {
                                                return confirmLink(this, 'DELETE FROM `' + g.db + '`.`' + g.table + '` WHERE ' +
                                                       decoded_new_clause + (is_unique ? '' : ' LIMIT 1'));
                                            });
                                    }
                                });
                                // update the multi edit checkboxes
                                $(this).find('input[type=checkbox]').each(function() {
                                    var $checkbox = $(this);
                                    var checkbox_name = $checkbox.attr('name');
                                    var checkbox_value = $checkbox.val();

                                    $checkbox.attr('name', checkbox_name.replace(old_clause, new_clause));
                                    $checkbox.val(checkbox_value.replace(decoded_old_clause, decoded_new_clause));
                                });
                            });
                            // update the display of executed SQL query command
                            $('#result_query').remove();
                            if (typeof data.sql_query != 'undefined') {
                                // display feedback
                                $('#sqlqueryresults').prepend(data.sql_query);
                            }
                            // hide and/or update the successfully saved cells
                            g.hideEditCell(true, data);

                            // remove the "Save edited cells" button
                            $('div.save_edited').hide();
                            // update saved fields
                            $(g.t).find('.to_be_saved')
                                .removeClass('to_be_saved')
                                .data('value', null)
                                .data('original_data', null);

                            g.isCellEdited = false;
                        } else {
                            PMA_ajaxShowMessage(data.error, false);
                        }
                    }
            }); // end $.ajax()
        },

        /**
         * Save edited cell, so it can be posted later.
         */
        saveEditedCell: function() {
            /**
             * @var $this_field    Object referring to the td that is being edited
             */
            var $this_field = $(g.currentEditCell);
            var $test_element = ''; // to test the presence of a element

            var need_to_post = false;

            /**
             * @var field_name  String containing the name of this field.
             * @see getFieldName()
             */
            var field_name = getFieldName($this_field);

            /**
             * @var this_field_params   Array temporary storage for the name/value of current field
             */
            var this_field_params = {};

            /**
             * @var is_null String capturing whether 'checkbox_null_<field_name>_<row_index>' is checked.
             */
            var is_null = $(g.cEdit).find('input:checkbox').is(':checked');
            var value;

            if ($(g.cEdit).find('.edit_area').is('.edit_area_loading')) {
                // the edit area is still loading (retrieving cell data), no need to post
                need_to_post = false;
            } else if (is_null) {
                if (!g.wasEditedCellNull) {
                    this_field_params[field_name] = null;
                    need_to_post = true;
                }
            } else {
                if ($this_field.is('.bit')) {
                    this_field_params[field_name] = '0b' + $(g.cEdit).find('.edit_box').val();
                } else if ($this_field.is('.set')) {
                    $test_element = $(g.cEdit).find('select');
                    this_field_params[field_name] = $test_element.map(function(){
                        return $(this).val();
                    }).get().join(",");
                } else if ($this_field.is('.relation, .enum')) {
                    // for relation and enumeration, take the results from edit box value,
                    // because selected value from drop-down, new window or multiple
                    // selection list will always be updated to the edit box
                    this_field_params[field_name] = $(g.cEdit).find('.edit_box').val();
                } else {
                    this_field_params[field_name] = $(g.cEdit).find('.edit_box').val();
                }
                if (g.wasEditedCellNull || this_field_params[field_name] != PMA_getCellValue(g.currentEditCell)) {
                    need_to_post = true;
                }
            }

            if (need_to_post) {
                $(g.currentEditCell).addClass('to_be_saved')
                    .data('value', this_field_params[field_name]);
                if (g.saveCellsAtOnce) {
                    $('div.save_edited').show();
                }
                g.isCellEdited = true;
            }

            return need_to_post;
        },

        /**
         * Save or post currently edited cell, depending on the "saveCellsAtOnce" configuration.
         */
        saveOrPostEditedCell: function() {
            var saved = g.saveEditedCell();
            if (!g.saveCellsAtOnce) {
                if (saved) {
                    g.postEditedCell();
                } else {
                    g.hideEditCell(true);
                }
            } else {
                if (saved) {
                    g.hideEditCell(true, true);
                } else {
                    g.hideEditCell(true);
                }
            }
        },

        /**
         * Initialize column resize feature.
         */
        initColResize: function() {
            // create column resizer div
            g.cRsz = document.createElement('div');
            g.cRsz.className = 'cRsz';

            // get data columns in the first row of the table
            var $firstRowCols = $(g.t).find('tr:first th.draggable');

            // create column borders
            $firstRowCols.each(function() {
                var cb = document.createElement('div'); // column border
                $(cb).addClass('colborder')
                    .mousedown(function(e) {
                        g.dragStartRsz(e, this);
                    });
                $(g.cRsz).append(cb);
            });
            g.reposRsz();

            // attach to global div
            $(g.gDiv).prepend(g.cRsz);
        },

        /**
         * Initialize column reordering feature.
         */
        initColReorder: function() {
            g.cCpy = document.createElement('div');     // column copy, to store copy of dragged column header
            g.cPointer = document.createElement('div'); // column pointer, used when reordering column

            // adjust g.cCpy
            g.cCpy.className = 'cCpy';
            $(g.cCpy).hide();

            // adjust g.cPointer
            g.cPointer.className = 'cPointer';
            $(g.cPointer).css('visibility', 'hidden');  // set visibility to hidden instead of calling hide() to force browsers to cache the image in cPointer class

            // assign column reordering hint
            g.reorderHint = PMA_messages['strColOrderHint'];

            // get data columns in the first row of the table
            var $firstRowCols = $(g.t).find('tr:first th.draggable');

            // initialize column order
            $col_order = $('#col_order');   // check if column order is passed from PHP
            if ($col_order.length > 0) {
                g.colOrder = $col_order.val().split(',');
                for (var i = 0; i < g.colOrder.length; i++) {
                    g.colOrder[i] = parseInt(g.colOrder[i]);
                }
            } else {
                g.colOrder = [];
                for (var i = 0; i < $firstRowCols.length; i++) {
                    g.colOrder.push(i);
                }
            }

            // register events
            $(t).find('th.draggable')
                .mousedown(function(e) {
                    if (g.visibleHeadersCount > 1) {
                        g.dragStartReorder(e, this);
                    }
                })
                .mouseenter(function(e) {
                    if (g.visibleHeadersCount > 1) {
                        $(this).css('cursor', 'move');
                    } else {
                        $(this).css('cursor', 'inherit');
                    }
                })
                .mouseleave(function(e) {
                    g.showReorderHint = false;
                    $(this).tooltip("option", {
                        content: g.updateHint()
                    }) ;
                })
                .dblclick(function(e) {
                    e.preventDefault();
                    $("<div/>")
                    .prop("title", PMA_messages["strColNameCopyTitle"])
                    .addClass("modal-copy")
                    .text(PMA_messages["strColNameCopyText"])
                    .append(
                        $("<input/>")
                        .prop("readonly", true)
                        .val($(this).data("column"))
                        )
                    .dialog({
                        resizable: false,
                        modal: true
                    })
                    .find("input").focus().select();
                });
            // restore column order when the restore button is clicked
            $('div.restore_column').click(function() {
                g.restoreColOrder();
            });

            // attach to global div
            $(g.gDiv).append(g.cPointer);
            $(g.gDiv).append(g.cCpy);

            // prevent default "dragstart" event when dragging a link
            $(t).find('th a').bind('dragstart', function() {
                return false;
            });

            // refresh the restore column button state
            g.refreshRestoreButton();
        },

        /**
         * Initialize column visibility feature.
         */
        initColVisib: function() {
            g.cDrop = document.createElement('div');    // column drop-down arrows
            g.cList = document.createElement('div');    // column visibility list

            // adjust g.cDrop
            g.cDrop.className = 'cDrop';

            // adjust g.cList
            g.cList.className = 'cList';
            $(g.cList).hide();

            // assign column visibility related hints
            g.showAllColText = PMA_messages['strShowAllCol'];

            // get data columns in the first row of the table
            var $firstRowCols = $(g.t).find('tr:first th.draggable');

            // initialize column visibility
            var $col_visib = $('#col_visib');   // check if column visibility is passed from PHP
            if ($col_visib.length > 0) {
                g.colVisib = $col_visib.val().split(',');
                for (var i = 0; i < g.colVisib.length; i++) {
                    g.colVisib[i] = parseInt(g.colVisib[i]);
                }
            } else {
                g.colVisib = [];
                for (var i = 0; i < $firstRowCols.length; i++) {
                    g.colVisib.push(1);
                }
            }

            // make sure we have more than one column
            if ($firstRowCols.length > 1) {
                var $colVisibTh = $(g.t).find('th:not(.draggable)');
                PMA_tooltip(
                    $colVisibTh,
                    'th',
                    PMA_messages['strColVisibHint']
                );

                // create column visibility drop-down arrow(s)
                $colVisibTh.each(function() {
                        var $th = $(this);
                        var cd = document.createElement('div'); // column drop-down arrow
                        var pos = $th.position();
                        $(cd).addClass('coldrop')
                            .click(function() {
                                if (g.cList.style.display == 'none') {
                                    g.showColList(this);
                                } else {
                                    g.hideColList();
                                }
                            });
                        $(g.cDrop).append(cd);
                    });

                // add column visibility control
                g.cList.innerHTML = '<div class="lDiv"></div>';
                var $listDiv = $(g.cList).find('div');
                for (var i = 0; i < $firstRowCols.length; i++) {
                    var currHeader = $firstRowCols[i];
                    var listElmt = document.createElement('div');
                    $(listElmt).text($(currHeader).text())
                        .prepend('<input type="checkbox" ' + (g.colVisib[i] ? 'checked="checked" ' : '') + '/>');
                    $listDiv.append(listElmt);
                    // add event on click
                    $(listElmt).click(function() {
                        if ( g.toggleCol($(this).index()) ) {
                            g.afterToggleCol();
                        }
                    });
                }
                // add "show all column" button
                var showAll = document.createElement('div');
                $(showAll).addClass('showAllColBtn')
                    .text(g.showAllColText);
                $(g.cList).append(showAll);
                $(showAll).click(function() {
                    g.showAllColumns();
                });
                // prepend "show all column" button at top if the list is too long
                if ($firstRowCols.length > 10) {
                    var clone = showAll.cloneNode(true);
                    $(g.cList).prepend(clone);
                    $(clone).click(function() {
                        g.showAllColumns();
                    });
                }
            }

            // hide column visibility list if we move outside the list
            $(t).find('td, th.draggable').mouseenter(function() {
                g.hideColList();
            });

            // attach to global div
            $(g.gDiv).append(g.cDrop);
            $(g.gDiv).append(g.cList);

            // some adjustment
            g.reposDrop();
        },

        /**
         * Initialize grid editing feature.
         */
        initGridEdit: function() {

            function startGridEditing(e, cell) {
                if (g.isCellEditActive) {
                    g.saveOrPostEditedCell();
                } else {
                    g.showEditCell(cell);
                }
                e.stopPropagation();
            }

            // create cell edit wrapper element
            g.cEdit = document.createElement('div');

            // adjust g.cEdit
            g.cEdit.className = 'cEdit';
            $(g.cEdit).html('<textarea class="edit_box" rows="1" ></textarea><div class="edit_area" />');
            $(g.cEdit).hide();

            // assign cell editing hint
            g.cellEditHint = PMA_messages['strCellEditHint'];
            g.saveCellWarning = PMA_messages['strSaveCellWarning'];
            g.alertNonUnique = PMA_messages['strAlertNonUnique'];
            g.gotoLinkText = PMA_messages['strGoToLink'];
            g.showDataRowLinkText = PMA_messages['strShowDataRowLink'];

            // initialize cell editing configuration
            g.saveCellsAtOnce = $('#save_cells_at_once').val();

            // register events
            $(t).find('td.data.click1')
                .click(function(e) {
                    startGridEditing(e, this);
                    // prevent default action when clicking on "link" in a table
                    if ($(e.target).is('.grid_edit a')) {
                        e.preventDefault();
                    }
                });

            $(t).find('td.data.click2')
                .click(function(e) {
                    $cell = $(this);
                    // In the case of relational link, We want single click on the link
                    // to goto the link and double click to start grid-editing.
                    var $link = $(e.target);
                    if ($link.is('.grid_edit.relation a')) {
                        e.preventDefault();
                        // get the click count and increase
                        var clicks = $cell.data('clicks');
                        clicks = (clicks == null) ? 1 : clicks + 1;

                        if (clicks == 1) {
                            // if there are no previous clicks,
                            // start the single click timer
                            timer = setTimeout(function() {
                                // temporarily remove ajax class so the page loader will not handle it,
                                // submit and then add it back
                                $link.removeClass('ajax');
                                AJAX.requestHandler.call($link[0]);
                                $link.addClass('ajax');
                                $cell.data('clicks', 0);
                            }, 700);
                            $cell.data('clicks', clicks);
                            $cell.data('timer', timer);
                        } else {
                            // this is a double click, cancel the single click timer
                            // and make the click count 0
                            clearTimeout($cell.data('timer'));
                            $cell.data('clicks', 0);
                            // start grid-editing
                            startGridEditing(e, this);
                        }
                    }
                })
                .dblclick(function(e) {
                    if ($(e.target).is('.grid_edit a')) {
                        e.preventDefault();
                    } else {
                        startGridEditing(e, this);
                    }
                });

            $(g.cEdit).find('.edit_box').focus(function(e) {
                g.showEditArea();
            });
            $(g.cEdit).find('.edit_box, select').live('keydown', function(e) {
                if (e.which == 13) {
                    // post on pressing "Enter"
                    e.preventDefault();
                    g.saveOrPostEditedCell();
                }
            });
            $(g.cEdit).keydown(function(e) {
                if (!g.isEditCellTextEditable) {
                    // prevent text editing
                    e.preventDefault();
                }
            });
            $('html').click(function(e) {
                // hide edit cell if the click is not from g.cEdit
                if ($(e.target).parents().index(g.cEdit) == -1) {
                    g.hideEditCell();
                }
            }).keydown(function(e) {
                if (e.which == 27 && g.isCellEditActive) {

                    // cancel on pressing "Esc"
                    g.hideEditCell(true);
                }
            });
            $('div.save_edited').click(function() {
                g.hideEditCell();
                g.postEditedCell();
            });
            $(window).bind('beforeunload', function(e) {
                if (g.isCellEdited) {
                    return g.saveCellWarning;
                }
            });

            // attach to global div
            $(g.gDiv).append(g.cEdit);

            // add hint for grid editing feature when hovering "Edit" link in each table row
            if (PMA_messages['strGridEditFeatureHint'] != undefined) {
                PMA_tooltip(
                    $(g.t).find('.edit_row_anchor a'),
                    'a',
                    PMA_messages['strGridEditFeatureHint']
                );
            }
        }
    };

    /******************
     * Initialize grid
     ******************/

    // wrap all data cells, except actions cell, with span
    $(t).find('th, td:not(:has(span))')
        .wrapInner('<span />');

    // create grid elements
    g.gDiv = document.createElement('div');     // create global div

    // initialize the table variable
    g.t = t;

    // get data columns in the first row of the table
    var $firstRowCols = $(t).find('tr:first th.draggable');

    // initialize visible headers count
    g.visibleHeadersCount = $firstRowCols.filter(':visible').length;

    // assign first column (actions) span
    if (! $(t).find('tr:first th:first').hasClass('draggable')) {  // action header exist
        g.actionSpan = $(t).find('tr:first th:first').prop('colspan');
    } else {
        g.actionSpan = 0;
    }

    // assign table create time
    // #table_create_time will only available if we are in "Browse" tab
    g.tableCreateTime = $('#table_create_time').val();

    // assign the hints
    g.sortHint = PMA_messages['strSortHint'];
    g.markHint = PMA_messages['strColMarkHint'];
    g.copyHint = PMA_messages['strColNameCopyHint'];

    // assign common hidden inputs
    var $common_hidden_inputs = $('div.common_hidden_inputs');
    g.token = $common_hidden_inputs.find('input[name=token]').val();
    g.server = $common_hidden_inputs.find('input[name=server]').val();
    g.db = $common_hidden_inputs.find('input[name=db]').val();
    g.table = $common_hidden_inputs.find('input[name=table]').val();

    // add table class
    $(t).addClass('pma_table');

    // add relative position to global div so that resize handlers are correctly positioned
    $(g.gDiv).css('position', 'relative');

    // link the global div
    $(t).before(g.gDiv);
    $(g.gDiv).append(t);

    // FEATURES
    enableResize    = enableResize == undefined ? true : enableResize;
    enableReorder   = enableReorder == undefined ? true : enableReorder;
    enableVisib     = enableVisib == undefined ? true : enableVisib;
    enableGridEdit  = enableGridEdit == undefined ? true : enableGridEdit;
    if (enableResize) {
        g.initColResize();
    }
    if (enableReorder &&
        $('table.navigation').length > 0)    // disable reordering for result from EXPLAIN or SHOW syntax, which do not have a table navigation panel
    {
        g.initColReorder();
    }
    if (enableVisib) {
        g.initColVisib();
    }
    if (enableGridEdit &&
        $(t).is('.ajax'))   // make sure we have the ajax class
    {
        g.initGridEdit();
    }

    // create tooltip for each <th> with draggable class
    PMA_tooltip(
            $(t).find("th.draggable"),
            'th',
            g.updateHint()
    );

    // register events for hint tooltip (anchors inside draggable th)
    $(t).find('th.draggable a')
        .mouseenter(function(e) {
            g.showSortHint = true;
            $(t).find("th.draggable").tooltip("option", {
                content: g.updateHint()
            });
        })
        .mouseleave(function(e) {
            g.showSortHint = false;
            $(t).find("th.draggable").tooltip("option", {
                content: g.updateHint()
            });
        });

    // register events for dragging-related feature
    if (enableResize || enableReorder) {
        $(document).mousemove(function(e) {
            g.dragMove(e);
        });
        $(document).mouseup(function(e) {
            g.dragEnd(e);
        });
    }

    // some adjustment
    $(t).removeClass('data');
    $(g.gDiv).addClass('data');
}
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @fileoverview    functions used wherever an sql query form is used
 *
 * @requires    jQuery
 * @requires    js/functions.js
 *
 */

var $data_a;

/**
 * decode a string URL_encoded
 *
 * @param string str
 * @return string the URL-decoded string
 */
function PMA_urldecode(str)
{
    return decodeURIComponent(str.replace(/\+/g, '%20'));
}

/**
 * endecode a string URL_decoded
 *
 * @param string str
 * @return string the URL-encoded string
 */
function PMA_urlencode(str)
{
    return encodeURIComponent(str).replace(/\%20/g, '+');
}

/**
 * Get the field name for the current field.  Required to construct the query
 * for grid editing
 *
 * @param $this_field  jQuery object that points to the current field's tr
 */
function getFieldName($this_field)
{

    var this_field_index = $this_field.index();
    // ltr or rtl direction does not impact how the DOM was generated
    // check if the action column in the left exist
    var left_action_exist = !$('#table_results').find('th:first').hasClass('draggable');
    // number of column span for checkbox and Actions
    var left_action_skip = left_action_exist ? $('#table_results').find('th:first').attr('colspan') - 1 : 0;
    var field_name = $('#table_results').find('thead').find('th:eq('+ (this_field_index - left_action_skip) + ') a').text();
    // happens when just one row (headings contain no a)
    if ("" == field_name) {
        var $heading = $('#table_results').find('thead').find('th:eq('+ (this_field_index - left_action_skip) + ')').children('span');
        // may contain column comment enclosed in a span - detach it temporarily to read the column name
        var $tempColComment = $heading.children().detach();
        field_name = $heading.text();
        // re-attach the column comment
        $heading.append($tempColComment);
    }

    field_name = $.trim(field_name);

    return field_name;
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('sql.js', function() {
    $('a.delete_row.ajax').unbind('click');
    $('#bookmarkQueryForm').die('submit');
    $('input#bkm_label').unbind('keyup');
    $("#sqlqueryresults").die('makegrid');
    $("#togglequerybox").unbind('click');
    $("#button_submit_query").die('click');
    $("input[name=bookmark_variable]").unbind("keypress");
    $("#sqlqueryform.ajax").die('submit');
    $("input[name=navig].ajax").die('click');
    $("#pageselector").die('change');
    $("#table_results.ajax").find("a[title=Sort]").die('click');
    $("#displayOptionsForm.ajax").die('submit');
    $("#resultsForm.ajax .mult_submit[value=edit]").die('click');
    $("#insertForm .insertRowTable.ajax input[type=submit]").die('click');
    $("#buttonYes.ajax").die('click');
    $('a.browse_foreign').die('click');
    $('th.column_heading.pointer').die('hover');
    $('th.column_heading.marker').die('click');
});

/**
 * @description <p>Ajax scripts for sql and browse pages</p>
 *
 * Actions ajaxified here:
 * <ul>
 * <li>Retrieve results of an SQL query</li>
 * <li>Paginate the results table</li>
 * <li>Sort the results table</li>
 * <li>Change table according to display options</li>
 * <li>Grid editing of data</li>
 * <li>Saving a bookmark</li>
 * </ul>
 *
 * @name        document.ready
 * @memberOf    jQuery
 */
AJAX.registerOnload('sql.js', function() {
    // Delete row from SQL results
    $('a.delete_row.ajax').click(function (e) {
        e.preventDefault();
        var question = $.sprintf(PMA_messages['strDoYouReally'], $(this).closest('td').find('div').text());
        var $link = $(this);
        $link.PMA_confirm(question, $link.attr('href'), function (url) {
            $msgbox = PMA_ajaxShowMessage();
            $.get(url, {'ajax_request':true, 'is_js_confirmed': true}, function (data) {
                if (data.success) {
                    PMA_ajaxShowMessage(data.message);
                    $link.closest('tr').remove();
                } else {
                    PMA_ajaxShowMessage(data.error, false);
                }
            })
        });
    });

    // Ajaxification for 'Bookmark this SQL query'
    $('#bookmarkQueryForm').live('submit', function (e) {
        e.preventDefault();
        PMA_ajaxShowMessage();
        $.post($(this).attr('action'), 'ajax_request=1&' + $(this).serialize(), function (data) {
            if (data.success) {
                PMA_ajaxShowMessage(data.message);
            } else {
                PMA_ajaxShowMessage(data.error, false);
            }
        });
    });

    /* Hides the bookmarkoptions checkboxes when the bookmark label is empty */
    $('input#bkm_label').keyup(function() {
        $('input#id_bkm_all_users, input#id_bkm_replace')
            .parent()
            .toggle($(this).val().length > 0);
    }).trigger('keyup');

    /**
     * Attach the {@link makegrid} function to a custom event, which will be
     * triggered manually everytime the table of results is reloaded
     * @memberOf    jQuery
     */
    $("#sqlqueryresults").live('makegrid', function() {
        PMA_makegrid($('#table_results')[0]);
    });

    /**
     * Append the "Show/Hide query box" message to the query input form
     *
     * @memberOf jQuery
     * @name    appendToggleSpan
     */
    // do not add this link more than once
    if (! $('#sqlqueryform').find('a').is('#togglequerybox')) {
        $('<a id="togglequerybox"></a>')
        .html(PMA_messages['strHideQueryBox'])
        .appendTo("#sqlqueryform")
        // initially hidden because at this point, nothing else
        // appears under the link
        .hide();

        // Attach the toggling of the query box visibility to a click
        $("#togglequerybox").bind('click', function() {
            var $link = $(this);
            $link.siblings().slideToggle("fast");
            if ($link.text() == PMA_messages['strHideQueryBox']) {
                $link.text(PMA_messages['strShowQueryBox']);
                // cheap trick to add a spacer between the menu tabs
                // and "Show query box"; feel free to improve!
                $('#togglequerybox_spacer').remove();
                $link.before('<br id="togglequerybox_spacer" />');
            } else {
                $link.text(PMA_messages['strHideQueryBox']);
            }
            // avoid default click action
            return false;
        });
    }


    /**
     * Event handler for sqlqueryform.ajax button_submit_query
     *
     * @memberOf    jQuery
     */
    $("#button_submit_query").live('click', function(event) {
        var $form = $(this).closest("form");
        // the Go button related to query submission was clicked,
        // instead of the one related to Bookmarks, so empty the
        // id_bookmark selector to avoid misinterpretation in
        // import.php about what needs to be done
        $form.find("select[name=id_bookmark]").val("");
        // let normal event propagation happen
    });

    /**
     * Event handler for hitting enter on sqlqueryform bookmark_variable
     * (the Variable textfield in Bookmarked SQL query section)
     *
     * @memberOf    jQuery
     */
    $("input[name=bookmark_variable]").bind("keypress", function(event) {
        // force the 'Enter Key' to implicitly click the #button_submit_bookmark
        var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
        if (keycode == 13) { // keycode for enter key
            // When you press enter in the sqlqueryform, which
            // has 2 submit buttons, the default is to run the
            // #button_submit_query, because of the tabindex
            // attribute.
            // This submits #button_submit_bookmark instead,
            // because when you are in the Bookmarked SQL query
            // section and hit enter, you expect it to do the
            // same action as the Go button in that section.
            $("#button_submit_bookmark").click();
           return false;
        } else  {
           return true;
        }
    });

    /**
     * Ajax Event handler for 'SQL Query Submit'
     *
     * @see         PMA_ajaxShowMessage()
     * @memberOf    jQuery
     * @name        sqlqueryform_submit
     */
    $("#sqlqueryform.ajax").live('submit', function(event) {
        event.preventDefault();

        var $form = $(this);
        if (! checkSqlQuery($form[0])) {
            return false;
        }

        // remove any div containing a previous error message
        $('div.error').remove();

        var $msgbox = PMA_ajaxShowMessage();
        var $sqlqueryresults = $('#sqlqueryresults');

        PMA_prepareForAjaxRequest($form);

        $.post($form.attr('action'), $form.serialize() , function(data) {
            if (data.success == true) {
                // success happens if the query returns rows or not
                //
                // fade out previous messages, if any
                $('div.success, div.sqlquery_message').fadeOut();
                if ($('#result_query').length) {
                    $('#result_query').remove();
                }

                // show a message that stays on screen
                if (typeof data.action_bookmark != 'undefined') {
                    // view only
                    if ('1' == data.action_bookmark) {
                        $('#sqlquery').text(data.sql_query);
                        // send to codemirror if possible
                        setQuery(data.sql_query);
                    }
                    // delete
                    if ('2' == data.action_bookmark) {
                        $("#id_bookmark option[value='" + data.id_bookmark + "']").remove();
                    }
                    $sqlqueryresults
                     .show()
                     .html(data.message);
                } else if (typeof data.sql_query != 'undefined') {
                    $('<div class="sqlquery_message"></div>')
                     .html(data.sql_query)
                     .insertBefore('#sqlqueryform');
                    // unnecessary div that came from data.sql_query
                    $('div.notice').remove();
                } else {
                    $sqlqueryresults
                     .show()
                     .html(data.message);
                }

                if (typeof data.ajax_reload != 'undefined') {
                    if (data.ajax_reload.reload) {
                        if (data.ajax_reload.table_name) {
                            PMA_commonParams.set('table', data.ajax_reload.table_name);
                            PMA_commonActions.refreshMain();
                        } else {
                            PMA_reloadNavigation();
                        }
                    }
                } else if (typeof data.reload != 'undefined') {
                    // this happens if a USE or DROP command was typed
                    PMA_commonActions.setDb(data.db);
                    var url;
                    if (data.db) {
                        if (data.table) {
                            url = 'table_sql.php';
                        } else {
                            url = 'db_sql.php';
                        }
                    } else {
                        url = 'server_sql.php';
                    }
                    PMA_commonActions.refreshMain(url, function () {
                        if ($('#result_query').length) {
                            $('#result_query').remove();
                        }
                        if (data.sql_query) {
                            $('<div id="result_query"></div>')
                                .html(data.sql_query)
                                .prependTo('#page_content');
                        }
                    });
                }

                $sqlqueryresults.show().trigger('makegrid');
                $('#togglequerybox').show();
                PMA_init_slider();

                if (typeof data.action_bookmark == 'undefined') {
                    if ( $('#sqlqueryform input[name="retain_query_box"]').is(':checked') != true ) {
                        if ($("#togglequerybox").siblings(":visible").length > 0) {
                            $("#togglequerybox").trigger('click');
                        }
                    }
                }
            } else if (data.success == false ) {
                // show an error message that stays on screen
                $('#sqlqueryform').before(data.error);
                $sqlqueryresults.hide();
            }
            PMA_ajaxRemoveMessage($msgbox);
        }); // end $.post()
    }); // end SQL Query submit

    /**
     * Paginate results with Page Selector dropdown
     * @memberOf    jQuery
     * @name        paginate_dropdown_change
     */
    $("#pageselector").live('change', function(event) {
        var $form = $(this).parent("form");
        $form.submit();
    }); // end Paginate results with Page Selector

    /**
     * Ajax Event handler for the display options
     * @memberOf    jQuery
     * @name        displayOptionsForm_submit
     */
    $("#displayOptionsForm.ajax").live('submit', function(event) {
        event.preventDefault();

        $form = $(this);

        $.post($form.attr('action'), $form.serialize() + '&ajax_request=true' , function(data) {
            $("#sqlqueryresults")
             .html(data.message)
             .trigger('makegrid');
            PMA_init_slider();
        }); // end $.post()
    }); //end displayOptionsForm handler

/**
 * Ajax Event for table row change
 * */
    $("#resultsForm.ajax .mult_submit[value=edit]").live('click', function(event){
        event.preventDefault();

        /*Check whether atleast one row is selected for change*/
        if ($("#table_results tbody tr, #table_results tbody tr td").hasClass("marked")) {
            var $div = $('<div id="change_row_dialog"></div>');

            /**
             * @var    button_options  Object that stores the options passed to jQueryUI
             *                          dialog
             */
            var button_options = {};
            // in the following function we need to use $(this)
            button_options[PMA_messages['strCancel']] = function() {
                $(this).dialog('close');
            };

            var button_options_error = {};
            button_options_error[PMA_messages['strOK']] = function() {
                $(this).dialog('close');
            };
            var $form = $("#resultsForm");
            var $msgbox = PMA_ajaxShowMessage();

            $.get($form.attr('action'), $form.serialize()+"&ajax_request=true&submit_mult=row_edit", function(data) {
                //in the case of an error, show the error message returned.
                if (data.success != undefined && data.success == false) {
                    $div
                    .append(data.error)
                    .dialog({
                        title: PMA_messages['strChangeTbl'],
                        height: 230,
                        width: 900,
                        open: PMA_verifyColumnsProperties,
                        close: function(event, ui) {
                            $(this).remove();
                        },
                        buttons : button_options_error
                    }); // end dialog options
                } else {
                    $div
                    .append(data.message)
                    .dialog({
                        title: PMA_messages['strChangeTbl'],
                        height: 600,
                        width: 900,
                        open: PMA_verifyColumnsProperties,
                        close: function(event, ui) {
                            $(this).remove();
                        },
                        buttons : button_options
                    })
                    //Remove the top menu container from the dialog
                    .find("#topmenucontainer").hide()
                    ; // end dialog options
                    $("table.insertRowTable").addClass("ajax");
                    $("#buttonYes").addClass("ajax");
                }
                PMA_ajaxRemoveMessage($msgbox);
            }); // end $.get()
        } else {
            PMA_ajaxShowMessage(PMA_messages['strNoRowSelected']);
        }
    });

/**
 * Click action for "Go" button in ajax dialog insertForm -> insertRowTable
 */
    $("#insertForm .insertRowTable.ajax input[type=submit]").live('click', function(event) {
        event.preventDefault();
        /**
         * @var    the_form    object referring to the insert form
         */
        var $form = $("#insertForm");
        PMA_prepareForAjaxRequest($form);
        //User wants to submit the form
        $.post($form.attr('action'), $form.serialize(), function(data) {
            if (data.success == true) {
                PMA_ajaxShowMessage(data.message);
                if ($("#pageselector").length != 0) {
                    $("#pageselector").trigger('change');
                } else {
                    $("input[name=navig].ajax").trigger('click');
                }

            } else {
                PMA_ajaxShowMessage(data.error, false);
                $("#table_results tbody tr.marked .multi_checkbox " +
                        ", #table_results tbody tr td.marked .multi_checkbox").prop("checked", false);
                $("#table_results tbody tr.marked .multi_checkbox " +
                        ", #table_results tbody tr td.marked .multi_checkbox").removeClass("last_clicked");
                $("#table_results tbody tr" +
                        ", #table_results tbody tr td").removeClass("marked");
            }
            if ($("#change_row_dialog").length > 0) {
                $("#change_row_dialog").dialog("close").remove();
            }
            /**Update the row count at the tableForm*/
            $("#result_query").remove();
            $("#sqlqueryresults").prepend(data.sql_query);
            $("#result_query .notice").remove();
            $("#result_query").prepend((data.message));
        }); // end $.post()
    }); // end insert table button "Go"

/**$("#buttonYes.ajax").live('click'
 * Click action for #buttonYes button in ajax dialog insertForm
 */

    $("#buttonYes.ajax").live('click', function(event){
        event.preventDefault();
        /**
         * @var    the_form    object referring to the insert form
         */
        var $form = $("#insertForm");
        /**Get the submit type in the form*/
        var selected_submit_type = $("#insertForm").find("#actions_panel .control_at_footer option:selected").val();
        $("#result_query").remove();
        PMA_prepareForAjaxRequest($form);
        //User wants to submit the form
        $.post($form.attr('action'), $form.serialize() , function(data) {
            if (data.success == true) {
                PMA_ajaxShowMessage(data.message);
                if (selected_submit_type == "showinsert") {
                    $("#sqlqueryresults").prepend(data.sql_query);
                    $("#result_query .notice").remove();
                    $("#result_query").prepend(data.message);
                    $("#table_results tbody tr.marked .multi_checkbox " +
                        ", #table_results tbody tr td.marked .multi_checkbox").prop("checked", false);
                    $("#table_results tbody tr.marked .multi_checkbox " +
                        ", #table_results tbody tr td.marked .multi_checkbox").removeClass("last_clicked");
                    $("#table_results tbody tr" +
                        ", #table_results tbody tr td").removeClass("marked");
                } else {
                    if ($("#pageselector").length != 0) {
                        $("#pageselector").trigger('change');
                    } else {
                        $("input[name=navig].ajax").trigger('click');
                    }
                    $("#result_query").remove();
                    $("#sqlqueryresults").prepend(data.sql_query);
                    $("#result_query .notice").remove();
                    $("#result_query").prepend((data.message));
                }
            } else {
                PMA_ajaxShowMessage(data.error, false);
                $("#table_results tbody tr.marked .multi_checkbox " +
                    ", #table_results tbody tr td.marked .multi_checkbox").prop("checked", false);
                $("#table_results tbody tr.marked .multi_checkbox " +
                    ", #table_results tbody tr td.marked .multi_checkbox").removeClass("last_clicked");
                $("#table_results tbody tr" +
                    ", #table_results tbody tr td").removeClass("marked");
            }
            if ($("#change_row_dialog").length > 0) {
                $("#change_row_dialog").dialog("close").remove();
            }
        }); // end $.post()
    });

}); // end $()


/**
 * Starting from some th, change the class of all td under it.
 * If isAddClass is specified, it will be used to determine whether to add or remove the class.
 */
function PMA_changeClassForColumn($this_th, newclass, isAddClass)
{
    // index 0 is the th containing the big T
    var th_index = $this_th.index();
    var has_big_t = !$this_th.closest('tr').children(':first').hasClass('column_heading');
    // .eq() is zero-based
    if (has_big_t) {
        th_index--;
    }
    var $tds = $this_th.closest('table').find('tbody tr').find('td.data:eq('+th_index+')');
    if (isAddClass == undefined) {
        $tds.toggleClass(newclass);
    } else {
        $tds.toggleClass(newclass, isAddClass);
    }
}

AJAX.registerOnload('sql.js', function() {

    $('a.browse_foreign').live('click', function(e) {
        e.preventDefault();
        window.open(this.href, 'foreigners', 'width=640,height=240,scrollbars=yes,resizable=yes');
        $anchor = $(this);
        $anchor.addClass('browse_foreign_clicked');
    });

    /**
     * vertical column highlighting in horizontal mode when hovering over the column header
     */
    $('th.column_heading.pointer').live('hover', function(e) {
        PMA_changeClassForColumn($(this), 'hover', e.type == 'mouseenter');
        });

    /**
     * vertical column marking in horizontal mode when clicking the column header
     */
    $('th.column_heading.marker').live('click', function() {
        PMA_changeClassForColumn($(this), 'marked');
        });

    /**
     * create resizable table
     */
    $("#sqlqueryresults").trigger('makegrid');
});

/*
 * Profiling Chart
 */
function makeProfilingChart()
{
    if ($('#profilingchart').length == 0
        || $('#profilingchart').html().length != 0
    ) {
        return;
    }

    var data = [];
    $.each(jQuery.parseJSON($('#profilingChartData').html()),function(key,value) {
        data.push([key,parseFloat(value)]);
    });

    // Remove chart and data divs contents
    $('#profilingchart').html('').show();
    $('#profilingChartData').html('');

    PMA_createProfilingChartJqplot('profilingchart', data);
}
;

