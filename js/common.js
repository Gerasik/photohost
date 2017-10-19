$(document).ready(function () {

	jQuery.event.props.push('dataTransfer');
	var maxFiles = 1;
	var errMessage = 0;
	var defaultUploadBtn = $('#uploadbtn');
	var dataArray = {};
	var dropZone = $('#drop-files');

	$('#keyword').typeahead({
		source: function (query, result) {
			$.ajax({
				url: "search.php",
				data: 'query=' + query,
				dataType: "json",
				type: "POST",
				success: function (data) {
					result($.map(data, function (item) {
						return item;
					}));
				}
			});
		}
	});

	$('.add-image').click(function(){
		$('.uploader').removeClass('hide-form');
	});

	$('#form-close').click(function(){
		$('.uploader').addClass('hide-form');
	});

	$('#filebtn').click(function(){
		$("input[type='file']").trigger('click');
	});

	$('.tags-area .tag a').click(function(){
		$(this).parent('.tag').remove();
	});

	$('a.add-tag').click(function(){
		if ($('.input-tag input').val()) {
			$('.tags-area').append($('.tags-area .tag:last-of-type').clone(true));
			$('.tags-area .tag:last-of-type p').text($('.input-tag input').val()).parent().removeClass('tag-hide');
			$('.input-tag input').val('');
		};
	});	

	dropZone[0].ondragover = function() {
		dropZone.addClass('hover');
		return false;
	};

	dropZone[0].ondragleave = function() {
		dropZone.removeClass('hover');
		return false;
	};

	dropZone[0].ondrop = function(event) {
		event.preventDefault();
		var files = event.dataTransfer.files;
		loadInView(files);
	};

	defaultUploadBtn.on('change', function() {
		var files = $(this)[0].files;
		loadInView(files);
	});

	function loadInView(files) {
		$('#drop-files').children().hide();	
		var fileReader = new FileReader();
		fileReader.onload = function(e) {
				dataArray.name = files[0].name;
				dataArray.value = this.result;
				addImage(dataArray);
			};
		fileReader.readAsDataURL(files[0]);
		return false;
	};

	function addImage(ind) {

		$('#drop-files').append('<div class="image" style="background: url('+dataArray.value+'); background-size: cover;"></div>'); 		
		return false;

	};

	$('.media-submit input[type="submit"]').click(function() {

		var imageName = $('.media-name input[type="text"]').val();
		var description = $('.media-description textarea').val();
		var tags = ""; 

		$('.tag p').text(function(index,value){
			tags = tags + " " + value;
		});

		$('#loading-content').html('uploaded '+dataArray.name);

		dataArray.image = imageName;
		dataArray.description = description;
		dataArray.tags = tags;

		$.post('publish.php', dataArray, function(data) { 
			var fileName = dataArray.name;
			var dataSplit = data.split(':');
			if(dataSplit[1] == 'successfully uploaded') {
				$('#uploaded-files').append('<li><a href="images/'+dataSplit[0]+'">'+fileName+'</a> successfully uploaded</li>');
				         
			} else {
				$('#uploaded-files').append('<li><a href="images/'+data+'. File name: '+dataArray[index].name+'</li>');
			}
		});

		$('#upload-form').each(function(){
				this.reset();
			});

		$('#drop-files .image').remove();
		$('.tags-area .tag:not(.tag-hide)').remove();
		$('#drop-files').children().show();
		dropZone.removeClass('hover');	
		$('#uploaded-files').show();
	});

	var busy;
	var scrollPagination = {
		nop     : 4,
		offset  : 15,
		error   : 'No more images'		
	};

	if($(window).height()==$(document).height() && !busy){
    		busy = true;
    		getData();
	}

	$(window).scroll(function() {
		if($(window).scrollTop()+$(window).height()+1>=$(document).height() && !busy){
    		busy = true;
    		getData();
		}
	});

	function getData() {

		if (pageSearch) {
			scrollPagination.search = pageSearch;
		}

		$.post('pagination.php', scrollPagination, function(data) {

			$(window).find('.loading-bar').html('123');
			
			if(data == "") { 
				$(window).find('.loading-bar').html(scrollPagination.error);  
			}
			else {
				scrollPagination.offset = scrollPagination.offset+scrollPagination.nop; 

				if(data == 'No more images'){
					$('.loading-bar').html('No more images');
					busy = true;
				}
				else {

				$('.image-collection').append(data);
				busy = false;
				}
			} 
		});
	};

});
