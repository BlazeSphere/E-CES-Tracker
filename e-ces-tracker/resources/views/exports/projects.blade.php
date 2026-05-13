<table>
    <thead>
        <tr>
            <th style="font-weight: bold; background-color: #1b8c00; color: #ffffff;">Project Name</th>
            <th style="font-weight: bold; background-color: #1b8c00; color: #ffffff;">Description</th>
            <th style="font-weight: bold; background-color: #1b8c00; color: #ffffff;">Status</th>
            <th style="font-weight: bold; background-color: #1b8c00; color: #ffffff;">Budget</th>
            <th style="font-weight: bold; background-color: #1b8c00; color: #ffffff;">Community Partner</th>
            <th style="font-weight: bold; background-color: #1b8c00; color: #ffffff;">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->description }}</td>
                <td>{{ ucfirst($project->status) }}</td>
                <td>{{ number_format($project->budget, 2) }}</td>
                <td>{{ $project->events->first()?->community?->community_name ?? 'N/A' }}</td>
                <td>{{ $project->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
