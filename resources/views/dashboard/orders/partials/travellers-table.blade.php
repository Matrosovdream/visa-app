<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
    <thead>
        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
            <th class="min-w-100px">Name</th>
            <th class="min-w-175px">Last name</th>
            <th class="min-w-175px">Date of birth</th>
            <th class="min-w-175px">Passport</th>
            <th class="min-w-175px">Actions</th>
        </tr>
    </thead>
    <tbody class="fw-semibold text-gray-600">

        @foreach($order->travellers as $traveller)

            <tr>
                <td>
                    {{ $traveller['name'] }}
                </td>
                <td>
                    {{ $traveller['lastname'] }}
                </td>
                <td>
                    {{ $traveller['birthday'] }}
                </td>
                <td>
                    {{ $traveller['passport'] }}
                </td>
                <td>


                    <a href="{{ route('dashboard.orders.traveller.show', ['order_id' => $order->id, 'traveller_id' => $traveller['id']]) }}"
                        class="btn btn-sm btn-light btn-active-light-primary">Show</a>
                    <a href="{{ route('dashboard.orders.traveller.edit', ['order_id' => $order->id, 'traveller_id' => $traveller['id']]) }}"
                        class="btn btn-sm btn-light btn-active-light-primary">Edit</a>

                    <form method="POST" class="d-inline"
                        action="{{ route('dashboard.orders.traveller.destroy', ['order' => $order->id, 'traveller' => $traveller['id']]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light btn-active-light-primary">Delete</button>
                    </form>
                    
                </td>
            </tr>

        @endforeach

    </tbody>
</table>