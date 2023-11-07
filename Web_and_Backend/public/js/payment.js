app.service('fileUploadService', function ($http, $q) {
    this.uploadFileToUrl = function (type,file, uploadUrl, data) {
        var fileFormData = new FormData();
        if(type == 'single') {
        	fileFormData.append('file', file);
        }
        else {
	        $.each(file, function( index, value ) {
	            fileFormData.append('file[]', value);
	        });        	
        }
        if(data) {
            $.each(data, function(i, v) {
                fileFormData.append(i, v);
            })
        }
        var deffered = $q.defer();
        $http.post(uploadUrl, fileFormData, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},
            config:{
                uploadEventHandlers: {
                    progress: function(e) {
                        console.log('UploadProgress -> ' + e);
                    }
                }
            }
        })
        .success(function (response) {
            deffered.resolve(response);
        })
        .error(function (response) {
            deffered.reject(response);
        });
        var getProgressListener = function(deffered) {
            return function(event) {
                eventLoaded = event.loaded;
                eventTotal = event.total;
                percentageLoaded = ((eventLoaded/eventTotal)*100);
                deffered.notify(Math.round(percentageLoaded));
            };
        };
        return deffered.promise;
    }
});


$scope.upload_document = function(document_for,document_name,document_id,vehicle_id)
{
	$('#span-cls').text($scope.select_file);
	$('.document_upload').text(document_name);
	$scope.uploadFormData.document_for = document_for;
	$scope.uploadFormData.document_id = document_id;
	$scope.uploadFormData.vehicle_id = vehicle_id;
}
$('#document_upload').change(function(e)
{    
    $('.doc-button').attr('type','submit');
    $('#uploadForm').submit();
});
$(".doc_upload").on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $("#document_upload").trigger('click');
});
$(document).ready(function (e) 
{
	$(".image-show").click(function(){

         // show Modal
         $('#myModalLabel').text($(this).attr('data-title'));
         $('.modal-image').attr('src',$(this).find('img').attr('src'));
         $('#myModal').modal('show');
    });

    $scope.uploadPhotos = function(element) {
		var photos = [];
		files = element.files;
		if(files) {
			photos = files;
			if(photos.length) {
				url = APP_URL+'/document_upload/'+ $scope.uploadFormData.id;
				upload = fileUploadService.uploadFileToUrl('single',photos[0], url,$scope.uploadFormData);
				upload.then(function(response) {
					$('.top-home').removeClass('loading');		    	
					if(response.status == 'true') {
						$('#span-cls').text($scope.upload_file);
						setInterval(function() {
							$(".popup1").hide();
							window.location.reload();
						},1500);
					}
					else {
						$('#error_msg').text(response.status_message);
					}
				});
			}
		}
	};

	$("#uploadForm").on('submit',(function(event) {
		$('.top-home').addClass('loading');
		event.preventDefault();
		$scope.uploadPhotos(document.getElementById("document_upload"));
	}));
});
	



	