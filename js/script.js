$(function () {
   $('#camera_toggle').on('click', function () {
      $('.input-camera').prop('checked', this.checked);
   });
   
   $('#event_toggle').on('click', function () {
      $('.input-event').prop('checked', this.checked);
    });



   $('#from').datepicker({
   	  onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
   });


   $('#to').datepicker({});

   $('#from_time,#to_time').mask('99:99');

});