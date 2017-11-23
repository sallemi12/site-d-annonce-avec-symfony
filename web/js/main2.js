/*
   $('#VoitureBundle_Voiture_marque').on('change', function() {
                $.ajax({

                                 url : 'http://127.0.0.1:8000/voiture/getModele_rechreche/'+ this.value,
                                  type : 'get',
                                 beforeSend:function(){
                                    $('#VoitureBundle_Voiture_modele option').remove();
                                 },

                                 success:function(data){
                                    $.each(data.modeles,function(index,value){
                                       $('#VoitureBundle_Voiture_modele').append($('<option>',{value:value,text:value}))
                                    });
                                    console.log(' ok');
                                    
                                 }
                                 
                        });
   });*/