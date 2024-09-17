document.addEventListener("DOMContentLoaded", function() {
    var xhttp = new XMLHttpRequest();
    var elementosPorPagina = 3; // Número de elementos por página
    var paginaActual = 1; // Página inicial
    var data = []; // Array que contendrá todos los elementos

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            data = JSON.parse(this.responseText);

            // Renderizar la página actual
            renderizarPagina(paginaActual);
        }
    };

    xhttp.open("GET", "datos.php", true);
    xhttp.send();

    function renderizarPagina(numeroPagina) {
        var filtroPrecioMin = document.getElementById('filtroPrecioMin').value;
        var filtroPrecioMax = document.getElementById('filtroPrecioMax').value;
        var filtroEstilo = document.getElementById('filtroEstilo').value;
        var elementosFiltrados = filtrarElementos(filtroPrecioMin, filtroPrecioMax, filtroEstilo);

        var totalPages = Math.ceil(elementosFiltrados.length / elementosPorPagina); // Calcular las páginas

        // Actualizar lógica de paginación
        var inicio = (numeroPagina - 1) * elementosPorPagina;
        var fin = inicio + elementosPorPagina;
        var elementosPagina = elementosFiltrados.slice(inicio, fin);

        var elementosHtml = '';
        elementosPagina.forEach(function(elemento) {
            elementosHtml += '<div class="col-lg-4 col-md-6 mb-4">'; // Tamaño de las columnas ajustado para dispositivos grandes y medianos
            elementosHtml += '<div class="card" style="background-color: beige;">';
            elementosHtml += '<img src="assets/images/' + elemento.Imagen + '" alt="Imagen del Elemento" class="card-img-top img-thumbnail">';
            elementosHtml += '<div class="card-body">';
            elementosHtml += '<h5 class="card-title">' + elemento.Nombre + '</h5>';
            elementosHtml += '<p class="card-text author"><span>Autor:</span> ' + elemento.Autor + '</p>';
            elementosHtml += '<p class="card-text"><span class="price bg-warning text-dark rounded px-2">Precio: ' + elemento.Precio + '€</span></p>';
            elementosHtml += '<a href="producto.php?id=' + elemento.ID + '" class="btn btn-secondary info-btn">+ Info</a>';
            elementosHtml += '</div></div></div>';
        });

        document.getElementById("elementos").innerHTML = '<div class="row">' + elementosHtml + '</div>';
        updatePagination(totalPages, numeroPagina);
    }    

    function filtrarElementos(filtroPrecioMin, filtroPrecioMax, filtroEstilo) {
        return data.filter(function(elemento) {
            var precio = parseFloat(elemento.Precio);
            var pasaFiltroPrecio = true;

            if (filtroPrecioMin !== '' && filtroPrecioMax !== '') {
                pasaFiltroPrecio = precio >= parseFloat(filtroPrecioMin) && precio <= parseFloat(filtroPrecioMax);
            }

            var pasaFiltroEstilo = true;
            if (filtroEstilo !== '') {
                pasaFiltroEstilo = elemento.Estilo.toLowerCase() === filtroEstilo.toLowerCase();
            }

            return pasaFiltroPrecio && pasaFiltroEstilo;
        });
    }

    function updatePagination(totalPages, currentPage) {
        var paginationHtml = '<ul class="pagination justify-content-center">';
    
        // Botón de página anterior
        if (currentPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link" href="#" id="prevPage">Página Anterior</a></li>';
        } else {
            paginationHtml += '<li class="page-item disabled"><span class="page-link">Página Anterior</span></li>';
        }
    
        // Botones para páginas individuales
        for (var i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                paginationHtml += '<li class="page-item active"><span class="page-link">' + i + '</span></li>';
            } else {
                paginationHtml += '<li class="page-item"><a class="page-link" href="#" id="page-' + i + '">' + i + '</a></li>';
            }
        }
    
        // Botón de página siguiente
        if (currentPage < totalPages) {
            paginationHtml += '<li class="page-item"><a class="page-link" href="#" id="nextPage">Página Siguiente</a></li>';
        } else {
            paginationHtml += '<li class="page-item disabled"><span class="page-link">Página Siguiente</span></li>';
        }
    
        paginationHtml += '</ul>';
    
        document.getElementById('pagination').innerHTML = paginationHtml;
    
        // Event listeners para los botones de paginación
        var prevPageBtn = document.getElementById('prevPage');
        if (prevPageBtn) {
            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    renderizarPagina(currentPage - 1);
                }
            });
        }
    
        var nextPageBtn = document.getElementById('nextPage');
        if (nextPageBtn) {
            nextPageBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    renderizarPagina(currentPage + 1);
                }
            });
        }
    
        for (var j = 1; j <= totalPages; j++) {
            var pageBtn = document.getElementById('page-' + j);
            if (pageBtn) {
                pageBtn.addEventListener('click', function(event) {
                    var pageNumber = parseInt(event.target.innerHTML);
                    renderizarPagina(pageNumber);
                });
            }
        }
    }
});


function addToCart(elementID) {
    // Make an AJAX call to your PHP script for adding to the cart
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
                if (response.success) {
                    // Item added to cart successfully
                    alert('Item added to cart successfully!');
                } else {
                    // Display an appropriate error message
                    alert(response.message);
                }
        }
    };
    
    xhttp.open("GET", "addToCart.php?elementID=" + elementID, true);
    xhttp.send();
}
