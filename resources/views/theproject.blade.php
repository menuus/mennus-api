@extends('layouts.app')

@section('content')
<div class="container">

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            <div class="logo" style="text-align:center; font-size:50px">
                                Menuus
                            </div>
                        </div>

                        <div class="card-body">

                            <div style="text-align: center;">

                                <img src="assets/theproject/fluxo-restaurantes.gif" alt="fluxo-restaurantes.gif" width=300 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <img src="assets/theproject/fluxo-pratos.gif" alt="fluxo-pratos.gif" width=300 />
                                <br /><br />
                                <img src="assets/theproject/lista-restaurantes.png" alt="lista-restaurantes.png" width=200 />&nbsp;&nbsp;&nbsp;
                                <img src="assets/theproject/lista-pratos.png" alt="lista-pratos.png" width=200 />&nbsp;&nbsp;&nbsp;
                                <img src="assets/theproject/pedidos-realizados.png" alt="pedidos-realizados.png" width=200 />
                                <br /><br />
                                <img src="assets/theproject/detalhe-restaurante.png" alt="detalhe-restaurante.png" width=200 />&nbsp;&nbsp;&nbsp;
                                <img src="assets/theproject/detalhe-prato.png" alt="detalhe-prato.png" width=200 />&nbsp;&nbsp;&nbsp;
                                <img src="assets/theproject/detalhe-carrinho.png" alt="detalhe-carrinho.png" width=200 />
                            </div>

                            <hr />

                            <div style="text-align: center;">
                                <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=https://storage.googleapis.com/mennus-images/Menuus.docx' width='831px' height='700px'>
                                </iframe>
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