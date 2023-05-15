<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BaseController,BranchController,CategoryController,CostController,DepartamentCostController,EmployeeController,FieldController,FormlistController,GanttController,HomeController,InvoiceController,InvoiceProductsController,RoleController,UserController,PermissionController,ProductController,ProfessionController,ProjectController,ProviderController,PublicController,ReceiptController,SectorController,SectorsCostsController, ShortcutController, StoksController
};
use App\Models\Task;
use Illuminate\Support\Facades\Date;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::prefix('s')->group(function(){
    Route::get('{shortcut}',[ShortcutController::class,'redirectToUrl'])->name('shortcut.url');
    Route::get('s/{shortcut}',[ShortcutController::class,'redirectToSecure'])->name('shortcut.secure');
});

Route::prefix('publico')->group(function () {
    // Route::get('projetos',[PublicController::class,'projects'])->name('public.projects');

});
Route::prefix('externo')->group(function () {
    Route::get('recibos/{receipt}/show', [ReceiptController::class, 'externReceiptShow'])->name('extern.receiptShow');
    Route::get('recibos/{receipt}/assinatura', [ReceiptController::class, 'externAssignShow'])->name('extern.externAssignShow');
    Route::post('recibos/{receipt}/assign', [ReceiptController::class, 'externAssign'])->name('extern.externAssign');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/home', [HomeController::class, 'getModels'])->name('modelos');
Route::get('/unauthorized', [HomeController::class, 'unauthorized'])->name('unauthorized');

Route::prefix('dashboard')->middleware(['auth', 'permission:dashboard'])->group(function () {

    Route::get('gantt', [GanttController::class, 'index'])->name('dashboard.projects.statistics.gantt');

    Route::get('teste', function () {
        $task = Task::find(2);
        $parent = $task->parentTask()->first();
        $lastDate = "";
        foreach ($task->subTasks()->get() as $subtask) {
            $newDate = date_create($subtask->start_date)->modify("+ {$subtask->duration} day");
            $lastDate =  $lastDate > $newDate ? $lastDate : $newDate;
        }
        dd($lastDate);
    });
    Route::get('formulario/{formlist_employee}', [BaseController::class, 'formlistPdf'])->name('formlistPdf');
    Route::prefix('api')->group(function () {
        Route::get('invoice/{invoice}/products', [StoksController::class, 'getProductsByInvoiceId'])->name('api.invoice.products');
        Route::get('providers/invoices/{sector}', [StoksController::class, 'getAllInvoicesFromProviderByProject'])->name('api.providers.invoices');
        Route::get('providers/{sector}', [StoksController::class, 'filterProviders'])->name('api.providers');
        Route::post('/products/store', [StoksController::class, 'store'])->name('api.stoks.store');
    });

    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('dashboard.users');
        Route::get('/cadastro', [UserController::class, 'create'])->name('dashboard.users.create');
        Route::get('/{user}', [UserController::class, 'show'])->name('dashboard.users.show');
        Route::get('/{user}/editar', [UserController::class, 'edit'])->name('dashboard.users.edit');

        Route::post('/', [UserController::class, 'store'])->name('dashboard.users.store');
        Route::post('{user}/assinatura', [UserController::class, 'generateSignature'])->name('dashboard.users.signature');

        Route::delete('/', [UserController::class, 'destroy'])->name('dashboard.users.destroy');
        Route::put('/', [UserController::class, 'update'])->name('dashboard.users.update');

        Route::get('{id}/permissoes', [UserController::class, 'permissions'])->name('dashboard.users.permissions');
        Route::put('{user}/permissoes/update', [UserController::class, 'permissionsUpdate'])->name('dashboard.users.permissions.update');
        Route::get('{id}/funcoes', [UserController::class, 'roles'])->name('dashboard.users.roles');
        Route::put('{user}/funcoes/update', [UserController::class, 'rolesUpdate'])->name('dashboard.users.roles.update');
    });

    Route::prefix('permissoes')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('dashboard.permissions');
        Route::get('/{id}/editar', [PermissionController::class, 'edit'])->name('dashboard.permissions.edit');
        Route::get('/criar', [PermissionController::class, 'create'])->name('dashboard.permissions.create');
        Route::get('/{id}', [PermissionController::class, 'show'])->name('dashboard.permissions.show');
        Route::get('/{permission}/vincular', [PermissionController::class, 'roles'])->name('dashboard.permissions.roles');

        Route::put('/{permission}/update', [PermissionController::class, 'syncRolesById'])->name('dashboard.permissions.sync');
        Route::put('/', [PermissionController::class, 'update'])->name('dashboard.permissions.update');
        Route::post('/', [PermissionController::class, 'store'])->name('dashboard.permissions.store');
        Route::delete('/', [PermissionController::class, 'destroy'])->name('dashboard.permissions.destroy');
    });

    Route::prefix('funcoes')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('dashboard.roles');
        Route::get('/{id}/editar', [RoleController::class, 'edit'])->name('dashboard.roles.edit');
        Route::get('/criar', [RoleController::class, 'create'])->name('dashboard.roles.create');
        Route::get('/{role}/funcao', [RoleController::class, 'show'])->name('dashboard.roles.show');
        Route::get('/{role}/vincular', [RoleController::class, 'permissions'])->name('dashboard.roles.permissions');


        Route::put('/{role}/update', [RoleController::class, 'syncPermissionsById'])->name('dashboard.roles.sync');
        Route::put('/', [RoleController::class, 'update'])->name('dashboard.roles.update');
        Route::post('/', [RoleController::class, 'store'])->name('dashboard.roles.store');
        Route::delete('/', [RoleController::class, 'destroy'])->name('dashboard.roles.destroy');
    });

    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('dashboard.projects');
        Route::get('/json/project', [ProjectController::class, 'getProjectByUuid'])->name('dashboard.projects.json.project');
        Route::get('/criar', [ProjectController::class, 'create'])->name('dashboard.projects.create');
        Route::get('/{project}/show', [ProjectController::class, 'show'])->name('dashboard.projects.show');
        Route::get('/{project}/editar', [ProjectController::class, 'edit'])->name('dashboard.projects.edit');
        Route::get('/{project}/funcionarios', [ProjectController::class, 'employees'])->name('dashboard.projects.employees');
        Route::get('/{project}/listar_funcionarios', [ProjectController::class, 'listEmployees'])->name('dashboard.projects.listEmployees');

        Route::post('/', [ProjectController::class, 'store'])->name('dashboard.projects.store');
        Route::post('/{project}/employee/{employee}/detach', [ProjectController::class, 'detachEmployee'])->name('dashboard.projects.detachEmployee');
        Route::post('/{project}/employee/{employee}/attach', [ProjectController::class, 'attachEmployee'])->name('dashboard.projects.attachEmployee');
        Route::put('/{project}/update', [ProjectController::class, 'update'])->name('dashboard.projects.update');
        Route::delete('/', [ProjectController::class, 'destroy'])->name('dashboard.projects.destroy');

        Route::get('/{project}/vincular', [ProjectController::class, 'providers'])->name('dashboard.projects.providers');

        Route::put('/{project}/sync', [ProjectController::class, 'syncProviders'])->name('dashboard.projects.syncProviders');
        Route::put('/{project}/syncEmployees', [ProjectController::class, 'syncEmployees'])->name('dashboard.projects.syncEmployees');
    });

    Route::prefix('custos')->group(function () {
        Route::get('/', [CostController::class, 'index'])->name('dashboard.costs.index');
        Route::get('/criar', [CostController::class, 'create'])->name('dashboard.costs.create');
        Route::get('/{cost}', [CostController::class, 'show'])->name('dashboard.costs.show');
        Route::get('/{cost}/editar', [CostController::class, 'edit'])->name('dashboard.costs.edit');
        Route::get('/{cost}/setordecustos/criar', [SectorsCostsController::class, 'createSectorForCost'])->name('dashboard.costs.createSector');

        Route::post('/', [CostController::class, 'store'])->name('dashboard.costs.store');
        Route::put('/', [CostController::class, 'update'])->name('dashboard.costs.update');
        Route::delete('/', [CostController::class, 'destroy'])->name('dashboard.costs.destroy');
    });

    Route::prefix('setordecustos')->group(function () {
        Route::get('/', [SectorsCostsController::class, 'index'])->name('dashboard.costs_sectors.index');
        Route::get('/criar', [SectorsCostsController::class, 'create'])->name('dashboard.costs_sectors.create');
        Route::get('/{sector}', [SectorsCostsController::class, 'show'])->name('dashboard.costs_sectors.show');
        Route::get('/{sector}/editar', [SectorsCostsController::class, 'edit'])->name('dashboard.costs_sectors.edit');

        Route::post('/', [SectorsCostsController::class, 'store'])->name('dashboard.costs_sectors.store');
        Route::put('/', [SectorsCostsController::class, 'update'])->name('dashboard.costs_sectors.update');
        Route::delete('/', [SectorsCostsController::class, 'destroy'])->name('dashboard.costs_sectors.destroy');
    });
    Route::prefix('departamentodecustos')->group(function () {
        Route::get('/', [DepartamentCostController::class, 'index'])->name('dashboard.costs_departaments.index');
        Route::get('/criar', [DepartamentCostController::class, 'create'])->name('dashboard.costs_departaments.create');
        Route::get('/{departament}', [DepartamentCostController::class, 'show'])->name('dashboard.costs_departaments.show');
        Route::get('/{departament}/editar', [DepartamentCostController::class, 'edit'])->name('dashboard.costs_departaments.edit');

        Route::post('/', [DepartamentCostController::class, 'store'])->name('dashboard.costs_departaments.store');
        Route::put('/', [DepartamentCostController::class, 'update'])->name('dashboard.costs_departaments.update');
        Route::delete('/', [DepartamentCostController::class, 'destroy'])->name('dashboard.costs_departaments.destroy');
    });
    Route::prefix('fornecedores')->group(function () {
        Route::get('/', [ProviderController::class, 'index'])->name('dashboard.providers.index');
        Route::get('/criar', [ProviderController::class, 'create'])->name('dashboard.providers.create');
        Route::get('/{provider}', [ProviderController::class, 'show'])->name('dashboard.providers.show');
        Route::get('/{provider}/editar', [ProviderController::class, 'edit'])->name('dashboard.providers.edit');
        Route::get('/{provider}/vincular', [ProviderController::class, 'projects'])->name('dashboard.providers.projects');

        Route::put('/{provider}/sync', [ProviderController::class, 'syncProjects'])->name('dashboard.providers.syncProjects');

        Route::post('/', [ProviderController::class, 'store'])->name('dashboard.providers.store');
        Route::put('/', [ProviderController::class, 'update'])->name('dashboard.providers.update');
        Route::delete('/', [ProviderController::class, 'destroy'])->name('dashboard.providers.destroy');
    });
    Route::prefix('notas')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('dashboard.invoices.index');
        Route::get('/criar', [InvoiceController::class, 'create'])->name('dashboard.invoices.create');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('dashboard.invoices.show');
        Route::get('/{invoice}/editar', [InvoiceController::class, 'edit'])->name('dashboard.invoices.edit');

        Route::post('/', [InvoiceController::class, 'store'])->name('dashboard.invoices.store');
        Route::put('/', [InvoiceController::class, 'update'])->name('dashboard.invoices.update');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('dashboard.invoices.destroy');
        //Invoice Productos routes
        Route::get('/produtos/{invoice}', [InvoiceProductsController::class, 'index'])->name('dashboard.invoicesProducts.index');
        Route::get('/produtos/{invoice}/show', [InvoiceProductsController::class, 'show'])->name('dashboard.invoicesProducts.show');
        Route::get('/popular/{invoice}', [InvoiceProductsController::class, 'create'])->name('dashboard.invoices.popular.create');
        Route::post('/popupar/{invoice}', [InvoiceProductsController::class, 'store'])->name('dashboard.invoices.popular.store');
    });
    Route::prefix('bases')->group(function () {
        Route::get('/', [BaseController::class, 'index'])->name('dashboard.bases.index');
        Route::get('/criar', [BaseController::class, 'create'])->name('dashboard.bases.create');
        Route::post('/', [BaseController::class, 'store'])->name('dashboard.bases.store');
        Route::put('/', [BaseController::class, 'update'])->name('dashboard.bases.update');

        Route::prefix('{base}')->group(function () {
            Route::get('/', [BaseController::class, 'show'])->name('dashboard.bases.show');
            Route::delete('/', [BaseController::class, 'destroy'])->name('dashboard.bases.destroy');
            Route::get('/editar', [BaseController::class, 'edit'])->name('dashboard.bases.edit');

            Route::get('/estoque', [BaseController::class, 'stoks'])->name('dashboard.bases.stoks');
            // Route::get('/formularios',[BaseController::class,'formlists'])->name('dashboard.bases.formlists');
            // formlists x bases
            Route::get('/formularios', [BaseController::class, 'formlists'])->name('dashboard.bases.formlists');
            Route::get('/formularios/show', [BaseController::class, 'showFormlists'])->name('dashboard.bases.formlists.show');
            Route::put('/formularios/sync', [BaseController::class, 'syncFormlistsById'])->name('dashboard.bases.formlists.sync');
            Route::delete('/formularios/detach', [BaseController::class, 'detachFormlist'])->name('dashboard.bases.detachFormlist');

            Route::get('/setores', [BaseController::class, 'sectors'])->name('dashboard.bases.sectors');

            //employees x bases
            Route::prefix('funcionarios')->group(function () {

                Route::get('/', [BaseController::class, 'employees'])->name('dashboard.bases.employees');
                Route::get('/show', [BaseController::class, 'showEmployees'])->name('dashboard.bases.employees.show');
                Route::get('/vinculados', [BaseController::class, 'employeesLinked'])->name('dashboard.bases.employees.linked');
                Route::put('/sync', [BaseController::class, 'syncEmployeesById'])->name('dashboard.bases.employees.sync');
                Route::post('/{employee}/detach', [BaseController::class, 'detachEmployee'])->name('dashboard.bases.employees.detachEmployee');
                Route::post('/{employee}/atttach', [BaseController::class, 'atttachEmployee'])->name('dashboard.bases.employees.atttachEmployee');

                Route::prefix('{employee}/formularios')->group(function () {
                    Route::get('/', [BaseController::class, 'formlistsByEmployee'])->name('dashboard.bases.employees.formlists');
                    Route::get('/list', [BaseController::class, 'listFormlistsForEmployee'])->name('dashboard.bases.employees.list.formlists');
                    Route::put('/sync', [BaseController::class, 'syncFormlistsByEmployee'])->name('dashboard.bases.employees.formlists.sync');
                    Route::prefix('{formlist_employee}/ficha')->group(function () {
                        Route::get('/', [BaseController::class, 'fieldsFormlistByEmployee'])->name('dashboard.bases.employees.formlists.fields');
                        Route::post('/remove', [BaseController::class, 'removeFieldFormlistByEmployee'])->name('dashboard.bases.employees.formlists.fields.remove');
                        Route::post('/devolver', [FieldController::class, 'devolutionField'])->name('dashboard.bases.employees.formlists.fields.devolution');
                        // Route::get('/adicionar',[FieldController::class,'create'])->name('dashboard.bases.employees.formlists.fields.create');
                    });
                });
            });
        });
    });
    Route::prefix('setores')->group(function () {
        Route::get('/', [SectorController::class, 'index'])->name('dashboard.sectors.index');
        Route::get('/criar', [SectorController::class, 'create'])->name('dashboard.sectors.create');
        Route::get('/{sector}', [SectorController::class, 'show'])->name('dashboard.sectors.show');
        Route::get('/{sector}/editar', [SectorController::class, 'edit'])->name('dashboard.sectors.edit');

        Route::post('/', [SectorController::class, 'store'])->name('dashboard.sectors.store');
        Route::put('/', [SectorController::class, 'update'])->name('dashboard.sectors.update');
        Route::delete('/{sector}', [SectorController::class, 'destroy'])->name('dashboard.sectors.destroy');


        Route::prefix('{sector}/estoque')->group(function () {
            Route::get('/', [StoksController::class, 'index'])->name('dashboard.sectors.stoks.index');
            Route::get('/cadastrar', [StoksController::class, 'create'])->name('dashboard.sectors.stoks.create');
            Route::get('/cadastrar/invoice/{invoice}/products', [StoksController::class, 'getProductsByInvoiceId'])->name('dashboard.sectors.stoks.invoices.products');
            Route::get('cadastrar/providers', [StoksController::class, 'filterProviders'])->name('dashboard.sectors.stoks.providers');
            Route::get('cadastrar/providers/invoices', [StoksController::class, 'getAllInvoicesFromProviderByProject'])->name('dashboard.sectors.stoks.providers.invoices');

            Route::post('cadastrar/products/store', [StoksController::class, 'store'])->name('dashboard.sectors.stoks.store');

            Route::post('/retirar', [StoksController::class, 'removeFromStock'])->name('dashboard.sectors.stoks.removeFromStock');
        });
    });

    Route::prefix('profissoes')->group(function () {
        Route::get('/', [ProfessionController::class, 'index'])->name('dashboard.professions');
        Route::get('/{profession}/editar', [ProfessionController::class, 'edit'])->name('dashboard.professions.edit');
        Route::get('/criar', [ProfessionController::class, 'create'])->name('dashboard.professions.create');
        Route::get('/{profession}/profissao', [ProfessionController::class, 'show'])->name('dashboard.professions.show');
        Route::get('/{profession}/vincular', [ProfessionController::class, 'projects'])->name('dashboard.professions.projects');


        Route::put('/{profession}/projects/update', [ProfessionController::class, 'syncProjectsById'])->name('dashboard.professions.sync');
        Route::put('/{profession}', [ProfessionController::class, 'update'])->name('dashboard.professions.update');
        Route::post('/', [ProfessionController::class, 'store'])->name('dashboard.professions.store');
        Route::delete('/', [ProfessionController::class, 'destroy'])->name('dashboard.professions.destroy');
    });

    Route::prefix('empregados')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('dashboard.employees');
        Route::get('/{employee}/editar', [EmployeeController::class, 'edit'])->name('dashboard.employees.edit');
        Route::get('/criar', [EmployeeController::class, 'create'])->name('dashboard.employees.create');
        Route::get('/criar/{project}/projeto/profissoes', [EmployeeController::class, 'getProfessions'])->name('dashboard.employees.getProfessions');
        Route::get('/{employee}/empregado', [EmployeeController::class, 'show'])->name('dashboard.employees.show');
        Route::get('/{employee}/vincular', [EmployeeController::class, 'projects'])->name('dashboard.employees.projects');
        Route::get('/{employee}/formularios', [EmployeeController::class, 'formlists'])->name('dashboard.employees.formlists');
        Route::put('/{employee}/update', [EmployeeController::class, 'update'])->name('dashboard.employees.update');


        Route::put('/{employee}/projects/update', [EmployeeController::class, 'syncProjectsById'])->name('dashboard.employees.sync');
        Route::post('/', [EmployeeController::class, 'store'])->name('dashboard.employees.store');
        // Route::put('/',[EmployeeController::class,'update'])->name('dashboard.employees.update');
        Route::delete('/', [EmployeeController::class, 'destroy'])->name('dashboard.employees.destroy');
    });

    Route::prefix('formularios')->group(function () {
        Route::get('/', [FormlistController::class, 'index'])->name('dashboard.formlists');
        Route::get('/{formlist}/editar', [FormlistController::class, 'edit'])->name('dashboard.formlists.edit');
        Route::get('/criar', [FormlistController::class, 'create'])->name('dashboard.formlists.create');
        Route::get('/{formlist}/empregado', [FormlistController::class, 'show'])->name('dashboard.formlists.show');
        // Route::get('/{formlist}/vincular',[FormlistController::class,'projects'])->name('dashboard.formlists.projects');


        // Route::put('/{formlist}/projects/update',[FormlistController::class,'syncProjectsById'])->name('dashboard.formlists.sync');
        Route::put('/{formlist}', [FormlistController::class, 'update'])->name('dashboard.formlists.update');
        Route::post('/', [FormlistController::class, 'store'])->name('dashboard.formlists.store');
        Route::delete('/', [FormlistController::class, 'destroy'])->name('dashboard.formlists.destroy');
    });

    Route::prefix('ficheiros/{formlist_employee}')->group(function () {
        Route::get('adicionar', [FieldController::class, 'create'])->name('dashboard.fields.create');
        Route::get('sectors', [FieldController::class, 'getSectors'])->name('dashboard.fields.getSectors');
        Route::get('sectors/{sector}', [FieldController::class, 'getStoksBySector'])->name('dashboard.fields.getStoksBySector');
        Route::post('save', [FieldController::class, 'salveField'])->name('dashboard.fields.salveField');
        Route::post('signatureField', [FieldController::class, 'signatureField'])->name('dashboard.fields.signatureField');
        Route::post('salveFieldAfterAssign', [FieldController::class, 'salveFieldAfterAssign'])->name('dashboard.fields.salveFieldAfterAssign');
    });

    Route::prefix('suprimentos')->group(function () {
        Route::prefix('categorias')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('dashboard.financeiro.categories');
            Route::get('/criar', [CategoryController::class, 'create'])->name('dashboard.financeiro.categories.create');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('dashboard.financeiro.categories.show');
            Route::get('/{category}', [CategoryController::class, 'edit'])->name('dashboard.financeiro.categories.edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('dashboard.financeiro.categories.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('dashboard.financeiro.categories.destroy');
            Route::post('/', [CategoryController::class, 'store'])->name('dashboard.financeiro.categories.store');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('dashboard.financeiro.products');
            Route::get('/criar', [ProductController::class, 'create'])->name('dashboard.financeiro.products.create');
            Route::get('/{product}', [ProductController::class, 'show'])->name('dashboard.financeiro.products.show');
            Route::get('/{product}', [ProductController::class, 'edit'])->name('dashboard.financeiro.products.edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('dashboard.financeiro.products.update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('dashboard.financeiro.products.destroy');
            Route::post('/', [ProductController::class, 'store'])->name('dashboard.financeiro.products.store');
        });
    });

    Route::prefix('financeiro')->group(function () {

        Route::prefix('filiais')->group(function () {

            Route::get('', [BranchController::class, 'index'])->name('dashboard.financeiro.branches');
            Route::get('/criar', [BranchController::class, 'create'])->name('dashboard.financeiro.branches.create');
            Route::get('/{branch}/editar', [BranchController::class, 'edit'])->name('dashboard.financeiro.branches.edit');
            Route::get('/{branch}/show', [BranchController::class, 'show'])->name('dashboard.financeiro.branches.show');

            Route::put('/{branch}', [BranchController::class, 'update'])->name('dashboard.financeiro.branches.update');
            Route::delete('/{branch}', [BranchController::class, 'destroy'])->name('dashboard.financeiro.branches.destroy');
            Route::post('', [BranchController::class, 'store'])->name('dashboard.financeiro.branches.store');
        });

        Route::prefix('recibos')->group(function () {
            Route::get('', [ReceiptController::class, 'index'])->name('dashboard.financeiro.receipts');
            Route::get('/criar', [ReceiptController::class, 'create'])->name('dashboard.financeiro.receipts.create');
            Route::get('/{receipt}/editar', [ReceiptController::class, 'edit'])->name('dashboard.financeiro.receipts.edit');
            Route::get('/{receipt}/show', [ReceiptController::class, 'show'])->name('dashboard.financeiro.receipts.show');

            Route::put('/{receipt}', [ReceiptController::class, 'update'])->name('dashboard.financeiro.receipts.update');
            Route::put('/{receipt}/genLink', [ReceiptController::class, 'genPublicLink'])->name('dashboard.financeiro.receipts.genLink');
            Route::delete('/{receipt}', [ReceiptController::class, 'destroy'])->name('dashboard.financeiro.receipts.destroy');
            Route::post('', [ReceiptController::class, 'store'])->name('dashboard.financeiro.receipts.store');
            Route::post('/{receipt}/storeList', [ReceiptController::class, 'storeList'])->name('dashboard.financeiro.receipts.storeList');
            Route::post('/{receipt}/genTemporaryLink', [ReceiptController::class, 'genTemporaryLink'])->name('dashboard.financeiro.receipts.genTemporaryLink');
        });
    });
});

Route::get('publico/login', [PublicController::class, 'login'])->name('public.login');
Route::get('publico/logout', [PublicController::class, 'logout'])->name('public.logout');
Route::post('publico/login', [PublicController::class, 'authenticate'])->name('public.authenticate');

Route::prefix('publico')->middleware(['auth','public-projects'])->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('public.index');
    Route::prefix('projetos')->middleware('permission:public_projects')->group(function () {
        Route::get('/', [PublicController::class, 'projects'])->name('public.projects');
        Route::get('/{project}/estoque', [PublicController::class, 'stokFromProject'])->name('public.projects.stoks');
        Route::get('/{project}/bases', [PublicController::class, 'bases'])->name('public.projects.bases');
        Route::get('/{project}/estoque', [PublicController::class, 'stokFromProject'])->name('public.projects.stoks');
        Route::get('/bases/{base}/estoque', [PublicController::class, 'stokFromBase'])->name('public.projects.bases.stoks');
    });
    Route::get('fichas/{user}/funcionario', [PublicController::class, 'formlists'])->name('public.employees.formlists');
    Route::get('fichas/{formlist}/show', [PublicController::class, 'fieldsFormlistByEmployee'])->name('public.employees.formlists.show');
});
