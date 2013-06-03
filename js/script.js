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


   // reset hash on key press
   $('.btn.btn-success.pull-right').click(function() {window.location.hash = ''; $(this).closest('form').submit(); });

});