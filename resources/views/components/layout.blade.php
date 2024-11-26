<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>{{ $title ?? 'Broobe Laravel Challenge' }}</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
		<link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet"/>
		<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
   </head>
    <body>
        <!-- Header -->
		<main>
			<div class="container">
				<div class="py-5">
					<div class="text-center">
						<a href="#"><h1>Broobe Challenge</h1></a>
					</div>
				</div>
				<div class="py-5">
					<ul class="nav nav-tabs justify-content-center">
						<li class="nav-item">
						  <a class="nav-link" aria-current="page" href="{{ route('metrics_index') }}">Run Metric</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="{{ route('metrics_list') }}">Metric History</a>
						</li>
					</ul>
				</div>
				<div class="py-5">
				{{ $slot }}
				</div>
			</div>
		</main>
    </body>
	<footer class="text-muted py-5">
	<div class="container">
		<p class="float-end mb-1">
		<a href="#">Go up</a>
		</p>
		<p class="mb-1">©Nadia Siksnys, 2024</p>
		<p class="mb-0">Powered by Laravel 10, Guzzle 7.2, and Bootstrap 5.0</p>
	</div>
	</footer>
</html>
