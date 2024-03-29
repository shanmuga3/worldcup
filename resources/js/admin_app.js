'use strict';

require('./bootstrap');

const app = angular.module('App', ['ngSanitize']);

app.controller('myApp', ['$scope', '$http','$rootScope', function($scope, $http,$rootScope) {
    $scope.isLoading = false;
    $scope.userLanguage = 'en';

    $(document).ready(function() {
    	setTimeout( () => {
    		$scope.initRichTextEditor('.rich-text-editor');
    	},500);

        $scope.initDefaultValues();

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

    $scope.initDefaultValues = function() {
        $scope.userLanguage = userLanguage;
        $scope.applyScope();
    };

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

    $scope.updateUserDefault = function(type) {
        $scope.isLoading = true;
        var url = routeList.update_user_default;
        var data_params = {type: type,language: $scope.userLanguage};

        var callback_function = (response_data) => {
            window.location.reload();
        };

        $scope.makePostRequest(url,data_params,callback_function);
    };
}]);

app.controller('authController', ['$scope', '$http', function($scope, $http) {
    $(document).ready(function() {
        flatpickr('#dob', {
            maxDate: 'today',
            altInput: true,
            disableMobile: true,
            altFormat: flatpickrFormat,
            dateFormat: "Y-m-d",
        });
    });
}]);

app.controller('dashboardController', ['$scope', '$http', function($scope, $http) {
    $scope.prediction_form = {
        first_team_score: '',
        second_team_score: '',
        first_team_penalty: '',
        second_team_penalty: '',
    };
    $scope.active_match = {};
    $scope.active_matches = [];
    $scope.upcoming_matches = [];
    $scope.showPredictionForm = false;
    $scope.isActiveLoading = false;
    $scope.isUpcomingLoading = false;

    $(document).ready(function() {
        $scope.getMatches('upcoming');
        $scope.getMatches('active');
    });
    
    $scope.getMatches = function(type) {
        $scope.isLoading = true;
        let url = routeList.get_matches;
        let data_params = {
            'type' : type,
        }

        if(type == 'upcoming') {
            $scope.isUpcomingLoading = true;
        }
        else {
            $scope.isActiveLoading = true;
        }

        let callback_function = (response_data) => {
            if(type == 'upcoming') {
                $scope.upcoming_matches = response_data.matches;
                $scope.isUpcomingLoading = false;
            }
            else {
                $scope.active_matches = response_data.matches;
                $scope.isActiveLoading = false;
            }
        };

        $scope.makePostRequest(url,data_params,callback_function);
    };

    $scope.predictNow = function(match) {
        $scope.prediction_form = {
            first_team_score: '',
            second_team_score: '',
            first_team_penalty: '',
            second_team_penalty: '',
        };
        $scope.active_match = match;
        $scope.showPredictionForm = true;
    };
    
    $scope.hidePrediction = function() {
        $scope.showPredictionForm = false;
        $scope.applyScope();
    };

    $scope.submitPrediction = function() {
        let url = routeList.predict_match;
        let data_params = $scope.prediction_form;
        data_params['match_id'] = $scope.active_match.id;
        $scope.isActiveLoading = true;

        let callback_function = (response_data) => {
            $scope.isActiveLoading = false;
            if(response_data.error) {
                $scope.error_messages = response_data.error_messages;
                return false;
            }

            $scope.error_messages = {};

            if(!response_data.status) {
                let content = {
                    title: response_data.status_title,
                    message: response_data.status_message,
                };
                flashMessage(content,"danger");
                return false;
            }

            let content = {
                title: response_data.status_title,
                message: response_data.status_message,
            };
            flashMessage(content,"success");
            $scope.showPredictionForm = false;
            $scope.getMatches('active');
        };

        $scope.makePostRequest(url,data_params,callback_function);
    };

}]);