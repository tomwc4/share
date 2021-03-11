// add extra v2 invisible recaptcha handler for before form validations
//(assuming recaptcha is enqueued above)

jQuery(document).ready(function($){ 
//check if recaptcha field exists 
  if ($('.ginput_recaptcha').length) { 
    $('.input').on('click', function() { 
      //console.log ('check recaptcha');
      //activate v2 invisible recaptcha
      grecaptcha.execute(); 
    });
  } else { 
   // console.log ( 'has no recaptcha' ); 
  } 
})
