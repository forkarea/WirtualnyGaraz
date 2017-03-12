  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd", maxDate: new Date});
	$(".price").keyup( function(){
		this.value = this.value.replace(',', '.');
        //only number and .
        this.value = this.value.replace(/[^0-9\.]/g, '');
        //first must be number
        this.value = this.value.replace(/^\./g, '');
        //.. is not allowed
        this.value = this.value.replace(/\.{2,}/g, '.');
        //only one . allowed
        this.value = this.value.replace('.','$#$').replace(/\./g, '').replace('$#$', '.'); 
    });

$( "select1" )
  .change(function () {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).text() + " ";
    });
    $( "div" ).text( str );
  })
  
  } );