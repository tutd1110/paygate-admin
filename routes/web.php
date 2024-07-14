<?php

use App\Http\Controllers\Admin\EmailTemplateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login/google', [\App\Http\Controllers\Auth\LoginGoogleController::class, 'start'])
    ->name('google.start.login')->middleware('guest');


Route::get('/login-done/google', [\App\Http\Controllers\Auth\LoginGoogleController::class, 'login'])
    ->name('google.done.login')->middleware('guest');


Route::group(['prefix' => '', 'middleware' => ['authgoogle', 'isAdmin']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['prefix' => '', 'middleware' => ['permission']], function () {
//        Route::group(['prefix' => 'contact-exams'], function () {
//            Route::get('scan-module-permission', [\App\Http\Controllers\Admin\ContactExamsController::class, 'scanModulePerission'])->name('scanModulePerission');
//        });

        Route::group(['prefix' => 'upload'], function () {
            Route::post('', [\App\Http\Controllers\Auth\UploadController::class, 'index'])->name('upload');
        });

        Route::get('pgw_partner/checkvaluePart', [\App\Http\Controllers\Admin\PartnerController::class, 'checkValidateParner']);
        Route::get('pgw_partner/create', [\App\Http\Controllers\Admin\PartnerController::class, 'store'])->name('pgw_partner.create');
        Route::get('pgw_partner/edit/{id}', [\App\Http\Controllers\Admin\PartnerController::class, 'update'])->name('pgw_partner.edit');
        Route::post('checkBankingPartner', [\App\Http\Controllers\Admin\PartnerController::class, 'checkBankingPartner']);

        Route::resource('pgw_partner', \App\Http\Controllers\Admin\PartnerController::class,['only' => ['index', 'store','update','destroy']]);


        Route::post('pgw_payment_merchant/statusChange/{id}', [\App\Http\Controllers\Admin\PgwPaymentMerchantController::class, 'statusChange'])->name('class.statusChange');
        Route::get('pgw_payment_merchant/create', [\App\Http\Controllers\Admin\PgwPaymentMerchantController::class, 'store'])->name('pgw_payment_merchant.create');
        Route::get('pgw_payment_merchant/edit/{id}', [\App\Http\Controllers\Admin\PgwPaymentMerchantController::class, 'update'])->name('pgw_payment_merchant.edit');
        Route::resource('pgw_payment_merchant', \App\Http\Controllers\Admin\PgwPaymentMerchantController::class,['only' => ['index', 'store','update','destroy']]);

//        Route::get('pgw_partner_resgistri_merchant/create', [\App\Http\Controllers\Admin\PgwPartnerResgistriMerchantController::class, 'store'])->name('pgw_payment_merchant.create');
//        Route::get('pgw_partner_resgistri_merchant/edit/{id}', [\App\Http\Controllers\Admin\PgwPartnerResgistriMerchantController::class, 'update'])->name('pgw_payment_merchant.edit');
//        Route::resource('pgw_partner_resgistri_merchant', \App\Http\Controllers\Admin\PgwPartnerResgistriMerchantController::class,['only' => ['index', 'store','update','destroy']]);


//        Route::resource('pgw_partner_resgistri_banking', \App\Http\Controllers\Admin\PgwPartnerResBankingController::class);
//        Route::post('pgw_partner_resgistri_banking/{id}', [\App\Http\Controllers\Admin\PgwPartnerResBankingController::class, 'update']);
        Route::get('pgw_partner_resgistri_banking_delete', [\App\Http\Controllers\Admin\PgwPartnerResBankingController::class, 'destroy'])->name('res_banking_destroy');

        Route::get('invoices/export', [\App\Http\Controllers\Admin\InvoicesController::class, 'export'])->name('invoices.export');
        Route::get('invoices/create', [\App\Http\Controllers\Admin\InvoicesController::class, 'store'])->name('invoices.create');
        Route::resource('invoices', \App\Http\Controllers\Admin\InvoicesController::class, ['only' => ['index', 'store', 'show']]);

        Route::get('pgw_orders/orderDetail', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'orderDetail'])->name('pgw_orders.orderDetail');
        Route::get('pgw_orders/export', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'export'])->name('pgw_orders.export');
        Route::get('pgw_orders/create', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'store'])->name('pgw_orders.create');
        Route::post('pgw_orders/index', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'index'])->name('pgw_orders.show');
        Route::post('pgw_orders/updateOrderPaid', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'updateOrderPaid'])->name('pgw_orders.updateOrderPaid');
        Route::post('pgw_orders/updateOrderStatusToCRM', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'updateOrderStatusToCRM'])->name('pgw_orders.updateOrderStatusToCRM');
        Route::get('pgw_orders/changeStatus', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'changeStatus'])->name('pgw_orders.changeStatus');
        Route::resource('pgw_orders', \App\Http\Controllers\Admin\PgwOrdersController::class, ['only' => ['index', 'store']]);
        Route::get('/statistical', [\App\Http\Controllers\Admin\PgwOrdersController::class, 'statistical'])->name('pgw_orders.statistical');


        Route::get('pgw_order_refund/export', [\App\Http\Controllers\Admin\PgwOrderRefundController::class, 'export'])->name('pgw_order_refund.export');
        Route::put('pgw_order_refund/statusChange', [\App\Http\Controllers\Admin\PgwOrderRefundController::class, 'statusChange'])->name('pgw_order_refund.statuChange');
        Route::resource('pgw_order_refund', \App\Http\Controllers\Admin\PgwOrderRefundController::class,['only' => ['index', 'store', 'destroy']]);

        Route::resource('pgw_payment_request', \App\Http\Controllers\Admin\PgwPaymentRequestController::class,['only' => ['index']]);

        Route::get('pgw_listbanking/create', [\App\Http\Controllers\Admin\PgwListBankingController::class, 'store'])->name('pgw_listbanking.create');
        Route::get('pgw_listbanking/edit/{id}', [\App\Http\Controllers\Admin\PgwListBankingController::class, 'update'])->name('pgw_listbanking.edit');
        Route::resource('pgw_listbanking', \App\Http\Controllers\Admin\PgwListBankingController::class,['only' => ['index', 'store','update','destroy']]);

        Route::get('sys_user/create', [\App\Http\Controllers\Admin\SYS\SysUserController::class, 'store'])->name('sys_user.create');
        Route::get('sys_user/edit/{id}', [\App\Http\Controllers\Admin\SYS\SysUserController::class, 'update'])->name('sys_user.edit');
        Route::resource('sys_user', \App\Http\Controllers\Admin\SYS\SysUserController::class,['only' => ['index', 'store','update','destroy']]);
        Route::post('get_name_group', [\App\Http\Controllers\Admin\SYS\SysUserController::class, 'getnameGroup']);
        Route::post('changOwner', [\App\Http\Controllers\Admin\SYS\SysUserController::class, 'changOwner']);
        Route::post('checkOwner', [\App\Http\Controllers\Admin\SYS\SysUserController::class, 'checkOwner']);
        Route::post('/changStatus/{id}', [\App\Http\Controllers\Admin\SYS\SysUserController::class, 'changStatus'])->name('changStatus.sys_user');

        Route::get('sys_group/create', [\App\Http\Controllers\Admin\SYS\SysGroupController::class, 'store'])->name('sys_group.create');
        Route::get('sys_group/edit/{id}', [\App\Http\Controllers\Admin\SYS\SysGroupController::class, 'update'])->name('sys_group.edit');
        Route::resource('sys_group', \App\Http\Controllers\Admin\SYS\SysGroupController::class,['only' => ['index', 'store','update','destroy']]);

        Route::get('sys_modules/edit/{id}', [\App\Http\Controllers\Admin\SYS\SysModulesController::class, 'update'])->name('sys_modules.edit');
        Route::resource('sys_modules', \App\Http\Controllers\Admin\SYS\SysModulesController::class,['only' => ['index','update']]);

        Route::get('sys_permission/create', [\App\Http\Controllers\Admin\SYS\SysPermissionController::class, 'store'])->name('sys_permission.create');
        Route::get('sys_permission/edit/{id}', [\App\Http\Controllers\Admin\SYS\SysPermissionController::class, 'update'])->name('sys_permission.edit');
        Route::get('scan-module-permission', [\App\Http\Controllers\Admin\SYS\SysPermissionController::class, 'scanModulePerission'])->name('scanModulePerission');
        Route::resource('sys_permission', \App\Http\Controllers\Admin\SYS\SysPermissionController::class,['only' => ['index','store','update']]);

        Route::post('template_messages/statusChange', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'statusChange'])->name('template_messages.statusChange');
        Route::get('template_messages/create', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'store'])->name('template_messages.create');
        Route::get('template_messages/edit/{id}', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'update'])->name('template_messages.edit');
        Route::resource('template_messages', \App\Http\Controllers\Admin\MessageTemplateController::class,['only' => ['index','store','update','destroy']]);

        Route::get('redis/cache', [\App\Http\Controllers\HocmaiController::class, 'clearCacheRedis'])->name('redis.cache');

        Route::resource('randomGift', \App\Http\Controllers\Admin\RandomGiftContactController::class,['only' => ['index','store','update']]);
        Route::get('randomGift/export', [\App\Http\Controllers\Admin\RandomGiftContactController::class, 'export'])->name('randomGift.export');
        Route::resource('emailTemplate', \App\Http\Controllers\Admin\EmailTemplateController::class, ['only' => ['index', 'store','update','destroy']]);
        Route::get('emailTemplate/create', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'store'])->name('emailTemplate.create');
        Route::get('emailTemplate/show_contact/{id}', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'show_contact'])->name('emailTemplate.show_contact');
        Route::get('emailTemplate/edit/{id}', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'update'])->name('emailTemplate.edit');



    });
    Route::get('/logout', [\App\Http\Controllers\Auth\LoginGoogleController::class, 'logout'])->name('google.logout');

});

require __DIR__ . '/auth.php';
