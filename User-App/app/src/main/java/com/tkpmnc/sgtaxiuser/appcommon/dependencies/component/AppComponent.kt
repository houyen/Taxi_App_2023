package com.tkpmnc.sgtaxiuser.appcommon.dependencies.component

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage dependencies.component
 * @category AppComponent
 * 
 *
 */


import com.tkpmnc.sgtaxiuser.taxiapp.firebase_auth.OTPActivity
import com.tkpmnc.sgtaxiuser.taxiapp.firebase_auth.PhoneActivity
import com.tkpmnc.sgtaxiuser.taxiapp.ScheduleRideDetailActivity
import com.tkpmnc.sgtaxiuser.taxiapp.adapters.CarDetailsListAdapter

import com.tkpmnc.sgtaxiuser.taxiapp.adapters.PastTripsPaginationAdapter
import com.tkpmnc.sgtaxiuser.taxiapp.adapters.PriceRecycleAdapter
import com.tkpmnc.sgtaxiuser.taxiapp.adapters.UpcomingAdapter
import com.tkpmnc.sgtaxiuser.taxiapp.adapters.UpcomingTripsPaginationAdapter
import com.tkpmnc.sgtaxiuser.appcommon.backgroundtask.ImageCompressAsyncTask
import com.tkpmnc.sgtaxiuser.appcommon.configs.RunTimePermission
import com.tkpmnc.sgtaxiuser.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiuser.taxiapp.database.AddFirebaseDatabase
import com.tkpmnc.sgtaxiuser.appcommon.dependencies.module.AppContainerModule
import com.tkpmnc.sgtaxiuser.appcommon.dependencies.module.ApplicationModule
import com.tkpmnc.sgtaxiuser.appcommon.dependencies.module.NetworkModule
import com.tkpmnc.sgtaxiuser.appcommon.helper.CommonDialog
import com.tkpmnc.sgtaxiuser.appcommon.drawpolyline.DownloadTask
import com.tkpmnc.sgtaxiuser.appcommon.pushnotification.MyFirebaseInstanceIDService
import com.tkpmnc.sgtaxiuser.appcommon.pushnotification.MyFirebaseMessagingService
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.CancelYourTripActivity
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.DriverNotAcceptActivity
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.DriverRatingActivity
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.PaymentAmountPage
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.SendingRequestActivity
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.AddHome
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.DriverContactActivity
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.EnRoute
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.FareBreakdown
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.Profile
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.Setting
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.payment.*
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.referral.ShowReferralOptions
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.trips.Past
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.trips.Receipt
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.trips.TripDetails
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.trips.Upcoming
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.trips.YourTrips
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiuser.appcommon.utils.RequestCallback
import com.tkpmnc.sgtaxiuser.appcommon.utils.userchoice.UserChoice
import com.tkpmnc.sgtaxiuser.appcommon.views.*
import com.tkpmnc.sgtaxiuser.taxiapp.views.addCardDetails.AddCardActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.facebookAccountKit.FacebookAccountKitActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.emergency.EmergencyContact
import com.tkpmnc.sgtaxiuser.taxiapp.views.emergency.SosActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.firebaseChat.ActivityChat
import com.tkpmnc.sgtaxiuser.taxiapp.views.firebaseChat.AdapterFirebaseRecylcerview
import com.tkpmnc.sgtaxiuser.taxiapp.views.firebaseChat.FirebaseChatHandler
import com.tkpmnc.sgtaxiuser.taxiapp.views.main.MainActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.main.filter.FeaturesInVehicleAdapter
import com.tkpmnc.sgtaxiuser.taxiapp.views.peakPricing.PeakPricing
import com.tkpmnc.sgtaxiuser.taxiapp.views.search.PlaceSearchActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.signinsignup.*
import com.tkpmnc.sgtaxiuser.taxiapp.views.splash.SplashActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.voip.CallProcessingActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.voip.NewTaxiSinchService

import javax.inject.Singleton

import dagger.Component


/*****************************************************************
 * App Component
 */
@Singleton
@Component(modules = [NetworkModule::class, ApplicationModule::class, AppContainerModule::class])
interface AppComponent {

    fun inject(splashActivity: SplashActivity)

    fun inject(mainActivity: MainActivity)

    fun inject(scheduleRideDetailActivity: ScheduleRideDetailActivity)

    fun inject(sendingRequestActivity: SendingRequestActivity)

    fun inject(driverNotAcceptActivity: DriverNotAcceptActivity)

    fun inject(mainActivity: PlaceSearchActivity)

    fun inject(signin_signup_activity: SigninSignupActivity)

    fun inject(otpActivity: OTPActivity)

    fun inject(phoneActivity: PhoneActivity)

    fun inject(ssResetPassword: SSResetPassword)

    fun inject(ssSocialDetailsActivity: SSRegisterActivity)

    fun inject(driverContactActivity: DriverContactActivity)

    fun inject(addHome: AddHome)

    fun inject(paymentPage: PaymentPage)

    fun inject(paymentAmountPage: PaymentAmountPage)

    fun inject(fareBreakdown: FareBreakdown)

    fun inject(addWalletActivity: AddWalletActivity)

    fun inject(promoAmountActivity: PromoAmountActivity)

    fun inject(yourTrips: YourTrips)

    fun inject(tripDetails: TripDetails)

    fun inject(enRoute: EnRoute)

    fun inject(sos_activity: SosActivity)

    fun inject(driverRatingActivity: DriverRatingActivity)

    fun inject(cancelYourTripActivity: CancelYourTripActivity)

    fun inject(commonDialog: CommonDialog)

    fun inject(setting: Setting)

    fun inject(profile: Profile)


    fun inject(emergencyContact: EmergencyContact)

    fun inject(activityChat: ActivityChat)

    fun inject(facebookAccountKitActivity: FacebookAccountKitActivity)

    fun inject(loginActivity: SSLoginActivity)

    fun inject(peakPricing: PeakPricing)

    fun inject(showReferralOptions: ShowReferralOptions)

    fun inject(callProcessingActivity: CallProcessingActivity)

    fun inject(NewTaxiSinchService: NewTaxiSinchService)

    // Fragments
    fun inject(past: Past)

    fun inject(upcoming: Upcoming)

    fun inject(receipt: Receipt)

    // Utilities
    fun inject(runTimePermission: RunTimePermission)

    fun inject(sessionManager: SessionManager)

    fun inject(commonMethods: CommonMethods)

    fun inject(requestCallback: RequestCallback)

    // Adapters

    fun inject(upcomingAdapter: UpcomingAdapter)


    fun inject(promoAmountAdapter: PromoAmountAdapter)

    fun inject(carDetailsListAdapter: CarDetailsListAdapter)

    fun inject(myFirebaseMessagingService: MyFirebaseMessagingService)

    fun inject(myFirebaseInstanceIDService: MyFirebaseInstanceIDService)

    fun inject(firebaseChatHandler: FirebaseChatHandler)

    fun inject(adapterFirebaseRecylcerview: AdapterFirebaseRecylcerview)


    // AsyncTask
    fun inject(imageCompressAsyncTask: ImageCompressAsyncTask)

    fun inject(downloadTask: DownloadTask)

    fun inject(firebaseDatabase: AddFirebaseDatabase)


    fun inject(priceRecycleAdapter: PriceRecycleAdapter)

    fun inject(pastTripsPaginationAdapter: PastTripsPaginationAdapter)

    fun inject(upcomingTripsPaginationAdapter: UpcomingTripsPaginationAdapter)
     fun inject(addCardActivity: AddCardActivity)
    fun inject(paymentMethodAdapter: PaymentMethodAdapter)
    fun inject(featuresInVehicleAdapter: FeaturesInVehicleAdapter)

    fun inject(supportActivityCommon: SupportActivityCommon)

    fun inject(supportAdapter: SupportAdapter)

    fun inject(bannerActivityCommon: BannerActivityCommon)

    fun inject(bannerAdapter: BannerAdapter)

    fun inject(paymentWebViewActivity: PaymentWebViewActivity)
    fun inject(paytmPaymentWebViewActivity: PaytmPaymentWebViewActivity)
    fun inject(mpesaPaymentWebViewActivity: MpesaPaymentWebViewActivity)
    fun inject(flutterwavePaymentWebViewActivity: FlutterwaveWebViewActivity)

    fun inject(commonActivity: CommonActivity)

    fun inject(userChoice: UserChoice)

}
