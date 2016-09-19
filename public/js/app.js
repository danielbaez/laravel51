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


});