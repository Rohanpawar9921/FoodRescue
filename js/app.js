$(document).ready(function() {
    function loadProducts(category = "") {
        $("#loader").show();

        $.get("php/fetch_products.php", {category : category}, function (data) {
            $("#products").html(data);
            $("#loader").hide();
        });
    }

    loadProducts();

    $("#category").change(function() {
        loadProducts($(this).val());
    });

    $(document).on("click", ".edit-product", function() {
        const productId = $(this).data("id");
        window.location.href = "edit.php?id=" + productId;
    });

    $(document).on("click", ".delete-product", function() {
        const productId = $(this).data("id");
        // Implement delete functionality here
        const category = $("#category").val();
        if(!confirm("Are you sure you want to delete this product?")) {
            return;
        }
        $.post("php/delete_product.php", {product_id: productId}, function(response) {
            alert(response);
            loadProducts(category);
        });
    });
});