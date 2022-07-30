app.controller('myApp', ['$scope', '$http','$rootScope', function($scope, $http,$rootScope) {
    $scope.isLoading = false;

    $(document).ready(function() {
    	setTimeout( () => {
    		$scope.initRichTextEditor('.rich-text-editor');
    	},500);

    	let deleteModalEl = document.getElementById('confirmDeleteModal');
	    if(deleteModalEl !== null) {
			let deleteModel = bootstrap.Modal.getOrCreateInstance(deleteModalEl);
	    	$(document).on('click', '.confirm-delete', function() {
				let url = $(this).attr('data-href');
				$('.confirm-delete-action').attr('href',url);
				deleteModel.show();
			});

	        deleteModalEl.addEventListener('hidden.bs.modal', function(event) {
	            $('.confirm-delete-action').attr('href','#');
	        });
	    }

	    $(document).on('change','.select-with-dropdown .dropdown-field',function() {
			let value = $(this).find('option:selected').data('display_value');
			$(this).parent('.select-with-dropdown').find('.select-value').text(value);
		});
    });

    // Common function to perform http requests
    $scope.makePostRequest = function(url, data, callback) {
        if(!data) {
          data = {};
        }
        $scope.isLoading = true;
        $http.post(url, data).then(function(response) {
            $scope.isLoading = false;
            if(response.status == 200) {
                if(callback) {
                    callback(response.data);
                }
            }
        });
    };

    $scope.checkInValidInput = function(value) {
        if(value == null) {
            return true;
        }
        if(typeof value == 'object') {
            return value.length == 0;
        }
        return (value == undefined || value == 0 || value == '');
    };

    $scope.truncateString = function(str, num = 20) {
        if (str.length > num) {
            return str.slice(0, num) + "..";
        }
        else {
            return str;
        }
    }

    // Common function to check and apply Scope value
    $scope.applyScope = function() {
        if(!$scope.$$phase) {
            $scope.$apply();
        }
    };

    // Get Checkbox Checked Values Based on given selector
    $scope.getSelectedData = function(selector) {
        var value = [];
        $(selector+':checked').each(function() {
            value.push($(this).val());
        });
        return value;
    };

    $scope.initRichTextEditor = function(selector) {
        let editors = document.querySelectorAll(selector);
        editors.forEach(editor => {
            let editorSelector = editor.id;
            $('#'+editorSelector).summernote({
                height: 250,
                callbacks: {
                    onImageUpload: function(files) {
                        $('.note-editor').addClass('loading');
                        for(let i=0; i < files.length; i++) {
                            let file = files[i];
                            let formData = new FormData();
                            formData.append('file', file, file.name);
                            axios.post(routeList.upload_image, formData, {
                                headers: {'Content-Type': 'multipart/form-data'}
                            }).then((response) => {
                                let response_data = response.data;
                                if(response_data.status) {
                                    let imgNode = document.createElement('img');
                                    imgNode.src = response_data.src;
                                    $('#'+editorSelector).summernote('insertNode', imgNode);
                                }
                                $('.note-editor').removeClass('loading');
                            });
                        }
                    }
                }
            });
        });
    };
}]);