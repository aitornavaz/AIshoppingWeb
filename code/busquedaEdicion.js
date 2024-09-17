document.addEventListener("DOMContentLoaded", function () {
    // Función para cargar la lista de productos
    function loadProductList() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('productList').innerHTML = xhr.responseText;
            }
        };
        xhr.open('GET', 'get_products.php', true);
        xhr.send();
    }

    // Cargar la lista de productos al cargar la página
    loadProductList();

    // Función para realizar la búsqueda de productos
    document.getElementById('search').addEventListener('input', function () {
        var query = this.value;
        if (query !== '') {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('productList').innerHTML = xhr.responseText;
                }
            };
            xhr.open('POST', 'search.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('query=' + query);
        } else {
            // Si la búsqueda está vacía, cargar la lista completa de productos
            loadProductList();
        }
    });

    document.getElementById('productList').addEventListener('click', function (event) {
        if (event.target.classList.contains('edit-btn')) {
            var product_id = event.target.getAttribute('data-id');
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Mostrar el formulario dentro del modal
                    $('#editModalBody').html(xhr.responseText);
                    $('#editModal').modal('show'); // Mostrar el modal
                }
            };
            xhr.open('POST', 'edit_form.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + product_id);
        }
    });


    // Función para actualizar una obra de arte
    window.updateArtwork = function (artwork_id) {
        var artworkName = document.getElementById('artworkName').value;
        var artworkPrice = document.getElementById('artworkPrice').value;
        // Agrega campos adicionales según la descripción de las columnas
        var artworkImage = document.getElementById('artworkImage').value; // Maneja la imagen según tu implementación
        var artworkDescription = document.getElementById('artworkDescription').value;
        var artworkYear = document.getElementById('artworkYear').value;
        var artworkStyle = document.getElementById('artworkStyle').value;
        var artworkAuthor = document.getElementById('artworkAuthor').value;
        var artworkType = document.getElementById('artworkType').value;

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Puedes manejar la respuesta aquí (por ejemplo, mostrar un mensaje de éxito)
                console.log(xhr.responseText);
                // Cierra el modal después de guardar los cambios
                $('#editModal').modal('hide');
            }
        };
        xhr.open('POST', 'update_artwork.php', true);
        var formData = new FormData();
        formData.append('id', artwork_id);
        formData.append('name', artworkName);
        formData.append('price', artworkPrice);
        // Agrega la imagen solo si se ha seleccionado una nueva
        if (artworkImage) {
            formData.append('image', artworkImageInput.files[0]);
        }
        formData.append('description', artworkDescription);
        formData.append('year', artworkYear);
        formData.append('style', artworkStyle);
        formData.append('author', artworkAuthor);
        formData.append('type', artworkType);
        xhr.send(formData);
    };
    window.deleteArtwork = function (artwork_id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta obra de arte?')) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Puedes manejar la respuesta aquí (por ejemplo, mostrar un mensaje de éxito)
                        console.log(xhr.responseText);
                        // Cierra el modal después de eliminar la obra de arte
                        $('#editModal').modal('hide');
                    } else {
                        // Manejar errores si es necesario
                        console.error('Error al eliminar la obra de arte: ' + xhr.statusText);
                    }
                }
            };
            xhr.open('POST', 'delete_artwork.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + artwork_id);
        }
    };
});
