@foreach($traveller->documents as $document)

    <h4>Documents</h4>

    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Filename</th>
                <th>Description</th>
                <th>Download Link</th>
            </tr>
        </thead>

        <tbody class="fw-semibold text-gray-600">
            @foreach($traveller->documents as $document)
            <tr>
                <td>{{ $document['filename'] }}</td>
                <td>{{ $document['description'] }}</td>
                <td><a href="{{ Storage::url($document['path']) }}">Download</a></td>
            </tr>
            @endforeach
        </tbody>
    
    </table>


@endforeach



