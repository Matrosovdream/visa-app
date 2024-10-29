<!-- Sidebar Navigation -->
<nav class="nav flex-column bg-light p-3 rounded">
    <h5 class="mb-3">
        {{ $order->getProduct()->name }} {{ __('Application') }}
    </h5>

    <a class="nav-link text-success" href="#">
        {{ __('Trip Details') }}
    </a>
    <ul class="nav flex-column ms-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('web.account.order.trip', $order->id) }}">
                {{ __('General Information') }}
            </a>
        </li>
    </ul>

    @foreach($order->travellers as $traveller)

        <a class="nav-link text-success" href="#">{{ $traveller->full_name }}</a>

        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a 
                    class="nav-link" 
                    href="{{ 
                        route('web.account.order.applicant.documents', 
                        ['order_id' => $order->id, 'applicant_id' => $traveller->id]) 
                        }}"
                    >
                    {{ __('Documents') }}
                </a>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link" 
                    href="{{ 
                        route('web.account.order.applicant.passport', 
                        ['order_id' => $order->id, 'applicant_id' => $traveller->id]) 
                        }}"
                    >
                    {{ __('Passport') }}
                </a>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link" 
                    href="{{ 
                        route('web.account.order.applicant.family', 
                        ['order_id' => $order->id, 'applicant_id' => $traveller->id]) 
                        }}"
                    >
                    {{ __('Family') }}
                </a>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link" 
                    href="{{ 
                        route('web.account.order.applicant.past-travel', 
                        ['order_id' => $order->id, 'applicant_id' => $traveller->id]) 
                        }}"
                    >
                    {{ __('Past Travel') }}
                </a>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link" 
                    href="{{ 
                        route('web.account.order.applicant.declarations', 
                        ['order_id' => $order->id, 'applicant_id' => $traveller->id]) 
                        }}"
                    >
                    {{ __('Declarations') }}
                </a>
            </li>

        </ul>

    @endforeach
    
</nav>