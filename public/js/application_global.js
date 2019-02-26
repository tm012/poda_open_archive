  function save_keyboard_stoke(keyContent) {

  	//alert(keyContent);
  	var d = new Date();
  	var time_c = Date.parse(d);
  	//Date.parse(d)/1000; //unix time stamp
  	var stroke_alphabet  = localStorage.getItem("stroke_alphabet");
  	var stroke_time  = localStorage.getItem("stroke_time");


    // document.cookie ='stroke_alphabet='+String(time_c);
    // document.cookie ='stroke_time='+String(time_c);
  	if (!stroke_alphabet) {
  // is emtpy

    	stroke_alphabet = keyContent;
  		stroke_time =  time_c.toString();
  		localStorage.setItem("stroke_alphabet", stroke_alphabet);
  		localStorage.setItem("stroke_time", stroke_time);
	 }
	 else{

  		stroke_alphabet = stroke_alphabet + "," + keyContent;
  		stroke_time = stroke_time + "," + time_c.toString();
  		localStorage.setItem("stroke_alphabet", stroke_alphabet);
  		localStorage.setItem("stroke_time", stroke_time);
  	}

  }

 function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }


function delete_cookie( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


function setCaretPosition(ctrl, pos) {
  
  // Modern browsers
  if (ctrl.setSelectionRange) {
    ctrl.focus();
    ctrl.setSelectionRange(pos, pos);
  
  // IE8 and below
  } else if (ctrl.createTextRange) {
    var range = ctrl.createTextRange();
    range.collapse(true);
    range.moveEnd('character', pos);
    range.moveStart('character', pos);
    range.select();
  }
}

//table search
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

    
