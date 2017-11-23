$(document).ready(function(){


      $(".fancybox ").fancybox();

	$('#voiturebundle_voiture_marque').on('change', function() {
					 $.ajax({

                                 url : 'http://127.0.0.1:8000/voiture/getModele/'+ this.value,
                                 type : 'get',
                                 beforeSend:function(){
                                 	$('#voiturebundle_voiture_modele option').remove();
                                 },

                                 success:function(data){
                                 	$.each(data.modeles,function(index,value){
                                 		$('#voiturebundle_voiture_modele').append($('<option>',{value:value,text:value}))
                                 	});
                                 	console.log('ville ok');
                                 	
                                 }
                                	
                        });
	});





});