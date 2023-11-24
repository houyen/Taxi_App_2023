package com.tkpmnc.sgtaxiusers.appcommon.dependencies.component

/**
 * @package com.tkpmnc.sgtaxiusers
 * @subpackage dependencies.component
 * @category AppComponent
 * @author Seen Technologies
 *
 */


import com.tkpmnc.sgtaxiusers.taxiapp.firebase_auth.OTPActivity
import com.tkpmnc.sgtaxiusers.taxiapp.firebase_auth.PhoneActivity
import com.tkpmnc.sgtaxiusers.taxiapp.ScheduleRideDetailActivity
import com.tkpmnc.sgtaxiusers.taxiapp.adapters.CarDetailsListAdapter

import com.tkpmnc.sgtaxiusers.taxiapp.adapters.PastTripsPaginationAdapter
import com.tkpmnc.sgtaxiusers.taxiapp.adapters.PriceRecycleAdapter
import com.tkpmnc.sgtaxiusers.taxiapp.adapters.UpcomingAdapter
import com.tkpmnc.sgtaxiusers.taxiapp.adapters.UpcomingTripsPaginationAdapter
import com.tkpmnc.sgtaxiusers.appcommon.backgroundtask.ImageCompressAsyncTask
import com.tkpmnc.sgtaxiusers.appcommon.configs.RunTimePermission
import com.tkpmnc.sgtaxiusers.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiusers.taxiapp.database.AddFirebaseDatabase
import com.tkpmnc.sgtaxiusers.appcommon.dependencies.module.AppContainerModule
import com.tkpmnc.sgtaxiusers.appcommon.dependencies.module.ApplicationModule
import com.tkpmnc.sgtaxiusers.appcommon.dependencies.module.NetworkModule
import com.tkpmnc.sgtaxiusers.appcommon.helper.CommonDialog
import com.tkpmnc.sgtaxiusers.appcommon.drawpolyline.DownloadTask
import com.tkpmnc.sgtaxiusers.appcommon.pushnotification.MyFirebaseInstanceIDService
import com.tkpmnc.sgtaxiusers.appcommon.pushnotification.MyFirebaseMessagingService
import com.tkpmnc.sgtaxiusers.taxiapp.sendrequest.CancelYourTripActivity
import com.tkpmnc.sgtaxiusers.taxiapp.sendrequest.DriverNotAcceptActivity
import com.tkpmnc.sgtaxiusers.taxiapp.sendrequest.DriverRatingActivity
import com.tkpmnc.sgtaxiusers.taxiapp.sendrequest.PaymentAmountPage
import com.tkpmnc.sgtaxiusers.taxiapp.sendrequest.SendingRequestActivity
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.AddHome
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.DriverContactActivity
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.EnRoute
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.FareBreakdown
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.Profile
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.Setting
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.payment.*
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.referral.ShowReferralOptions
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.trips.Past
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.trips.Receipt
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.trips.TripDetails
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.trips.Upcoming
import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.trips.YourTrips
import com.tkpmnc.sgtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiusers.appcommon.utils.RequestCallback
import com.tkpmnc.sgtaxiusers.appcommon.utils.userchoice.UserChoice
import com.tkpmnc.sgtaxiusers.appcommon.views.*
import com.tkpmnc.sgtaxiusers.taxiapp.views.addCardDetails.AddCardActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.facebookAccountKit.FacebookAccountKitActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.emergency.EmergencyContact
import com.tkpmnc.sgtaxiusers.taxiapp.views.emergency.SosActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.firebaseChat.ActivityChat
import com.tkpmnc.sgtaxiusers.taxiapp.views.firebaseChat.AdapterFirebaseRecylcerview
import com.tkpmnc.sgtaxiusers.taxiapp.views.firebaseChat.FirebaseChatHandler
import com.tkpmnc.sgtaxiusers.taxiapp.views.main.MainActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.main.filter.FeaturesInVehicleAdapter
import com.tkpmnc.sgtaxiusers.taxiapp.views.peakPricing.PeakPricing
import com.tkpmnc.sgtaxiusers.taxiapp.views.search.PlaceSearchActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.signinsignup.*
import com.tkpmnc.sgtaxiusers.taxiapp.views.splash.SplashActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.voip.CallProcessingActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.voip.NewTaxiSinchService

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
