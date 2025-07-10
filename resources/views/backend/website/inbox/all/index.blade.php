@extends('backend.layout.auth')
@section('backend')
<div class="container">
    <h4 class="mb-4">All Assigned Dispatches</h4>

    @if($models->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Dispatch Title</th>
                        <th>Sender</th>
                        <th>Status</th>
                        <th>Attachments</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($models as $index => $model)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $model->dispatch->title ?? 'N/A' }}</td>
                            <td>{{ $model->dispatch->sender_name ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $statuses = [
                                        0 => 'Pending',
                                        1 => 'Approved',
                                        2 => 'Rejected',
                                        3 => 'Returned',
                                        4 => 'Recommended',
                                    ];
                                @endphp
                                <span class="badge bg-info">
                                    {{ $statuses[$model->dispatch->status] ?? 'Unknown' }}
                                </span>
                            </td>
                            <td>
                                @if($model->dispatch->dispatchDocuments && $model->dispatch->dispatchDocuments->count())
                                    <ul>
                                        @foreach($model->dispatch->dispatchDocuments as $doc)
                                            <li>
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                                    {{ $doc->file_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    No Documents
                                @endif
                            </td>
                            <td>{{ $model->created_at->format('d M Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">No dispatches assigned to you.</div>
    @endif
</div>
@endsection
