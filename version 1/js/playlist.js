$(function() {
  $( "#sortable" ).sortable({
    revert: false,
    stop: function(event, ui) {
      var data = $(this).sortable('serialize');
      console.log(data);
    }

  });
  $( "ul, li" ).disableSelection();
});