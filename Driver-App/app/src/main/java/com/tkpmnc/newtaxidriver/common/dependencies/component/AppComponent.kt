package com.tkpmnc.newtaxidriver.common.dependencies.component

/**
 * @subpackage dependencies.component
 * @category AppComponent
 *
 */

import com.tkpmnc.newtaxidriver.common.configs.SessionManager
import com.tkpmnc.newtaxidriver.common.database.AddFirebaseDatabase
import com.tkpmnc.newtaxidriver.common.dependencies.module.AppContainerModule
import com.tkpmnc.newtaxidriver.common.dependencies.module.ApplicationModule
import com.tkpmnc.newtaxidriver.common.dependencies.module.ImageCompressAsyncTask
import com.tkpmnc.newtaxidriver.common.dependencies.module.NetworkModule
import com.tkpmnc.newtaxidriver.common.helper.CarTypeAdapter
import com.tkpmnc.newtaxidriver.common.helper.CommonDialog
import com.tkpmnc.newtaxidriver.common.helper.RunTimePermission
import com.tkpmnc.newtaxidriver.common.util.CommonMethods
import com.tkpmnc.newtaxidriver.common.util.RequestCallback
import com.tkpmnc.newtaxidriver.common.util.userchoice.UserChoice
import com.tkpmnc.newtaxidriver.common.views.*
import com.tkpmnc.newtaxidriver.google.direction.GetDirectionData
import com.tkpmnc.newtaxidriver.google.locationmanager.*
import com.tkpmnc.newtaxidriver.home.MainActivity
import com.tkpmnc.newtaxidriver.home.facebookAccountKit.FacebookAccountKitActivity
import com.tkpmnc.newtaxidriver.home.firebaseChat.ActivityChat
import com.tkpmnc.newtaxidriver.home.firebaseChat.AdapterFirebaseRecylcerview
import com.tkpmnc.newtaxidriver.home.firebaseChat.FirebaseChatHandler
import com.tkpmnc.newtaxidriver.home.fragments.AccountFragment
import com.tkpmnc.newtaxidriver.home.fragments.EarningActivity
import com.tkpmnc.newtaxidriver.home.fragments.HomeFragment
import com.tkpmnc.newtaxidriver.home.fragments.RatingActivity
import com.tkpmnc.newtaxidriver.home.fragments.language.LanguageAdapter
import com.tkpmnc.newtaxidriver.home.managevehicles.*
import com.tkpmnc.newtaxidriver.home.managevehicles.adapter.*
import com.tkpmnc.newtaxidriver.home.map.GpsService
import com.tkpmnc.newtaxidriver.home.map.drawpolyline.DownloadTask
import com.tkpmnc.newtaxidriver.home.profile.DriverProfile
import com.tkpmnc.newtaxidriver.home.profile.VehiclInformation
import com.tkpmnc.newtaxidriver.home.pushnotification.MyFirebaseInstanceIDService
import com.tkpmnc.newtaxidriver.home.pushnotification.MyFirebaseMessagingService
import com.tkpmnc.newtaxidriver.home.service.ForeService
import com.tkpmnc.newtaxidriver.home.service.LocationService
import com.tkpmnc.newtaxidriver.home.signinsignup.*
import com.tkpmnc.newtaxidriver.home.splash.SplashActivity
import com.tkpmnc.newtaxidriver.trips.*
import com.tkpmnc.newtaxidriver.trips.rating.*
import com.tkpmnc.newtaxidriver.trips.tripsdetails.*
import com.tkpmnc.newtaxidriver.trips.viewmodel.ReqAccpVM
import com.tkpmnc.newtaxidriver.trips.voip.CallProcessingActivity
import com.tkpmnc.newtaxidriver.trips.voip.NewTaxiSinchService
import com.tkpmnc.newtaxidriver.common.views.FlutterwaveWebViewActivity
import com.tkpmnc.newtaxidriver.home.firebase_auth.OTPActivity
import com.tkpmnc.newtaxidriver.home.firebase_auth.PhoneActivity
import dagger.Component
import javax.inject.Singleton


/*****************************************************************
 * App Component
 */
@Singleton
@Component(modules = [NetworkModule::class, ApplicationModule::class, AppContainerModule::class])
interface AppComponent {
    // ACTIVITY


    fun inject(priceStatementAdapter: PriceStatementAdapter)

    fun inject(driverDetailsAdapter: DriverDetailsAdapter)

    fun inject(sessionManager: SessionManager)

    fun inject(pendingTripsFragment: PendingTripsFragment)

    fun inject(accountFragment: AccountFragment)

    fun inject(viewDocumentFragment: ViewVehicleDocumentFragment)

    fun inject(homeFragment: HomeFragment)

    fun inject(past: CompletedTripsFragments)

    fun inject(ratingFragment: RatingActivity)

    fun inject(comments: Comments)

    fun inject(yourTrips: YourTrips)

    fun inject(carTypeAdapter: CarTypeAdapter)

    fun inject(tripDetails: TripDetails)

    fun inject(ManageVehicleActivity: ManageVehicleFragment)
    
    fun inject(vehicleTypeAdapter: VehicleTypeAdapter)

    fun inject(earningFragment: EarningActivity)

    fun inject(mainActivity: MainActivity)

    fun inject(signinSignupHomeActivity: SigninSignupHomeActivity)

    fun inject(splashActivity: SplashActivity)

    fun inject(riderProfilePage: RiderProfilePage)

    fun inject(setting_Activity: SettingActivity)

    fun inject(requestReceiveActivity: RequestReceiveActivity)

    fun inject(manageDriverDocFrag: ManageDriverDocumentFragment)

    fun inject(viewVehicleDocFrag: ViewDriverDocumentFragment)

    fun inject(requestAcceptActivity: RequestAcceptActivity)

    fun inject(riderContactActivity: RiderContactActivity)

    fun inject(cancelYourTripActivity: CancelYourTripActivity)

    fun inject(documentDetails: DocumentDetails)

    fun inject(tripEarningsDetail: TripEarningsDetail)

    fun inject(dailyEarningDetails: DailyEarningDetails)

    fun inject(riderrating: Riderrating)

    fun inject(gps_service: GpsService)

    fun inject(registerCarDetailsActivity: RegisterCarDetailsActivity)

    fun inject(resetPassword: ResetPassword)

    fun inject(register: Register)


    fun inject(registerOTPActivity: RegisterOTPActivity)

    fun inject(commonMethods: CommonMethods)

    fun inject(MobileActivity: MobileActivity)

    fun inject(signinActivity: SigninActivity)

    fun inject(requestCallback: RequestCallback)

    fun inject(runTimePermission: RunTimePermission)

    fun inject(driverProfile: DriverProfile)

    fun inject(vehiclInformation: VehiclInformation)

    fun inject(riderFeedBack: RiderFeedBack)

    fun inject(activityChat: ActivityChat)

    fun inject(facebookAccountKitActivity: FacebookAccountKitActivity)

    fun inject(phoneActivity: PhoneActivity)

    fun inject(otpActivity: OTPActivity)
    // Adapters
    fun inject(manageVehicleAdapter: ManageVehicleAdapter)

    fun inject(yearAdapter: YearAdapter)

    fun inject(languageAdapter: LanguageAdapter)

    fun inject(addVehicle: AddVehicleFragment)

    fun inject(manageDocumentsAdapter: ManageDocumentsAdapter)

    fun inject(myFirebaseMessagingService: MyFirebaseMessagingService)

    fun inject(myFirebaseInstanceIDService: MyFirebaseInstanceIDService)

    fun inject(imageCompressAsyncTask: ImageCompressAsyncTask)

    fun inject(firebaseChatHandler: FirebaseChatHandler)

    fun inject(adapterFirebaseRecylcerview: AdapterFirebaseRecylcerview)

    fun inject(makeAdapter: MakeAdapter)

    fun inject(modelAdapter: ModelAdapter)

    fun inject(reqAccpVM: ReqAccpVM)

    //    service

    fun inject(downloadTask: DownloadTask)

    fun inject(foreService: ForeService)


    fun inject(newTaxiSinchService: NewTaxiSinchService)

    //fun inject(workerUtils: WorkerUtils)


    //fun inject(updateGPSWorker: UpdateGPSWorker)


    fun inject(locationService: LocationService)

    fun inject(firebaseDatabase: AddFirebaseDatabase)


    fun inject(flutterwaveWebViewActivity: FlutterwaveWebViewActivity)

    fun inject(manageVehicles: ManageVehicles)

    fun inject(addCardActivity: AddCardActivity)

    fun inject(manageDocumentActivity: ManageVehicleDocumentFragment)

    fun inject(callProcessingActivity: CallProcessingActivity)

    fun inject(priceRecycleAdapter: PriceRecycleAdapter)


    fun inject(upcomingTripsPaginationAdapter: PendingTripsPaginationAdapter)

    fun inject(pastTripsPaginationAdapter: CompletedTripsPaginationAdapter)

    fun inject(featuresInVehicleAdapter: FeaturesInVehicleAdapter)


    /**
     * Live Tracking Injects
     */
    fun inject(getDirectionData: GetDirectionData)

    fun inject(updateLocations: UpdateLocations)

    fun inject(trackingServiceListener: TrackingServiceListener)

    fun inject(trackingService: TrackingService)

    fun inject(androidPositionProvider: AndroidPositionProvider)

    fun inject(trackingController: TrackingController)

    fun inject(supportActivityCommon: SupportActivityCommon)

    fun inject(supportAdapter: SupportAdapter)

    fun inject(payStatementPaginationAdapter: PayStatementPaginationAdapter)

    fun inject(dailyEarnPaginationAdapter: DailyEarnPaginationAdapter)

    fun inject(dailyHoursPaginationAdapter: DailyHoursPaginationAdapter)

    fun inject(dailyEarnListAdapter: DailyEarnListAdapter)

    fun inject(commonActivity: CommonActivity)

    fun inject(commonDialog: CommonDialog)

    fun inject(commentsPaginationAdapter: CommentsPaginationAdapter)

    fun inject(userChoice: UserChoice)

    fun inject(commentsRecycleAdapter: CommentsRecycleAdapter)
    //fun inject(applicationContext: Context)

}
