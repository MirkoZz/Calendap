
$(document).ready(function(){
  /***** MODIFICATION DU NOM *****/
  $("#lastnameModif").click(function(){
    $("#lastnameValue").hide();
    $(this).css("visibility", 'hidden');
    $("#lastnameProfil").show();
    $("#lastnameProfil").focus();
     
  });
  
  $("#lastnameProfil").blur(function(){   
    var lastname = $('#lastnameProfil').val();
    if (lastname.length < 3 || lastname.length > 20)
    {
      $("#lastnameHelp").show();
      $("#lastnameModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#lastnameHelp").hide();
      $("#lastnameModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#lastnameValue").text($("#lastnameProfil").val());
    $("#lastnameValue").show();
    $(this).hide();
    $("#lastnameModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DU PRENOM *****/
  $("#firstnameModif").click(function(){
    $("#firstnameValue").hide();
    $(this).css("visibility", 'hidden');
    $("#firstnameProfil").show();
    $("#firstnameProfil").focus();
  });
  
  $("#firstnameProfil").blur(function(){   
    var firstname = $('#firstnameProfil').val();
    if (firstname.length < 3 || firstname.length > 20)
    {
      $("#firstnameHelp").show();
      $("#firstnameModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#firstnameHelp").hide();
      $("#firstnameModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#firstnameValue").text($("#firstnameProfil").val());
    $("#firstnameValue").show();
    $(this).hide();
    $("#firstnameModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DU L'EMAIL *****/
  $("#emailModif").click(function()
  {
    $("#emailValue").hide();
    $(this).css("visibility", 'hidden');
    $("#emailProfil").show();
    $("#emailProfil").focus();
  });
  
  $("#emailProfil").blur(function()
  {   
    var email = $('#emailProfil').val();
    var emailRegex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    if (!emailRegex.test(email))
    {
      $("#emailHelp").show();
      $("#emailModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#emailHelp").hide();
      $("#emailModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#emailValue").text($("#emailProfil").val());
    $("#emailValue").show();
    $(this).hide();
    $("#emailModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DU TELEPHONE *****/
  $("#phoneModif").click(function()
  {
    $("#phoneValue").hide();
    $(this).css("visibility", 'hidden');
    $("#phoneProfil").show();
    $("#phoneProfil").focus();
  });
  
  $("#phoneProfil").blur(function()
  {   
    var phone = $('#phoneProfil').val();
    var phoneRegex = /^(0|\+33)[1-9]( ?-?\.?[0-9]{2}){4}$/;
    if (!phoneRegex.test(phone))
    {
      $("#phoneHelp").show();
      $("#phoneModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#phoneHelp").hide();
      $("#phoneModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#phoneValue").text($("#phoneProfil").val());
    $("#phoneValue").show();
    $(this).hide();
    $("#phoneModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE L'ACTIVITE *****/
  $("#activityModif").click(function(){
    $("#activityValue").hide();
    $(this).css("visibility", 'hidden');
    $("#activityProfil").show();
    $("#activityProfil").focus();
  });
  
  $("#activityProfil").blur(function()
  {   
    $("#activityValue").text($("#activityProfil").val());
    $("#activityValue").show();
    $(this).hide();
    $("#activityModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE LA SOCIETE *****/
  $("#societyModif").click(function(){
    $("#societyValue").hide();
    $(this).css("visibility", 'hidden');
    $("#societyProfil").show();
    $("#societyProfil").focus();
  });
  
  $("#societyProfil").blur(function(){   
    var society = $('#societyProfil').val();
    if (society.length < 3 || society.length > 20)
    {
      $("#societyHelp").show();
      $("#societyModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#societyHelp").hide();
      $("#societyModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#societyValue").text($("#societyProfil").val());
    $("#societyValue").show();
    $(this).hide();
    $("#societyModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DU SIRET *****/
  $("#siretModif").click(function()
  {
    $("#siretValue").hide();
    $(this).css("visibility", 'hidden');
    $("#siretProfil").show();
    $("#siretProfil").focus();
  });
  
  $("#siretProfil").blur(function()
  {   
    var siret = $('#siretProfil').val();
    var siretRegex = /^[0-9]{14}$/;
    if (!siretRegex.test(siret))
    {
      $("#siretHelp").show();
      $("#siretModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#siretHelp").hide();
      $("#siretModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#siretValue").text($("#siretProfil").val());
    $("#siretValue").show();
    $(this).hide();
    $("#siretModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE L'ADRESSE *****/
  $("#addressModif").click(function(){
    $("#addressValue").hide();
    $(this).css("visibility", 'hidden');
    $("#addressProfil").show();
    $("#addressProfil").focus();
  });
  
  $("#addressProfil").blur(function(){   
    var address = $('#addressProfil').val();
    if (address.length < 3 || address.length > 20)
    {
      $("#addressHelp").show();
      $("#addressModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#addressHelp").hide();
      $("#addressModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#addressValue").text($("#addressProfil").val());
    $("#addressValue").show();
    $(this).hide();
    $("#addressModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DU CODE POSTAL *****/
  $("#postalCodeModif").click(function()
  {
    $("#postalCodeValue").hide();
    $(this).css("visibility", 'hidden');
    $("#postalCodeProfil").show();
    $("#postalCodeProfil").focus();
  });
  
  $("#postalCodeProfil").blur(function()
  {   
    var postalCode = $('#postalCodeProfil').val();
    var postalCodeRegex = /^[0-9]{5}$/;
    if (!postalCodeRegex.test(postalCode) && postalCode != '')
    {
      $("#postalCodeHelp").show();
      $("#postalCodeModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#postalCodeHelp").hide();
      $("#postalCodeModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#postalCodeValue").text($("#postalCodeProfil").val());
    $("#postalCodeValue").show();
    $(this).hide();
    $("#postalCodeModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE LA VILLE *****/
  $("#cityModif").click(function(){
    $("#cityValue").hide();
    $(this).css("visibility", 'hidden');
    $("#cityProfil").show();
    $("#cityProfil").focus();
  });
  
  $("#cityProfil").blur(function(){   
    var city = $('#cityProfil').val();
    if (city.length < 3 || city.length > 20)
    {
      $("#cityHelp").show();
      $("#cityModif").removeClass('btn-info').addClass('btn-danger');
    }
    else
    {
      $("#cityHelp").hide();
      $("#cityModif").addClass('btn-info').removeClass('btn-danger');
    }
    $("#cityValue").text($("#cityProfil").val());
    $("#cityValue").show();
    $(this).hide();
    $("#cityModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE L'HEURE D'OUVERTURE (MATIN) *****/
  $("#openingAMModif").click(function(){
    $("#openingAMValue").hide();
    $(this).css("visibility", 'hidden');
    $("#openingAMProfil").show();
    $("#openingAMProfil").focus();
  });
  
  $("#openingAMProfil").blur(function()
  {   
    $("#openingAMValue").text($("#openingAMProfil").val());
    $("#openingAMValue").show();
    $(this).hide();
    $("#openingAMModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE FERMETURE (MATIN) *****/
  $("#closingAMModif").click(function(){
    $("#closingAMValue").hide();
    $(this).css("visibility", 'hidden');
    $("#closingAMProfil").show();
    $("#closingAMProfil").focus();
  });
  
  $("#closingAMProfil").blur(function()
  {   
    $("#closingAMValue").text($("#closingAMProfil").val());
    $("#closingAMValue").show();
    $(this).hide();
    $("#closingAMModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE L'HEURE D'OUVERTURE (APRES-MIDI) *****/
  $("#openingPMModif").click(function(){
    $("#openingPMValue").hide();
    $(this).css("visibility", 'hidden');
    $("#openingPMProfil").show();
    $("#openingPMProfil").focus();
  });
  
  $("#openingPMProfil").blur(function()
  {   
    $("#openingPMValue").text($("#openingPMProfil").val());
    $("#openingPMValue").show();
    $(this).hide();
    $("#openingPMModif").css("visibility", 'visible');
  });
  
  /***** MODIFICATION DE FERMETURE (MATIN) *****/
  $("#closingPMModif").click(function(){
    $("#closingPMValue").hide();
    $(this).css("visibility", 'hidden');
    $("#closingPMProfil").show();
    $("#closingPMProfil").focus();
  });
  
  $("#closingPMProfil").blur(function()
  {   
    $("#closingPMValue").text($("#closingPMProfil").val());
    $("#closingPMValue").show();
    $(this).hide();
    $("#closingPMModif").css("visibility", 'visible');
  });
});



