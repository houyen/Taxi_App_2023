package com.tkpmnc.sgtaxidriver.common.dependencies.component

/**
 * @package com.tkpmnc.sgtaxidriver
 * @subpackage dependencies.component
 * @category AppComponent
 * 
 *
 */

import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.common.database.AddFirebaseDatabase
import com.tkpmnc.sgtaxidriver.common.dependencies.module.AppContainerModule
import com.tkpmnc.sgtaxidriver.common.dependencies.module.ApplicationModule
import com.tkpmnc.sgtaxidriver.common.dependencies.module.ImageCompressAsyncTask
import com.tkpmnc.sgtaxidriver.common.dependencies.module.NetworkModule
import com.tkpmnc.sgtaxidriver.common.helper.CarTypeAdapter
import com.tkpmnc.sgtaxidriver.common.helper.CommonDialog
import com.tkpmnc.sgtaxidriver.common.helper.RunTimePermission
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import com.tkpmnc.sgtaxidriver.common.util.RequestCallback
import com.tkpmnc.sgtaxidriver.common.util.userchoice.UserChoice
import com.tkpmnc.sgtaxidriver.common.views.*
import com.tkpmnc.sgtaxidriver.google.direction.GetDirectionData
import com.tkpmnc.sgtaxidriver.google.locationmanager.*
import com.tkpmnc.sgtaxidriver.home.MainActivity
import com.tkpmnc.sgtaxidriver.home.facebookAccountKit.FacebookAccountKitActivity
import com.tkpmnc.sgtaxidriver.home.firebaseChat.ActivityChat
import com.tkpmnc.sgtaxidriver.home.firebaseChat.AdapterFirebaseRecylcerview
import com.tkpmnc.sgtaxidriver.home.firebaseChat.FirebaseChatHandler
import com.tkpmnc.sgtaxidriver.home.fragments.AccountFragment
import com.tkpmnc.sgtaxidriver.home.fragments.EarningActivity
import com.tkpmnc.sgtaxidriver.home.fragments.HomeFragment
import com.tkpmnc.sgtaxidriver.home.fragments.RatingActivity
import com.tkpmnc.sgtaxidriver.home.fragments.Referral.ShowReferralOptionsActivity
import com.tkpmnc.sgtaxidriver.home.fragments.currency.CurrencyListAdapter
import com.tkpmnc.sgtaxidriver.home.fragments.language.LanguageAdapter
import com.tkpmnc.sgtaxidriver.home.managevehicles.*
import com.tkpmnc.sgtaxidriver.home.managevehicles.adapter.*
import com.tkpmnc.sgtaxidriver.home.map.GpsService
import com.tkpmnc.sgtaxidriver.home.map.drawpolyline.DownloadTask
import com.tkpmnc.sgtaxidriver.home.payouts.*
import com.tkpmnc.sgtaxidriver.home.profile.DriverProfile
import com.tkpmnc.sgtaxidriver.home.profile.VehiclInformation
import com.tkpmnc.sgtaxidriver.home.pushnotification.MyFirebaseInstanceIDService
import com.tkpmnc.sgtaxidriver.home.pushnotification.MyFirebaseMessagingService
import com.tkpmnc.sgtaxidriver.home.service.ForeService
import com.tkpmnc.sgtaxidriver.home.service.LocationService
import com.tkpmnc.sgtaxidriver.home.signinsignup.*
import com.tkpmnc.sgtaxidriver.home.splash.SplashActivity
import com.tkpmnc.sgtaxidriver.trips.*
import com.tkpmnc.sgtaxidriver.trips.rating.*
import com.tkpmnc.sgtaxidriver.trips.tripsdetails.*
import com.tkpmnc.sgtaxidriver.trips.viewmodel.ReqAccpVM
import com.tkpmnc.sgtaxidriver.trips.voip.CallProcessingActivity
import com.tkpmnc.sgtaxidriver.trips.voip.NewTaxiSinchService
import com.tkpmnc.sgtaxidriver.common.views.FlutterwaveWebViewActivity
import com.tkpmnc.sgtaxidriver.home.firebase_auth.OTPActivity
import com.tkpmnc.sgtaxidriver.home.firebase_auth.PhoneActivity
import dagger.Component
import javax.inject.Singleton


/*****************************************************************
 * App Component
 */
@Singleton
@Component(modules = [NetworkModule::class, ApplicationModule::class, AppContainerModule::class])
interface AppComponent {
    // ACTIVITY

    fun inject(currencyListAdapter: CurrencyListAdapter)

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

    fun inject(payStatementDetails: PayStatementDetails)

    fun inject(tripEarningsDetail: TripEarningsDetail)

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

    fun inject(locationService: LocationService)

    fun inject(firebaseDatabase: AddFirebaseDatabase)


    fun inject(flutterwaveWebViewActivity: FlutterwaveWebViewActivity)

    fun inject(manageVehicles: ManageVehicles)


    fun inject(manageDocumentActivity: ManageVehicleDocumentFragment)

    fun inject(callProcessingActivity: CallProcessingActivity)

    fun inject(priceRecycleAdapter: PriceRecycleAdapter)

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

    fun inject(commonActivity: CommonActivity)

    fun inject(commonDialog: CommonDialog)

    fun inject(commentsPaginationAdapter: CommentsPaginationAdapter)

    fun inject(userChoice: UserChoice)

    fun inject(commentsRecycleAdapter: CommentsRecycleAdapter)
    //fun inject(applicationContext: Context)

}
