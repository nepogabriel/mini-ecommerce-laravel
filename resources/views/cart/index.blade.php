<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    <title>E-commerce</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mini E-commerce</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.index') }}">Nossos Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                @if (!isset($cartItems['Empty']))
                    @foreach ($cartItems as $item)
                        <div class="card my-4">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex justify-content-center">
                                    <img src="/img/no-image.jpg" class="img-fluid rounded-start" alt="..." style="height: auto; width: 120px;">
                                </div>

                                <div class="col-md-8 d-flex align-items-center">
                                    <div class="card-body d-flex justify-content-between">
                                        <div class="">
                                            <h5 class="card-title">{{ $item['name'] }}</h5>
                                            <p class="card-text">R$ {{ $item['price'] }}</p>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-danger add-to-cart" data-id="{{ $item['id'] }}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="fw-bold my-4">{{ $cartItems['message'] }}</p>
                @endif
            </div>
        
            <div class="col-sm-12 col-md-4">
                <div class="card my-4">
                    <div class="card-header fw-bold">
                        Totais
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotal:</span> <span id="subtotal"></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Frete:</span> <span>R$ 0.00</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total:</span> <span id="total"></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between text-success fw-bold">
                            <span>No Pix (-10%):</span> <span id="discount"></span>
                        </li>

                        <li class="list-group-item">
                            <button class="btn btn-success">Finalizar Pedido</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-center">
            Desenvolvido por Gabriel Ribeiro.
            <div class="">
                <i class="fa fa-github-square" aria-hidden="true"></i>
                <i class="fa fa-linkedin-square" aria-hidden="true"></i>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('/js/script.js') }}"></script>

    <script>
        function loadCart() {
            fetch('/carrinho/total', {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('subtotal').textContent = `R$ ${data.subtotal.toFixed(2)}`;

                    document.getElementById('total').textContent = `R$ ${data.total.toFixed(2)}`;

                    document.getElementById('discount').textContent = `R$ ${data.discountedTotal.toFixed(2)}`;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Erro:', error));
        }

        loadCart();
    </script>
</body>
</html>