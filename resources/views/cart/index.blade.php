@include('components.menu')

<div class="container my-5 container-cart">
    <h2 class="page-title">Carrinho</h2>
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

@include('components.footer')

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