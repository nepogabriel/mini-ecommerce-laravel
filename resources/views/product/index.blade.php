@include('components.menu');

<div class="container my-5">
    @if ($products != null)
        @foreach ($products as $product)
            <div class="card my-4">
                <div class="row g-0">
                    <div class="col-md-4 d-flex justify-content-center">
                        <img src="/img/no-image.jpg" class="img-fluid rounded-start" alt="..." style="height: auto; width: 250px;">
                    </div>

                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <p class="card-text">R$ {{ $product->price }}</p>
                            <button class="btn btn-success add-to-cart" data-id="{{ $product->id }}">Adicionar no carrinho</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="fw-bold my-4">Não existe produtos cadastrados!</p>
    @endif
</div>

@include('components.footer')

<script>
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            let productId = this.getAttribute('data-id');
            let quantity = 1;

            fetch('/carrinho/adicionar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => console.error('Erro:', error));
        });
    });
</script>