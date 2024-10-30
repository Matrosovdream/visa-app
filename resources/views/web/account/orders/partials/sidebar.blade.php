<!-- Sidebar Navigation -->
<nav class="nav flex-column bg-light p-3 rounded application-sidebar">

    <a class="nav-link nav-link-header text-success" href="#">
        <img src="{{ asset('/user/assets/img/icon/book.svg') }}" alt="" class="header-icon">
        {{ __('Trip Details') }}
    </a>
    <ul class="nav flex-column ms-3">
        <li class="nav-item">
            <a class="nav-link nav-link-item active" href="{{ route('web.account.order.trip', $order->id) }}">
                {{ __('General Information') }}
            </a>
        </li>
    </ul>

    <hr>

    @foreach($order->travellers as $key=>$traveller)

        <a class="nav-link nav-link-header text-success" href="#">
            <img src="{{ asset('/user/assets/img/icon/c_user.svg') }}" alt="" class="header-icon">
            {{ $traveller->full_name }}
        </a>

        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a 
                    class="nav-link nav-link-item" 
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
                    class="nav-link nav-link-item" 
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
                    class="nav-link nav-link-item" 
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
                    class="nav-link nav-link-item" 
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
                    class="nav-link nav-link-item" 
                    href="{{ 
                        route('web.account.order.applicant.declarations', 
                        ['order_id' => $order->id, 'applicant_id' => $traveller->id]) 
                        }}"
                    >
                    {{ __('Declarations') }}
                </a>
            </li>

        </ul>

        @if ($key < count($order->travellers) - 1)
            <hr>
        @endif

    @endforeach
    
</nav>