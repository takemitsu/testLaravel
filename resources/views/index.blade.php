@extends('app')
@section('css')
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
@endsection
@section('content')

<div class="container" ng-app="bbsApp" ng-controller="mainController">
	<div class="row">
		<div class="col-md-12">
			<form ng-submit="submitComment()">
				<div class="form-group">
					<input type="text" class="form-control input-sm" name="author" ng-model="postData.name" placeholder="名前">
				</div>
				<div class="form-group">
					<input type="text" class="form-control input-lg" name="subject" ng-model="postData.subject" placeholder="タイトル">
				</div>
				<div class="form-group">
					<textarea class="form-control" rows="3" name="comment" ng-model="postData.comment" placeholder="内容"></textarea>
				</div>

				<div class="form-group text-right">
					<button type="submit" class="btn btn-primary btn-lg">コメントする</button>
				</div>
			</form>

			<p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>

			<div class="comment" ng-hide="loading" ng-repeat="p in posts">
				<h3>@{{ p.subject }} <small>by @{{ p.name }}</h3>

				<p style="white-space: pre-line;">@{{ p.comment }}</p>
				<p><a href="#" ng-click="deleteComment(p.id)" class="text-muted">削除</a></p>
			</div>

		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<script src="js/controllers/mainCtrl.js"></script>
<script src="js/services/bbsService.js"></script>
<script src="js/app.js"></script>

@endsection
