<?php

use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\NewsController;
use App\Controllers\UserController;
use App\Controllers\ComboController;

// Khởi tạo router
$router = new Router();

// Trang chủ & Giới thiệu
$router->get('/', [HomeController::class, 'Home_page']);
$router->get('/about-us', [HomeController::class, 'About_us']);

// Sản phẩm
$router->get('/products', [ProductController::class, 'Products']);
$router->get('/product/{id}', [ProductController::class, 'Item']);
$router->post('/product/add', [ProductController::class, 'add_new_item']);
$router->post('/product/update/{id}', [ProductController::class, 'update_item']);
$router->delete('/product/delete/{id}', [ProductController::class, 'delete_item']);

// Giỏ hàng & Thanh toán
$router->get('/cart', [CartController::class, 'Cart']);
$router->post('/cart/add', [CartController::class, 'create_cart']);
$router->post('/cart/update', [CartController::class, 'update_product_in_cart']);
$router->delete('/cart/remove/{id}', [CartController::class, 'delete_product_incart']);
$router->get('/payment', [CartController::class, 'Payment']);
$router->post('/payment/confirm', [CartController::class, 'update_cart_combo']);

// Tin tức
$router->get('/news', [NewsController::class, 'News']);
$router->get('/news/{id}', [NewsController::class, 'News_detail']);
$router->post('/news/add', [NewsController::class, 'insert_news']);
$router->delete('/news/delete/{id}', [NewsController::class, 'delete_news']);
$router->post('/news/comment', [NewsController::class, 'add_comment_news']);
$router->delete('/news/comment/delete/{id}', [NewsController::class, 'delete_comment']);

// Combo sản phẩm
$router->get('/combo', [ComboController::class, 'Cost_table']);
$router->post('/combo/add', [ComboController::class, 'add_new_combo']);
$router->post('/combo/update', [ComboController::class, 'update_new_combo']);
$router->delete('/combo/delete/{id}', [ComboController::class, 'delete_combo']);
$router->post('/combo/order', [ComboController::class, 'create_order_combo']);
$router->delete('/combo/order/delete/{id}', [ComboController::class, 'delete_order_combo_id']);

// Tài khoản người dùng
$router->get('/login', [UserController::class, 'Login']);
$router->post('/login', [UserController::class, 'check_login']);
$router->get('/register', [UserController::class, 'register']);
$router->post('/register', [UserController::class, 'create_account']);
$router->get('/logout', [UserController::class, 'logout']);
$router->get('/member', [UserController::class, 'member_page']);
$router->post('/profile/update', [UserController::class, 'update_profile']);
$router->post('/profile/password', [UserController::class, 'update_password_profile']);
$router->delete('/user/delete/{id}', [UserController::class, 'remove_user']);
$router->post('/user/ban/{id}', [UserController::class, 'ban_user']);

// Quên mật khẩu
$router->get('/forgot', [UserController::class, 'forgot']);
$router->post('/forgot-password', [UserController::class, 'change_passwork']);

// Liên hệ & tin nhắn
$router->get('/contact-us', [HomeController::class, 'Contact_us']);
$router->post('/contact/send', [UserController::class, 'insert_message']);
$router->post('/contact/message/{id}', [UserController::class, 'sendmessage']);

?>
