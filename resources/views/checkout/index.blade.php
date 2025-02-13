@include('components.menu_checkout')

<div class="container container-checkout">
    <h2 class="page-title">Pagamento</h2>
    
    <div class="row">
        <div class="col-sm-12 col-md-8 my-4">
        <form action="{{ route('checkout.process') }}" id="form_payment" method="post">
            @csrf
            
            <div>
                <h4>Forma de Pagamento</h4>
                <select id="payment_method" name="payment_method" class="form-select">
                    <option value="pix">Pix</option>
                    <option value="credit_card">Cartão de Crédito</option>
                </select>
            </div>

            <div id="credit_card_container" class="my-3" style="display: none;">
                <h6 class="my-4">Preencha seus dados</h6>

                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <img src="/img/credit-card.png" class="img-fluid rounded-start" alt="..." style="height: auto; width: 80%;">
                        </div>

                        <div class="col-md-6 d-flex align-items-center">
                            <div class="card-body">
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
                                                <select id="month_card" class="form-select">
                                                    @for ($month = 1; $month <= 12; $month++)
                                                        <option value="{{ $month }}">{{ $month }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label for="year_card" class="form-label">Ano*</label>
                                                <select id="year_card" name="year_card" class="form-select">
                                                    @for ($year = 25; $year <= 30; $year++)
                                                        <option value="{{ $year }}">20{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label for="cvv_card" class="form-label">CVV*</label>
                                                <input type="text" name="cvv_card" class="form-control" id="cvv_card">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

@include('components.footer')

<script>
document.addEventListener("DOMContentLoaded", function () {
    loadCart();

    const paymentMethodSelect = document.getElementById("payment_method");
    const checkoutButton = document.getElementById("checkout_button");
    const responseDiv = document.getElementById("response");

    paymentMethodSelect.addEventListener("change", function () {
        let viewCreditCard = "none";

        if (this.value === "credit_card") {
            viewCreditCard = "block";
            validateRealTime();
        }

        document.getElementById("credit_card_container").style.display = viewCreditCard; 
        document.getElementById("discount_pix").style.display = this.value === "pix" ? "block" : "none";
    });

    checkoutButton.addEventListener("click", function () {
        let paymentMethod = paymentMethodSelect.value;

        if (paymentMethod === "credit_card" && !validadeCreditCard()) {
            return;
        }
   
        let installments = paymentMethod === "credit_card" ? parseInt(document.getElementById("installments").value) : 1;

        document.getElementById('form_payment').submit();

        /*fetch("/pagamento/processar", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ payment_method: paymentMethod, installments })
        })
        .then(response => response.json())
        .then(data => {
            window.location.replace("/confirmado");
        })
        .catch(error => console.error("Erro no checkout:", error));*/
    });

    function validadeCreditCard() {
        let numberCard = document.getElementById("number_card").value.replace(/\D/g, "");
        let nameCard = document.getElementById("name_card").value.trim();
        let documentCard = document.getElementById("document_card").value.replace(/\D/g, "");
        let cvv = document.getElementById("cvv_card").value.replace(/\D/g, "");

        if (numberCard.length !== 16) {
            alert("O número do cartão deve ter 16 dígitos.");
            return false;
        }

        if (nameCard.split(" ").length < 2) {
            alert("O nome deve conter pelo menos nome e sobrenome.");
            return false;
        }

        if (documentCard.length !== 11 && documentCard.length !== 14) {
            alert("O campo CPF/CNPJ deve ter 11 ou 14 dígitos.");
            return false;
        }

        if (cvv.length !== 3) {
            alert("O CVV deve ter 3 dígitos.");
            return false;
        }

        return true;
    }

    function validateRealTime() {
        document.getElementById("number_card").addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "").slice(0, 16);
        });

        document.getElementById("name_card").addEventListener("focusout", function () {
            let words = this.value.trim().split(/\s+/);
            if (words.length < 2) {
                alert("Digite pelo menos nome e sobrenome.");
            }
        });

        document.getElementById("document_card").addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "").slice(0, 14);
        });

        document.getElementById("cvv_card").addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "").slice(0, 3);
        });
    }
});
</script>