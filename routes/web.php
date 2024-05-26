<?php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Artisan;
   use  Illuminate\Routing\UrlGenerator;
    use App\Http\Controllers\NotificationController;
    use App\Http\Controllers\FrontendController;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\MovmentsControllers;
    use App\Http\Controllers\MovementsCartsController;
    use App\Http\Controllers\StoreMovemntsController;
    use App\Http\Controllers\TransferControllers;
    use App\Http\Controllers\TransferCartsController;
    use App\Http\Controllers\TransferOrders;
    use App\Http\Controllers\QutationControllers;
    use App\Http\Controllers\QuotationCartsControllers;
    use App\Http\Controllers\QutationOrdersControllers;
    use App\Http\Controllers\ExportFiles;
    use Barryvdh\DomPDF\Facade\Pdf;
    use Dompdf\Dompdf;

    
    // Route::get('/', function () {
    //     return view('welcome');
    // });




    Route::get('cache-clear', function () {
        Artisan::call('optimize:clear');
        request()->session()->flash('success', 'Successfully cache cleared.');
        return redirect()->back();
    })->name('cache.clear');

        // STORAGE LINKED ROUTE
        Route::get('storage-link',[AdminController::class,'storageLink'])->name('storage.link');


        Auth::routes(['register' => false]);

        Route::get('user/login', [FrontendController::class, 'login'])->name('login.form');
        Route::post('user/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
    
        Route::post('user/logout', [FrontendController::class, 'logout'])->name('user.logout');

        Route::get('user/register', [FrontendController::class, 'register'])->name('register.form');
        Route::post('user/register', [FrontendController::class, 'registerSubmit'])->name('register.submit');

        Route::get('/',  [FrontendController::class, 'login'])->name('login.form');

    // Backend section start
    // Route::middleware(['isAdmin'])->prefix('/admin')->group(function () {
    Route::group(['prefix' => '/admin', 'middleware' => ['auth']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::get('/file-manager', function () {
            return view('backend.layouts.file-manager');
        })->name('file-manager');
        // user route
        Route::resource('users', 'App\Http\Controllers\UsersController');

        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
        Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');

        // Definition
        Route::resource('/category', 'App\Http\Controllers\CategoryController');
        Route::resource('/product', 'App\Http\Controllers\ProductController');
        Route::resource('/post', 'App\Http\Controllers\PostController');
        Route::resource('/shipping', 'App\Http\Controllers\ShippingController');
        Route::get('/indeedit', [ProductController::class, 'indeedit'])->name('indeedit');
        Route::get('/stores/{store}', [ProductController::class, 'index'])->name('stores');

        Route::get('/all_product', [ProductController::class, 'allprodct'])->name('allproduct');

      
        // Notification
        Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
        Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
       
    });

    Route::group([ 'middleware' => ['auth']], function () {

    // Route::middleware(['isAdmin'])->group(function () {
    Route::get('/outbound/product-lists/{order_type}', [MovmentsControllers::class, 'show'])->name('outbound');
    Route::get('/inbound/product-lists', [TransferControllers::class, 'show'])->name('inbound');
    Route::get('/source', [TransferControllers::class, 'source'])->name('source');
    Route::get('/qutation/product-lists', [QutationControllers::class, 'show'])->name('qutation');

    
    //Cart inbound Section
    Route::post('/add-to-inbound', [TransferCartsController::class, 'singleAddToCart'])->name('in.single-add-to-cart');
    Route::get('inbound-delete/{id}', [TransferCartsController::class, 'cartDelete'])->name('in.cart-delete');
    Route::post('/inbound-update', [TransferCartsController::class, 'cartUpdate'])->name('t_cart_update');

    //Cart outbound Section
    Route::post('/add-to-outbound', [MovementsCartsController::class, 'singleAddToCart'])->name('out.single-add-to-cart');
    Route::get('outbound-delete/{id}', [MovementsCartsController::class, 'cartDelete'])->name('out.cart-delete');
    Route::post('outbound-update', [MovementsCartsController::class, 'cartUpdate'])->name('out.cart.update');

    Route::post('/add-to-qutation', [QuotationCartsControllers::class, 'singleAddToCart'])->name('qutation-add-to-cart');
    Route::get('qutation-delete/{id}', [QuotationCartsControllers::class, 'cartDelete'])->name('qutation-delete');
    Route::post('qutation-update', [QuotationCartsControllers::class, 'cartUpdate'])->name('qutation.cart.update');
    //////////////////
    Route::get('/outbound/cart/{order_type}', [MovmentsControllers::class, 'cart']);
    Route::get('/inbound/cart/{source}', [TransferControllers::class, 'cart'])->name('in_cart');
    Route::get('/qutation/cart', function(){
        return view('frontend.qutation.cart');
    });
       
    Route::post('/inbound/order', [TransferOrders::class, 'store'])->name('in.cart.order');

    Route::post('/outbound/order', [StoreMovemntsController::class, 'store'])->name('out.cart.order');

    Route::post('/qutation/order', [QutationOrdersControllers::class, 'store'])->name('qutation.order');

//orders
    //orders index
    Route::get('/envoy/qutation/index',[QutationOrdersControllers::class, 'envoy_index'])->name('envoy.qutation.index');
    Route::get('/qutation/index',[QutationOrdersControllers::class, 'index'])->name('qutation.index');
    Route::get('/order/outbound',[StoreMovemntsController::class, 'index'])->name('out.order.index');
    Route::get('/order/envoybound',[StoreMovemntsController::class, 'envoyindex'])->name('env.order.index');
    Route::get('/order/inbound',[TransferOrders::class, 'index'])->name('in.order.index');
    // orders show
    Route::get('/pdf/{id}',[QutationControllers::class,'pdf'])->name('pdf'); 
    Route::get('/order/qutation/show/{id}',[QutationOrdersControllers::class, 'show'])->name('qutation.show');
    Route::get('/order/outbound/show/{id}',[StoreMovemntsController::class, 'show'])->name('out.order.show');
    Route::get('/order/inbound/show/{id}',[TransferOrders::class, 'show'])->name('in.order.show');
    //orders edit
    Route::get('/order/qutation/edit/{id}',[QutationOrdersControllers::class, 'edit'])->name('qutation.edit');
    Route::get('/order/outbound/edit/{id}',[StoreMovemntsController::class, 'edit'])->name('out.order.edit');
    Route::get('/order/inbound/edit/{id}',[TransferOrders::class, 'edit'])->name('in.order.edit');
    // orrders delete
    Route::delete('/qutation/delete/{id}', [QutationOrdersControllers::class, 'destroy'])->name('qutation.destroy');
    Route::delete('/inbound/delete/{id}', [TransferOrders::class, 'destroy'])->name('in.order.destroy');
    Route::delete('/outbound/delete/{id}', [StoreMovemntsController::class, 'destroy'])->name('out.order.destroy');
    Route::delete('/envoy/delete/{id}', [StoreMovemntsController::class, 'destroyenv'])->name('env.order.destroy');
    // orders update
    Route::resource('/inorder', 'App\Http\Controllers\TransferOrders');
    Route::resource('/outorder', 'App\Http\Controllers\StoreMovemntsController');
    Route::resource('/qutation', 'App\Http\Controllers\QutationOrdersControllers');

    Route::get('/order/checkbox/{created_at}', [StoreMovemntsController::class, 'checkbox'])->name('checkbox');


    //export excel
    Route::get('product/export/', [ExportFiles::class, 'export'])->name('export_product');
    Route::get('stock/export/{store}', [ExportFiles::class, 'export_stock'])->name('export_stock');

    Route::get('outbound/export', [ExportFiles::class, 'export_store_movemnts'])->name('export_outbound');
    Route::get('showout/export/{id}', [ExportFiles::class, 'export_show_store_movemnts'])->name('export_outbound_show');
    Route::get('/order/checkbox/{id}', [ExportFiles::class, 'checkbox'])->name('checkbox');

    Route::get('inbound/export', [ExportFiles::class, 'export_transfer_orders'])->name('export_Inbound');
    Route::get('showoin/export/{id}', [ExportFiles::class, 'export_one_transfer_order'])->name('export_inbound_show');


});
    Route::get('/history/pdf/', [QutationControllers::class, 'pdf'])->name('pdf.history');

    Route::get('/pdf/{id}', [ExportFiles::class, 'export_price'])->name('pdf'); 
    Route::get('/file/{id}', [QutationControllers::class, 'pdf'])->name('pdf.link');