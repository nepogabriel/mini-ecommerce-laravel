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
            window.location.replace("/");
        }
    })
    .catch(error => console.error('Erro:', error));
}
