@extends('layouts.app')

@section('content')
<div class="container">

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">End-points</div>

                        <div class="card-body">

                            <a href="api/food_courts">food_courts</a>: Praças de alimentação <br />
                            <a href="api/establishments">establishments</a>: Estabelecimentos <br />
                            <a href="api/plates">plates</a>: Pratos <br />
                            <a href="api/menu_types">menu_types</a>: Tipos de cardápios <br />
                            <a href="api/plate_categories">plate_categories</a>: Categorias de pratos <br />
                            <a href="api/establishment_categories">establishment_categories</a>: Categorias de estabelecimentos <br />
                            <a href="api/images">images</a>: Imagens <br />
                            <a href="api/orders">orders</a>: Pedidos <br />

                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>
</div>

@endsection

@section('javascript')
@endsection