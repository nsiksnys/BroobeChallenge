<x-layout>
    <!-- Display errors -->
    <div id="errors" class="alert alert-danger">
        <ul>
        </ul>
    </div>
    
    <!-- Display info -->
    <div id="success" class="alert alert-success">
    </div>

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
                <button id="spinnerGetInsights" class="form-control btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">SENDING REQUEST...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- display results -->
    <div id="results" class="mt-5">
        @csrf
        <input id="strategy_id" name="strategy_id" type="hidden">
        
        @foreach($fillables as $fillable)
        <input id="{{ $fillable }}" name="{{ $fillable }}" type="hidden">
        @endforeach

        <div class="row">
            {{-- create category cards (all but PWA) --}}
            @foreach ($categories as $category)
            @if ($category->name != "PWA")
            <x-card :category="$category->name">
            </x-card>
            @endif
            @endforeach
        </div>
        <div class="row mt-2">
            <button id="saveInsights" class="btn btn-primary col-md-2" onclick="saveMetrics()">SAVE METRIC RUN</button>
            <button id="spinnerSaveInsights" class="btn btn-primary col-md-2" type="button" disabled>
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">SAVING...</span>
            </button>
        </div>
    </div>
    <script type="application/javascript">
        // Hide the spinner button and the results section
        document.getElementById("spinnerGetInsights").hidden = true;
        document.getElementById("spinnerSaveInsights").hidden = true;
        document.getElementById("results").hidden = true;
        document.getElementById("errors").hidden = true;
        document.getElementById("success").hidden = true;

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
            ajaxRequest("GET", url, params, "spinnerGetInsights", "getInsights", showResults);
        }

        function saveMetrics() {
            var form = document.getElementById('results');
            var inputs = Array();
            form.querySelectorAll('input').forEach(input => {
                inputs.push(input.name + "=" + input.value);
            })
            var params = inputs.join('&');
            var url = "{{ route('metrics_store') }}";

            // Ajax call
            ajaxRequest("POST", url, params, 'spinnerSaveInsights', 'saveInsights', showSuccess);
        }
        
        function ajaxRequest(method, url, params, spinner, submit, callback) {
            var request = new XMLHttpRequest();
			request.open(method, url + "?" + params);
            request.onloadstart = function() {
                document.getElementById(spinner).hidden = false;
                document.getElementById(submit).hidden = true;
            }
			request.onreadystatechange = function() {
				if (request.readyState == XMLHttpRequest.DONE) {
                    if (request.status == 200) {
                        // Access the data returned by the server
                        var data = JSON.parse(request.responseText);
                        // Do something with the data
                        callback(data);
                    }
                    // Handle errors
                    else {
                        var errors = JSON.parse(request.responseText);
                        parseErrors(errors);
                        document.getElementById("errors").hidden = false;
					}
				}
			}
            request.onloadend = function() {
                document.getElementById(spinner).hidden = true;
                document.getElementById(submit).hidden = false;
            }
			request.send();
        }

        function showResults(data) {
            var form = document.getElementById('results');

            // set hidden values
            form.querySelector("input[name='url']").value = data['requestedUrl'];
            form.querySelector("input[name='strategy_id']").value = document.getElementById("insightsForm").querySelector("select[name='strategy']").selectedOptions[0].value;

            // set metric values
            for (const [key, value] of Object.entries(data.categories)) {
                var category = key.replace('-','_');
                document.getElementById(category + '-card-value').textContent = value.score;
                document.getElementById(category.replace('accessibility','accesibility') + '_metric').value = value.score;
                
                // paint the card based on the score
                var card = document.getElementById(category + '-card');
                var classes = card.getAttribute('class');
                var color = 'text-bg-' + paintCards(value.score);
                card.setAttribute('class', classes + ' ' + color);
            }

            // make the results section visible
            document.getElementById("results").hidden = false;
        }

        function showSuccess(message) {
            var info = document.getElementById('success');
            info.innerHTML = message;
            info.hidden = false;
        }

        function resetInputs() {
            // make the results section hidden
            document.getElementById("results").hidden = true;

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
            
            // remove all text-bg classes
            form.querySelectorAll('card').forEach(card => {
                var classes = card.getAttribute('class');
                card.setAttribute('class', classes.replaceAll(/ text-bg-([a-z]+)/gi,''));
            })

            // clear all errors and hide the div
            document.getElementById("errors").hidden = true;
            document.getElementById('errors').querySelector('ul').innerHTML = "";

            // make the success section hidden
            document.getElementById('success').hidden = true;
            document.getElementById('success').innerHTML = "";
        }

        /*
            Paint cards according to their score
            Values are:
            0 to 49 (red): Poor
            50 to 89 (orange): Needs Improvement
            90 to 100 (green): Good
            For more information about this, check https://developer.chrome.com/docs/lighthouse/performance/performance-scoring#color-coding
        */
        function paintCards(value){
            if (value >= 0 && value < 0.5) {
                return "danger";
            }
            
            if (value >= 0.5 && value < 0.9) {
                return "warning";
            }

            if (value >= 0.9 && value <= 1) {
                return "success";
            }
        }

        function parseErrors(inputs){
            var errorsList = "";

            if (typeof inputs === "string") {
                document.getElementById('errors').querySelector('ul').innerHTML = inputs;
                return;
            }

            for (const [input, errors] of Object.entries(inputs)) {
                errors.forEach(error => {
                    errorsList += "<li>" + error + "</li>";
                });
            }
            document.getElementById('errors').querySelector('ul').innerHTML = errorsList;
        }
    </script>
</x-layout>