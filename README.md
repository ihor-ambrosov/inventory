# Multi-Warehouse for Magento 2
###### Magento Open Source: 2.3, 2.4

Multi-Warehouse is the extension that provides extra features for [Multi-Source Inventory (MSI)](https://docs.magento.com/m2/ce/user_guide/catalog/inventory-management.html) standard Magento function. It can be useful for those who have multi-location, multi-warehouse stores or for dropshipping purposes. The module allows differentiating regular prices, tax classes, shipping methods and shipping rates depending on a source/warehouse.
Each time when a customer buys a product the final price is the most important. At the same time the shipping costs is a crucial part of the final price. The final price can be optimized by reducing the shipping costs with multiple sources. With this module installed a customer estimates shipping costs for each source and chooses the most appropriate source for each product to be purchased. A customer can see an accurate shipping price that is calculated for each source before putting a product into the cart. Also, you can define source-specific regular prices and tax classes.

## Features
 - Split orders by sources
 - Regular prices per sources
 - Source-specific tax classes
 - Shipping origin address per source for shipping rate calculation
 - Manage shipping methods and rates for sources
 - Flatrate, Free Shippin, Table Rates, UPS, USPS, FedEx, DHL are supported shipping methods
 - Ease of 3rd party shipping methods extending
 - Assign a product source and select a shipping method for each source both on the storefront and the backend
 - Estimate product shipping costs, taxes, and other totals before putting it into the cart

## Configuration
### Shipping Origin
On the admin menu, tap **Stores → Settings → Configuration**. Select **Sales → Shipping Settings** in the configuration left menu. Expand **Origin** section.

![Configuration - Shipping Origin](https://i.postimg.cc/rsC0VhSx/admin-configuration-shipping-origin.png)

The module extends the standard configuration settings function by adding **Source** selector in addition to **Store View** selector. This way configuration settings can be defined not only for stores and websites but for sources as well.
Once a source is selected, you can enter the shipping origin for it. The system calculates the source shipping costs depending on the address entered.

### Shipping Methods
Besides shipping origin, shipping methods can be managed for each source separately. Select **Sales → Shipping Methods** in the configuration left menu.

![Configuration - Shipping Methods](https://i.postimg.cc/gksX1TcP/admin-configuration-shipping-methods.png)

Available shipping methods, rates, labels, other settings can be defined for sources here. All standard Magento shipping carriers are available. Any additional 3rd party shipping carriers can be added with a minimum of additional coding. We took care about the ease of configuration settings extensibility.

### Table Rates Shipping Method
**Table Rates** shipping method requires a separate presentation. Select a website with **Store View** selector and **Default Config** for **Source** selector (which is on the left side to the store view selector). Expand **Table Rates** shipping method section. **Import** and **Export** fields are available to upload and download a rates CSV file. Click **Export CSV** button and save the file. Open the file.

![Configuration - Shipping Tablerates Method](https://i.postimg.cc/g0nZVHWb/admin-configuration-shipping-method-tablerate.png)

It looks exactly the same as the standard table rates with the only one difference: **Source** column is available. This way shipping rates are definable for sources.
Click **Browse** button for **Import** field, select a CSV file to upload and press **Save Config** button to take new rates into effect.

## Create Order
Select **Sales → Orders**. Click **Create New Order** button, select a customer and a store. Now we are on the create order form. Let's walk by the changes that the module introduced.

![Create Order - Item](https://i.postimg.cc/ncp9RJJk/admin-order-create-item-configure.png)

While adding a product or configuring an item that was already added, you can see the additional **Source** option to assign a source to the cart item.

![Create Order - Items](https://i.postimg.cc/JhfGbwxj/admin-order-create-items.png)

Next, to change cart items sources easely, **Source** column is added to the items grid. The system reassigns sources on **Update Items and Quantities** button click.
Scroll down to **Payment & Shipping Information** section.

![Create Order - Shipping Methods](https://i.postimg.cc/25MB2Lkb/admin-order-create-shipping-methods.png)

Please note that **Shipping Method** block is changed to allow shipping methods picking per source.

![Create Order - Totals](https://i.postimg.cc/t4m14nVS/admin-order-create-totals.png)

The shipping summary includes shipping methods selected for sources and the total shipping amount.

## Create Shipment
Select **Sales → Orders**. Click an order record to create a shipment for it. On the order page click **Ship** action button.

![Create Shipment](https://i.postimg.cc/VLZsqQL5/admin-shipment-create.png)

With the module installed additional **Customer** source selection algorithm is available as a default one. The algorithm can be changed if shipment sources must be assigned in some other way. On **Source Selection Algorithm** dropdown button changing **Items Ordered** block becomes reloaded. **Qty To Deduct** column contains a prepopulated quantity according to the algorithm selected.

## Customer Area
The main module idea is that customers must be able to choose delivery sources and estimate shipping costs for selected sources. As a result, there are 2 things changed on storefront pages. The first common difference is a source information that is displayed as a required option for each cart item. The second difference is every shipping method selector is replaced with a selector that enables methods picking on per source basis.

### Product

![Product](https://i.postimg.cc/bvxjFK8x/product.png)

On each product page **Source** required option is placed above the quantity input. This way a customer chooses not only the desired quantity but a source as well.
**Estimate Totals** is the additional block that allows estimating product shipping costs and other product totals for each source. The block is similar to **Estimate Shipping and Tax** on the cart page and therefore shouldn't confuse visitors.

### Cart

![Cart](https://i.postimg.cc/1RJyShFM/cart.png)

On the cart page you can see the source option for each item.
The shipping method selector is replaced with the multi-source selector in **Estimate Shipping and Tax** block.

### Checkout

![Cart](https://i.postimg.cc/GmZcfFDC/checkout-shipping-methods.png)

The checkout process remains the same except the shipping method selector replaced. A shipping method must be selected for each source.

### Multishipping

![Cart](https://i.postimg.cc/52H4p76g/multishipping-shipping-methods.png)

Multishipping checkout type is also supported and enables shipping method selection on per source basis.


