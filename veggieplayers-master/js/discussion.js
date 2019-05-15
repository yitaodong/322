
    /*$('.dropbtn').click(function(){
        $('#myDropdown').slideDown(500);
        $(".main li").hover(
            function(){
                //$('ul.sub', this).slideDown(500);
                //$('>ul.sub', this).slideDown(500);
                $('>ul.sub:not(:animated)', this).slideDown(500);
            },
            function(){
                //$('ul.sub',this).slideUp(300);
                $('>ul.sub',this).slideUp(300);
            }
        );
    });*/
    $(function(){
        $(".dropbtn a").hover(
            function(){
                //$('ul.sub', this).slideDown(500);
                //$('>ul.sub', this).slideDown(500);
                //$('>ul.sub:not(:animated)', this).slideDown(500);
                $(this).slideDown(500);
            });
    });

$(document).ready(function() {
    $('.c_mypost').hide();
    $('.create_post').click(function(e)
    {
        $('#mypostform').hide();
	    $('#postdiss').show();
	    e.preventDefault();
    });

    $('.return_mypost_post').click(function(e)
    {
        $('#postdiss').hide("fast");
        $('#mypostform').show();
        e.preventDefault();
    });
    
    $('.edit_post').click(function(e)
    {
        e.preventDefault();
        $('#mypostform').hide();
        $('#editpost').show();
    });

    $('.return_mypost_edit').click(function(e)
    {
        e.preventDefault();
        $('#editpost').hide();
        $('#mypostform').show();
    });
});
 