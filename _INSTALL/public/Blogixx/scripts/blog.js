$(document).ready(function() {
			
	var iSelectedIndex = 0;
	$('#suggest').addClass('hide').attr("autocomplete", "off");			

	// navigate through suggest pulldown
	$('body').keydown(function (event) {

		if (event.keyCode == 13)
		{
			var sHref = $('#suggest a:nth-child(' + iSelectedIndex + ')').attr('href');
			('undefined' !== typeof sHref) ? location.href = sHref : false;
			return false;
		}

		if (event.keyCode == 40) {
			iSelectedIndex++;
			(iSelectedIndex > $('#suggest a').length) ? iSelectedIndex = $('#suggest a').length : false;
			$('#suggest a').removeClass('suggestHover');
			$('#suggest a:nth-child(' + iSelectedIndex + ')').addClass('suggestHover');						
		}					

		if (event.keyCode == 38) {
			iSelectedIndex--;
			(iSelectedIndex <= 0) ? iSelectedIndex = 0 : false;
			$('#suggest a').removeClass('suggestHover');
			$('#suggest a:nth-child(' + iSelectedIndex + ')').addClass('suggestHover');						
		}
	});

	// suggest
	$('#inputSearch').on('keyup', function(event){

		if (event.keyCode == 40 || event.keyCode == 38 || event.keyCode == 13) {
			return false;
		}

		var sInput = this.value;
		sInput = sInput.trim();

		if (sInput.length < 3)
		{
			return false;
		}

		$.get("/Ajax/", 
			{"a":sInput}, 
			function(data, status) {

				if (data.length > 0)
				{
					var sLink = '';
					data.forEach(function(item){sLink+= '<a href="' + item[1] + '">' + item[0] + '</a>';});							
					$('#suggest').removeClass('hide');
					$('#suggest').html(sLink);
				}
				else
				{
					$('#suggest').addClass('hide').attr("autocomplete", "off");
				}
			}
		);
	});

	// make images behave responsive
	$('.container img').addClass('img-responsive');

	// convert <tag> list into clickable hyperlinks
	$('.container tag').each(function( index ) {
		var sTag = $(this).html();
		var aTag = sTag.split(',');
		var sTagUrls = '';
		aTag.forEach(function(item){
			sTagUrls+= '<a href="/tag/' + item.trim() + '/">' + item.trim() + '</a>, ';
		});
		
		$(this).html('Tags: <strong>' + sTagUrls + '</strong>');					
	});		
});