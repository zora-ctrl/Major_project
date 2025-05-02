<?php
/**
 * Export to PHP Array plugin for PHPMyAdmin
 * @version 5.2.1
 */

/**
 * Database `av`
 */

/* `av`.`contact_us` */
$contact_us = array(
  array('id' => '1','name' => 'Jora Singh','mail' => 'gy@gmail.com','sub' => 'appreciation','msg' => 'Good Work')
);

/* `av`.`form` */
$form = array(
  array('id' => '20','uname' => 'zora','uclass' => 'bca'),
  array('id' => '21','uname' => '','uclass' => ''),
  array('id' => '22','uname' => '','uclass' => '')
);

/* `av`.`orders` */
$orders = array(
  array('order_id' => '1','product' => 'Data Cables ','pdprice' => '249','created_at' => '2025-04-20 16:02:22.215799','total_amount' => '249','order_date' => '2025-04-20 16:02:22.215799','status' => 'Delivered','quantity' => '1'),
  array('order_id' => '2','product' => 'Data Cables ','pdprice' => '249','created_at' => '2025-04-20 16:03:20.626273','total_amount' => '249','order_date' => '2025-04-20 16:03:20.626273','status' => 'Pending','quantity' => '1'),
  array('order_id' => '4','product' => 'Bluetooth Earbuds (x1)','pdprice' => '1299','created_at' => '2025-04-20 16:02:41.443640','total_amount' => '1299','order_date' => '2025-04-20 16:02:41.443640','status' => 'Shipped','quantity' => '1'),
  array('order_id' => '5','product' => 'Wireless Charger (x1)','pdprice' => '1499','created_at' => '2025-04-20 16:03:22.829260','total_amount' => '1499','order_date' => '2025-04-20 16:03:22.829260','status' => 'Pending','quantity' => '1'),
  array('order_id' => '6','product' => 'Bluetooth Earbuds (x1)','pdprice' => '1299','created_at' => '2025-04-20 17:56:47.562486','total_amount' => '1299','order_date' => '2025-04-20 00:00:00.000000','status' => '','quantity' => '0')
);

/* `av`.`order_customers` */
$order_customers = array(
  array('order_id' => '1','name' => 'Zora Singh','email' => 'dff@mail.com','phone' => '8544468712','address' => 'Jalandhar','created_at' => '2025-04-20 13:26:14.713516'),
  array('order_id' => '2','name' => 'Mohit Chopra','email' => 'mohit@mail.com','phone' => '7585548444','address' => 'Maqsudan','created_at' => '2025-04-20 14:39:06.038600'),
  array('order_id' => '4','name' => 'Jora','email' => 'gy@gmail.com','phone' => '8544468712','address' => 'Ludhiana','created_at' => '2025-04-20 15:33:15.258236'),
  array('order_id' => '5','name' => 'Love','email' => 'love@mail.com','phone' => '9230845808','address' => 'Patiala','created_at' => '2025-04-20 16:00:24.705081'),
  array('order_id' => '6','name' => 'Jora Singh','email' => 'dff@mail.com','phone' => '9230845808','address' => 'Jalandhar','created_at' => '2025-04-20 17:56:02.181276')
);

/* `av`.`order_items` */
$order_items = array(
  array('id' => '1','order_id' => '1','product_id' => '1','price' => '149.00','quantity' => '1'),
  array('id' => '2','order_id' => '2','product_id' => '3','price' => '1299.00','quantity' => '1')
);

/* `av`.`product` */
$product = array(
  array('id' => '1','product_id' => '1','name' => 'Back Cover','price' => '149','image_url' => 'http://localhost/mobile_cart/js/images/cover.jpg','description' => 'stylish back cover for Iphones','stock' => '10','created_at' => '2025-04-05 16:42:30','category' => 'Phone Cases'),
  array('id' => '2','product_id' => '2','name' => 'Wireless Charger','price' => '1499','image_url' => 'http://localhost/mobile_cart/js/images/wireless_charger.jpeg','description' => 'wireless charger is a type of wireless power transfer. It uses electromagnetic induction to provide electricity to portable devices.','stock' => '10','created_at' => '2025-04-05 16:42:30','category' => 'Chargers'),
  array('id' => '3','product_id' => '3','name' => 'Bluetooth Earbuds','price' => '1299','image_url' => 'http://localhost/mobile_cart/js/images/bt.jpeg','description' => 'Bluetooth Earbuds are portable speakers that fit inside people\'s ears.','stock' => '10','created_at' => '2025-04-05 16:42:30','category' => 'Audio Accessories'),
  array('id' => '4','product_id' => '4','name' => 'Data Cables','price' => '249','image_url' => '
http://localhost/mobile_cart/js/images/cable.jpeg','description' => 'Multi-purposes data cables for various ports.','stock' => '10','created_at' => '2025-04-05 16:42:30','category' => 'Cables')
);
