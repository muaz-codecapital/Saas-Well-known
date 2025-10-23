<?php

use App\Http\Controllers\ActionsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\MckinseyController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PestController;
use App\Http\Controllers\PestelController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PorterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SwotController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductPlanningController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\GoogleCalendarController;

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

Route::get('/', [AuthController::class, "login"])->name("login");

Route::prefix("super-admin")->group(function () {
    Route::get("/", [AuthController::class, "superAdminLogin"])->name(
        "super-admin-login"
    );
    Route::post("/auth", [AuthController::class, "superAdminAuthenticate"]);
});
Route::get("/super-admin/dashboard", [
    SuperAdminController::class,
    "dashboard",
]);

Route::get("/super-admin/update-schema", [
    SuperAdminController::class,
    "updateSchema",
]);

Route::get("/subscription-plans", [SuperAdminController::class, "saasPlans"]);
Route::get("/subscription-plan", [
    SuperAdminController::class,
    "createSaasPlan",
]);
Route::get("/payment-gateways", [
    SuperAdminController::class,
    "paymentGateways",
]);
Route::get("/configure-payment-gateway", [
    SuperAdminController::class,
    "configurePaymentGateway",
]);

Route::get('/validate-paypal-subscription', [DashboardController::class, 'validatePaypalSubscription']);
Route::post('/paypal-ipn', [SuperAdminController::class, "paypalIpn"]);

Route::post("/save-subscription-plan", [
    SuperAdminController::class,
    "subscriptionPlanPost",
]);
Route::get("/edit-workspace", [
    SuperAdminController::class,
    "editWorkspace",
]);
Route::get("/view-workspace", [
    SuperAdminController::class,
    "viewWorkspace",
]);
Route::post("/save-workspace", [
    SuperAdminController::class,
    "saveWorkspace",
]);
Route::post("/configure-gateway", [
    SuperAdminController::class,
    "configurePaymentGatewayPost",
]);
Route::get("/user-profile", [SuperAdminController::class, "userProfile"]);
Route::get("/super-admin-profile", [
    SuperAdminController::class,
    "adminProfile",
]);
Route::get("/super-admin-setting", [
    SuperAdminController::class,
    "adminSetting",
]);
Route::get("/workspaces", [SuperAdminController::class, "workspaces"]);
Route::get("/add-user", [SuperAdminController::class, "addUser"]);
Route::get("/delete-workspace/{id}", [
    SuperAdminController::class,
    "deleteWorkspace",
]);




Route::get("/email-setting", [SuperAdminController::class, "emailSetting"]);
Route::post("/save-email-setting", [SuperAdminController::class, "saveEmailSetting"]);

Route::get("/delete-user/{id}", [SuperAdminController::class, "deleteUser"]);
Route::get("/users", [SuperAdminController::class, "users"]);
Route::get("/emails", [SuperAdminController::class, "newsletterEmail"]);
// Activation routes disabled
// Route::get("/activate", [SuperAdminController::class, "activateLicense"]);
// Route::post("/activate-license", [SettingController::class, "activateLicensePost"]);
Route::get("/subscribe", [SubscribeController::class, "subscribe"]);
Route::get("/cancel-subscription", [SubscribeController::class, "cancelSubscription"]);
Route::post("/payment-stripe", [SubscribeController::class, "paymentStripe"]);
Route::post("/payment-paystack", [SubscribeController::class, "paymentPaystack"]);
Route::get("/", [AuthController::class, "login"])->name("login");
Route::get("/login", [AuthController::class, "login"]);
Route::get("/signup", [AuthController::class, "signup"]);

// Payment routes
Route::get("/payment/stripe", [PaymentController::class, "stripePayment"]);
Route::post("/payment/stripe/create-session", [PaymentController::class, "createStripeSession"]);
Route::get("/payment/success", [PaymentController::class, "paymentSuccess"]);
Route::get("/payment/cancel", [PaymentController::class, "paymentCancel"]);

Route::get("/forgot-password", [AuthController::class, "forgotPassword"]);
Route::get("/password-reset", [AuthController::class, "passwordReset"]);
Route::get("/logout", [AuthController::class, "logout"]);
Route::get("/download/{id}", [DownloadController::class, "download"]);
// Routes that require authentication but not necessarily subscription
Route::middleware(['auth'])->group(function () {
    Route::get("/dashboard", [DashboardController::class, "dashboard"]);
    Route::get("/profile", [ProfileController::class, "profile"]);
    Route::get("/staff", [ProfileController::class, "staff"]);
    Route::get("/settings", [SettingController::class, "settings"]);
    Route::get("/billing", [SettingController::class, "billing"]);
    Route::get("/new-user", [ProfileController::class, "newUser"]);
    Route::get("/user-edit/{id}", [ProfileController::class, "userEdit"]);
    Route::post("/user-post", [ProfileController::class, "userPost"]);
    Route::get("/delete/{action}/{id}", [DeleteController::class, "delete"]);
});

// Routes that require both authentication and active subscription
Route::middleware(['auth', 'subscription.required'])->group(function () {
    // Project Management
    Route::get("/projects", [ProjectController::class, "projects"]);
    Route::get("/create-project", [ProjectController::class, "createProject"]);
    Route::get("/view-project", [ProjectController::class, "projectView"]);
    Route::get("/view-project-discussion", [ProjectController::class, "projectViewDiscussion"]);
    Route::get("/view-project-tasks", [ProjectController::class, "projectViewTasks"]);
    Route::get("/view-project-files", [ProjectController::class, "projectViewFiles"]);
    Route::post("/save-project", [ProjectController::class, "projectPost"]);
    Route::post("/save-project-message", [ProjectController::class, "projectMessagePost"]);

    // Task Management
    Route::prefix("admin")->name("admin.")->group(function () {
        Route::get("/tasks/{action}", [TaskController::class, "tasksAction"])->name("tasks");
        Route::post("/tasks/{action}", [TaskController::class, "tasksSave"])->name("tasks.save");
        Route::get("/task-list", [TaskController::class, "taskList"]);
        Route::patch("/tasks/{id}/status", [TaskController::class, "updateStatus"])->name("tasks.updateStatus");

        // Product Planning
        Route::prefix("product-planning")->name("product-planning.")->group(function () {
            Route::get("/", [ProductPlanningController::class, "index"])->name("index");
            Route::get("/list", [ProductPlanningController::class, "list"])->name("list");
            Route::get("/kanban", [ProductPlanningController::class, "kanban"])->name("kanban");
            Route::get("/create", [ProductPlanningController::class, "create"])->name("create");
            Route::post("/", [ProductPlanningController::class, "store"])->name("store");
            Route::get("/{id}", [ProductPlanningController::class, "show"])->name("show");
            Route::get("/{id}/edit", [ProductPlanningController::class, "edit"])->name("edit");
            Route::put("/{id}", [ProductPlanningController::class, "update"])->name("update");
            Route::patch("/{id}/status", [ProductPlanningController::class, "updateStatus"])->name("updateStatus");
            Route::delete("/{id}", [ProductPlanningController::class, "destroy"])->name("destroy");
            Route::get("/{id}/json", [ProductPlanningController::class, "getItem"])->name("get-item");
        Route::post("/bulk-update-status", [ProductPlanningController::class, "bulkUpdateStatus"])->name("bulk-update-status");
        Route::post("/bulk-delete", [ProductPlanningController::class, "bulkDelete"])->name("bulk-delete");
        Route::post("/products", [ProductPlanningController::class, "storeProduct"])->name("store-product");
        Route::post("/departments", [ProductPlanningController::class, "storeDepartment"])->name("store-department");
        Route::post("/product-milestones", [ProductPlanningController::class, "storeMilestone"])->name("store-milestone");
        });

        // CRM Module
        Route::prefix("crm")->name("crm.")->group(function () {
            Route::get("/", [CrmController::class, "dashboard"])->name("dashboard");
            Route::get("/contacts", [CrmController::class, "contacts"])->name("contacts");
            Route::get("/contacts/kanban", [CrmController::class, "contactsKanban"])->name("contacts.kanban");
            Route::get("/contacts/create", [CrmController::class, "contactCreate"])->name("contacts.create");
            Route::get("/contacts/{id}", [CrmController::class, "contactShow"])->name("contacts.show");
            Route::get("/companies", [CrmController::class, "companies"])->name("companies");
            Route::get("/companies/create", [CrmController::class, "companyCreate"])->name("companies.create");
            Route::get("/companies/{id}", [CrmController::class, "companyShow"])->name("companies.show");
            Route::get("/companies/{id}/edit", [CrmController::class, "companyEdit"])->name("companies.edit");
            Route::get("/activities", [CrmController::class, "activities"])->name("activities");
            Route::get("/activities/create", [CrmController::class, "activityCreate"])->name("activities.create");
            Route::get("/reminders", [CrmController::class, "reminders"])->name("reminders");
            Route::get("/reminders/create", [CrmController::class, "reminderCreate"])->name("reminders.create");

            // AJAX Routes
            Route::post("/contacts", [CrmController::class, "contactStore"])->name("contacts.store");
            Route::post("/companies", [CrmController::class, "companyStore"])->name("companies.store");
            Route::put("/companies/{id}", [CrmController::class, "companyUpdate"])->name("companies.update");
            Route::post("/activities", [CrmController::class, "activityStore"])->name("activities.store");
            Route::post("/reminders", [CrmController::class, "reminderStore"])->name("reminders.store");
            Route::patch("/contacts/{id}/status", [CrmController::class, "updateContactStatus"])->name("contacts.update-status");
            Route::patch("/reminders/{id}/status", [CrmController::class, "updateReminderStatus"])->name("reminders.update-status");
            Route::get("/contacts/{id}/json", [CrmController::class, "getContact"])->name("contacts.get");
            Route::get("/companies/{id}/json", [CrmController::class, "getCompany"])->name("companies.get");
            Route::get("/search/companies", [CrmController::class, "searchCompanies"])->name("search.companies");
            Route::get("/search/contacts", [CrmController::class, "searchContacts"])->name("search.contacts");
            Route::post("/contacts/bulk-update-status", [CrmController::class, "bulkUpdateContactStatus"])->name("contacts.bulk-update-status");
            Route::delete("/contacts/{id}", [CrmController::class, "deleteContact"])->name("contacts.delete");
            Route::delete("/companies/{id}", [CrmController::class, "deleteCompany"])->name("companies.delete");
        });
    });

    Route::get("/kanban", [TaskController::class, "kanban"]);
    Route::post("/todo/set-status", [TaskController::class, "setStatus"]);
    Route::post('/tasks/add-status', [TaskController::class, 'addStatus'])->name('tasks.addStatus');
    Route::post('/tasks/add-workspace', [TaskController::class, 'addWorkSpace'])->name('tasks.addGroup');

    // Business Planning
    Route::get("/business-plans", [PlansController::class, "businessPlans"]);
    Route::get("/write-business-plan", [PlansController::class, "writeBusinessPlans"]);
    Route::get("/view-business-plan", [PlansController::class, "viewBusinessPlan"]);
    Route::post("/business-plan-post", [PlansController::class, "businessPlanPost"]);

    // Marketing Planning
    Route::get("/marketing-plans", [MarketingController::class, "marketingPlans"]);
    Route::get("/write-marketing-plan", [MarketingController::class, "writeMarketingPlan"]);
    Route::get("/view-marketing-plan", [MarketingController::class, "ViewMarketingPlan"]);
    Route::post("/save-marketing-plan", [MarketingController::class, "marketingPlanPost"]);

    // Strategic Analysis Tools
    Route::get("/swot-list", [SwotController::class, "swotList"]);
    Route::get("/write-swot", [SwotController::class, "writeSwot"]);
    Route::get("/view-swot", [SwotController::class, "viewSwot"]);
    Route::post("/save-swot", [SwotController::class, "swotPost"]);

    Route::get("/write-pest", [PestController::class, "writePest"]);
    Route::get("/pest-list", [PestController::class, "pestList"]);
    Route::get("/view-pest", [PestController::class, "viewPest"]);
    Route::post("/save-pest", [PestController::class, "pestPost"]);

    Route::get("/write-pestle", [PestelController::class, "writePestel"]);
    Route::get("/pestle-list", [PestelController::class, "pestelList"]);
    Route::get("/view-pestle", [PestelController::class, "viewPestel"]);
    Route::post("/save-pestel", [PestelController::class, "pestelPost"]);

    // Business Model Tools
    Route::get("/porter-models", [PorterController::class, "porterList"]);
    Route::get("/new-porter", [PorterController::class, "newPorter"]);
    Route::get("/view-porter", [PorterController::class, "viewPorter"]);
    Route::post("/save-porter-model", [PorterController::class, "porterPost"]);

    Route::get("/mckinsey-models", [MckinseyController::class, "mckinseyModels"]);
    Route::get("/new-mckinsey-model", [MckinseyController::class, "NewMckinseyModels"]);
    Route::get("/view-mckinsey-model", [MckinseyController::class, "ViewMckinseyModel"]);
    Route::post("/save-mckinsey-model", [MckinseyController::class, "MckinseyModelPost"]);

    // Startup Tools
    Route::get("/startup-canvases", [PlansController::class, "startupCanvases"]);
    Route::get("/design-startup-canvas", [PlansController::class, "startupCanvas"]);
    Route::get("/view-startup-canvas", [PlansController::class, "viewStartupCanvas"]);
    Route::post("/save-startup-canvas", [PlansController::class, "startupCanvasPost"]);

    // Brainstorming
    Route::get("/brainstorming", [PlansController::class, "brainStorm"]);
    Route::get("/brainstorming-list", [PlansController::class, "brainStormList"]);
    Route::post("/save-canvas", [PlansController::class, "saveCanvas"]);

    // Reports
    Route::get("/reports", [ReportController::class, "reportList"]);
    Route::get("/new-report", [ReportController::class, "newReport"]);
    Route::get("/view-report", [ReportController::class, "viewReport"]);
    Route::post("/save-report", [ReportController::class, "reportPost"]);

    // Notice Board
    Route::get("/write-notice", [NoticeController::class, "writeNotice"]);
    Route::get("/notice-list", [NoticeController::class, "noticeList"]);
    Route::post("/save-notice", [NoticeController::class, "noticePost"]);

    // Calendar and Notes (basic features)
    Route::get("/calendar/{action?}", [PlansController::class, "calendarAction"])->name('calendar');

    // Google Calendar Integration
    Route::get('/google/redirect', [GoogleCalendarController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::post('/google/sync', [GoogleCalendarController::class, 'sync'])->name('google.sync');
    Route::get('/google/disconnect', [GoogleCalendarController::class, 'disconnect'])->name('google.disconnect');

    Route::get("/notes", [ActionsController::class, "notes"])->name('notes.index');
    Route::get("/add-note", [ActionsController::class, "addNote"])->name('notes.create');
    Route::get("/view-note", [ActionsController::class, "viewNote"])->name('notes.show');
    Route::post("/save-note", [ActionsController::class, "notePost"])->name('notes.store');
    Route::delete("/notes/{note}", [ActionsController::class, "deleteNote"])->name('notes.destroy');

    // Tag Management Routes
    Route::resource('tags', TagController::class);
    Route::get('/api/tags', [TagController::class, 'getTags'])->name('tags.api');
    Route::post('/api/tags/create', [TagController::class, 'createTag'])->name('tags.create.api');

    // Basic Actions
    Route::get("/add-task", [ActionsController::class, "addTask"]);

    // Documents (premium feature)
    Route::get("/documents", [DocumentController::class, "documents"]);

    // Investor Management (premium feature)
    Route::get("/add-investor", [ContactController::class, "addInvestor"]);
    Route::get("/investors", [ContactController::class, "investorList"]);
    Route::get("/view-investor", [ContactController::class, "investorView"]);
    Route::post("/save-investor", [ContactController::class, "investorPost"]);
});

Route::post("/save-reset-password", [
    AuthController::class,
    "resetPasswordPost",
]);
Route::post("/post-new-password", [AuthController::class, "newPasswordPost"]);
Route::post("/user-change-password", [
    ProfileController::class,
    "userChangePasswordPost",
]);
Route::post("/login", [AuthController::class, "loginPost"]);
Route::post("/super-admin/login", [
    AuthController::class,
    "superAdminLoginPost",
]);
Route::post("/signup", [AuthController::class, "signupPost"]);


Route::post("/settings", [SettingController::class, "settingsPost"]);
Route::post("/profile", [ProfileController::class, "profilePost"]);


Route::get("/pricing", [FrontendController::class, "pricing"]);
Route::get('/privacy', [FrontendController::class, 'privacy']);
Route::get("/termsandconditions", [FrontendController::class, "termsCondition"]);
Route::get("/cookie-policy", [FrontendController::class, "cookiePolicy"]);
Route::get("/contact", [FrontendController::class, "contact"]);


Route::post("/save-email", [FrontendController::class, "emailSave"]);


Route::get('/landingpage', [SuperAdminController::class, 'landingPage']);
Route::get('/pricingpage', [SuperAdminController::class, 'pricingPage']);
Route::get('/termspage', [SuperAdminController::class, 'termsPage']);
Route::get('/cookiepage', [SuperAdminController::class, 'cookiePage']);
Route::get('/privacypage', [SuperAdminController::class, 'privacyPage']);
Route::get('/contactpage', [SuperAdminController::class, 'contactPage']);
Route::get('/footer', [SuperAdminController::class, 'footer']);


Route::get("/blog", [FrontendController::class, "blogs"]);
Route::get("/blog/{slug}", [FrontendController::class, "viewArticle"]);

Route::get("/write-blog", [BlogController::class, "writeBlog"]);
Route::get("/blogs", [BlogController::class, "blogs"]);
Route::get("/view-blog", [BlogController::class, "viewBlog"]);
Route::post("/save-blog", [BlogController::class, "blogPost"]);

Route::get("/write-notice", [NoticeController::class, "writeNotice"]);
Route::get("/notice-list", [NoticeController::class, "noticeList"]);

Route::post("/save-notice", [NoticeController::class, "noticePost"]);

Route::post('/save-cookie-section', [SuperAdminController::class, 'saveCookie']);

Route::post('/save-footer-section', [SuperAdminController::class, 'footerSection']);
Route::post('/save-calltoaction-section', [SuperAdminController::class, 'calltoactionSection']);

Route::post('/save-hero-section', [SuperAdminController::class, 'heroSection']);
Route::post('/save-feature1-section', [SuperAdminController::class, 'feature1Section']);
Route::post('/save-feature2-section', [SuperAdminController::class, 'feature2Section']);
Route::post('/save-partner-section', [SuperAdminController::class, 'partnerSection']);

Route::post('/save-story1-section', [SuperAdminController::class, 'story1Section']);
Route::post('/save-story2-section', [SuperAdminController::class, 'story2Section']);

Route::post('/save-newsletter-section', [SuperAdminController::class, 'newsletterSection']);
Route::post('/save-number-section', [SuperAdminController::class, 'numberSection']);
Route::post('/save-privacy-section', [SuperAdminController::class, 'savePrivacy']);
Route::post('/save-terms-section', [SuperAdminController::class, 'saveTerms']);


Route::post("/settings/{action}", [SettingController::class, "settingsStore"]);

Route::middleware(['auth', 'subscription.required'])->group(function () {
    Route::prefix("admin")
        ->name("admin.")
        ->group(function () {
            Route::get("/tasks/{action}", [
                TaskController::class,
                "tasksAction",
            ])->name("tasks");
            Route::post("/tasks/{action}", [
                TaskController::class,
                "tasksSave",
            ])->name("tasks.save");

            Route::get("/delete/{action}/{id}", [
                DeleteController::class,
                "delete",
            ])->name("delete");
        });
    Route::get("/kanban", [TaskController::class, "kanban"]);
    Route::post("/todo/set-status", [TaskController::class, "setStatus"]);
    Route::post('/tasks/add-status', [TaskController::class, 'addStatus'])->name('tasks.addStatus');
    Route::post('/tasks/quick-update-status', [TaskController::class, 'quickUpdateStatus'])->name('tasks.quickUpdateStatus');
    Route::post("/ai", [AiController::class, "ai"]);

    Route::get("/update", function () {
        \App\Supports\UpdateSupport::updateSchema();
    });


    Route::post("/save-swot", [SwotController::class, "swotPost"]);
    Route::post("/save-pest", [PestController::class, "pestPost"]);
    Route::post("/save-pestel", [PestelController::class, "pestelPost"]);

    Route::post("/save-project", [ProjectController::class, "projectPost"]);
    Route::post("/save-project-message", [
        ProjectController::class,
        "projectMessagePost",
    ]);

    Route::post("/document", [DocumentController::class, "documentPost"]);


    Route::post("/save-event", [PlansController::class, "eventPost"]);
    Route::post("/user-post", [ProfileController::class, "userPost"]);
    Route::get("/business-plans", [PlansController::class, "businessPlans"]);
    Route::get("/write-business-plan", [
        PlansController::class,
        "writeBusinessPlans",
    ]);

    Route::get("/view-business-plan", [PlansController::class, "viewBusinessPlan"]);
    Route::get("/view-business-model", [
        PlansController::class,
        "viewBusinessModel",
    ]);

    Route::get("/business-models", [PlansController::class, "businessModels"]);
    Route::get("/design-business-model", [PlansController::class, "businessModel"]);

    Route::get("/marketing-plans", [MarketingController::class, "marketingPlans"]);
    Route::get("/write-marketing-plan", [MarketingController::class, "writeMarketingPlan"]);
    Route::get("/view-marketing-plan", [MarketingController::class, "ViewMarketingPlan"]);

    Route::post("/save-marketing-plan", [MarketingController::class, "marketingPlanPost"]);

    Route::get("/startup-canvases", [PlansController::class, "startupCanvases"]);
    Route::get("/design-startup-canvas", [PlansController::class, "startupCanvas"]);
    Route::get("/view-startup-canvas", [PlansController::class, "viewStartupCanvas"]);
    Route::post("/save-startup-canvas", [PlansController::class, "startupCanvasPost"]);


    Route::get("/brainstorming", [PlansController::class, "brainStorm"]);
    Route::get("/brainstorming-list", [PlansController::class, "brainStormList"]);
    Route::post("/save-canvas", [PlansController::class, "saveCanvas"]);
    Route::post("/business-plan-post", [
        PlansController::class,
        "businessPlanPost",
    ]);

    Route::post("/business-model-post", [
        PlansController::class,
        "businessModelPost",
    ]);
});
