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
    <!-- Escolha do método de pagamento -->
    <div>
        <h4>Forma de Pagamento</h4>
        <select id="payment_method">
            <option value="pix">Pix</option>
            <option value="credit_card">Cartão de Crédito</option>
        </select>
    </div>

    <!-- Escolha do número de parcelas (aparece apenas para cartão) -->
    <div id="installments_container" style="display: none;">
        <h4>Parcelamento</h4>
        <select id="installments">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}x</option>
            @endfor
        </select>
    </div>

    <!-- Botão de checkout -->
    <button id="checkoutBtn">Finalizar Compra</button>

    <!-- Área de resposta -->
    <div id="response"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('/js/script.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const paymentMethodSelect = document.getElementById("payment_method");
    const installmentsContainer = document.getElementById("installments_container");
    const checkoutBtn = document.getElementById("checkoutBtn");
    const responseDiv = document.getElementById("response");

    paymentMethodSelect.addEventListener("change", function () {
        installmentsContainer.style.display = this.value === "credit_card" ? "block" : "none";
    });

    checkoutBtn.addEventListener("click", function () {
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