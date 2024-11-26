<x-layout>
    @if ($errors->any())
    <!-- Display errors -->
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- metrics form -->
    <div id="insightsForm">
        <div class="row">
            <div class="col-md-3">
                <label class="form-label" for="url"><b>URL</b></label>
                <input id="url" name="url" type="text" class="form-control form-control-lg" required>
            </div>
            <div class="col-md-7">
                <label class="form-label"><b>CATEGORIES</b></label>
                @foreach ($categories as $category)
                <div class="form-check">
                    <input id="categories" name="categories" class="form-check-input" type="checkbox" value="{{ $category->name }}">
                    <label class="form-check-label">
                        {{ $category->name }}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="col-md-2">
                <label class="form-label" for="strategy"><b>STRATEGY</b></label>
                <select id="strategy" name="strategy" class="form-select">
                    @foreach ($strategies as $strategy)
                    <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button id="getInsights" class="form-control btn btn-primary" onclick="insightsRequest()">GET METRICS</button>
            </div>
        </div>
    </div>

    <!-- display results -->
    <div id="results" class="mt-5" hidden>
        <form method="POST" action="{{ route('metrics_store') }}">
            @csrf
            <input id="strategy_id" name="strategy_id" type="hidden">
            
            @foreach($fillables as $fillable)
            <input id="{{ $fillable }}" name="{{ $fillable }}" type="hidden">
            @endforeach

            <div class="row">
                {{-- create category cards (all but PWA) --}}
                @foreach ($categories as $category)
                @if ($category->name != "PWA")
                <div id="{{ strtolower($category->name) }}-card" name="{{ strtolower($category->name) }}-card" class="card text-center col-md-2 me-5">
                    <div id="{{ strtolower($category->name) }}-card" name="{{ strtolower($category->name) }}-card" class="card-body">
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ str_replace('_',' ',$category->name) }}</h6>
                        <h1 id="{{ strtolower($category->name) }}-card-value" class="card-title">0.0</h1>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            <div class="row mt-2">
                <button id="insights-save" type="submit" class="btn btn-primary col-md-2">SAVE METRIC RUN</button>
            </div>
        </form>
    </div>
    <script type="application/javascript">
		// Get site metrics
        function insightsRequest() {
            // form element and submitted inputs
            var form = document.getElementById("insightsForm");
            const targetUrl = form.querySelector("input[name='url']").value;
            const strategy = form.querySelector("select[name='strategy']").selectedOptions[0].text;

            const checkboxes = form.querySelectorAll("input[name='categories']:checked");
            var categories = Array();
            checkboxes.forEach((item) => {
                categories.push('categories[]=' + item.value);
            });

            var params = 'url=' + targetUrl + '&' + categories.join('&') + '&strategy=' + strategy; 
            
            // route defined in the project
            var url = "{{ route('insights') }}";
            
            // Clear all inputs, just in case
            resetInputs();

            // Ajax call
			var request = new XMLHttpRequest();
			request.open("GET", url + "?" + params);
			request.send();
			request.onreadystatechange = function() {
				if (request.readyState == XMLHttpRequest.DONE) {
					// Check the status of the response
					if (request.status == 200) {
                        // Access the data returned by the server
                        var data = JSON.parse(request.responseText);
                        // Do something with the data
                        showResults(data);
					} else {
                        // Handle error
                        var error = JSON.parse(request.responseText)
                        console.error(error);
                        alert(error);
					}
				}
			};
        }
        
        function showResults(data) {
            var form = document.getElementById('results');

            // set hidden values
            form.querySelector("input[name='url']").value = data['requestedUrl'];
            form.querySelector("input[name='strategy_id']").value = document.getElementById("insightsForm").querySelector("select[name='strategy']").selectedOptions[0].value;

            // set metric values
            for (const [key, value] of Object.entries(data.categories)) {
                document.getElementById(key.replace('-','_') + '-card-value').textContent = value.score;
                document.getElementById(key.replace('-','_').replace('accessibility','accesibility') + '_metric').value = value.score;
            }

            // make the results section visible
            document.getElementById('results').hidden = false;
        }

        function resetInputs() {
            // make the results section hidden
            document.getElementById('results').hidden = true;
            
            // clear all inputs
            var form = document.getElementById('results');
            form.querySelectorAll('input').forEach((item) => {
                if (item.name != "_token"){
                    if (item.name == 'url') {
                        item.value = "";
                    }
                    else {
                        item.value = 0;
                    }
                }
            });

            // clear all cards
            form.querySelectorAll('h1.card-title').forEach((item) => {
                item.textContent = "0.0"
            })
        }
    </script>
</x-layout>