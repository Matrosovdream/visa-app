<div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid">

            <div class="card-header">
                <div class="card-title">
                    <h2>Order History</h2>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">

                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">Date</th>
                                <th class="min-w-175px">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">

                            @foreach($order->history as $history)

                                <tr>
                                    <td>
                                        {{ $history->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ $history->comment }}
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>