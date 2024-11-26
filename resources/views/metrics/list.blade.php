<x-layout>
    <!-- list metrics -->
    <h1> Metric history</h1>
    <table class="table">
        <thead>
            <th>ID</th>
            <th>URL</th>
            <th>ACCESSIBILITY</th>
            <th>BEST_PRACTICES</th>
            <th>PERFORMANCE</th>
            <th>PWA</th>
            <th>SEO</th>
            <th>DATE</th>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <td>{{ $record->id }}</td>
                <td>{{ $record->url }}</td>
                <td>{{ $record->accesibility_metric }}</td>
                <td>{{ $record->best_practices_metric }}</td>
                <td>{{ $record->performance_metric }}</td>
                <td>{{ $record->pwa_metric }}</td>
                <td>{{ $record->seo_metric }}</td>
                <td>{{ $record->created_at }}</td>
            @empty
                <td colspan="8" class="text-center">No records available</td>
            @endforelse
    </table>
</x-layout>