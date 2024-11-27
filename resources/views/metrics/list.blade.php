<x-layout>
    <!-- list metrics -->
    <h1> Metric history</h1>
    <table id="resultsTable" class="table">
        <thead>
            <th>ID</th>
            <th>URL</th>
            <th>STRATEGY</th>
            <th>ACCESSIBILITY</th>
            <th>BEST_PRACTICES</th>
            <th>PERFORMANCE</th>
            <th>PWA</th>
            <th>SEO</th>
            <th>DATE</th>
        </thead>
        <tbody>
            @forelse ($records as $record)
            <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->url }}</td>
                <td>{{ $record->strategy->name }}</td>
                <td>{{ $record->accesibility_metric }}</td>
                <td>{{ $record->best_practices_metric }}</td>
                <td>{{ $record->performance_metric }}</td>
                <td>{{ $record->pwa_metric }}</td>
                <td>{{ $record->seo_metric }}</td>
                <td>{{ $record->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No records available</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <script>
        $(document).ready( function () {
            $('#resultsTable').DataTable({
                // Hide the id column
                columnDefs: [
                    {
                        target: 0,
                        visible: false,
                        searchable: false
                    }
                ]
            });
        } );
    </script>
</x-layout>