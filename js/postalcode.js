$(document).ready(function(){

  $('#postalCode').blur(function(){

    var postalcode = $('#postalCode').val();
    if(postalcode == '')
    {
      var city = '<div class="md-form"  id="cityArea"><i class="prefix"></i><input type="text" id="city" name="city" class="form-control"><label for="city" id="cityLabel">Votre ville *</label></div>';
      $('#cityArea').html(city);
      $('#cityArea').css('margin-left', '0rem');
      $('#cityArea').removeClass('form-group').addClass('md-form');
    }
    else
    {
      $.ajax({
        url: "http://api.geonames.org/postalCodeSearchJSON",
        data:{ postalcode:postalcode,
          country: 'FR',
          username: 'ophois34' },
        method: 'GET',
        dataType: 'json',
        success: function(data){

          $.each(data, function(cle, valeur){

            if(valeur.length > 1)
            {
              $('#cityArea').css('margin-left', '3rem');
              $('#cityArea').css('width', '96%');
              $('#cityArea').removeClass('md-form').addClass('form-group');

              var city = '<i class="prefix"></i><label id="cityLabel "for="city" style="color: #757575; font-size: 1rem;">Votre Ville *</label><select id="city" name="city" class="form-control" >'

              $.each(valeur, function(key, val){
                city += '<option>' + val.placeName + '</option>';
              });

              city += '</select>';
              $('#cityArea').html(city);
            }
            else if(valeur.length == 1)
            {
              $('#cityArea').css('margin-left', '0rem');
              $('#cityArea').removeClass('form-group').addClass('md-form');

              $.each(valeur, function(key, val){
                var city = '<i class="prefix"></i><input type="text" id="city" name="city" class="form-control" value="<?= $city; ?>"><label for="city" id="cityLabel">Votre ville</label>';
                $('#cityArea').html(city);
                $('#city').val(val.placeName);
                $('#cityLabel').addClass('active');
              });
            }
            else
            {
              var city = '<div class="md-form"  id="cityArea"><i class="prefix"></i><input type="text" id="city" name="city" class="form-control"><label for="city" id="cityLabel">Votre ville *</label></div>';
              $('#cityArea').html(city);
              $('#cityArea').css('margin-left', '0rem');
              $('#cityArea').css('width', '100%');
              $('#cityArea').removeClass('form-group').addClass('md-form');
            }
          });
        }
      });
    }
  });
});