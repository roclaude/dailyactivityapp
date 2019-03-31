$( document ).ready(function() {
    console.log( "ready!" );

    deleteActivity();
    editActivity();
    cancelActivity();
    saveActivity();

    function deleteActivity() {
        
        $('button.delete-activity').on('click', function() {

            var sure = confirm('Are you sure?');
            
            if (sure) {

                var data    = {};
                var $tr     = $(this).closest('tr');

                data['activity_id'] = $tr.attr('data-idactivity');

                $.ajax({
                    url: "includes/delete_activity.php", 
                    type: "post",
                    dataType: 'json',
                    data: data,
                    success: function(result){
                        //console.log(result.respond);

                        var table = $tr.closest('table');
                    
                        $($tr).remove();
                        correct_lines_numbers(table);
                    }
                });
            }
        });
    }

    function saveActivity() {
        
        $('button.save-activity').on('click', function() {
            var self = this;

            var data        = {};
            
            var $tr         = $(this).closest('tr');
            var $inputs     = $($tr).find('input');
            var activity_id = $($tr).attr('data-idactivity');

            data['activity_id'] = activity_id;

            // create json
            for(var i=0; i<$inputs.length; i++) {
                var name = $inputs[i].name;
                var val  = $inputs[i].value;
     
                data[name] = val;
            }

            $.ajax({
                url: 'includes/update_activity.php', 
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(result){
                    //console.log(result.respond);

                    if (result.respond == true) {
                        $($inputs).prop('readonly', true);
                        $tr.removeClass('edit');
                    }
                },
                error: function(err) {}
            });
        });
    }

    function editActivity() {
        
        $('button.edit-activity').on('click', function() {
            defaultValuesActivity = {};

            var $tr     = $(this).closest('tr');
            var $inputs = $tr.find('input');

            $tr.addClass('edit');

            for(var i=0; i<$inputs.length; i++) {
                $($inputs[i]).attr("data-default", $($inputs[i]).val());
                $($inputs[i]).prop('readonly', false);
            }
        });
    }

    function cancelActivity() {
       
        $('button.cancel-activity').on('click', function() {

            var $tr     = $(this).closest('tr');
            var $inputs = $tr.find('input');

            $tr.removeClass('edit');

            for(var i=0; i<$inputs.length; i++) {
                $($inputs[i]).val( $($inputs[i]).attr("data-default") );
                $($inputs[i]).prop('readonly', true);
            }
        });
    }

    // Change table crt
    function correct_lines_numbers($table) {
        var noLineClass = 'td.act_no';
        var $el = $($table).find(noLineClass);

        for(var i=0; i<$el.length; i++) {
            $($el[i]).text(i+1);
        }
    }

    // Add activity
    $('form#add-activity-form').submit(function(e) {
        e.preventDefault();
        var self = this;

        var data = {};
        var $inputs = $(this).find('input');
        var $selects = $(this).find('select');

        // create json
        for(var i=0; i<$inputs.length; i++) {
            var name = $inputs[i].name;
            var val  = $inputs[i].value;
 
            data[name] = val;
        }

        for(var i=0; i<$selects.length; i++) {
            var name = $selects[i].name;
            var val  = $selects[i].value;
 
            data[name] = val;
        }

        $.ajax({
            url: "includes/add_activity.php", 
            type: "post",
            dataType: 'html',
            data: data,
            success: function(result){

                // hide alert messages
                $(self).find('.alert').css('display', 'none');

                //clear input fields
                $(self).find('input:not([type=hidden])').val('');
                $(self).find('select').val(0);

                if (result) {
                    $(self).find('.alert.alert-success').css('display', 'block');
                    $('#table-activity-wrap').html(result);

                    deleteActivity();
                    editActivity();
                    cancelActivity();
                    saveActivity();
                } else {
                    $(self).find('.alert.alert-danger').css('display', 'block');
                }
            },
            error: function(err) {
                $(self).find('.alert').css('display', 'none');
                $(self).find('.alert.alert-danger').css('display', 'bllock');
            }
        });
    });

});
