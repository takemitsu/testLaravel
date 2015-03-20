<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BBS MDK</title>
<!--
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
-->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">簡易掲示板的な何か</a>
			</div>
		</div>
	</nav>



<div class="container" ng-app="commentApp" ng-controller="mainController">
	<div class="row">
		<div class="col-md-12">
<!--
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>
				<div class="panel-body">
					You are logged in!
				</div>
			</div>
-->
<form ng-submit="submitComment()">
	<div class="form-group">
		<input type="text" class="form-control input-sm" name="author" ng-model="post.name" placeholder="名前">
	</div>
	<div class="form-group">
		<input type="text" class="form-control input-lg" name="subject" ng-model="post.subject" placeholder="タイトル">
	</div>
	<div class="form-group">
		<textarea class="form-control" rows="3" name="comment" ng-model="post.comment" placeholder="内容"></textarea>
	</div>

	<div class="form-group text-right">
		<button type="submit" class="btn btn-primary btn-lg">コメントする</button>
	</div>
</form>

<p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>

<div class="comment" ng-hide="loading" ng-repeat="post in posts">
	<h3>コメント #{{ post.id }} <small>by {{ post.name }}</h3>
	<p>{{ post.title }}</p>
	<p>{{ post.comment }}</p>
	<p><a href="#" ng-click="deletePost(post.id)" class="text-muted">削除</a></p>
</div>

		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<script src="js/controllers/mainCtrl.js"></script>
<script src="js/service/bbsService.js"></script>
<script src="js/app.js"></script>




	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>


