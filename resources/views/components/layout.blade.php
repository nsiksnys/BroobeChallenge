<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>{{ $title ?? 'Broobe Laravel Challenge' }}</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
		<link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet"/>
		<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
   </head>
    <body>
        <!-- Body -->
		<main class="bg-light">
			<div class="py-3 border-bottom">
				<div class="text-center">
					<h1>Broobe Challenge</h1>	
				</div>
			</div>
			<div class="container">
				<div class="py-3">
					<ul class="nav nav-tabs justify-content-center">
						<li class="nav-item">
						  <a class="nav-link @if(url()->current() == route('metrics_index')) active @endif " href="{{ route('metrics_index') }}" @if(url()->current() == route('metrics_index')) aria-current="page" @endif >Run Metric</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link @if(url()->current() == route('metrics_list')) active @endif " href="{{ route('metrics_list') }}" @if(url()->current() == route('metrics_list')) aria-current="page" @endif >Metric History</a>
						</li>
					</ul>
				</div>
				<div class="py-3">
				{{ $slot }}
				</div>
			</div>
		</main>
    </body>
	<footer class="text-muted py-3">
        <!-- Footer -->
		<div class="container">
			<p class="mb-1">©Nadia Siksnys, 2024</p>
			<p class="mb-0">Powered by Laravel 10, Guzzle 7.2, Bootstrap 5.3, DataTables 2.1</p>
		</div>
	</footer>
</html>
