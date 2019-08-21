$(document).ready(function(e){
    $( document ).on( 'click', '.bs-dropdown-to-select-group .dropdown-menu li', function( event ) {
    	let $target = $( event.currentTarget );
		$target.closest('.bs-dropdown-to-select-group')
			.find('[data-bind="bs-drp-sel-value"]').val($target.attr('data-value'))
			.end()
			.children('.dropdown-toggle').dropdown('toggle');
		$target.closest('.bs-dropdown-to-select-group')
    		.find('[data-bind="bs-drp-sel-label"]').text($target.context.textContent);
		return false;
	});
});


$(document).ready(function(){
    $('[data-toggle="popover"]').popover({html:true,container: 'body'});   
});

$(document).ready(function() { 								// GETTING THE SIDE NAV FILLED IN MATERIALS INDEX
    var sidebarMainMenu = $('#sidebar-menu .main-menu');
	var staticContent = $('#static-content');
	staticContent.find('h2').each(function() {
		sidebarMainMenu.append('<li id="'+ $(this).attr('id') + '-menu" ><a href="#' + $(this).attr('id') + '">' + $(this).html() + '</li>');
		title = sidebarMainMenu.find('#' + $(this).attr('id'));
	});
	// staticContent.find('h3').each(function() {
	// 	prevTitle = sidebarMainMenu.find('#' + $(this).prevAll('h1').first().attr('id') + '-menu');
	// 	prevTitle.not(":has(ul)").append('<ul class="sub-menu"></ul>');
	// 	prevTitle.find('.sub-menu').append('<li id="'+ $(this).attr('id') + '-menu"><a href="#' + $(this).attr('id') + '">' + $(this).html() + '</li>');
	// });
	sidebarMainMenu.affix({
	      offset: {
	        top: 0  // To Modify according to the height offset
	      }
	});
});



$(document).ready(function(){
	$("#tenderSearchInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#tenderSearchTableBody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});

// $(document).ready(function(){
// 	CountDownTimer('02/19/2018 10:1 AM', 'timeOfExpiry');

//     function CountDownTimer(dt, id)
//     {
//         var end = new Date(dt);

//         var _second = 1000;
//         var _minute = _second * 60;
//         var _hour = _minute * 60;
//         var _day = _hour * 24;
//         var timer;

//         function showRemaining() {
//             var now = new Date();
//             var distance = end - now;
//             if (distance < 0) {

//                 clearInterval(timer);
//                 document.getElementById(id).innerHTML = 'EXPIRED!';

//                 return;
//             }
//             var days = Math.floor(distance / _day);
//             var hours = Math.floor((distance % _day) / _hour);
//             var minutes = Math.floor((distance % _hour) / _minute);
//             var seconds = Math.floor((distance % _minute) / _second);

//             document.getElementById(id).innerHTML = days + 'days ';
//             document.getElementById(id).innerHTML += hours + 'hrs ';
//             document.getElementById(id).innerHTML += minutes + 'mins ';
//             document.getElementById(id).innerHTML += seconds + 'secs';
//         }

//         timer = setInterval(showRemaining, 1000);
//     }
// });

function sortTable(n) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById("tenderSearchTable");
	switching = true;
	// Set the sorting direction to ascending:
	dir = "asc";
	/* Make a loop that will continue until
	no switching has been done: */
	while (switching) {
	  // Start by saying: no switching is done:
	  switching = false;
	  rows = table.getElementsByTagName("TR");
	  /* Loop through all table rows (except the
	  first, which contains table headers): */
	  for (i = 1; i < (rows.length - 1); i++) {
		// Start by saying there should be no switching:
		shouldSwitch = false;
		/* Get the two elements you want to compare,
		one from current row and one from the next: */
		x = rows[i].getElementsByTagName("TD")[n];
		y = rows[i + 1].getElementsByTagName("TD")[n];
		/* Check if the two rows should switch place,
		based on the direction, asc or desc: */
		if (dir == "asc") {
		  if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			// If so, mark as a switch and break the loop:
			shouldSwitch= true;
			break;
		  }
		} else if (dir == "desc") {
		  if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			// If so, mark as a switch and break the loop:
			shouldSwitch= true;
			break;
		  }
		}
	  }
	  if (shouldSwitch) {
		/* If a switch has been marked, make the switch
		and mark that a switch has been done: */
		rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
		switching = true;
		// Each time a switch is done, increase this count by 1:
		switchcount ++;
	  } else {
		/* If no switching has been done AND the direction is "asc",
		set the direction to "desc" and run the while loop again. */
		if (switchcount == 0 && dir == "asc") {
		  dir = "desc";
		  switching = true;
		}
	  }
	}
  }


 
$(document).ready(function(){		//CHANGING PLACEHOLDER IN TENDER SEARCH PAGE
	var text = ["Search Raw Materials", "Search Quantities", "Search Time till Expiry" , "Search Prices"];
	var counter = 0;
	var elem = document.getElementById("tenderSearchInput");
	setInterval(change, 1000);

	function change() {
	elem.placeholder = text[counter];
	counter++;
		if (counter >= text.length) {
			counter = 0;
		}
	}
});

$(document).ready(function() {			//	MAKE EACH ROW CLICKABLE IN TENDER TABLE
	$('#tenderSearchTableBody tr').click(function() {
			var href = $(this).find("a").attr("href");
			if(href) {
					window.location = href;
			}
	});
});


$(document).ready(function() {			//	manufacturer tender page , list group active changes
	$('div#listInUserTender > a').click(function() {
		if ($(this).hasClass("active")) {
			$(this).removeClass('active');
		}
		else{
			$(this).addClass('active');
		}
	});
});

$(document).ready(function() {			//	MAKE EACH WELL CLICKABLE IN USER TENDER
	$('div#clickableTenders').click(function() {
			var href = $(this).find("a").attr("href");
			if(href) {
					window.location = href;
			}
	});
});

$(document).ready(function() {			//	WELL HOVER OVER COLOR CHANGE
	$(".well").mouseenter(
    function(){
      $(this).css('background-color','#E0E0E0');
    });
  
   $(".well").mouseleave(
    function(){
      $(this).css('background-color','#ECF0F1');
    });
});


$('#tenderSearchTableBody td#tenderSearchTableTD').each(function () {  //color change in tender index page
	var dtTd = String($(this).text()).replace(/\s/g,'');
	(dtTd === "Expired") ? $(this).parent('tr').addClass('text-danger') : $(this).parent('tr').addClass('text-success');
});

$(document).ready(function() {
	$('.progress .progress-bar').css("width",
						function() {
								return $(this).attr("aria-valuenow") + "%";
						}
		)
});

