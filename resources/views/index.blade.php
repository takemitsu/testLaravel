@extends('app')
@section('css')
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
@endsection
@section('content')

<div class="container" ng-view>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-route.js"></script>
<script src="/js/common/angular-file-upload.min.js"></script>
<script src="/js/common/angular-file-upload-shim.min.js"></script>
<script src="/js/common/ui-bootstrap.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>
<script src="/js/controllers/mainCtrl.js"></script>
<script src="/js/services/bbsService.js"></script>
<script src="/js/app.js"></script>

@endsection
