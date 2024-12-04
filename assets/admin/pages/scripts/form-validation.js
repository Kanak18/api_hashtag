$(document).ready(function() {
    setTimeout(function() {
        $('.alert-success').hide();
    }, 3000);
    setTimeout(function() {
        $('.alert-error').hide();
    }, 3000);
});
var FormValidation = function() {
    var userFunction = function() {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#form_sample_1');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {},
            rules: {
                Name: {
                    minlength: 2,
                    required: true
                },
                Email: {
                    email: true
                },
                phone: {
                    required: true,
                    number: true
                }

            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                //                success1.show();
                //                error1.hide();

                $.ajax({
                    url: "register_db.php",
                    type: "POST",
                    data: $('#form_sample_1').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (result.status) {
                            if (result.msg == "New user added successfully.") {
                                $("#Name").val('');
                                $("#Email1").val('');
                                $("#phone").val('');
                                $("#facebook").val('');
                                $("#twitter").val('');
                                $("#instagram").val('');
                            }
                            success1.show();
                            $('.alert-success').empty().html(result.msg);
                            error1.hide();
                            setTimeout(function() {
                                $('.alert-success').hide();
                            }, 3000);
                            window.location = result.urlfilename;
                        } else {
                            error1.show();
                            //                            alert(result.status+2);
                            $('.alert-danger').empty().html(result.html);
                            setTimeout(function() {
                                $('.alert-danger').hide();
                            }, 3000);
                            success1.hide();
                        }
                    }
                });
                return false;
            }
        });
        $('#form_sample_1').keypress(function(e) {
            if (e.which == 13) {
                if ($('#form_sample_1').validate().form()) {
                    $.ajax({
                        url: "register_db.php",
                        type: "POST",
                        data: $('#form_sample_1').serialize(),
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (result.status) {
                                if (result.msg == "New user added successfully.") {
                                    $("#Name").val('');
                                    $("#Name").focus();
                                    $("#Email1").val('');
                                    $("#phone").val('');
                                    $("#facebook").val('');
                                    $("#twitter").val('');
                                    $("#instagram").val('');
                                }
                                success1.show();
                                $('.alert-success').empty().html(result.msg);
                                error1.hide();
                                setTimeout(function() {
                                    $('.alert-success').hide();
                                }, 3000);
                                window.location = result.urlfilename;
                            } else {
                                error1.show();
                                $("#Name").focus();
                                $('.alert-danger').empty().html(result.html);
                                setTimeout(function() {
                                    $('.alert-danger').hide();
                                }, 3000);
                                success1.hide();
                            }
                        }
                    });
                    return false;
                }
            }
        });
    }

    var changepassFunction = function() {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var changepass = $('#changepass');
        var error1 = $('.alert-danger', changepass);
        var success1 = $('.alert-success', changepass);
        changepass.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {},
            rules: {
                currentpass: {
                    required: true,
                    minlength: 5,
                },
                newpass: {
                    required: true,
                    minlength: 5,
                },
                newpass_confirm: {
                    required: true,
                    minlength: 5,
                    equalTo: "#newpass"
                }

            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "changepass_db.php",
                    type: "POST",
                    data: $('#changepass').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (result.status) {
                            success1.show();
                            $('.alert-success').empty().html(result.msg);
                            error1.hide();
                            setTimeout(function() {
                                $('.alert-success').hide();
                            }, 3000);
                            window.location = result.urlfilename;
                        } else {
                            error1.show();
                            $('.alert-danger').empty().html(result.html);
                            setTimeout(function() {
                                $('.alert-danger').hide();
                            }, 3000);
                            success1.hide();
                        }
                        $("#currentpass").val('');
                        $("#currentpass").focus();
                        $("#newpass").val('');
                        $("#newpass_confirm").val('');
                    }
                });
                return false;
            }
        });
        $('#changepass input').keypress(function(e) {
            if (e.which == 13) {
                if ($('#changepass').validate().form()) {
                    $.ajax({
                        url: "changepass_db.php",
                        type: "POST",
                        data: $('#changepass').serialize(),
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (result.status) {
                                success1.show();
                                $('.alert-success').empty().html(result.msg);
                                error1.hide();
                                setTimeout(function() {
                                    $('.alert-success').hide();
                                }, 3000);
                                window.location = result.urlfilename;
                            } else {
                                error1.show();
                                $('.alert-danger').empty().html(result.html);
                                setTimeout(function() {
                                    $('.alert-danger').hide();
                                }, 3000);
                                success1.hide();
                            }
                            $("#currentpass").val('');
                            $("#currentpass").focus();
                            $("#newpass").val('');
                            $("#newpass_confirm").val('');
                        }
                    });
                    return false;
                }
                return false;
            }
        });
    }

    var changesettingFunction = function() {

        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var changesetting = $('#changesetting');
        var error1 = $('.alert-danger', changesetting);
        var success1 = $('.alert-success', changesetting);
        changesetting.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                win_sound: {
                    accept: "Please upload mp3,wav audio file only "
                },
                loose_sound: {
                    accept: "Please upload mp3,wav audio file only "
                },
                spin_sound: {
                    accept: "Please upload mp3,wav audio file only "
                },
                immortal_player_sound: {
                    accept: "Please upload mp3,wav audio file only "
                }
            },
            rules: {
                email: {
                    required: true,
                    email: true
                },
                femail: {
                    required: true,
                    email: true
                },
                fname: {
                    required: true,
                }
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                function onsuccess(result) {
                    if (result.status) {
                        $('.alert-success').empty().html(result.msg);
                        success1.show();
                        error1.hide();
                        setTimeout(function() {
                            $('.alert-success').hide();
                        }, 3000);
                        //                        window.location = result.urlfilename;
                    } else {
                        error1.show();
                        $('.alert-danger').empty().html(result.html);
                        setTimeout(function() {
                            $('.alert-danger').hide();
                        }, 3000);
                        success1.hide();
                    }

                }
                var options = {
                    url: "changepass_db.php",
                    data: {
                        type: 'image'
                    },
                    dataType: 'json',
                    cache: false,
                    success: onsuccess
                };
                $('#changesetting').ajaxSubmit(options);
                return false;
            }
        });
        $('#changesetting input').keypress(function(e) {
            if (e.which == 13) {
                if ($('#changepass').validate().form()) {
                    function onsuccess(result) {
                        if (result.status) {
                            $('.alert-success').empty().html(result.msg);
                            success1.show();
                            error1.hide();
                            setTimeout(function() {
                                $('.alert-success').hide();
                            }, 3000);
                            //                            window.location = result.urlfilename;
                        } else {
                            error1.show();
                            $('.alert-danger').empty().html(result.html);
                            setTimeout(function() {
                                $('.alert-danger').hide();
                            }, 3000);
                            success1.hide();
                        }

                    }
                    return false;
                }
                return false;
            }
        });
    }

    var appFunction = function() {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#app');

        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        var action = $("#myaction").val();
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {                
            },
            rules: {
                app_name: {
                    required: true
                },
                package_name: {
                    required: true
                },
                ad_network: {
                    required: true
                }                
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                //                success1.show();
                //                error1.hide();

                $.ajax({
                    url: "app_db.php",
                    type: "POST",
                    data: $('#app').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {                        
                        if (result.status) {
                            if (result.msg == "New app added successfully.") {
                                $('input[type=text], textarea, select').val('');                                
                            }
                            success1.show();
                            $('.alert-success').empty().html(result.msg);
                            error1.hide();
                            setTimeout(function() {
                                $('.alert-success').hide();
                                window.location = result.urlfilename;
                            }, 2000);                            
                        } else {
                            error1.show();
                            //                            alert(result.status+2);
                            $('.alert-danger').empty().html(result.html);
                            setTimeout(function() {
                                $('.alert-danger').hide();
                            }, 2000);
                            success1.hide();
                        }
                    }
                });
                return false;
            }

        });        
    }
	
	var coinlinkFunction = function() {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#coinlink');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {},
            rules: {
                link_title: {                  
                    required: true
                },
                link_desc: {
                    required: true
                },
                link_source: {
                    required: true
                }
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                //                success1.show();
                //                error1.hide();

                $.ajax({
                    url: "coin_db.php",
                    type: "POST",
                    data: $('#coinlink').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (result.status) {
                            if (result.msg == "New link added successfully.") {
                                $("#link_title").val('');
                                $("#link_desc").val('');                              
                            }
                            success1.show();
                            $('.alert-success').empty().html(result.msg);
                            error1.hide();
                            setTimeout(function() {
                                $('.alert-success').hide();
                            }, 3000);
                            window.location = result.urlfilename;
                        } else {
                            error1.show();
                            //                            alert(result.status+2);
                            $('.alert-danger').empty().html(result.html);
                            setTimeout(function() {
                                $('.alert-danger').hide();
                            }, 3000);
                            success1.hide();
                        }
                    }
                });
                return false;
            }
        });
        $('#form_sample_1').keypress(function(e) {
            if (e.which == 13) {
                if ($('#form_sample_1').validate().form()) {
                    $.ajax({
                        url: "register_db.php",
                        type: "POST",
                        data: $('#form_sample_1').serialize(),
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (result.status) {
                                if (result.msg == "New user added successfully.") {
                                    $("#Name").val('');
                                    $("#Name").focus();
                                    $("#Email1").val('');
                                    $("#phone").val('');
                                    $("#facebook").val('');
                                    $("#twitter").val('');
                                    $("#instagram").val('');
                                }
                                success1.show();
                                $('.alert-success').empty().html(result.msg);
                                error1.hide();
                                setTimeout(function() {
                                    $('.alert-success').hide();
                                }, 3000);
                                window.location = result.urlfilename;
                            } else {
                                error1.show();
                                $("#Name").focus();
                                $('.alert-danger').empty().html(result.html);
                                setTimeout(function() {
                                    $('.alert-danger').hide();
                                }, 3000);
                                success1.hide();
                            }
                        }
                    });
                    return false;
                }
            }
        });
    }
    var fcmFunction = function() {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#fcm');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {},
            rules: {
                fcm_key: {                  
                    required: true
                }
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                //                success1.show();
                //                error1.hide();

                $.ajax({
                    url: "fcm_db.php",
                    type: "POST",
                    data: $('#fcm').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (result.status) {
                            if (result.msg == "Key added successfully.") {
                                $("#link_title").val('');
                                $("#link_desc").val('');                              
                            }
                            success1.show();
                            $('.alert-success').empty().html(result.msg);
                            error1.hide();
                            setTimeout(function() {
                                $('.alert-success').hide();
                            }, 3000);
                            window.location = result.urlfilename;
                        } else {
                            error1.show();
                            //                            alert(result.status+2);
                            $('.alert-danger').empty().html(result.html);
                            setTimeout(function() {
                                $('.alert-danger').hide();
                            }, 3000);
                            success1.hide();
                        }
                    }
                });
                return false;
            }
        });
        $('#form_sample_1').keypress(function(e) {
            if (e.which == 13) {
                if ($('#form_sample_1').validate().form()) {
                    $.ajax({
                        url: "register_db.php",
                        type: "POST",
                        data: $('#form_sample_1').serialize(),
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (result.status) {
                                if (result.msg == "New user added successfully.") {
                                    $("#Name").val('');
                                    $("#Name").focus();
                                    $("#Email1").val('');
                                    $("#phone").val('');
                                    $("#facebook").val('');
                                    $("#twitter").val('');
                                    $("#instagram").val('');
                                }
                                success1.show();
                                $('.alert-success').empty().html(result.msg);
                                error1.hide();
                                setTimeout(function() {
                                    $('.alert-success').hide();
                                }, 3000);
                                window.location = result.urlfilename;
                            } else {
                                error1.show();
                                $("#Name").focus();
                                $('.alert-danger').empty().html(result.html);
                                setTimeout(function() {
                                    $('.alert-danger').hide();
                                }, 3000);
                                success1.hide();
                            }
                        }
                    });
                    return false;
                }
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            userFunction();
            changepassFunction();
            changesettingFunction();
            appFunction();
			coinlinkFunction();
            fcmFunction();
                  
        }
    };
}();