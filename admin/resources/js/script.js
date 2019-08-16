$(function() {


    // Client Side Validation on Adding a new post text input limits ...
	$(".post form").submit(function (){
           var title,content,excerpt,count;
           count = 0;
           title = $(".post form input[name='title']").val();
           content = $(".post form textarea").val();
           excerpt = $(".post form input[name='excerpt']").val();
           if (title.length < 50 || title.length > 200) {
                $(".post li.title-error").fadeIn(450);
                count = count + 1;
            }
            else
            	 $(".post li.title-error").fadeOut(450);
            if (content.length < 200 || content.length > 10000) {
                $(".post li.body-error").fadeIn(450);
                count = count + 1;
            }
            else 
            	$(".post li.body-error").fadeOut(450);
            if (excerpt.length != 0 ) {
	            if (excerpt.length < 50 || excerpt.length > 200) {
	                $(".post li.excerpt-error").fadeIn(450);
	                count = count + 1;
	            }
	            else 
	            	$(".post li.excerpt-error").fadeOut(450);
            }
            if (count > 0) {
            	window.scrollTo(0, 0); // scroll top of page to show errors 
            	return false; // never send to the server 
            }
            else
            	count = 0;
            	return true; // send to the server 






	});











});