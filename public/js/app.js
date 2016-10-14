$( document ).ready(function() {
    
	$('input[type=radio][name=type]').change(function() {
    if (this.value == '3') {
    	$('#companiesForm').show();
    	$('.byType2').hide();
    }
    else{
    	$('#companiesForm').hide();
    	$('.byType2').show();
    }
  });

  $('.btn-actualizar').on('click', function() {
    $("#select-operaciones option[value='']").prop('selected',true);
    $("#select-motivo option[value='']").prop('selected',true);
    $('.div-fecha').hide();
    $('.div-comentario').hide();
    $('.div-producto').hide();
    $('.div-motivo').hide();
    $('.div-gps').hide();
    $('.div-email').hide();
    $('.div-valor').hide();
    $('.div-prima').hide();
    $('.div-cuota').hide();
    $('.div-nrocuotas').hide();
    $('.btn-guardar-operacion').prop( "disabled", true);    
    $('#myModal').modal();  
  });

  $('#select-operaciones').on('change', function() {
    $('.div-fecha').hide();
    $('.div-comentario').hide();
    $('.div-producto').hide();
    $('.div-motivo').hide();
    $('.div-gps').hide();
    $('.div-email').hide();
    $('.div-valor').hide();
    $('.div-prima').hide();
    $('.div-cuota').hide();
    $('.div-nrocuotas').hide();
    $('.btn-guardar-operacion').prop( "disabled", false);
    var idOperation = this.value;
    switch(idOperation){
        case '5':
          $('.div-fecha').show();
          $('.div-comentario').show();
        break;
        case '1':
          $('.div-producto').show();
          $('.div-comentario').show();
          $('.btn-guardar-operacion').prop( "disabled", true);
          $("#select-producto option[value='']").prop('selected',true);
        break;
        case '2':
          $('.btn-guardar-operacion').prop( "disabled", true);
          $("#select-motivo option[value='']").prop('selected',true);
          $('.div-motivo').show();
        break;
        case '4':
          $('.div-producto').show();
          $('.div-fecha').show();
          $("#select-producto option[value='']").prop('selected',true);
          $('.btn-guardar-operacion').prop( "disabled", true);
        break;
        default:
          $('.div-fecha').hide();
          $('.div-comentario').hide();
          $('.btn-guardar-operacion').prop( "disabled", true);
    }

  });

  $('#select-producto').on('change', function() {
    var idProducto = this.value;
    if($( "#select-operaciones option:selected" ).val() == 4){
      $('.div-comentario').show();
      $('.div-gps').show();
      $('.div-email').show();
      $('.div-valor').show();
      $('.div-prima').show();
      $('.div-cuota').show();
      $('.div-nrocuotas').show();
    }

    
    $('.btn-guardar-operacion').prop( "disabled", true);
    if(idProducto != ''){
      $('.btn-guardar-operacion').prop( "disabled", false);
    }
  });

  $('#select-motivo').on('change', function() {
    var idMotivo = this.value;
    if(idMotivo != ''){
      $('.btn-guardar-operacion').prop( "disabled", false);
    }

    if(idMotivo == 5){
      $('.div-comentario').show();
    }
    else{
      $('.div-comentario').hide();
    }
  });

  $('.btn-guardar-operacion').on('click', function() {
    console.log($(this).closest('tr').find('.aaa').text());
    var form = $('#form-operations');
    var url = form.attr('action');
    console.log(form.serialize());
    //form.submit();
    $.ajax({
      data: form.serialize(),
      type: "POST",
      dataType: "json",
      url: url,
    })
    .done(function(data){
      console.log(data);
    })
  });


  $('#datetimepicker1').datetimepicker({
    format: 'YYYY-MM-DD hh:mm A',
    ignoreReadonly: true
  });

});