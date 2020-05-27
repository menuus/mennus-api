<table class="table table-responsive-sm table-hover table-outline mb-0">
    <thead class="thead-light">
        <tr>
            <th class="text-center">
                <svg class="c-icon">
                    <use xlink:href="assets/icons/free-symbol-defs.svg#cui-people"></use>
                </svg>
            </th>
            <th>Cliente</th>
            <th class="text-center" width="25%">Tempo</th>
            <th>Pedidos</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr id="order{{$order->id}}">
            <td class="text-center">
                <div class="c-avatar">
                    @if($order->user->profile && $order->user->profile->image)
                    <img class="c-avatar-img" src="{{ $order->user->profile->image->path }}" alt={{ $order->user->email }}>
                    @else
                    <svg class="c-avatar-img" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 008 15a6.987 6.987 0 005.468-2.63z" />
                        <path fill-rule="evenodd" d="M8 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M8 1a7 7 0 100 14A7 7 0 008 1zM0 8a8 8 0 1116 0A8 8 0 010 8z" clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
            </td>

            <td>
                <div>{{ $order->user->name }}</div>
                <div class=" small text-muted">{{ $order->user->email }}</div>
            </td>

            <td>
                <input type="hidden" id="timestamp" value="{{$order->created_at->timestamp}}" />
                <div class="clearfix">
                    <div class="float-left"><strong><span id='percentage'>{{$percentage[$order->id]}}%</span></strong></div>
                    <div class="float-right"><small class="text-muted">Pedido feito à <strong><span id='timeElapsed'>{{$timeElapsed[$order->id]}}</span></strong></small></div>
                </div>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-secondary" id="progressbar"></div>
                </div>
            </td>

            <td>
                @foreach($order->plates as $plate)
                <strong>{{$plate->pivot->plates_amount}}x: </strong>{{ $plate->name }}<br />
                @endforeach
            </td>

            <td class="text-center">
                <button class="btn btn-primary" type="button" onclick="callOrder({{ $order->id }})">
                    <svg class="c-icon" title="Chamar">
                        <use xlink:href="assets/icons/free-symbol-defs.svg#cui-phone"></use>
                    </svg>
                </button>

                <button class="btn btn-warning" type="button" onclick="orderSelected={{ $order->id }};" data-toggle="modal" data-target="#confirmationModal">
                    <svg class="c-icon" title="Cancelar pedido">
                        <use xlink:href="assets/icons/free-symbol-defs.svg#cui-trash"></use>
                    </svg>
                </button>

                <button class="btn btn-success" type="button" onclick="closeOrder({{ $order->id }})">
                    <svg class="c-icon" title="Finalizar pedido">
                        <use xlink:href="assets/icons/free-symbol-defs.svg#cui-check"></use>
                    </svg>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td class="text-center" colspan="4">Sem pedidos</td>
        </tr>
        @endforelse
    </tbody>
</table>