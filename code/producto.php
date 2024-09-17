    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalles del Producto</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <div id="product-details" class="row justify-content-center">
                <!-- Aquí se cargarán los detalles del producto -->
            </div>
            <?php
                session_start();
                if (isset($_SESSION["username"])) {
                    echo '<button class="btn btn-primary add-to-cart-btn" onclick="addToCart(\'' . $_GET["id"] . '\')">Add to Cart</button>';
                }
            ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var xhttp = new XMLHttpRequest();
                var productId = obtenerParametroDeUrl('id');

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);

                        var product = data.find(function(elemento) {
                            return elemento.ID === productId;
                        });

                        if (product) {
                            // Generar el HTML con los detalles del producto
                            var productDetailsHTML = `
                                <h1 class="text-center mb-4">${product.Nombre}</h1>
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="assets/images/${product.Imagen}" class="img-fluid rounded-start" alt="Imagen del Producto">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <p class="card-text"><strong>Autor:</strong> ${product.Autor}</p>
                                                <p class="card-text"><strong>Precio:</strong> ${product.Precio}€</p>
                                                <p class="card-text"><strong>Año de Creación:</strong> ${product.AnoDeCreacion}</p>
                                                <p class="card-text"><strong>Estilo:</strong> ${product.Estilo}</p>
                                                <p class="card-text"><strong>Descripción:</strong> ${product.Descripcion}</p>
                                                <!-- Otros detalles que desees mostrar -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            // Insertar los detalles del producto en el contenedor
                            document.getElementById('product-details').innerHTML = productDetailsHTML;
                        } else {
                            // Si no se encuentra el producto, muestra un mensaje de error o redirige a otra página
                            document.getElementById('product-details').innerHTML = '<p class="text-center">Producto no encontrado</p>';
                        }
                    }
                };

                xhttp.open("GET", "datos.php", true);
                xhttp.send();

                function obtenerParametroDeUrl(nombre) {
                    var urlParams = new URLSearchParams(window.location.search);
                    return urlParams.get(nombre);
                }
            });
        </script>

        <!-- Pie de página -->
        <footer class="bg-dark text-light py-3 mt-5">
            <div class="container text-center">
                &copy; 2023 Colores y Sueños. Todos los derechos reservados.
            </div>
        </footer>

        <!-- Agregar el enlace al archivo JavaScript de Bootstrap (opcional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <script>
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
        </script>
    </body>
    </html>
