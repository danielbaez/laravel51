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

     var idCall = $(this).closest("tr").data('idcall');
     $("#idCall").val(idCall);

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
    $('#msgOperationDiv').hide();
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
      $('#msgOperationDiv').show();
      $('#msgOperation').html('La operación se ha realizado con éxito!');
      $('#myModal').modal('hide');
    })
  });


  $('#datetimepicker1').datetimepicker({
    format: 'YYYY-MM-DD hh:mm A',
    ignoreReadonly: true
  });

  $(document).on('click', '.entriesMoreClient', function(even) {
    even.preventDefault();
    var inst = $(this);
    var email = $(this).data('email');
    var id = $(this).data('id');
    var other = $("tr.showMoreEntriesClient").data('idcall');
    if(other != id){
      $("tr[data-idParent='"+other+"']").remove();
      $("tr.showMoreEntriesClient").css('border-left','none');
      $("tr.showMoreEntriesClient").find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
      $("tr.showMoreEntriesClient").removeClass('showMoreEntriesClient');
    }
    if(inst.find('i').hasClass('fa-arrow-down')){

      inst.closest("tr").addClass('showMoreEntriesClient');
      inst.find('i').removeClass('fa-arrow-down').addClass('fa-arrow-up');
      var url = 'calls/ajax';
      $.ajax({
        data: {email: email, id:id, action:'entriesMoreClient'},
        type: "GET",
        dataType: "json",
        url: url,
      })
      .done(function(data){
        if(data.success){
          var result = data.result;
          for(var i = 0; i < result.length; i++){
            var html = '';
            var carname = '';
            if(result[i].request['carname'])
            {
              carname = result[i].request['carname'];
            }
            if(result[i].request['year'])
            {
              carname += "("+result[i].request['year']+")";
            }
            if(result[i].compare && result[i].compare.length > 0){
              carname += "<br><a href='"+result[i].compare+"' target='_blank'>Resultados</a>";
            } 

            html = "<tr style='border-left: 12px solid dodgerblue;' data-idParent="+id+"><td class='text-center'>"+result[i].id+"</td><td>"+result[i].name+"<br>"+result[i].e+"</td><td>"+result[i].time+"</td><td><input class='form-control input-tel' type='input' value='"+result[i].phone+"'></td><td class='text-center'>"+carname+"</td><td class='text-center'><button class='btn disabled btn-success'><i class='fa fa-phone fa-2x' aria-hidden='true'></i></button></td><td>"+result[i].prima+"</td><td>"+result[i].company+"</td><td class='text-center'><a class='btn btn-warning btn-actualizar disabled'><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a></td></tr>";

            inst.closest("tr").after(html);
            inst.closest("tr").css('border-left','20px solid green');
          } 

            
        }
        
      })
    }
    else{
      $("tr[data-idParent='"+id+"']").remove();
      inst.closest("tr").css('border-left','none');
      inst.find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
      inst.closest("tr").removeClass('showMoreEntriesClient');
    }
  });

  $('.btn-search').on('click', function() {
    var search = $('input[name="search"]').val();
    //var url = 'calls/ajax';
    var url = 'calls';
    $.ajax({
      data: {search: search, action:'searchCall'},
      type: "GET",
      dataType: "json",
      url: url,
    })
    .done(function(response){
      $('.table-calls-search tbody').html('');
      $('.table-calls').hide();
      $('.paginator-calls').hide();
      $('.table-calls-search').show();

      if(response.data){
        console.log(response);
        var result = response.data;
        for(var i = 0; i < result.length; i++){
          var html = '';
          var carname = '';
          if(result[i].request['carname'])
          {
            carname = result[i].request['carname'];
          }
          if(result[i].request['year'])
          {
            carname += "("+result[i].request['year']+")";
          }
          if(result[i].compare && result[i].compare.length > 0){
            carname += "<br><a href='"+result[i].compare+"' target='_blank'>Resultados</a>";
          } 
          var moreCalls = '';
          if(result[i].cant > 1){
            moreCalls = '<button class="btn entriesMoreClient" style="color:white;background:teal; font-size:15px" data-id='+result[i].id+' data-email="'+result[i].e+'"">'+result[i].cant+' <i class="fa fa-arrow-down" aria-hidden="true"></i></button>';
          }

          html = "<tr data-idcall="+result[i].id+"><td class='text-center'>"+result[i].id+' '+moreCalls+"</td><td>"+result[i].name+"<br>"+result[i].e+"</td><td>"+result[i].time+"</td><td><input class='form-control input-tel' type='input' value='"+result[i].phone+"'></td><td class='text-center'>"+carname+"</td><td class='text-center'><button class='btn btn-success'><i class='fa fa-phone fa-2x' aria-hidden='true'></i></button></td><td>"+result[i].prima+"</td><td>"+result[i].company+"</td><td class='text-center'><a class='btn btn-warning btn-actualizar'><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a></td></tr>";

          $('.table-calls-search tbody:last-child').append(html);
        }  


        if(response.last_page > 1){
          var pag = '<div class="text-center paginator-calls"><ul class="pagination">';
          pag += "<li class='disabled'><span>«</span></li>";
          for(var j = 1; j <= response.last_page; j++){
            if(j == 1){
              pag += "<li class='active'><a href='?action=searchCall&search="+search+"&page="+j+"'><span>"+j+"</span></a></li>";
            }
            else{
              pag += "<li><a href='?action=searchCall&search="+search+"&page="+j+"'>"+j+"</a></li>";
            }
            
          }

          pag += "<li><a href='?action=searchCall&search="+search+"&page=2' rel='next'>»</a></li>";
          

          pag +='</ul></div>';
          $('.paginator-calls-search').html(pag);
          
        }

      }
    });
  });

});