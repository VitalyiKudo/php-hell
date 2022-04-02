<script>
    $(document).ready(function(){

        //Initialize Select2 Elements
        $('.select2').select2({
            templateSelection : function (container){
                // here we are finding option element of tag and
                // if it has property 'locked' we will add class 'locked-tag'
                // to be able to style element in select
                var $option = $('.select2 option[value="'+id+'"]');
                if ($option.attr('locked')){
                    $(container).addClass('locked-tag');
                    locked = true;
                }
                return text;
            },
        }).on('select2:unselecting', function(e){
            // before removing tag we check option element of tag and
            // if it has property 'locked' we will create error to prevent all select2 functionality
            if ($(e.params.args.data.element).attr('locked')) {
                e.select2.pleaseStop();
            }
        });
/*
        let dataCities = {--!! $cities !!--};
            //console.log(dataCities);
        let cities = (dataCities.length  > 0) ? $.map(dataCities, function (val, item) {
            let city = (!$.isEmptyObject(val.city)) ? val.city + ', ' : '';
            let region = (!$.isEmptyObject(val.region)) ? val.region + ', ' : '';
            let country = (!$.isEmptyObject(val.country)) ? val.country : '';
            return {id: val.geonameid, text: city + ' ' + region + ' ' + country};
        }) : '';
        console.log(cities);
*/

        $('#city').select2({
            minimumInputLength: 3,
            closeOnSelect: false,
            tags: false,
            placeholder:'Select a City',
            ajax: {
                url: '{{ route('admin.operator.ajaxSearchCity') }}',
                dataType: 'json',
                type: 'post',
                quietMillis: 50,
                data: function (params) {
                    var queryParameters = {
                        city: params.term,
                        _token: '{{ csrf_token() }}',
                        page: params.page
                    };
                    return queryParameters;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function (val, item) {
                            var city = (!$.isEmptyObject(val.city)) ? val.city + ', ' : '';
                            var region = (!$.isEmptyObject(val.region)) ? val.region + ', ' : '';
                            var country = (!$.isEmptyObject(val.country)) ? val.country : '';
                            return { id: val.geonameid, text: city + ' ' + region + ' ' + country};
                        }),
                        // if more then 30 items in dropdown, remaining set of items  will be show on numbered page link in dropdown control.
                        pagination: { more: (params.page * 30) < data.length }
                    };
                }
            }
        });

        /*$('#airport').select2({
            minimumInputLength: 3,
            tags: false,
            minimumResultsForSearch: 1,
            selectOnClose: false,
            ajax: {
                url: '{{-- route('admin.operator.ajaxSearchAirport') --}}',
                dataType: 'json',
                type: 'post',
                quietMillis: 50,
                data: function (params) {
                    var queryParameters = {
                        airports: params.term,
                        _token: '{{-- csrf_token() --}}',
                        page: params.page
                    };
                    return queryParameters;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function (val, item) {
                            var icao = val.icao;
                            var iata = (!$.isEmptyObject(val.iata)) ? ' | ' + val.iata : '';
                            var airport = (!$.isEmptyObject(val.airport)) ? val.airport + ', ' : '';
                            var city = (!$.isEmptyObject(val.city)) ? val.city + ', ' : '';
                            var region = (!$.isEmptyObject(val.region)) ? val.region + ', ' : '';
                            var country = (!$.isEmptyObject(val.country)) ? val.country : '';
                            return { id: val.icao, text: airport + ' (' + icao + iata + ') ' +city + ' ' + region + ' ' + country};
                        }),
                        // if more then 30 items in dropdown, remaining set of items  will be show on numbered page link in dropdown control.
                        pagination: { more: (params.page * 30) < data.length }
                    };
                }
            }
        });*/

        $.validator.methods.email = function( value, element ) {
            return this.optional( element ) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test( value );
        }

        var validobj = $('#quickForm').validate({
            ignoreTitle: true,
            ignore: 'input[type=search], .select2-input',
            success: function(label){
                label.addClass("valid").removeClass('error');//.text("Ok!");
            },
            error: function(label){
                label.addClass("error").removeClass('valid');
            },
            rules: {
                name: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    minlength: 3
                },
                email: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    email: true
                },
                email_other: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return false;
                        }
                    },
                    email: true,
                    minlength: 0
                },
                city: {
                    required: true,
                    minlength: 1
                }/*,
                airport: {
                    required: true,
                    minlength: 1
                }*/
            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                email_other: {
                    email: "Please enter a valid email address"
                },
                city: {
                    required: "Please provide a city",
                    minlength: "Please enter a valid city address",
                }/*,
                airport: {
                    required: "Please provide a airport",
                    minlength: "Please enter a valid airport",
                }*/
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                if(element.attr("id") == 'email') {
                    if (($('#email-error').length > 0) == false) {
                        element.after(error);
                    }
                    else if ( $("#email-error").hasClass("text-success")) {
                        $(element).nextAll('#email-error').first('div').remove();
                        element.after(error);
                    }
                }
                else {
                    element.after(error);
                }
            },

            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('');
                $(element).nextAll('span.select2-container').first('div').addClass('is-invalid').removeClass('text-success');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('');
                $(element).nextAll('span.select2-container').first('div').removeClass('is-invalid').addClass('text-success');
            }
        });

        //If the change event fires we want to see if the form validates.
        $(document).on('change', '#quickForm', function() {
            //validobj.form();
        });

        var startTimer;
        $('#email').on('change', function () {
            clearTimeout(startTimer);
        });
        $('#email').on('change', function () { // keyup focusout
            clearTimeout(startTimer);
            if ($('#email').valid() === true && $('#email-error').hasClass('text-success') !== true) {
                startTimer = setTimeout(checkEmail($(this).val()), 500);
            }
        });

        $('input[type="tel"]').usPhoneFormat({
            format: '(xxx) xxx-xxxx',
        });

        function checkEmail(email) {
            $.ajax({
                type: 'post',
                url: "{{ route('admin.operator.ajaxValidationEmail') }}",
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                datatype: 'json'
            })
                .done(function (data) {
                    if (data.success === true) {
                        $('#email-error').text(data.message).removeClass('is-invalid').addClass('text-success');
                        return false;
                    }
                    else {
                        $('#email').removeClass('text-success').addClass('is-invalid');
                        $('#email-error').text(data.message[0]).removeClass('text-success').addClass('is-invalid');
                        return false;
                    }
                })
                .fail(function (data) {
                    return false;
                })
        }

        $('#city-select2').observe(function () {
            $(this).find('.select2-container').addClass('form-control');
        });

        /*$('#airport-select2').observe(function () {
            $(this).find('.select2-container').addClass('form-control');
        });*/
    });

</script>
