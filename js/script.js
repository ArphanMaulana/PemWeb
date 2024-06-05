document.addEventListener('DOMContentLoaded', () => {
    const productForm = document.getElementById('productForm');
    const productList = document.getElementById('productList');

    let products = [];

    if (productForm) {
        productForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const productName = document.getElementById('productName').value;
            const productPrice = document.getElementById('productPrice').value;
            const productPhoto = document.getElementById('productPhoto').files[0];

            const reader = new FileReader();
            reader.onload = function (e) {
                const product = {
                    id: Date.now(),
                    name: productName,
                    price: productPrice,
                    photo: e.target.result
                };

                products.push(product);
                renderProducts();
                productForm.reset();
            };
            reader.readAsDataURL(productPhoto);
        });
    }

    function renderProducts() {
        productList.innerHTML = '';
        products.forEach(product => {
            const productItem = document.createElement('div');
            productItem.classList.add('product-item');
            productItem.setAttribute('data-id', product.id);
            productItem.innerHTML = `
                <img src="${product.photo}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p>$${product.price}</p>
                <button class="edit-button">Edit</button>
                <button class="delete-button">Delete</button>
            `;

            productList.appendChild(productItem);
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', deleteProduct);
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', editProduct);
        });
    }

    function deleteProduct(event) {
        const productId = event.target.parentElement.getAttribute('data-id');
        products = products.filter(product => product.id != productId);
        renderProducts();
    }

    function editProduct(event) {
        const productId = event.target.parentElement.getAttribute('data-id');
        const product = products.find(product => product.id == productId);

        document.getElementById('productName').value = product.name;
        document.getElementById('productPrice').value = product.price;

        deleteProduct(event);
        window.location.href = 'add_product.php';
    }
});
