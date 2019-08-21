$(document).ready(function(){
	$("#search").keyup(function(){
		if($("#search").val().length<=2){
			$('#finalResult').html('');
		}
		if($("#search").val().length>2){
			$.ajax({
				type: "post",
				url: "http://localhost/stockhub/Materials/materialsearch",
				cache: false,    
				data:'search='+$("#search").val(),
				
				success: function(response){
					$('#finalResult').html("");
					var obj = JSON.parse(response);
					if(obj.length>0){
						try{
							var items=[];
							var temp=0;
							
							$.each(obj, function(i,val){           
								// items.push($('<a/>').text(val.rm_name));
								// items.push($('<a>'.text(val.rm_name).'</a>'));
								items.push('<a class="list-group-item linkInSearch" href="http://localhost/stockhub/materials/'+val.rm_slug+'"> <b>'+ val.rm_name +'</b></a>');

								if(temp==0){
									items.push('<a class="list-group-item linkInSearch" href="http://localhost/stockhub/materials#'+val.subcat_name+'"> <b> Category : '+ val.subcat_name +'</b></a>');
								}
								temp=temp+1;
							}); 
							$('#finalResult').append.apply($('#finalResult'), items);
						}catch(e) {  
							alert('Exception while request.',e);
						}
					}else{
						// $('#finalResult').html($('<li/>').text("No Data Found"));  
						$('#finalResult').html('<a class="list-group-item linkInSearch"> <b>Your search did not match any items. Please make sure that all words are spelled correctly.</b></a>'); 
					}
				},

				error: function(){
				alert('Error while request (Backend Error)');
				}
			});
		}
   	return false;
	});
});

$(document).ready(function(){
	if(document.getElementById("search") === null){
		$('#homesearch').html('');
	}else{
		var text = ["Search Raw Materials", "Search Products", "Search Categories" ];
		var counter = 0;
		var elem = document.getElementById("search");
		setInterval(change, 1500);

		function change() {
		elem.placeholder = text[counter];
		counter++;
			if (counter >= text.length) {
				counter = 0;
			}
		}
	}
	
});

// $(document).ready(function(){
// 	$("#homesearch").keyup(function(){
// 		if($("#homesearch").val().length<=2){
// 			$('#finalResult2').html('');
// 		}
// 		if($("#homesearch").val().length>2){
// 			$.ajax({
// 				type: "post",
// 				url: "http://localhost/Stockhub/Materials/homesearch",
// 				cache: false,    
// 				data:'search='+$("#homesearch").val(),
				
// 				success: function(response){
// 					$('#finalResult2').html("");
// 					var obj = JSON.parse(response);
// 					if(obj.length>0){
// 						try{
// 							var items=[];
							
							
// 							$.each(obj, function(i,val){           
// 								// items.push($('<a/>').text(val.rm_name));
// 								// items.push($('<a>'.text(val.rm_name).'</a>'));
// 								items.push('<a class="list-group-item linkInSearch" href="http://localhost/Stockhub/pages/search/'+val.product_cat_name+'"> <b class="text-capitalize">'+ val.product_cat_name +'</b></a>');

// 							}); 
// 							$('#finalResult2').append.apply($('#finalResult2'), items);
// 						}catch(e) {  
// 							alert('Exception while request.',e);
// 						}
// 					}else{
// 						// $('#finalResult').html($('<li/>').text("No Data Found"));  
// 						$('#finalResult2').html('<a class="list-group-item linkInSearch"> <b>Your search did not match any items. Please make sure that all words are spelled correctly.</b></a>'); 
// 					}
// 				},

// 				error: function(){
// 				alert('Error while request (Backend Error)');
// 				}
// 			});
// 		}
//    	return false;
// 	});
// });


$(document).ready(function(){
	$("#homesearch").keyup(function(e){
		if(e.keyCode == 13){
		if($("#homesearch").val().length<=2){
			$('#finalResult2').html('');
			// $("#titleHomeDiv").addClass("animated fadeInUp");
			// $("#titleHomeDiv").show();
			$("#titleHomeDiv").fadeIn(1000);
			$("#howitworks").fadeIn(1000);
		}
		if($("#homesearch").val().length>2){
			$.ajax({
				type: "post",
				url: "http://localhost/stockhub/Materials/homesearch",
				cache: false,    
				data:'search='+$("#homesearch").val(),
				
				success: function(response){
					// $("#titleHomeDiv").addClass("animated fadeOutUp");
					// $("#titleHomeDiv").hide();
					$("#titleHomeDiv").fadeOut(1000);
					$("#howitworks").fadeOut(1000);
					$('#finalResult2').html("");
					var obj = JSON.parse(response);
					
					if(obj.length>0){
						try{
							var items=[];
							
							
							items.push('<h2 id="homeSearchResultH2" class="animated 2s fadeInUp inverseColor">'+obj[0].product_cat_name+'</h2>');
							items.push('<small class="material-date animated 2s fadeInUp">Raw Materials Required</small>');

							$.each(obj, function(i,val){           
								// items.push($('<a/>').text(val.rm_name));
								// items.push($('<a>'.text(val.rm_name).'</a>'));
								// items.push('<a class="list-group-item linkInSearch" href=""> <b class="text-capitalize">'+ val.product_cat_name +'</b></a>');
								
								// items.push('<a href=http://localhost/Stockhub/materials#'+val.subcat_name+' class="well well-sm animated fadeInUp" id="homeSearchResultA">'+val.subcat_name+'</a>');

								
								$.ajax({
									type: "post",
									url: "http://localhost/stockhub/Materials/indexJSON",
									cache: false,    
									
									success: function(response){
										$('#finalResult2').html("");
										var obj2 = JSON.parse(response);
										
										
										items.push('<h3 id="homeSearchResultH2" class="animated fadeInUp">'+val.subcat_name+'</h3>');

										

										if(obj2.length>0){
											try{
												
												
												items.push('<div class="row display-flex animated fadeInUp">');

												//let enclosure = [];

												$.each(obj2, function(i,val2){           
													
													
													var base_url = window.location.origin;
													base_url += "/stockhub";

													if(val.subcat_name===val2.subcat_name){
														items.push('<div class="col-sm-6 col-md-4 col-lg-3 display-flex"> \
																		<div class="thumbnail"> \
																			<div class="caption"> \
																				<img class="post-thumb thumbnail" id="imgUnderIndexSearch" src="'+base_url+'/assets/images/materials/'+ val2.rm_pic+'" /> \
																				<a class="h3 h3-margin-top-change" href="'+base_url+'/materials/'+val2.rm_slug+'" >'+val2.rm_name+'</a> \
																			</div> \
																		</div> \
																	</div> ');

														// var base_url = window.location.origin;
														// document.getElementById("imgUnderIndexSearch").src = base_url + '/assets/images/materials/' + val2.rm_pic; 


																//items.push('<h2 id="homeSearchResultH2" class="animated fadeInUp">'+val2.rm_name+'</h2>');
													}
													
					
												}); 
												items.push('</div>');
												$('#finalResult2').html(items.join(''));
												// $('#finalResult2').append.apply($('#finalResult2'), items.join(''));
											}catch(e) {  
												alert('Exception while request.'+e+'',e);
											}
										}else{
											// $('#finalResult').html($('<li/>').text("No Data Found"));  
											$('#finalResult2').html('<h1>NULL</h1>'); 
										}

									},
									error: function(){
										alert('Error while request (Backend Error)');
									}

								});
								

							}); 
							$('#finalResult2').append.apply($('#finalResult2'), items);
						}catch(e) {  
							alert('Exception while request.'+e+'',e);
						}
					}else{
						// $('#finalResult').html($('<li/>').text("No Data Found"));  
						$('#finalResult2').html('<a class="list-group-item linkInSearch"> <b>Your search did not match any items. Please make sure that all words are spelled correctly.</b></a>'); 
					}
				},

				error: function(){
				alert('Error while request (Backend Error)');
				}
			});
		}
	}
   	return false;
	});

});