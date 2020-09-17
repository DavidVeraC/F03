var inputCalcularSub = document.getElementById('cantidad-prod');
var divSubtotal = document.getElementById('div-subtotal');
var nuevoSubtotal = document.createElement('div');



eventListeners();

function eventListeners() {
    inputCalcularSub.addEventListener("blur", calcularSubtotal);
}


// CALCULAR SUBTOTAL
function calcularSubtotal() {

    if (this.value === '' || (this.value <= 0)) {
        swal({
            title: 'Error',
            text: 'Error... ! Ha ingresado un valor no valido',
            type: 'error'
        });

        btnAgregarCarrito.disabled = true;
        nuevoSubtotal.innerText = '';

    } else {
        let cantidad = document.getElementById('cantidad-prod').value;
        let precio = document.getElementById('precio').value;
        let stock = document.getElementById('stock').textContent;
        let pegar = document.querySelector('.div-subtotal');

        stock = Number(stock);
        cantidad = Number(cantidad);


        if (stock > cantidad) {
            let resultado = cantidad * precio;
            resultado = Number(resultado);

            nuevoSubtotal.id = 'subtotal';
            nuevoSubtotal.classList.add('subtotal')
            nuevoSubtotal.setAttribute("name", "subtotal");;
            nuevoSubtotal.innerHTML = `s/${resultado}`;
            divSubtotal.firstChild.remove();
            pegar.appendChild(nuevoSubtotal);
            btnAgregarCarrito.disabled = false;

        } else {
            swal({
                title: 'Error',
                text: 'Error... ! Ha superado el stock del producto',
                type: 'error'
            });
            nuevoSubtotal.innerText = '';
            btnAgregarCarrito.disabled = true;

        }


    }

}