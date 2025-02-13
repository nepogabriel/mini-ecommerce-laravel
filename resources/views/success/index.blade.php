@include('components.menu_checkout')

<div class="container container-success text-center">
    <div class="card shadow p-4">
        <div class="card-body">
            <i class="fa fa-check-circle text-success fa-5x mb-3"></i>
            <h1 class="text-success">Pagamento Concluído!</h1>
            <p class="lead">Seu pagamento foi processado com sucesso.</p>

            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total:</span> <span>R$ {{ $checkoutData['order']->total }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Pagamento: </span> <span>{{ $checkoutData['order']->payment_method }}</span>
                </li>
            </ul>

            <a href="{{ route('product.index') }}" class="btn btn-success mt-3">Voltar para o início</a>
        </div>
    </div>
</div>

@include('components.footer')