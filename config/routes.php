<?php
/**
 * Application Routes Configuration
 */

// Authentication routes
$router->get('/', 'AuthController@login');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/otp', 'AuthController@otp');
$router->post('/verify-otp', 'AuthController@verifyOtp');
$router->post('/resend-otp', 'ResendOtpController@resend');
$router->get('/api/resend-otp', 'ResendOtpController@simpleResend');

// Forgot Password routes
$router->get('/forgot-password', 'AuthController@forgotPassword');
$router->post('/forgot-password', 'AuthController@processForgotPassword');
$router->get('/reset-password', 'AuthController@resetPassword');
$router->post('/reset-password', 'AuthController@processResetPassword');
$router->post('/resend-forgot-password-otp', 'AuthController@resendForgotPasswordOtp');

// AJAX routes for OTP validation with pop-up errors
$router->post('/api/verify-otp', 'AuthController@verifyOtpAjax');
$router->post('/api/reset-password', 'AuthController@resetPasswordAjax');

$router->get('/logout', 'AuthController@logout');

// Dashboard routes (protected)
$router->get('/dashboard', 'DashboardController@index');

// User profile and settings routes
$router->get('/profile', 'UserController@profile');
$router->get('/settings', 'UserController@settings');

// Accounts & Permissions (Admin Management)
$router->get('/accounts', 'AccountController@index');
$router->get('/accounts/create', 'AccountController@create');
$router->post('/accounts', 'AccountController@store');
$router->get('/accounts/{id}', 'AccountController@show');
$router->get('/accounts/{id}/edit', 'AccountController@edit');
$router->put('/accounts/{id}', 'AccountController@update');
$router->delete('/accounts/{id}', 'AccountController@delete');

// AJAX endpoints for accounts
$router->get('/api/accounts/search', 'AccountController@ajaxSearch');
$router->post('/api/accounts/{id}/activate', 'AccountController@activate');
$router->post('/api/accounts/{id}/deactivate', 'AccountController@deactivate');

// Clients routes
$router->get('/clients', 'ClientController@index');
$router->get('/clients/create', 'ClientController@create');
$router->post('/clients', 'ClientController@store');
$router->get('/clients/{id}', 'ClientController@show');
$router->get('/clients/{id}/edit', 'ClientController@edit');
$router->put('/clients/{id}', 'ClientController@update');
$router->delete('/clients/{id}', 'ClientController@delete');

$router->get('/clients/active', 'ClientController@active');
$router->get('/clients/capted', 'ClientController@capted');

// Messages routes
$router->get('/messages', 'MessageController@index');
$router->get('/messages/create', 'MessageController@create');
$router->post('/messages', 'MessageController@store');
$router->get('/messages/{id}', 'MessageController@show');
$router->delete('/messages/{id}', 'MessageController@delete');

$router->get('/messages/by-client', 'MessageController@byClient');
$router->get('/messages/conversion', 'MessageController@conversion');
$router->get('/messages/by-client/all', 'MessageController@byClientAll');

// Financial routes
$router->get('/finances', 'FinanceController@index');
$router->get('/finances/monthly', 'FinanceController@monthly');
$router->get('/finances/daily', 'FinanceController@daily');
$router->get('/finances/weekly', 'FinanceController@weekly');

// Invoice/Document routes
$router->get('/invoices', 'InvoiceController@index');
$router->get('/invoices/create', 'InvoiceController@create');
$router->post('/invoices', 'InvoiceController@store');
$router->get('/invoices/{id}', 'InvoiceController@show');
$router->get('/invoices/{id}/edit', 'InvoiceController@edit');
$router->put('/invoices/{id}', 'InvoiceController@update');
$router->delete('/invoices/{id}', 'InvoiceController@delete');

$router->get('/invoices/receipts', 'InvoiceController@receipts');
$router->get('/invoices/planos', 'InvoiceController@plans');

// API routes for AJAX requests
$router->post('/api/auth/login', 'Api\\AuthController@login');
$router->post('/api/auth/verify-otp', 'Api\\AuthController@verifyOtp');
$router->get('/api/auth/resend-otp', 'Api\\AuthController@resendOtp');
// Removed: $router->post('/api/auth/forgot-password', 'Api\\AuthController@forgotPassword'); - Now handled by /forgot-password
// $router->get('/api/clients/search', 'Api\\ClientController@search'); // Temporariamente desabilitado
$router->get('/api/messages/stats', 'Api\\MessageController@stats');
$router->get('/api/finances/chart', 'Api\\FinanceController@chartData');

// API routes for searchable selects
$router->get('/api/data/organization-types', 'Api\\DataController@organizationTypes');
$router->get('/api/data/countries', 'Api\\DataController@countries');
$router->get('/api/data/provinces', 'Api\\DataController@provinces');

// API routes for searchable select search functionality
$router->get('/api/organization-types/search', 'Api\\DataController@searchOrganizationTypes');
$router->get('/api/countries/search', 'Api\\DataController@searchCountries');
$router->get('/api/provinces/search', 'Api\\DataController@searchProvinces');

// API routes for users (clients) - TEMPORÁRIO: usar método show existente
$router->get('/clients/{id}/api', 'ClientController@apiShowUser');
$router->put('/clients/{id}/api', 'ClientController@apiUpdateUser');

// Test route
$router->get('/test-route', 'ClientController@testRoute');