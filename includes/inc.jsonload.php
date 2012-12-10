<?php
echo '$(".menubutton").bind("click", function(){
			var NewLink= $(this).attr("rel");
			window.location.href = NewLink;
		})
		.bind("mouseenter mouseleave", function() {
			$(this).toggleClass("mover");
		});';
?>