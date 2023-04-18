/*
Author: Pradeep Khodke
URL: http://www.codingcage.com/
*/

$('document').ready(function()
{ 
     /* validation */
    $("#login-form").validate({
        rules:
        {
            password: {
                required: true
            },
            user_name: {
                required: true
            }
        },
        messages:
            {
            password:{
                required: "por favor introduce tu contraseña"
            },
            user_name:{
                user_name: "por favor introduce un nombre de usuario"
            }
        },
        submitHandler: submitForm	
    });  
    /* validation */
	   
    $("#signin-form").validate({
        rules:
        {
            signpassword: {
                required: true
            },
            signpassword2: {
                required: true
            },
            signuser_name: {
                required: true
            },
            signemail: {
                required: true
            }
        },
        messages:
        {
            signpassword:{
                required: "por favor introduce tu contraseña"
            },
            signpassword2:{
                required: "por favor repite tu contraseña"
            },
            signuser_name:{
                required: "por favor introduce un nombre de usuario"
            },
            signemail:{
                required: "por favor introduce un nombre de usuario"
            }
       },
	   submitHandler: submitSignInForm	
       });  
        /* validation */
	   
        /* login submit */
        function submitForm()
        {		
             var data = $("#login-form").serialize();

             $.ajax({
                 type : 'POST',
                 url  : '/core/login-process.php',
                 data : data,
                 beforeSend: function()
                 {	
                     $("#error").fadeOut();
                     $("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; enviando ...');
                 },
                 success :  function(response)
                 {						
                     if(response === "ok"){

                         $("#btn-login").html('<img src="/img/btn-ajax-loader.gif" height="20" /> &nbsp; Iniciando ...');
                         setTimeout(' window.location.href = "/index.php"; ',4000);
                     }
                     else{

                         $("#error").fadeIn(1000, function(){						
                             $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
                             $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; LOGIN');
                         });
                     }
                 }
             });
             return false;
         }
        /* login submit */
        /* signin submit */
        function submitSignInForm()
        {		
            var data = $("#signin-form").serialize();
            $.ajax({

                type : 'POST',
                url  : '/core/signin-process.php',
                data : data,
                beforeSend: function()
                {	
                    $("#signerror").fadeOut();
                    $("#btn-signin").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; enviando ...');
                },
                success :  function(response)
                {						
                    if(response == "ok"){
                        $("#btn-signin").html('<img src="/img/btn-ajax-loader.gif" height="20" /> &nbsp; Registrando ...');
                        setTimeout(' window.location.href = "/login.php"; ',4000);
                    }
                    else{
                        //alert (response);
                        $("#signerror").fadeIn(1000, function(){						
                            $("#signerror").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
                            $("#btn-signin").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; REGÍSTRATE');
                        });
                    }
                }
            });
            return false;
        }	   
        /* signin submit */
});