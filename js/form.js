$(document).ready(function()
{
  /***** CONTROLE DU NOM *****/
  $('#lastname').blur(function()
  {
    var lastname = $('#lastname').val();

    if (lastname.length > 2 && lastname.length < 21) 
    {
      $('#lastname').addClass('valid').removeClass('invalid');
      $("#lastnameHelp").hide();
    } 
    else 
    {
      $('#lastname').addClass('invalid').removeClass('valid');
      $("#lastnameHelp").show();
    }
  });

  /***** CONTROLE DU PRENOM ******/
  $('#firstname').blur(function()
  {
    var firstname = $('#firstname').val();
    if (firstname.length > 2 && firstname.length < 21) 
    {
      $('#firstname').addClass('valid').removeClass('invalid');
      $("#firstnameHelp").hide();
    } 
    else 
    {
      $('#firstname').addClass('invalid').removeClass('valid');
      $("#firstnameHelp").show();
    }
  });
  
  /***** CONTROLE DU PSEUDO *****/
  $('#nickname').blur(function()
  {
    var nickname = $('#nickname').val();
    if(nickname == '')
    {
      $('#nickname').removeClass('valid');             
      $('#nickname').removeClass('invalid');
    }
    else if (nickname.length > 2 && nickname.length < 21) 
    {
      $('#nickname').addClass('valid').removeClass('invalid');
    } 
    else 
    {
      $('#nickname').addClass('invalid').removeClass('valid');
    }
  });

  /***** CONTROLE DU MOT DE PASSE *****/
  /* Vérification si au moins 6 caractères dont une majuscule, une minuscule, et un chiffre */
  $('#password').blur(function()
  {
    var password = $('#password').val();
    var passwordCheck = $('#passwordCheck').val();
    var passwordRegex= /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,}$/;

    if (passwordRegex.test(password)) 
    {
      $('#password').addClass('valid').removeClass('invalid');
      $('#passwordHelp').hide();
    } 
    else 
    {
      $('#password').addClass('invalid').removeClass('valid');
      $('#passwordHelp').show();
    }

    if(password == '')
    {
      $('#passwordCheck').removeClass('valid');             
      $('#passwordCheck').removeClass('invalid');
    }
    else if (password == passwordCheck) 
    {
      $('#passwordCheck').addClass('valid').removeClass('invalid');
      $('#passwordCheckHelp').hide();
    } 
    else 
    {
      $('#passwordCheck').addClass('invalid').removeClass('valid');
      $('#passwordCheckHelp').show();
    }
  });
  
  $('#password').focus(function()
  {               
    if($('#password').hasClass('valid')) 
    {
      $('#passwordHelp').hide();
    } 
    else 
    {
      $('#passwordHelp').show();
    }
  });

  /* Vérification de la correspondance des mots de passe*/
  $('#passwordCheck').blur(function()
  {
    var password = $('#password').val();
    var passwordCheck = $('#passwordCheck').val();

    if(password == '')
    {
      $('#passwordCheck').removeClass('valid');             
      $('#passwordCheck').removeClass('invalid');
    }
    else if (password == passwordCheck) 
    {
      $('#passwordCheck').addClass('valid').removeClass('invalid');
      $('#passwordCheckHelp').hide();
    } 
    else 
    {
      $('#passwordCheck').addClass('invalid').removeClass('valid');
      $('#passwordCheckHelp').show();
    }
  });

  /* Effacement du mot de passe de vérification si le 1er mot de passe est changé */
  $('#password').change(function()
  {
    $('#passwordCheck').val('');
  });
            
  /***** CONTROLE DU FORMAT DE L'EMAIL *****/
  $('#email').blur(function()
  {
    var email = $('#email').val();
    var emailRegex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;

    if (emailRegex.test(email)) 
    {
      $('#email').addClass('valid').removeClass('invalid');
      $('#emailHelp').hide();
    } 
    else 
    {
      $('#email').addClass('invalid').removeClass('valid');
      $('#emailHelp').show();
    }
  });

  /***** CONTROLE DU FORMAT DU TELEPHONE *****/
  $('#phone').blur(function()
  {
    var phone = $('#phone').val();
    var phoneRegex = /^(0|\+33)[1-9]( ?-?\.?[0-9]{2}){4}$/;

    if (phoneRegex.test(phone)) 
    {
      $('#phone').addClass('valid').removeClass('invalid');
      $('#phoneHelp').hide();
    } 
    else 
    {
      $('#phone').addClass('invalid').removeClass('valid');
      $('#phoneHelp').show();
    }
  });
  
  /***** CONTROLE DU NOM DE LA SOCIETE *****/
  $('#society').blur(function()
  {
    var society = $('#society').val();
    
    if(society == '')
    {
      $('#society').removeClass('valid');             
      $('#society').removeClass('invalid');
      $('#societyHelp').hide();
    }
    else if (society.length > 2 && society.length < 20) 
    {
      $('#society').addClass('valid').removeClass('invalid');
      $('#societyHelp').hide();
    } 
    else 
    {
      $('#society').addClass('invalid').removeClass('valid');
      $('#societyHelp').show();
    }
  });
  
  /***** CONTROLE DE L'ACTIVITE ******/
  $('#activity').blur(function()
  {
    var activity = $('#activity').val();
    if (activity != 'coiffeur' && activity != 'masseur') 
    {
      $('#activity').css('border', '2px solid #F44336');
    }
    else
    {
      $('#activity').css('border', '1px solid #ced4da');
    }
  });
  
  /***** CONTROLE DU FORMAT DU SIRET *****/
  $('#siret').blur(function()
  {
    var siret = $('#siret').val();
    var siretRegex = /^[0-9]{14}$/;

    if (siretRegex.test(siret)) 
    {
      $('#siret').addClass('valid').removeClass('invalid');
      $('#siretHelp').hide();
    } 
    else 
    {
      $('#siret').addClass('invalid').removeClass('valid');
      $('#siretHelp').show();
    }
  });

  /***** CONTROLE DU FORMAT DU CODE POSTAL *****/
  $('#postalCode').blur(function()
  {
    var postalCode = $('#postalCode').val();
    var postalCodeRegex = /^[0-9]{5}$/;

    if(postalCode == '')
    {
      $('#postalCode').removeClass('valid');             
      $('#postalCode').removeClass('invalid');
      $('#postalCodeHelp').hide();
    }
    else if (postalCodeRegex.test(postalCode)) 
    {
      $('#postalCode').addClass('valid').removeClass('invalid');
      $('#postalCodeHelp').hide();
    } 
    else 
    {
      $('#postalCode').addClass('invalid').removeClass('valid');
      $('#postalCodeHelp').show();
    }
  });
});