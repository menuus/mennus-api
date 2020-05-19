@extends('layouts.app')

@section('content')
<div class="container">

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Pedidos</div>

                        <div class="card-body">
                            @asyncWidget('ordersTable')
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja cancelar este pedido?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelOrder" onclick="cancelSelectedOrder()" data-dismiss="modal">Cancelar pedido</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Manter pedido</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="callingModal" aria-labelledby="callingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Chamando</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                O pedido está sendo chamado...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok!</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    var orderSelected = 0;

    function callOrder(id) {
        $.ajax({
            url: '/order_call',
            type: 'post',
            data: {
                order_id: id
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name=csrf-token]').attr("content")
            },
            dataType: 'json',
            success: function(data, status) {
                console.log(data);
                var modal = $('#callingModal');
                clearTimeout(modal.data('hideInterval'));
                modal.data('hideInterval', setTimeout(function() {
                    modal.modal('hide');
                }, 3000));
                modal.modal();
            },
            error: function(data, status) {
                console.log(data);
                alert('Não foi possível chamar o pedido'); //TODO: arrumar
            }
        });
    }

    function cancelSelectedOrder() {
        $.ajax({
            url: '/order_delete',
            type: 'post',
            data: {
                order_id: orderSelected
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name=csrf-token]').attr("content")
            },
            dataType: 'json',
            success: function(data, status) {
                console.log(data);
            },
            error: function(data, status) {
                console.log(data);
                alert('Não foi possível cancelar o pedido'); //TODO: arrumar
            }
        });
        orderSelected = 0;
    }

    function closeOrder(id) {
        $.ajax({
            url: '/order_finish',
            type: 'post',
            data: {
                order_id: id
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name=csrf-token]').attr("content")
            },
            dataType: 'json',
            success: function(data, status) {
                console.log(data);
            },
            error: function(data, status) {
                console.log(data);
                alert('Não foi possível finalizar o pedido'); //TODO: arrumar
            }
        });
    }
</script>
@endsection