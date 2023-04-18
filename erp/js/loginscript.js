/*
Author: Pradeep Khodke
URL: http://www.codingcage.com/
*/

$('document').ready(function()
{ 
    /* validation Weroi Login Form */
    $("#login-form").validate({
        rules:
        {
            password: {
                required: false
            },
            user_name: {
                required: true
            }
        },
        messages:
            {
            password:{
                required: "Por favor introduzca su contraseña"
            },
            user_name:{
                user_name: "Por favor introduzca su usuario"
            }
        },
        submitHandler: submitForm	
    });  
    /* validation */
    
    /* validation Weroi Login Form */
    $("#login-client-form").validate({
        rules:
        {
            password: {
                required: false
            },
            user_name: {
                required: true
            }
        },
        messages:
            {
            password:{
                required: "Por favor introduzca su contraseña"
            },
            user_name:{
                user_name: "Por favor introduzca su usuario"
            }
        },
        submitHandler: submitClientForm	
    });  
    /* validation */
    
    /* validation Signin Form */
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
            sign_name: {
                required: true
            },
            signemail: {
                required: true,
                email: true
            },
            sign_apellidos: {
                required: true
            },
            signtlfno: {
                required: true
            },
            signempresa: {
                required: true
            }
        },
        messages:
        {
            signpassword:{
                required: "Por favor introduzca su contraseña"
            },
            signpassword2:{
                required: "Por favor repita su contraseña"
            },
            sign_name:{
                required: "Por favor introduzca su nombre"
            },
            signuser_name:{
                required: "Por favor introduzca un nombre de usuario"
            },
            signemail:{
                required: "Por favor introduzca una dirección de email válida",
                email: "Por favor introduzca una dirección de email válida"
            },
            sign_apellidos: {
                required: "Por favor introduzca su apellido"
            },
            signtlfno: {
                required: "Por favor introduzca su teléfono"
            },
            signempresa: {
                required: "Por favor introduzca su empresa"
            }
       },
        submitHandler: submitSignInForm	
    });  
    /* validation */
    
    $("#btn-signin").click('', function (e) {
        $("label.error").remove();
    });
    
    
    /* validation Client Signin Form */
    $("#client-signin-form").validate({
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
            signname: {
                required: true
            },
            signemail: {
                required: true,
                email: true
            },
            sign_apellidos: {
                required: true
            },
            signtlfno: {
                required: true
            },
            signempresa: {
                required: true
            }
        },
        messages:
        {
            signpassword:{
                required: "Por favor introduzca su contraseña"
            },
            signpassword2:{
                required: "Por favor repita su contraseña"
            },
            signuser_name:{
                required: "Por favor introduzca su nombre"
            },
            signname:{
                required: "Por favor introduzca su nombre"
            },
            sign_apellidos:{
                required: "Por favor introduzca su apellido"
            },
            signuser_name:{
                required: "Por favor introduzca un nombre de usuario"
            },
            signempresa:{
                required: "Por favor introduzca su empresa"
            },
            signtlfno:{
                required: "Por favor introduzca su teléfono"
            },
            signemail:{
                required: "Por favor introduzca una dirección de email válida",
                email: "Por favor introduzca una dirección de email válida"
            }
       },
        submitHandler: submitClientSignInForm	
    });  
    /* validation */
    
	   
    /* login submit */
    function submitForm()
    {		
         var data = $("#login-form").serialize();

         $.ajax({
             type : 'POST',
             url  : '/erp/core/login-process.php',
             data : data,
             beforeSend: function()
             {	
                 $("#error").fadeOut();
                 $("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; enviando ...');
             },
             success :  function(response)
             {						
                 if(response === "ok"){

                     $("#btn-login").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" /> &nbsp; Iniciando ...');
                     setTimeout(' window.location.href = "/erp/index.php"; ',1000);
                 }
                 else{

                     $("#error").fadeIn(1000, function(){						
                         $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
                         $("#btn-login").html('&nbsp; ACCEDER');
                     });
                 }
             }
         });
         return false;
    }
    /* login submit */
    
    /* Client login submit */
    function submitClientForm()
    {		
         var data = $("#login-client-form").serialize();

         $.ajax({
             type : 'POST',
             url  : '/erp/core/client-login-process.php',
             data : data,
             beforeSend: function()
             {	
                 $("#client-login-error").fadeOut();
                 $("#btn-login-client").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; enviando ...');
             },
             success :  function(response)
             {						
                 if(response === "ok"){

                     $("#btn-login-client").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" /> &nbsp; Iniciando ...');
                     setTimeout(' window.location.href = "/erp/index.php"; ',1000);
                 }
                 else{

                     $("#client-login-error").fadeIn(1000, function(){						
                         $("#client-login-error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
                         $("#btn-login-client").html('&nbsp; ACCEDER');
                     });
                 }
             }
         });
         return false;
    }
    /* Client login submit */
    
    /* signin submit */
    function submitSignInForm()
    {   
        var data = $("#signin-form").serialize();
        $.ajax({

            type : 'POST',
            url  : '/erp/core/signin-process.php',
            data : data,
            beforeSend: function()
            {	
                $("#signerror").fadeOut();
                $("#btn-signin").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" /> &nbsp; Registrando ...');
            },
            success :  function(response)
            {						
                if(response === "ok"){
                    $("#signsuccess").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Registro completado. Deberá esperar a que Weroi le de acceso.</div>');
                    $("#btn-signin").html('&nbsp; SOLICITAR');
                    //setTimeout(' window.location.href = "/login.php"; ',4000);
                }
                else{
                    //alert (response);
                    $("#signerror").fadeIn(1000, function(){						
                        $("#signerror").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
                        $("#btn-signin").html('&nbsp; SOLICITAR');
                    });
                }
            }
        });
        return false;
    }	   
    /* signin submit */
    
    /* signin submit */
    function submitClientSignInForm()
    {		
        var data = $("#client-signin-form").serialize();
        $.ajax({

            type : 'POST',
            url  : '/erp/core/client-signin-process.php',
            data : data,
            beforeSend: function()
            {	
                $("#signerror").fadeOut();
                $("#btn-signin").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" /> &nbsp; Registrando ...');
            },
            success :  function(response)
            {						
                if(response === "ok"){
                    $("#signsuccess").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Registro completado. Deberá esperar a que Weroi le de acceso.</div>');
                    $("#btn-signin").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; SOLICITAR');
                    //setTimeout(' window.location.href = "/loginclientes.php"; ',4000);
                }
                else{
                    //alert (response);
                    $("#signerror").fadeIn(1000, function(){						
                        $("#signerror").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
                        $("#btn-signin").html('&nbsp; SOLICITAR');
                    });
                }
            }
        });
        return false;
    }	   
    /* signin submit */
});