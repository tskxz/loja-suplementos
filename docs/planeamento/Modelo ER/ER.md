## Entidades
```
Category(name)
Product(name, price, stock)
Customer(name)
Cart(cart_date, quantity)
Purchase(purchase_date, status)
Reservation(reservation_date, status)
```

## Relações

### Categoria
```
CategoryhasManyProduct(Category, Product)
ProductsBelongsToCategory(Product, Category)
```

### Carrinho
```
CarthasManyProducts(Cart, Product)
ProductBelongsToManyCart(Product, Cart)
CartsBelongstoCustomer(Customer, Cart)
CustomerhasManyCart(Customer, Cart)
```

### Compra

```
PurchaseBelongsToCustomer(Purchase, Customer)
PurchaseBelongsToCart(Purchase, Cart)
CustomerHasManyPurchases(Customer, Purchase)
```
### Reserva

```
ReservationBelongsToCustomer(Customer, Cart)
ReservationBelongsToCart(Reservation, Cart)
CustomerHasManyReservations(Customer, Reservation)
```