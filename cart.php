
<h2>Your Cart</h2>
  <form method="post" action="cart.php">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($cart_items)): ?>
        <tr>
          <td colspan="5">Your cart is empty.</td>
        </tr>
        <?php else: ?>
        <?php foreach ($cart_items as $item): ?>
        <tr>
          <td><?php echo htmlspecialchars($item['product_id']); ?></td>
          <td><?php echo htmlspecialchars($item['product_name']); ?></td>
          <td>
            <input type="hidden" name="product_id[]" value="<?php echo htmlspecialchars($item['product_id']); ?>">
            <input type="number" name="product_quantity[]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
          </td>
          <td><?php echo htmlspecialchars($item['product_price']); ?></td>
          <td>
            <button type="submit" name="remove_from_cart" value="Remove" class="btn btn-danger">Remove</button>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
    <?php if (!empty($cart_items)): ?>
    <div class="cart-total">
      <h4>Total Price: <?php echo $total_price; ?></h4>
      <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
      <a href="checkout.php" class="btn btn-success">Checkout</a>
    </div>
    <?php endif; ?>
  </form>
  