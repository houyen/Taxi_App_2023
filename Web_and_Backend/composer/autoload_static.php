<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit07703d1633a9d397d52e60a002d213f9
{
    public static $files = array (
        '1e4ef4f507b0213406f12c7da3c17ccb' => __DIR__ . '/../..' . '/app/Http/Start/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tests\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'ApiCredentialsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/ApiCredentialsTableSeeder.php',
        'App\\Console\\Kernel' => __DIR__ . '/../..' . '/app/Console/Kernel.php',
        'App\\Contracts\\AuthInterface' => __DIR__ . '/../..' . '/app/Contracts/AuthInterface.php',
        'App\\Contracts\\ImageHandlerInterface' => __DIR__ . '/../..' . '/app/Contracts/ImageHandlerInterface.php',
        'App\\Contracts\\SMSInterface' => __DIR__ . '/../..' . '/app/Contracts/SMSInterface.php',
        'App\\DataTables\\AdminusersDataTable' => __DIR__ . '/../..' . '/app/DataTables/AdminusersDataTable.php',
        'App\\DataTables\\AppVersionDataTables' => __DIR__ . '/../..' . '/app/DataTables/AppVersionDataTables.php',
        'App\\DataTables\\CancelReasonDataTable' => __DIR__ . '/../..' . '/app/DataTables/CancelReasonDataTable.php',
        'App\\DataTables\\CancelTripsDataTable' => __DIR__ . '/../..' . '/app/DataTables/CancelTripsDataTable.php',
        'App\\DataTables\\CompanyDataTable' => __DIR__ . '/../..' . '/app/DataTables/CompanyDataTable.php',
        'App\\DataTables\\CompanyOweDataTable' => __DIR__ . '/../..' . '/app/DataTables/CompanyOweDataTable.php',
        'App\\DataTables\\CompanyPayoutDataTable' => __DIR__ . '/../..' . '/app/DataTables/CompanyPayoutDataTable.php',
        'App\\DataTables\\CompanyPayoutReportsDataTable' => __DIR__ . '/../..' . '/app/DataTables/CompanyPayoutReportsDataTable.php',
        'App\\DataTables\\CountryDataTable' => __DIR__ . '/../..' . '/app/DataTables/CountryDataTable.php',
        'App\\DataTables\\CurrencyDataTable' => __DIR__ . '/../..' . '/app/DataTables/CurrencyDataTable.php',
        'App\\DataTables\\DocumentsDataTable' => __DIR__ . '/../..' . '/app/DataTables/DocumentsDataTable.php',
        'App\\DataTables\\DriverDataTable' => __DIR__ . '/../..' . '/app/DataTables/DriverDataTable.php',
        'App\\DataTables\\DriverPaymentDataTable' => __DIR__ . '/../..' . '/app/DataTables/DriverPaymentDataTable.php',
        'App\\DataTables\\HelpCategoryDataTable' => __DIR__ . '/../..' . '/app/DataTables/HelpCategoryDataTable.php',
        'App\\DataTables\\HelpDataTable' => __DIR__ . '/../..' . '/app/DataTables/HelpDataTable.php',
        'App\\DataTables\\HelpSubCategoryDataTable' => __DIR__ . '/../..' . '/app/DataTables/HelpSubCategoryDataTable.php',
        'App\\DataTables\\LanguageDataTable' => __DIR__ . '/../..' . '/app/DataTables/LanguageDataTable.php',
        'App\\DataTables\\LaterBookingDataTable' => __DIR__ . '/../..' . '/app/DataTables/LaterBookingDataTable.php',
        'App\\DataTables\\LocationsDataTable' => __DIR__ . '/../..' . '/app/DataTables/LocationsDataTable.php',
        'App\\DataTables\\MakeVehicleDataTable' => __DIR__ . '/../..' . '/app/DataTables/MakeVehicleDataTable.php',
        'App\\DataTables\\ManageFareDataTable' => __DIR__ . '/../..' . '/app/DataTables/ManageFareDataTable.php',
        'App\\DataTables\\MetasDataTable' => __DIR__ . '/../..' . '/app/DataTables/MetasDataTable.php',
        'App\\DataTables\\OweDataTable' => __DIR__ . '/../..' . '/app/DataTables/OweDataTable.php',
        'App\\DataTables\\PagesDataTable' => __DIR__ . '/../..' . '/app/DataTables/PagesDataTable.php',
        'App\\DataTables\\PaymentsDataTable' => __DIR__ . '/../..' . '/app/DataTables/PaymentsDataTable.php',
        'App\\DataTables\\PayoutDataTable' => __DIR__ . '/../..' . '/app/DataTables/PayoutDataTable.php',
        'App\\DataTables\\PayoutReportsDataTable' => __DIR__ . '/../..' . '/app/DataTables/PayoutReportsDataTable.php',
        'App\\DataTables\\PromoCodeDataTable' => __DIR__ . '/../..' . '/app/DataTables/PromoCodeDataTable.php',
        'App\\DataTables\\ProviderstatementDataTable' => __DIR__ . '/../..' . '/app/DataTables/ProviderstatementDataTable.php',
        'App\\DataTables\\RatingDataTable' => __DIR__ . '/../..' . '/app/DataTables/RatingDataTable.php',
        'App\\DataTables\\ReferralsDataTable' => __DIR__ . '/../..' . '/app/DataTables/ReferralsDataTable.php',
        'App\\DataTables\\RequestDataTable' => __DIR__ . '/../..' . '/app/DataTables/RequestDataTable.php',
        'App\\DataTables\\RiderDataTable' => __DIR__ . '/../..' . '/app/DataTables/RiderDataTable.php',
        'App\\DataTables\\RoleDataTable' => __DIR__ . '/../..' . '/app/DataTables/RoleDataTable.php',
        'App\\DataTables\\SupportDataTable' => __DIR__ . '/../..' . '/app/DataTables/SupportDataTable.php',
        'App\\DataTables\\BannerDataTable' => __DIR__ . '/../..' . '/app/DataTables/BannerDataTable.php',
        'App\\DataTables\\TollReasonDataTable' => __DIR__ . '/../..' . '/app/DataTables/TollReasonDataTable.php',
        'App\\DataTables\\TripsDataTable' => __DIR__ . '/../..' . '/app/DataTables/TripsDataTable.php',
        'App\\DataTables\\VehicleDataTable' => __DIR__ . '/../..' . '/app/DataTables/VehicleDataTable.php',
        'App\\DataTables\\VehicleModelDataTable' => __DIR__ . '/../..' . '/app/DataTables/VehicleModelDataTable.php',
        'App\\DataTables\\VehicleTypeDataTable' => __DIR__ . '/../..' . '/app/DataTables/VehicleTypeDataTable.php',
        'App\\DataTables\\WalletDataTable' => __DIR__ . '/../..' . '/app/DataTables/WalletDataTable.php',
        'App\\Exceptions\\Handler' => __DIR__ . '/../..' . '/app/Exceptions/Handler.php',
        'App\\Http\\Controllers\\Admin\\AdminController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/AdminController.php',
        'App\\Http\\Controllers\\Admin\\ApiCredentialsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/ApiCredentialsController.php',
        'App\\Http\\Controllers\\Admin\\AppVersionController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/AppVersionController.php',
        'App\\Http\\Controllers\\Admin\\CancelReasonController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/CancelReasonController.php',
        'App\\Http\\Controllers\\Admin\\CompanyController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/CompanyController.php',
        'App\\Http\\Controllers\\Admin\\CompanyPayoutController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/CompanyPayoutController.php',
        'App\\Http\\Controllers\\Admin\\CountryController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/CountryController.php',
        'App\\Http\\Controllers\\Admin\\CurrencyController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/CurrencyController.php',
        'App\\Http\\Controllers\\Admin\\DataTableBase' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/DataTableBase.php',
        'App\\Http\\Controllers\\Admin\\DocumentsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/DocumentsController.php',
        'App\\Http\\Controllers\\Admin\\DriverController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/DriverController.php',
        'App\\Http\\Controllers\\Admin\\EmailController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/EmailController.php',
        'App\\Http\\Controllers\\Admin\\FeesController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/FeesController.php',
        'App\\Http\\Controllers\\Admin\\HelpCategoryController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/HelpCategoryController.php',
        'App\\Http\\Controllers\\Admin\\HelpController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/HelpController.php',
        'App\\Http\\Controllers\\Admin\\HelpSubCategoryController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/HelpSubCategoryController.php',
        'App\\Http\\Controllers\\Admin\\JoinUsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/JoinUsController.php',
        'App\\Http\\Controllers\\Admin\\LanguageController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/LanguageController.php',
        'App\\Http\\Controllers\\Admin\\LaterBookingController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/LaterBookingController.php',
        'App\\Http\\Controllers\\Admin\\LocaleFileController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/LocaleFileController.php',
        'App\\Http\\Controllers\\Admin\\LocationsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/LocationsController.php',
        'App\\Http\\Controllers\\Admin\\MakeVehicleController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/MakeVehicleController.php',
        'App\\Http\\Controllers\\Admin\\ManageFareController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/ManageFareController.php',
        'App\\Http\\Controllers\\Admin\\ManualBookingController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/ManualBookingController.php',
        'App\\Http\\Controllers\\Admin\\MapController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/MapController.php',
        'App\\Http\\Controllers\\Admin\\MetasController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/MetasController.php',
        'App\\Http\\Controllers\\Admin\\OweController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/OweController.php',
        'App\\Http\\Controllers\\Admin\\PagesController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/PagesController.php',
        'App\\Http\\Controllers\\Admin\\PaymentGatewayController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/PaymentGatewayController.php',
        'App\\Http\\Controllers\\Admin\\PaymentsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/PaymentsController.php',
        'App\\Http\\Controllers\\Admin\\PayoutController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/PayoutController.php',
        'App\\Http\\Controllers\\Admin\\PromocodeController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/PromocodeController.php',
        'App\\Http\\Controllers\\Admin\\RatingController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/RatingController.php',
        'App\\Http\\Controllers\\Admin\\ReferralSettingsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/ReferralSettingsController.php',
        'App\\Http\\Controllers\\Admin\\ReferralsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/ReferralsController.php',
        'App\\Http\\Controllers\\Admin\\RequestController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/RequestController.php',
        'App\\Http\\Controllers\\Admin\\RiderController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/RiderController.php',
        'App\\Http\\Controllers\\Admin\\RolesController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/RolesController.php',
        'App\\Http\\Controllers\\Admin\\SendmessageController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/SendmessageController.php',
        'App\\Http\\Controllers\\Admin\\SiteSettingsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/SiteSettingsController.php',
        'App\\Http\\Controllers\\Admin\\StatementController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/StatementController.php',
        'App\\Http\\Controllers\\Admin\\SupportController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/SupportController.php',
        'App\\Http\\Controllers\\Admin\\TollReasonController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/TollReasonController.php',
        'App\\Http\\Controllers\\Admin\\TripsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/TripsController.php',
        'App\\Http\\Controllers\\Admin\\VehicleController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/VehicleController.php',
        'App\\Http\\Controllers\\Admin\\VehicleModelController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/VehicleModelController.php',
        'App\\Http\\Controllers\\Admin\\VehicleTypeController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/VehicleTypeController.php',
        'App\\Http\\Controllers\\Admin\\WalletController' => __DIR__ . '/../..' . '/app/Http/Controllers/Admin/WalletController.php',
        'App\\Http\\Controllers\\Api\\CronController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/CronController.php',
        'App\\Http\\Controllers\\Api\\DriverController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/DriverController.php',
        'App\\Http\\Controllers\\Api\\EarningController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/EarningController.php',
        'App\\Http\\Controllers\\Api\\HomeController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/HomeController.php',
        'App\\Http\\Controllers\\Api\\MapController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/MapController.php',
        'App\\Http\\Controllers\\Api\\PayoutDetailController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/PayoutDetailController.php',
        'App\\Http\\Controllers\\Api\\ProfileController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/ProfileController.php',
        'App\\Http\\Controllers\\Api\\RatingController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/RatingController.php',
        'App\\Http\\Controllers\\Api\\ReferralsController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/ReferralsController.php',
        'App\\Http\\Controllers\\Api\\RiderController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/RiderController.php',
        'App\\Http\\Controllers\\Api\\TokenAuthController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/TokenAuthController.php',
        'App\\Http\\Controllers\\Api\\TripController' => __DIR__ . '/../..' . '/app/Http/Controllers/Api/TripController.php',
        'App\\Http\\Controllers\\Auth\\ForgotPasswordController' => __DIR__ . '/../..' . '/app/Http/Controllers/Auth/ForgotPasswordController.php',
        'App\\Http\\Controllers\\Auth\\LoginController' => __DIR__ . '/../..' . '/app/Http/Controllers/Auth/LoginController.php',
        'App\\Http\\Controllers\\Auth\\RegisterController' => __DIR__ . '/../..' . '/app/Http/Controllers/Auth/RegisterController.php',
        'App\\Http\\Controllers\\Auth\\ResetPasswordController' => __DIR__ . '/../..' . '/app/Http/Controllers/Auth/ResetPasswordController.php',
        'App\\Http\\Controllers\\CompanyController' => __DIR__ . '/../..' . '/app/Http/Controllers/CompanyController.php',
        'App\\Http\\Controllers\\Controller' => __DIR__ . '/../..' . '/app/Http/Controllers/Controller.php',
        'App\\Http\\Controllers\\DashboardController' => __DIR__ . '/../..' . '/app/Http/Controllers/DashboardController.php',
        'App\\Http\\Controllers\\DriverDashboardController' => __DIR__ . '/../..' . '/app/Http/Controllers/DriverDashboardController.php',
        'App\\Http\\Controllers\\EmailController' => __DIR__ . '/../..' . '/app/Http/Controllers/EmailController.php',
        'App\\Http\\Controllers\\HomeController' => __DIR__ . '/../..' . '/app/Http/Controllers/HomeController.php',
        'App\\Http\\Controllers\\UserController' => __DIR__ . '/../..' . '/app/Http/Controllers/UserController.php',
        'App\\Http\\Helper\\FacebookHelper' => __DIR__ . '/../..' . '/app/Http/Helper/FacebookHelper.php',
        'App\\Http\\Helper\\OtpHelper' => __DIR__ . '/../..' . '/app/Http/Helper/OtpHelper.php',
        'App\\Http\\Helper\\RequestHelper' => __DIR__ . '/../..' . '/app/Http/Helper/RequestHelper.php',
        'App\\Http\\Kernel' => __DIR__ . '/../..' . '/app/Http/Kernel.php',
        'App\\Http\\Middleware\\AdminAuthenticate' => __DIR__ . '/../..' . '/app/Http/Middleware/AdminAuthenticate.php',
        'App\\Http\\Middleware\\Authenticate' => __DIR__ . '/../..' . '/app/Http/Middleware/Authenticate.php',
        'App\\Http\\Middleware\\CheckForMaintenanceMode' => __DIR__ . '/../..' . '/app/Http/Middleware/CheckForMaintenanceMode.php',
        'App\\Http\\Middleware\\EncryptCookies' => __DIR__ . '/../..' . '/app/Http/Middleware/EncryptCookies.php',
        'App\\Http\\Middleware\\EntrustPermission' => __DIR__ . '/../..' . '/app/Http/Middleware/EntrustPermission.php',
        'App\\Http\\Middleware\\GetUserFromToken' => __DIR__ . '/../..' . '/app/Http/Middleware/GetUserFromToken.php',
        'App\\Http\\Middleware\\JwtMiddleware' => __DIR__ . '/../..' . '/app/Http/Middleware/JwtMiddleware.php',
        'App\\Http\\Middleware\\LiveRestrict' => __DIR__ . '/../..' . '/app/Http/Middleware/LiveRestrict.php',
        'App\\Http\\Middleware\\Locale' => __DIR__ . '/../..' . '/app/Http/Middleware/Locale.php',
        'App\\Http\\Middleware\\RedirectIfAdminAuthenticated' => __DIR__ . '/../..' . '/app/Http/Middleware/RedirectIfAdminAuthenticated.php',
        'App\\Http\\Middleware\\RedirectIfAuthenticated' => __DIR__ . '/../..' . '/app/Http/Middleware/RedirectIfAuthenticated.php',
        'App\\Http\\Middleware\\RedirectIfDriverAuthenticated' => __DIR__ . '/../..' . '/app/Http/Middleware/RedirectIfDriverAuthenticated.php',
        'App\\Http\\Middleware\\RedirectIfRiderAuthenticated' => __DIR__ . '/../..' . '/app/Http/Middleware/RedirectIfRiderAuthenticated.php',
        'App\\Http\\Middleware\\SecureHeaders' => __DIR__ . '/../..' . '/app/Http/Middleware/SecureHeaders.php',
        'App\\Http\\Middleware\\TrimStrings' => __DIR__ . '/../..' . '/app/Http/Middleware/TrimStrings.php',
        'App\\Http\\Middleware\\TrustProxies' => __DIR__ . '/../..' . '/app/Http/Middleware/TrustProxies.php',
        'App\\Http\\Middleware\\URLDecode' => __DIR__ . '/../..' . '/app/Http/Middleware/URLDecode.php',
        'App\\Http\\Middleware\\VerifyCsrfToken' => __DIR__ . '/../..' . '/app/Http/Middleware/VerifyCsrfToken.php',
        'App\\Http\\Middleware\\canInstall' => __DIR__ . '/../..' . '/app/Http/Middleware/canInstall.php',
        'App\\Http\\Requests\\StoreCancelReasonRequest' => __DIR__ . '/../..' . '/app/Http/Requests/StoreCancelReasonRequest.php',
        'App\\Http\\Requests\\StoreTollReasonRequest' => __DIR__ . '/../..' . '/app/Http/Requests/StoreTollReasonRequest.php',
        'App\\Http\\Start\\Helpers' => __DIR__ . '/../..' . '/app/Http/Start/helpers.php',
        'App\\Jobs\\DriverRequestNotificationTimeout' => __DIR__ . '/../..' . '/app/Jobs/DriverRequestNotificationTimeout.php',
        'App\\Mail\\ForgotPasswordMail' => __DIR__ . '/../..' . '/app/Mail/ForgotPasswordMail.php',
        'App\\Mail\\MailQueue' => __DIR__ . '/../..' . '/app/Mail/MailQueue.php',
        'App\\Models\\Admin' => __DIR__ . '/../..' . '/app/Models/Admin.php',
        'App\\Models\\ApiCredentials' => __DIR__ . '/../..' . '/app/Models/ApiCredentials.php',
        'App\\Models\\AppVersion' => __DIR__ . '/../..' . '/app/Models/AppVersion.php',
        'App\\Models\\AppliedReferrals' => __DIR__ . '/../..' . '/app/Models/AppliedReferrals.php',
        'App\\Models\\Cancel' => __DIR__ . '/../..' . '/app/Models/Cancel.php',
        'App\\Models\\CancelReason' => __DIR__ . '/../..' . '/app/Models/CancelReason.php',
        'App\\Models\\CarType' => __DIR__ . '/../..' . '/app/Models/CarType.php',
        'App\\Models\\Company' => __DIR__ . '/../..' . '/app/Models/Company.php',
        'App\\Models\\CompanyDocuments' => __DIR__ . '/../..' . '/app/Models/CompanyDocuments.php',
        'App\\Models\\CompanyPayoutCredentials' => __DIR__ . '/../..' . '/app/Models/CompanyPayoutCredentials.php',
        'App\\Models\\CompanyPayoutPreference' => __DIR__ . '/../..' . '/app/Models/CompanyPayoutPreference.php',
        'App\\Models\\Country' => __DIR__ . '/../..' . '/app/Models/Country.php',
        'App\\Models\\Currency' => __DIR__ . '/../..' . '/app/Models/Currency.php',
        'App\\Models\\CurrencyConversion' => __DIR__ . '/../..' . '/app/Models/CurrencyConversion.php',
        'App\\Models\\Documents' => __DIR__ . '/../..' . '/app/Models/Documents.php',
        'App\\Models\\DocumentsTranslations' => __DIR__ . '/../..' . '/app/Models/DocumentsTranslations.php',
        'App\\Models\\DriverAddress' => __DIR__ . '/../..' . '/app/Models/DriverAddress.php',
        'App\\Models\\DriverDocuments' => __DIR__ . '/../..' . '/app/Models/DriverDocuments.php',
        'App\\Models\\DriverLocation' => __DIR__ . '/../..' . '/app/Models/DriverLocation.php',
        'App\\Models\\DriverOweAmount' => __DIR__ . '/../..' . '/app/Models/DriverOweAmount.php',
        'App\\Models\\DriverOweAmountPayment' => __DIR__ . '/../..' . '/app/Models/DriverOweAmountPayment.php',
        'App\\Models\\DriverPayment' => __DIR__ . '/../..' . '/app/Models/DriverPayment.php',
        'App\\Models\\EmailSettings' => __DIR__ . '/../..' . '/app/Models/EmailSettings.php',
        'App\\Models\\EmergencySos' => __DIR__ . '/../..' . '/app/Models/EmergencySos.php',
        'App\\Models\\Fees' => __DIR__ . '/../..' . '/app/Models/Fees.php',
        'App\\Models\\FilterObject' => __DIR__ . '/../..' . '/app/Models/FilterObject.php',
        'App\\Models\\FilterOption' => __DIR__ . '/../..' . '/app/Models/FilterOption.php',
        'App\\Models\\FilterOptionTranslations' => __DIR__ . '/../..' . '/app/Models/FilterOptionTranslations.php',
        'App\\Models\\Help' => __DIR__ . '/../..' . '/app/Models/Help.php',
        'App\\Models\\HelpCategory' => __DIR__ . '/../..' . '/app/Models/HelpCategory.php',
        'App\\Models\\HelpCategoryLang' => __DIR__ . '/../..' . '/app/Models/HelpCategoryLang.php',
        'App\\Models\\HelpSubCategory' => __DIR__ . '/../..' . '/app/Models/HelpSubCategory.php',
        'App\\Models\\HelpSubCategoryLang' => __DIR__ . '/../..' . '/app/Models/HelpSubCategoryLang.php',
        'App\\Models\\HelpTranslations' => __DIR__ . '/../..' . '/app/Models/HelpTranslations.php',
        'App\\Models\\JoinUs' => __DIR__ . '/../..' . '/app/Models/JoinUs.php',
        'App\\Models\\Language' => __DIR__ . '/../..' . '/app/Models/Language.php',
        'App\\Models\\Location' => __DIR__ . '/../..' . '/app/Models/Location.php',
        'App\\Models\\MakeVehicle' => __DIR__ . '/../..' . '/app/Models/MakeVehicle.php',
        'App\\Models\\ManageFare' => __DIR__ . '/../..' . '/app/Models/ManageFare.php',
        'App\\Models\\Metas' => __DIR__ . '/../..' . '/app/Models/Metas.php',
        'App\\Models\\Pages' => __DIR__ . '/../..' . '/app/Models/Pages.php',
        'App\\Models\\PasswordResets' => __DIR__ . '/../..' . '/app/Models/PasswordResets.php',
        'App\\Models\\Payment' => __DIR__ . '/../..' . '/app/Models/Payment.php',
        'App\\Models\\PaymentGateway' => __DIR__ . '/../..' . '/app/Models/PaymentGateway.php',
        'App\\Models\\PaymentMethod' => __DIR__ . '/../..' . '/app/Models/PaymentMethod.php',
        'App\\Models\\PayoutCredentials' => __DIR__ . '/../..' . '/app/Models/PayoutCredentials.php',
        'App\\Models\\PayoutPreference' => __DIR__ . '/../..' . '/app/Models/PayoutPreference.php',
        'App\\Models\\PeakFareDetail' => __DIR__ . '/../..' . '/app/Models/PeakFareDetail.php',
        'App\\Models\\Permission' => __DIR__ . '/../..' . '/app/Models/Permission.php',
        'App\\Models\\PoolTrip' => __DIR__ . '/../..' . '/app/Models/PoolTrip.php',
        'App\\Models\\ProfilePicture' => __DIR__ . '/../..' . '/app/Models/ProfilePicture.php',
        'App\\Models\\PromoCode' => __DIR__ . '/../..' . '/app/Models/PromoCode.php',
        'App\\Models\\Rating' => __DIR__ . '/../..' . '/app/Models/Rating.php',
        'App\\Models\\ReferralSetting' => __DIR__ . '/../..' . '/app/Models/ReferralSetting.php',
        'App\\Models\\ReferralUser' => __DIR__ . '/../..' . '/app/Models/ReferralUser.php',
        'App\\Models\\Request' => __DIR__ . '/../..' . '/app/Models/Request.php',
        'App\\Models\\RiderLocation' => __DIR__ . '/../..' . '/app/Models/RiderLocation.php',
        'App\\Models\\Role' => __DIR__ . '/../..' . '/app/Models/Role.php',
        'App\\Models\\ScheduleCancel' => __DIR__ . '/../..' . '/app/Models/ScheduleCancel.php',
        'App\\Models\\ScheduleRide' => __DIR__ . '/../..' . '/app/Models/ScheduleRide.php',
        'App\\Models\\SiteSettings' => __DIR__ . '/../..' . '/app/Models/SiteSettings.php',
        'App\\Models\\Support' => __DIR__ . '/../..' . '/app/Models/Support.php',
        'App\\Models\\Banner' => __DIR__ . '/../..' . '/app/Models/Banner.php',
        'App\\Models\\TollReason' => __DIR__ . '/../..' . '/app/Models/TollReason.php',
        'App\\Models\\Translatable' => __DIR__ . '/../..' . '/app/Models/Translatable.php',
        'App\\Models\\TripTollReason' => __DIR__ . '/../..' . '/app/Models/TripTollReason.php',
        'App\\Models\\Trips' => __DIR__ . '/../..' . '/app/Models/Trips.php',
        'App\\Models\\User' => __DIR__ . '/../..' . '/app/Models/User.php',
        'App\\Models\\UsersPromoCode' => __DIR__ . '/../..' . '/app/Models/UsersPromoCode.php',
        'App\\Models\\Vehicle' => __DIR__ . '/../..' . '/app/Models/Vehicle.php',
        'App\\Models\\VehicleModel' => __DIR__ . '/../..' . '/app/Models/VehicleModel.php',
        'App\\Models\\Wallet' => __DIR__ . '/../..' . '/app/Models/Wallet.php',
        'App\\Observers\\TripObserver' => __DIR__ . '/../..' . '/app/Observers/TripObserver.php',
        'App\\Observers\\UserObserver' => __DIR__ . '/../..' . '/app/Observers/UserObserver.php',
        'App\\Providers\\AppServiceProvider' => __DIR__ . '/../..' . '/app/Providers/AppServiceProvider.php',
        'App\\Providers\\AuthServiceProvider' => __DIR__ . '/../..' . '/app/Providers/AuthServiceProvider.php',
        'App\\Providers\\BroadcastServiceProvider' => __DIR__ . '/../..' . '/app/Providers/BroadcastServiceProvider.php',
        'App\\Providers\\EventServiceProvider' => __DIR__ . '/../..' . '/app/Providers/EventServiceProvider.php',
        'App\\Providers\\JWT\\IlluminateAuthAdapter' => __DIR__ . '/../..' . '/app/Providers/JWT/IlluminateAuthAdapter.php',
        'App\\Providers\\RouteServiceProvider' => __DIR__ . '/../..' . '/app/Providers/RouteServiceProvider.php',
        'App\\Providers\\StartServiceProvider' => __DIR__ . '/../..' . '/app/Providers/StartServiceProvider.php',
        'App\\Providers\\TelescopeServiceProvider' => __DIR__ . '/../..' . '/app/Providers/TelescopeServiceProvider.php',
        'App\\Repositories\\DriverOweAmountRepository' => __DIR__ . '/../..' . '/app/Repositories/DriverOweAmountRepository.php',
        'App\\Repositories\\Repository' => __DIR__ . '/../..' . '/app/Repositories/Repository.php',
        'App\\Repositories\\TripsRepository' => __DIR__ . '/../..' . '/app/Repositories/TripsRepository.php',
        'App\\Services\\Auth\\AuthViaApple' => __DIR__ . '/../..' . '/app/Services/Auth/AuthViaApple.php',
        'App\\Services\\Auth\\AuthViaEmail' => __DIR__ . '/../..' . '/app/Services/Auth/AuthViaEmail.php',
        'App\\Services\\Auth\\AuthViaFacebook' => __DIR__ . '/../..' . '/app/Services/Auth/AuthViaFacebook.php',
        'App\\Services\\Auth\\AuthViaGoogle' => __DIR__ . '/../..' . '/app/Services/Auth/AuthViaGoogle.php',
        'App\\Services\\FirebaseService' => __DIR__ . '/../..' . '/app/Services/FirebaseService.php',
        'App\\Services\\GoogleAPIService' => __DIR__ . '/../..' . '/app/Services/GoogleAPIService.php',
        'App\\Services\\LocalImageHandler' => __DIR__ . '/../..' . '/app/Services/LocalImageHandler.php',
        'App\\Services\\Payouts\\BankTransferPayout' => __DIR__ . '/../..' . '/app/Services/Payouts/BankTransferPayout.php',
        'App\\Services\\Payouts\\PaypalPayout' => __DIR__ . '/../..' . '/app/Services/Payouts/PaypalPayout.php',
        'App\\Services\\Payouts\\StripePayout' => __DIR__ . '/../..' . '/app/Services/Payouts/StripePayout.php',
        'App\\Services\\SMS\\TwillioSms' => __DIR__ . '/../..' . '/app/Services/SMS/TwillioSms.php',
        'CancelReasonsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/CancelReasonsTableSeeder.php',
        'CompaniesTableSeeder' => __DIR__ . '/../..' . '/database/seeds/CompaniesTableSeeder.php',
        'CountryTableSeeder' => __DIR__ . '/../..' . '/database/seeds/CountryTableSeeder.php',
        'CurrencyTableSeeder' => __DIR__ . '/../..' . '/database/seeds/CurrencyTableSeeder.php',
        'DatabaseSeeder' => __DIR__ . '/../..' . '/database/seeds/DatabaseSeeder.php',
        'DriverOweAmountTableSeeder' => __DIR__ . '/../..' . '/database/seeds/DriverOweAmountTableSeeder.php',
        'EmailSettingsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/EmailSettingsTableSeeder.php',
        'FareTableSeeder' => __DIR__ . '/../..' . '/database/seeds/FareTableSeeder.php',
        'FeesTableSeeder' => __DIR__ . '/../..' . '/database/seeds/FeesTableSeeder.php',
        'FilterOptionsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/FilterOptionsTableSeeder.php',
        'JoinUsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/JoinUsTableSeeder.php',
        'LanguageTableSeeder' => __DIR__ . '/../..' . '/database/seeds/LanguageTableSeeder.php',
        'LaravelEntrustSeeder' => __DIR__ . '/../..' . '/database/seeds/LaravelEntrustSeeder.php',
        'LocationsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/LocationsTableSeeder.php',
        'MakeVehicle' => __DIR__ . '/../..' . '/database/seeds/MakeVehicle.php',
        'MakeVehicleTableSeeder' => __DIR__ . '/../..' . '/database/seeds/MakeVehicleTableSeeder.php',
        'MetasTableSeeder' => __DIR__ . '/../..' . '/database/seeds/MetasTableSeeder.php',
        'PagesTableSeeder' => __DIR__ . '/../..' . '/database/seeds/PagesTableSeeder.php',
        'PaymentGatewayTableSeeder' => __DIR__ . '/../..' . '/database/seeds/PaymentGatewayTableSeeder.php',
        'PaymentTableSeeder' => __DIR__ . '/../..' . '/database/seeds/PaymentTableSeeder.php',
        'PromocodeTableSeeder' => __DIR__ . '/../..' . '/database/seeds/PromocodeTableSeeder.php',
        'ReferralSettingsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/ReferralSettingsTableSeeder.php',
        'RequestTableSeeder' => __DIR__ . '/../..' . '/database/seeds/RequestTableSeeder.php',
        'SiteSettingsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/SiteSettingsTableSeeder.php',
        'SupportTableSeeder' => __DIR__ . '/../..' . '/database/seeds/SupportTableSeeder.php',
        'Tests\\CreatesApplication' => __DIR__ . '/../..' . '/tests/CreatesApplication.php',
        'Tests\\Feature\\ExampleTest' => __DIR__ . '/../..' . '/tests/Feature/ExampleTest.php',
        'Tests\\TestCase' => __DIR__ . '/../..' . '/tests/TestCase.php',
        'Tests\\Unit\\ExampleTest' => __DIR__ . '/../..' . '/tests/Unit/ExampleTest.php',
        'TollReasonSeeder' => __DIR__ . '/../..' . '/database/seeds/TollReasonSeeder.php',
        'TripsTableSeeder' => __DIR__ . '/../..' . '/database/seeds/TripsTableSeeder.php',
        'UsersTableSeeder' => __DIR__ . '/../..' . '/database/seeds/UsersTableSeeder.php',
        'UserspromoTableSeeder' => __DIR__ . '/../..' . '/database/seeds/UserspromoTableSeeder.php',
        'VehiclesTableSeeder' => __DIR__ . '/../..' . '/database/seeds/VehiclesTableSeeder.php',
        'WalletTableSeeder' => __DIR__ . '/../..' . '/database/seeds/WalletTableSeeder.php',
        'vehicleModel' => __DIR__ . '/../..' . '/database/seeds/vehicleModel.php',
        'vehicleModelTableSeeder' => __DIR__ . '/../..' . '/database/seeds/vehicleModelTableSeeder.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit07703d1633a9d397d52e60a002d213f9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit07703d1633a9d397d52e60a002d213f9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit07703d1633a9d397d52e60a002d213f9::$classMap;

        }, null, ClassLoader::class);
    }
}
