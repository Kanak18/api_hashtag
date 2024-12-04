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
            messages: {
            },
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
                        if (result.status)
                        {
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
                            if (result.status)
                            {
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
            messages: {
            },
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
                        if (result.status)
                        {
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
                            if (result.status)
                            {
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
                }, loose_sound: {
                    accept: "Please upload mp3,wav audio file only "
                }, spin_sound: {
                    accept: "Please upload mp3,wav audio file only "
                }, immortal_player_sound: {
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
                    if (result.status)
                    {
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
                    data: {type: 'image'},
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
                        if (result.status)
                        {
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
    var usersFunction = function() {
// for more info visit the official plugin documentation:
// http://docs.jquery.com/Plugins/Validation

        var form1 = $('#users');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        var action = $("#myaction").val();
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                photo: {
                    accept: "Please upload jpg, jpeg, png, gif image only "
                }				
            },
            rules: {
                login_username: {
                    minlength: 2,
                    required: true
                },
                password: {
                    required: function() {
                        if (action == 'edit')
                            return false;
                        else
                            return true;
                    }
                },                
                phone: {
                    number: true
                },
                photo: {
                    accept: "image/jpeg, image/jpg, image/png, image/gif"
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

 function onsuccess(result) {
                 if (result.status)
                    {
                        success1.show();
                        $('.alert-success').empty().html(result.html);
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

                }
                var options = {
                    url: "users_db.php",
                    data: {type: 'uploadImage'},
                    dataType: 'json',
                    cache: false,
                    success: onsuccess
                };
                $('#users').ajaxSubmit(options);
                return false;
            }
					   
        });
        $('#users').keypress(function(e) {
            if (e.which == 13) {
                if ($('#users').validate().form()) {
                    //$.ajax({
//                        url: "users_db.php",
//                        type: "POST",
//                        data: $('#users').serialize(),
//                        dataType: 'json',
//                        cache: false,
//                        success: function(result) {
//                            if (result.status)
//                            {
//                                if (result.msg == "New user added successfully.") {
//                                    $("#name").val('');
//                                    $("#name").focus();
//                                    $("#password").val('');
//                                    $("#email").val('');
//                                    $("#phone").val('');
//                                }
//                                success1.show();
//                                $('.alert-success').empty().html(result.msg);
//                                error1.hide();
//                                setTimeout(function() {
//                                    $('.alert-success').hide();
//                                }, 3000);
//                                window.location = result.urlfilename;
//                            } else {
//                                error1.show();
//                                $("#name").focus();
//                                $('.alert-danger').empty().html(result.html);
//                                setTimeout(function() {
//                                    $('.alert-danger').hide();
//                                }, 3000);
//                                success1.hide();
//                            }
//                        }
//                    });
					function onsuccess(result) {
					if (result.status)
                        {
                            success1.show();
                            $("#point_to").val('');
                            $('.alert-success').empty().html(result.html);
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
					}
                    
                    var options = {
                        url: "users_db.php",
                        data: {type: 'uploadImage'},
                        dataType: 'json',
                        cache: false,
                        success: onsuccess
                    };
                    $('#users').ajaxSubmit(options);
					
                    return false;
                }
            }
        });
    }
    var cmsFunction = function() {

// for more info visit the official plugin documentation:
// http://docs.jquery.com/Plugins/Validation

        var cms = $('#cmsForm');
        var error1 = $('.alert-danger', cms);
        var success1 = $('.alert-success', cms);
        cms.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                image: {
                    accept: "Please upload jpg, jpeg, png, gif image only "
                }, video_image: {
                    accept: "Please upload jpg, jpeg, png, gif image only "
                }, video: {
                    accept: "Please upload mp4,mpeg video file only "
                }
            },
            rules: {
                catname: {
                    required: true,
                }/*, calink: {
                 url: true
                 }*/, video_url: {
                    url: true
                }, image: {
                    accept: "image/jpeg, image/jpg, image/png, image/gif"
                }, video_image: {
                    accept: "image/jpeg, image/jpg, image/png, image/gif"
                }, video: {
                    accept: "video/mp4,video/mpeg"
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
//                var editor2 = CKEDITOR.instances['editor2'].getData();
//                $.ajax({
//                    url: "cms_db.php",
//                    type: "POST",
//                    data: 'editor2=' + editor2 + '&aid=' + $('#aid').val() + '&myaction=' + $('#myaction').val() + '&file_name=' + $('#file_name').val() + '&page_name=' + $('#page_name').val() + '&status=' + $("input[name=status]:checked").val(),
////                    data: $('#cmsForm').serialize(),
//                    dataType: 'json',
//                    cache: false,
//                    success: function(result) {
//                        if (result.status)
//                        {
//                            success1.show();
//                            $('.alert-success').empty().html(result.html);
//                            error1.hide();
//                            setTimeout(function() {
//                                $('.alert-success').hide();
//                            }, 3000);
//                            window.location = result.urlfilename;
//                        } else {
//                            error1.show();
//                            $('.alert-danger').empty().html(result.html);
//                            setTimeout(function() {
//                                $('.alert-danger').hide();
//                            }, 3000);
//                            success1.hide();
//                        }
//                        $("#file_name").val('');
//                        $("#file_name").focus();
//                        $("#page_name").val('');
//                    }
//                });

                var editor2 = CKEDITOR.instances['editor2'].getData();
                function onsuccess(result) {
                    if (result.status)
                    {
                        success1.show();
                        $("#catname").val('');
                        $("#catname").focus();
                        $('.alert-success').empty().html(result.html);
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

                }
                var options = {
                    url: "cms_db.php",
                    data: {type: 'image', editor2: editor2},
                    dataType: 'json',
                    cache: false,
                    success: onsuccess
                };
                $('#cmsForm').ajaxSubmit(options);
                return false;
            }
        });
        $('#cmsForm input').keypress(function(e) {
            if (e.which == 13) {
                if ($('#cmsForm').validate().form()) {
                    var editor2 = CKEDITOR.instances['editor2'].getData();
                    function onsuccess(result) {
                        if (result.status)
                        {
                            success1.show();
                            $("#page_name").val('');
                            $("#page_name").focus();
                            $('.alert-success').empty().html(result.html);
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

                    }
                    var options = {
                        url: "cms_db.php",
                        data: {type: 'image', editor2: editor2},
                        dataType: 'json',
                        cache: false,
                        success: onsuccess
                    };
                    $('#cmsForm').ajaxSubmit(options);
                    return false;
                }
                return false;
            }
        });
    }
	var predefinedMessagesFunction = function() {
        var form1 = $('#predefinedmessages');
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
                message: {
                    minlength: 2,
					maxlength: 140,
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
                $.ajax({
                    url: "predefined_messages_db.php",
                    type: "POST",
                    data: $('#predefinedmessages').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (result.status)
                        {
                            if (result.msg == "New user message successfully.") {
                                $("#message").val('');
                                $("#message").focus();
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
        $('#predefinedmessages').keypress(function(e) {
            if (e.which == 13) {
                if ($('#predefinedmessages').validate().form()) {
                    $.ajax({
                        url: "predefined_messages_db.php",
                        type: "POST",
                        data: $('#predefinedmessages').serialize(),
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (result.status)
                            {
                                if (result.msg == "New message added successfully.") {
                                    $("#message").val('');
                                    $("#message").focus();
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
                                $("#message").focus();
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
	var flyinglocationFunction = function() {
        var form1 = $('#flyinglocation');
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
                cust_id: {                    
                    required: true
                },
				 location_name: {
                    minlength: 2,
                    required: true
                },
				 location_lat: {
                    minlength: 2,
                    required: true
                },
				 location_lng: {
                    minlength: 2,
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
                $.ajax({
                    url: "flying_location_db.php",
                    type: "POST",
                    data: $('#flyinglocation').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (result.status)
                        {
                            if (result.msg == "New location added successfully.") {
                                $("#message").val('');
                                $("#message").focus();
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
        $('#flyinglocation').keypress(function(e) {
            if (e.which == 13) {
                if ($('#flyinglocation').validate().form()) {
                    $.ajax({
                        url: "flying_location_db.php",
                        type: "POST",
                        data: $('#flyinglocation').serialize(),
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (result.status)
                            {
                                if (result.msg == "New location added successfully.") {
                                    $("#message").val('');
                                    $("#message").focus();
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
                                $("#message").focus();
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
	var flyinglogFunction = function() {
        var form1 = $('#flyinglog');
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
                cust_id: {                    
                    required: true
                },
				 location_id: {                   
                    required: true
                },
				 lat: {
                    minlength: 2,
                    required: true
                },
				 lng: {
                    minlength: 2,
                    required: true
                },
				 start_time: {
                    minlength: 2,
                    required: true
                }
				,
				 end_time: {
                    minlength: 2,
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
                $.ajax({
                    url: "flying_log_db.php",
                    type: "POST",
                    data: $('#flyinglog').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (result.status)
                        {
                            if (result.msg == "New location added successfully.") {
                                $("#message").val('');
                                $("#message").focus();
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
        $('#flyinglog').keypress(function(e) {
            if (e.which == 13) {
                if ($('#flyinglog').validate().form()) {
                    $.ajax({
                        url: "flying_log_db.php",
                        type: "POST",
                        data: $('#flyinglog').serialize(),
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (result.status)
                            {
                                if (result.msg == "Location log added successfully.") {
                                    $("#message").val('');
                                    $("#message").focus();
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
                                $("#message").focus();
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
            usersFunction();
            cmsFunction();
			predefinedMessagesFunction();
			flyinglocationFunction();
			flyinglogFunction();
        }
    };
}();
