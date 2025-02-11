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
        </div>
    </nav>

    <div class="container">
        <h2>Checkout</h2>
        
        <div class="row">
            <div class="col-sm-12 col-md-8 my-4">
                <div>
                    <h4>Forma de Pagamento</h4>
                    <select id="payment_method" class="form-select">
                        <option value="pix">Pix</option>
                        <option value="credit_card">Cartão de Crédito</option>
                    </select>
                </div>

                <div id="credit_card_container" class="my-3" style="display: none;">
                    <h6 class="my-4">Preencha seus dados</h6>

                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <img src="/img/no-image.jpg" class="img-fluid rounded-start" alt="..." style="height: 120px; width: auto;">
                            </div>

                            <div class="col-md-6 d-flex align-items-center">
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label for="number_card" class="form-label">Número do cartão*</label>
                                            <input type="text" name="number_card" class="form-control" id="number_card">
                                        </div>

                                        <div class="mb-3">
                                            <label for="name_card" class="form-label">Nome impresso no cartão*</label>
                                            <input type="text" name="name_card" class="form-control" id="name_card">
                                        </div>

                                        <div class="mb-3">
                                            <label for="document_card" class="form-label">CPF ou CNPJ do titular*</label>
                                            <input type="text" name="document_card" class="form-control" id="document_card">
                                        </div>

                                        <div>
                                            <div class="row">
                                                <div class="col-sm-4 mb-3">
                                                    <label for="month_card" class="form-label">Mês*</label>
                                                    <!-- <input type="text" name="month_card" class="form-control" id="month_card"> -->
                                                    <select id="month_card" class="form-select">
                                                        @for ($month = 1; $month <= 12; $month++)
                                                            <option value="{{ $month }}">{{ $month }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-sm-4 mb-3">
                                                    <label for="year_card" class="form-label">Ano*</label>
                                                    <!-- <input type="text" name="year_card" class="form-control" id="year_card"> -->
                                                    <select id="year_card" name="year_card" class="form-select">
                                                        @for ($year = 25; $year <= 30; $year++)
                                                            <option value="{{ $year }}">20{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-sm-4 mb-3">
                                                    <label for="number_card" class="form-label">CVV*</label>
                                                    <input type="text" name="number_card" class="form-control" id="number_card">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="container-installments">
                                            <label for="installments">Parcelamento</label>
                                            <select id="installments" name="installments" class="form-select">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}x</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="response"></div>
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

                        <li class="list-group-item justify-content-between text-success fw-bold" id="discount_pix" style="display: flex">
                            <span>No Pix (-10%):</span> <span id="discount"></span>
                        </li>

                        <li class="list-group-item">
                            <button id="checkout_button" class="btn btn-success">Concluir Compra</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('/js/script.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    loadCart();

    const paymentMethodSelect = document.getElementById("payment_method");
    const checkoutButton = document.getElementById("checkout_button");
    const responseDiv = document.getElementById("response");

    paymentMethodSelect.addEventListener("change", function () {
        document.getElementById("credit_card_container").style.display = this.value === "credit_card" ? "block" : "none";
        document.getElementById("discount_pix").style.display = this.value === "pix" ? "block" : "none";
    });

    checkoutButton.addEventListener("click", function () {
        let paymentMethod = paymentMethodSelect.value;
        let installments = paymentMethod === "credit_card" ? parseInt(document.getElementById("installments").value) : 1;

        fetch("{{ route('checkout.process') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ payment_method: paymentMethod, installments })
        })
        .then(response => response.json())
        .then(data => {
            responseDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
        })
        .catch(error => console.error("Erro no checkout:", error));
    });
});
</script>


</body>
</html>