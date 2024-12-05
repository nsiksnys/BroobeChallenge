<div id="{{ strtolower($category) }}-card" name="{{ strtolower($category) }}-card" class="card text-center col-md-2 me-5">
    <div id="{{ strtolower($category) }}-card" name="{{ strtolower($category) }}-card" class="card-body">
        <h6 class="card-subtitle mb-2 text-body-secondary">{{ str_replace('_',' ',$category) }}</h6>
        <h1 id="{{ strtolower($category) }}-card-value" class="card-title">0.0</h1>
    </div>
</div>