$( document ).ready(function() {

  function timeConverter(UNIX_timestamp){
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var year = a.getFullYear();
    //var month = months[a.getMonth()];
    var month = ("0" + (a.getMonth() + 1)).slice(-2);
    var date = ("0" + (a.getDate())).slice(-2);
    var hour = ("0" + (a.getHours())).slice(-2);
    var min = ("0" + (a.getMinutes())).slice(-2);
    //var sec = ("0" + (a.getSeconds())).slice(-2);
    var date_format = date + '-' + month + '-' + year + ' ' + hour + ':' + min;
    return date_format;
  }
    
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

  $(document).on('click', '.btn-actualizar', function() {

     
     var email = $(this).closest("tr").data('email');
     $('#email').val(email);

    if($('#uri').val() == 'repcot'){
      var idCall = $(this).closest("tr").data('id');
      $("#idCall").val(idCall);
      $("#idt").val($(this).closest("tr").data('idcall'));
    }
    else{
      var idCall = $(this).closest("tr").data('idcall');
      $("#idCall").val(idCall);
    }     

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
    $('#comment').val('');
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
      $('#msgOperationSuccessDiv').hide();
      $('#msgOperationErrorDiv').hide();
      if(data.success == true){
        $('#msgOperationSuccessDiv').show();
        $('#msgOperationSuccess').html('La operación se ha realizado con éxito!');
        $('#myModal').modal('hide');
        if($('#uri').val() == 'repcot'){
          $("tr[data-idcall="+$("#idt").val()+"]").remove();  
        }
        else{
          $("tr[data-idcall="+$("#idCall").val()+"]").remove();
        }
        
        $('html, body').animate({scrollTop: 0}, 500);
      }
      else{
        $('#msgOperationErrorDiv').show();
        $('#msgOperationError').html('La operación no se puede realizar!');
        $('#myModal').modal('hide');
      }      
    })
  });


  $('#datetimepicker1').datetimepicker({
    format: 'MM/DD/YYYY hh:mm A',
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
      $("tr.showMoreEntriesClient").find('i.icon-morecall').removeClass('fa-arrow-up').addClass('fa-arrow-down');
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

            var counterCalls = '<p class="counterCall" style="margin-top: 7px;">';
            if(result[i].countCall > 0){
              counterCalls += '<span class="badge call-bagde bagde-counter-call">'+result[i].countCall+'</span>';
            }
            counterCalls+='</p>';

            var agentStatus = '<span class="badge call-bagde" style="white-space: normal;background-color:dodgerblue">'+result[i].agente+'</span>';
            if(result[i].agente == ''){
              agentStatus = '<span class="badge call-bagde" style="white-space: normal;background-color:dodgerblue">Libre</span>';
            }

            var icnnns = '';

            if(result.length == 1 || i > 0){
              icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/sinaccion.png">';
              if(result[i].usuario != '' && result[i].usuario != $('#idUser').val())
              {
                icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/redir.png">';
              }
              if(result[i].state == 0 && result[i].lead == 'clicktocall')
              {
                icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/clicktocall.png">';
              }
              if(result[i].state == 0 && result[i].lead == 'si')
              {
                icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/lead.png">';
              }              
            }               

            html = "<tr style='border-left: 12px solid dodgerblue;' data-idcall="+result[i].id+" data-idParent="+id+" data-table='calls'><td class='text-center'><p class='table-colum-id'>"+result[i].id+"</p></td><td>"+result[i].name+"<br>"+result[i].e+"<br>"+icnnns+"</td><td>"+timeConverter(result[i].time)+"</td><td><input class='form-control input-tel' type='input' value='"+result[i].phone+"'></td><td class='text-center'>"+carname+"</td><td class='text-center'><button class='btn disabled btn-success'><i class='fa fa-phone fa-2x' aria-hidden='true'></i></button>"+counterCalls+"</td><td>"+result[i].prima+"</td><td>"+result[i].company+"</td><td class='text-center'>"+agentStatus+"</td></tr>";

            inst.closest("tr").after(html);
            inst.closest("tr").css('border-left','20px solid green');
          } 

            
        }
        
      })
    }
    else{
      $("tr[data-idParent='"+id+"']").remove();
      inst.closest("tr").css('border-left','none');
      inst.find('i.icon-morecall').removeClass('fa-arrow-up').addClass('fa-arrow-down');
      inst.closest("tr").removeClass('showMoreEntriesClient');
    }
  });

  $(document).on('click', '.entriesMoreClientRepCot', function(even) {
    even.preventDefault();
    var inst = $(this);
    var email = $(this).data('email');
    var id = $(this).data('id');
    var idt = $(this).data('idt');
    var otherp = $("tr.showMoreEntriesClient").data('id');
    var other = $("tr.showMoreEntriesClient").data('idcall');
    if(other != idt){
      $("tr[data-idParent='"+otherp+"']").remove();
      $("tr.showMoreEntriesClient").css('border-left','none');
      $("tr.showMoreEntriesClient").find('i.icon-morecall').removeClass('fa-arrow-up').addClass('fa-arrow-down');
      $("tr.showMoreEntriesClient").removeClass('showMoreEntriesClient');
    }
    if(inst.find('i').hasClass('fa-arrow-down')){
      
      inst.closest("tr").addClass('showMoreEntriesClient');
      inst.find('i').removeClass('fa-arrow-down').addClass('fa-arrow-up');
      var url = 'calls/ajax';
      $.ajax({
        data: {id:id, idt:idt, action:'entriesMoreClientRepCot'},
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

            var counterCalls = '<p class="counterCall" style="margin-top: 7px;">';
            if(result[i].countCall > 0){
              counterCalls += '<span class="badge call-bagde bagde-counter-call">'+result[i].countCall+'</span>';
            }
            counterCalls+='</p>';

            var aaa = '';

            if(result[i].operation_id == 4){
              aaa = '<i class="fa fa-database info-cotiz" aria-hidden="true" data-id='+result[i].id+'></i>';
            }

            html = "<tr style='border-left: 12px solid dodgerblue;' data-idcall="+result[i].id+" data-idParent="+id+" data-table='repcot'><td class='text-center'><p class='table-colum-id'>"+result[i].id+"</p>"+aaa+"</td><td>"+result[i].name+"<br>"+result[i].e+"</td><td>"+timeConverter(result[i].time)+"</td><td><input class='form-control input-tel' type='input' value='"+result[i].phone+"'></td><td class='text-center'>"+carname+"</td><td class='text-center'><button class='btn disabled btn-success'><i class='fa fa-phone fa-2x' aria-hidden='true'></i></button>"+counterCalls+"</td><td>"+result[i].prima+"</td><td>"+result[i].company+"</td><td class='text-center'><a class='btn btn-warning btn-actualizar disabled'><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a></td></tr>";

            inst.closest("tr").after(html);
            inst.closest("tr").css('border-left','20px solid green');
          } 

            
        }
        
      })
    }
    else{
      $("tr[data-idParent='"+id+"']").remove();
      inst.closest("tr").css('border-left','none');
      inst.find('i.icon-morecall').removeClass('fa-arrow-up').addClass('fa-arrow-down');
      inst.closest("tr").removeClass('showMoreEntriesClient');
    }
  });

  $(document).on('click', '.btn-calling', function() {
    var btn = $(this);
    var tel = btn.parent().parent().find('.input-tel').val();
    if(btn.hasClass('btn-success')){
      var t = $(this).closest("tr").data('table');

      var idCall = $(this).closest("tr").data('idcall');
      var url = 'calls/ajax';
      $.ajax({
        data: {idCall: idCall, t: t, action:'calling'},
        type: "GET",
        dataType: "json",
        url: url,
      })
      .done(function(response){
        params = { "tocall" : tel};
        connection = Twilio.Device.connect(params); 
        btn.removeClass('btn-success').addClass('btn-danger');
        console.log(response);
        $("tr[data-idcall="+idCall+"]").find('.counterCall').html('<span class="badge call-bagde bagde-counter-call">'+response.result.counter+'</span>');
        console.log("tr[data-idcall="+idCall+"]");
      });
    }
    else{
      Twilio.Device.disconnectAll();
      btn.removeClass('btn-danger').addClass('btn-success');
    }
  });

  $(document).on('click', '.bagde-counter-call', function() {
    $('.body-detail-call').html('');
    $('#modalDetailCall').modal(); 
    var idCall = $(this).closest("tr").data('idcall');
    var url = 'calls/ajax';
    var t = $(this).closest("tr").data('table');
    $.ajax({
      data: {idCall: idCall, t: t, action:'detailCall'},
      type: "GET",
      dataType: "json",
      url: url,
    })
    .done(function(response){
      var body = '';
      for(var i = 0; i < response.result.length; i++){
        body += "<button style='margin:13px;padding:13px 20px' class='btn btn-primary' type='button'><span class='badge'>"+response.result[i].id+"</span> "+timeConverter(response.result[i].time)+"</button>";
      }
      $('.body-detail-call').html(body);
    });
  });

  $('.btn-search').on('click', function() {
    var search = $('input[name="search"]').val();
    //var url = 'calls/ajax';
    var t = $('table').data('table');
    var url = 'calls';
    $.ajax({
      data: {search: search, t: t, action:'searchCall'},
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
            var cl = '';
            if(t == 'calls'){
              cl = 'entriesMoreClient';
              moreCalls = '<button class="btn '+cl+'" style="color:white;background:teal; font-size:15px" data-id='+result[i].id+' data-email="'+result[i].e+'">'+result[i].cant+' <i class="icon-morecall fa fa-arrow-down" aria-hidden="true"></i></button>';
            }
            if(t == 'repcot'){
              cl = 'entriesMoreClientRepCot';
              moreCalls = '<button class="btn '+cl+'" style="color:white;background:teal; font-size:15px" data-id='+result[i].call_id+' data-idt='+result[i].id+' data-email="'+result[i].e+'">'+result[i].cant+' <i class="icon-morecall fa fa-arrow-down" aria-hidden="true"></i></button>';
            }            
          }

          var iconcot = '';
          if(result[i].normal == 0 && result[i].operation_id == 4){
            iconcot = '<i class="fa fa-database info-cotiz" aria-hidden="true" data-id='+result[i].id+'></i>';
          }

          var counterCalls = '<p class="counterCall" style="margin-top: 7px;">';
          if(result[i].countCall > 0){
            counterCalls += '<span class="badge call-bagde bagde-counter-call">'+result[i].countCall+'</span>';
          }
          counterCalls+='</p>';

          var xx = result[i].normal == 0 ? 'data-id='+result[i].call_id+' data-table=repcot' : 'data-table=calls';

          var icnnns = '';

          icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/sinaccion.png">';
          if(result[i].normal == 1 && result[i].usuario != '' && result[i].usuario != $('#idUser').val())
          {
            icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/redir.png">';
          }
          if(result[i].normal == 1 && result[i].state == 0 && result[i].lead == 'clicktocall')
          {
            icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/clicktocall.png">';
          }    
          if(result[i].normal == 1 && result[i].state == 0 && result[i].lead == 'si')
          {
            icnnns += '<img style="height: 25px;width: 25px; margin-right:5px" src="../images/lead.png">';
          }         

          html = "<tr data-idcall="+result[i].id+" "+xx+" data-email="+result[i].e+"><td class='text-center'><p class='table-colum-id'>"+result[i].id+"</p>"+moreCalls+iconcot+"</td><td>"+result[i].name+"<br>"+result[i].e+"<br>"+icnnns+"</td><td>"+result[i].time+"</td><td><input class='form-control input-tel' type='input' value='"+result[i].phone+"'></td><td class='text-center'>"+carname+"</td><td class='text-center'><button class='btn btn-success btn-calling'><i class='fa fa-phone fa-2x' aria-hidden='true'></i></button>"+counterCalls+"</td><td>"+result[i].prima+"</td><td>"+result[i].company+"</td><td class='text-center'><a class='btn btn-warning btn-actualizar'><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a></td></tr>";

          $('.table-calls-search tbody:last-child').append(html);
        }  


        if(response.last_page > 1){
          var pag = '<div class="text-center paginator-calls"><ul class="pagination">';
          pag += "<li class='disabled'><span>«</span></li>";
          for(var j = 1; j <= response.last_page; j++){
            if(j == 1){
              pag += "<li class='active'><a href='?action=searchCall&search="+search+"&t="+t+"&page="+j+"'><span>"+j+"</span></a></li>";
            }
            else{
              pag += "<li><a href='?action=searchCall&search="+search+"&t="+t+"&page="+j+"'>"+j+"</a></li>";
            }
            
          }

          pag += "<li><a href='?action=searchCall&search="+search+"&t="+t+"&page=2' rel='next'>»</a></li>";
          

          pag +='</ul></div>';
          $('.paginator-calls-search').html(pag);
          
        }

      }
    });
  });

  $(document).on('click', '.info-cotiz', function() {
    $('.body-detail-call').html('');
    $('#modalDetailCotiz').modal(); 
    var id = $(this).data('id');
    var url = 'calls/ajax';
    $.ajax({
      data: {id: id, action:'detailCotiz'},
      type: "GET",
      dataType: "json",
      url: url,
    })
    .done(function(response){
      var body = '<table class="table table-striped table-hover"><thead><tr><th class="text-center">GPS</th><th class="text-center">Valor</th><th class="text-center">Prima</th><th class="text-center">Cuota</th><th class="text-center">Nro Cuotas</th></tr></thead><tbody>';
      body += '<tr><td>'+response.gps+'</td><td>'+response.valor+'</td><td>'+response.prima+'</td><td>'+response.cuota+'</td><td>'+response.nrocuotas+'</td></tr>';
      body += '</tbody>';

      body += '</table>';
      
      $('.body-detail-call').html(body);
    });
  });

  

  $(document).on('click', '.alerts-custom', function() {
    
  });

});