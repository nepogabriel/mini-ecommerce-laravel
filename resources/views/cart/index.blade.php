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
                @if (!isset($cartItems['empty']))
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
                                            <p class="card-text">
                                                <span class="fw-bold">Qntd.:</span> {{ $item['quantity'] }} | <span class="fw-bold">R$</span> {{ $item['price'] }}
                                            </p>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-danger remove-from-cart" data-id="{{ $item['id'] }}" data-bs-toggle="modal" data-bs-target="#removeFromCart">
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
                        Resumo da compra
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
                            <a href="{{ Route('checkout.index') }}" class="btn btn-success">Ir para o pagamento</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeFromCart" tabindex="-1" aria-labelledby="removeFromCartLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body d-flex justify-content-center">
                    Deseja remover o produto do carrinho?
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm-remove-from-cart">Remover</button>
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
        loadCart();

        let productId = null;

        function removeProductFromCart() {            
            document.querySelectorAll(".remove-from-cart").forEach(button => {
                button.addEventListener("click", function() {
                    productId = this.getAttribute("data-id");
                });
            });

            requestToRemoveProductFromCart();
        }

        function requestToRemoveProductFromCart() {
            document.getElementById("confirm-remove-from-cart").addEventListener("click", function() {
                if (productId) {
                    fetch('/carrinho/remover', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert(data.message);
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Erro:', error));
                }
            });
        }

        removeProductFromCart();
    </script>
</body>
</html>