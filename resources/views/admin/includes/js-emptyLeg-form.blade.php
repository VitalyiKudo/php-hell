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

        $('#operatorEmail').select2({
            minimumInputLength: 3,
            closeOnSelect: true,
            tags: false,
            placeholder:'Select a Operator',
            ajax: {
                url: '{{ route('admin.emptyLeg.ajaxSearchOperator') }}',
                dataType: 'json',
                type: 'post',
                quietMillis: 50,
                data: function (params) {
                    var queryParameters = {
                        operatorEmail: params.term,
                        _token: '{{ csrf_token() }}',
                        page: params.page
                    };
                    return queryParameters;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function (val, item) {
                            var name = (!$.isEmptyObject(val.name)) ? val.name + ', ' : '';
                            var email = (!$.isEmptyObject(val.email)) ? val.email : '';
                            return { id: email, text: name + ' ' + email};
                        }),
                        // if more then 30 items in dropdown, remaining set of items  will be show on numbered page link in dropdown control.
                        pagination: { more: (params.page * 30) < data.length }
                    };
                }
            }
        });

        $('#icaoDeparture').select2({
            minimumInputLength: 3,
            closeOnSelect: true,
            tags: false,
            placeholder:'Select a Airport',
            ajax: {
                url: '{{ route('admin.emptyLeg.ajaxSearchAirport') }}',
                dataType: 'json',
                type: 'post',
                quietMillis: 50,
                data: function (params) {
                    var queryParameters = {
                        airport: params.term,
                        _token: '{{ csrf_token() }}',
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
                            var geoNameIdCity = ($(val.geoNameIdCity).length > 0) ? val.geoNameIdCity : '';

                            return { id: val.icao, text: airport + ' (' + icao + iata + ') ' +city + ' ' + region + ' ' + country, geoid: geoNameIdCity };
                        }),
                        // if more then 30 items in dropdown, remaining set of items  will be show on numbered page link in dropdown control.
                        pagination: { more: (params.page * 30) < data.length }
                    };
                }
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            $('#geoNameIdCityDeparture').val(data.geoid);
        });

        $('#icaoArrival').select2({
            minimumInputLength: 3,
            closeOnSelect: true,
            tags: false,
            placeholder:'Select a Airport',
            ajax: {
                url: '{{ route('admin.emptyLeg.ajaxSearchAirport') }}',
                dataType: 'json',
                type: 'post',
                quietMillis: 50,
                data: function (params) {
                    var queryParameters = {
                        airport: params.term,
                        _token: '{{ csrf_token() }}',
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
                            var geoNameIdCity = ($(val.geoNameIdCity).length > 0) ? val.geoNameIdCity : '';

                            return { id: val.icao, text: airport + ' (' + icao + iata + ') ' +city + ' ' + region + ' ' + country, geoid: geoNameIdCity };
                        }),
                        // if more then 30 items in dropdown, remaining set of items  will be show on numbered page link in dropdown control.
                        pagination: { more: (params.page * 30) < data.length }
                    };
                }
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            $('#geoNameIdCityArrival').val(data.geoid);
        });

        $.validator.addMethod('notOnlyZero', function (value, element, param) {
            return this.optional(element) || parseInt(value) > 0;
        });

        var validobj = $('#quickForm').validate({
            //debug: true,
            ignoreTitle: true,
            ignore: 'input[type=search], .select2-input',
            success: function(label){
                label.addClass("valid").removeClass('error');//.text("Ok!");
            },
            error: function(label){
                label.addClass("error").removeClass('valid');
            },
            rules: {
                icaoDeparture: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    minlength: 1
                },
                icaoArrival: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    minlength: 1
                },
                operatorEmail: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    minlength: 1
                },
                typePlane: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    minlength: 1
                },
                price: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    number: true
                    /*, notOnlyZero: '0'*/
                },
                dateDeparture: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    dateISO: false
                }
            },
            messages: {
                icaoDeparture: {
                    required: "Please provide a airport",
                    minlength: "Please enter a valid airport address",
                },
                icaoArrival: {
                    required: "Please provide a airport",
                    minlength: "Please enter a valid airport address",
                },
                operatorEmail: {
                    required: "Please provide a city",
                    minlength: "Please enter a valid city address",
                },
                typePlane: {
                    required: "Please provide a type Plane",
                    minlength: "Please enter a valid type Plane",
                },
                price: {
                    required: "Please provide a Price",
                    minlength: "Please enter a valid Price",
                    notOnlyZero: "Please enter a valid Price"
                },
                dateDeparture: {
                    required: "Please provide a Date",
                    minlength: "Please enter a valid Date",
                }
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                if(element.attr("id") == 'typePlane') {
                    if (($('#typePlane-error').length > 0) == false) {
                        element.after(error);
                    }
                    else if ( $("#typePlanel-error").hasClass("text-success")) {
                        $(element).nextAll('#typePlane-error').first('div').remove();
                        element.after(error);
                    }
                }
                else {
                    //element.after(error);
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
            validobj.form();
        });

        $('#operatorEmail-select2').observe(function () {
            $(this).find('.select2-container').addClass('form-control');
        });

        $('#icaoDeparture-select2').observe(function () {
            $(this).find('.select2-container').addClass('form-control');
        });

        $('#icaoArrival-select2').observe(function () {
            $(this).find('.select2-container').addClass('form-control');
        });

        $('#typePlane').on('change', function () {
            this.value == '' ? $(this).addClass('color-placeholder') : $(this).removeClass('color-placeholder')
        });

        $(function(){
            $('#emptyLegs span').tooltip();
        });
        //Date range picker with time picker
        //$('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
        $('#dateDeparture').daterangepicker({
            timePicker: true,
            timePickerIncrement: 10,
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            autoUpdateInput: false,
            autoClose: true,
            placeholder: 'Enter date',
            drops: 'auto',
            icons: { time: 'far fa-clock' },
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        }).on("apply.daterangepicker", function(e, picker) {
            picker.element.val(picker.startDate.format(picker.locale.format));
            e.preventDefault();
        }).on("cancel.daterangepicker", function(e, picker) {
            if(e.keyCode == 8 || e.keyCode == 46) {
                picker.element.val('');
            }
        });

        $('.iconDateDeparture').click(function(e){
            e.preventDefault();
            $('#dateDeparture').click();
        });
    });

</script>
