 <!DOCTYPE html>
<html lang="en-US">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Flickr images Searching Tool">
    <meta name="author" content="Gabriel Roget">

	<title>The Rubber Duck Company ©</title>
	<link href="bootstrap.min.css" rel="stylesheet">
	<link href="galerie.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body ng-app="rubberDuckApp" ng-controller="rubberDuckCtrl">

	    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">

      	<div>
  			<span class="navbar-brand" href="#">Search for images</span>
  			<input type="text" name="tags" placeholder="Enter tags here"  ng-model="tags" ng-change="load(true)" ng-model-options="{debounce: 750}">
  		</div>


  		<div>
		<label for="subscribeNews" class="navbar-brand">Resize images</label>
  		<input type="checkbox" id="resizeImages" name="resize" value="resize" ng-model="resize">
  		</div>

        <div class="collapse navbar-collapse" id="navbarResponsive">
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <h1 class="my-4 text-center text-lg-left" ng-if="items.length > 0">Images from Flickr</h1>

		<div class="row text-center text-lg-left">

			<div class="col-lg-3 col-md-4 col-xs-6" ng-repeat="item in items">
				<p>
				<a href="#" class="d-block mb-4 h-100" ng-if="!resize"><img class="img-fluid img-thumbnail" src="{{item.media.m}}" style="text-align: center;"></a>
				<a href="#" class="d-block mb-4 h-100" ng-if="resize"><img class="img-fluid img-thumbnail" src="getty.php?src={{item.media.m}}" style="text-align: center;"></a>
				</p>
				<p>
				<a href="{{item.media.m}}">{{item.title}}</a><br />
				By {{ getAuthor(item.author) }}
				{{resize}}
				</p>
        	</div>
        </div>
	</div>

	<script>
		var app = angular.module('rubberDuckApp', []);
		app.controller('rubberDuckCtrl', function($scope, $http) {
			$scope.items = [];
			$scope.resize = false;

			$scope.load = function(remove) {
				if (remove)
					$scope.items.length = 0;

				$http.get("data.php?request=" + $scope.tags)
				.then(
					function (response) {
						$scope.json = response.data;
						console.log($scope.json);
						//$scope.items = $scope.json.items;
						for(var i = 0 ; i < $scope.json.items.length ; ++i)
							$scope.items.push($scope.json.items[i]);
					},
					function (response) {
						$scope.data = "Error occured " + response.status + " " + response.statusText + " " + response.data;
					}
				);
			};

			$scope.update = function(state) {
				alert(state);
			};

			$scope.getAuthor = function(data) {
				return data.substring(data.indexOf("\"") + 1, data.lastIndexOf("\""));
			};
		});
	</script> 
</body>
</html> 