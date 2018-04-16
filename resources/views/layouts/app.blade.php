<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="csrf-token" content="{{csrf_toen()}}">
	<title>@yield('title',Larabbs) -实战教程</title>
	<style type="text/css">
		<link href="{{asset('css/app.css')}}" rel="stylesheet"/ >
	</style>
</head>
<body>
	<div id="app" class="{{route_class()}}-page">
		@include('layouts._header')
		<div class="container">
			@yield('content')
		</div>
		@include('layouts._footer')
	</div>
	<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>