package com.seentechs.newtaxiusers.appcommon.dependencies.component

/**
 *  newtaxiusers
 * @subpackage dependencies.component
 * @category AppComponent
 *  
 *
 */


import com.tkpmnc.newtaxiusers.taxiapp.firebase_auth.OTPActivity
import com.tkpmnc.newtaxiusers.taxiapp.firebase_auth.PhoneActivity
import com.tkpmnc.newtaxiusers.taxiapp.ScheduleRideDetailActivity
import com.tkpmnc.newtaxiusers.taxiapp.adapters.CarDetailsListAdapter

import com.tkpmnc.newtaxiusers.taxiapp.adapters.PastTripsPaginationAdapter
import com.tkpmnc.newtaxiusers.taxiapp.adapters.PriceRecycleAdapter
import com.tkpmnc.newtaxiusers.taxiapp.adapters.UpcomingAdapter
import com.tkpmnc.newtaxiusers.taxiapp.adapters.UpcomingTripsPaginationAdapter
import com.tkpmnc.newtaxiusers.appcommon.backgroundtask.ImageCompressAsyncTask
import com.tkpmnc.newtaxiusers.appcommon.configs.RunTimePermission
import com.tkpmnc.newtaxiusers.appcommon.configs.SessionManager
import com.tkpmnc.newtaxiusers.taxiapp.database.AddFirebaseDatabase
import com.tkpmnc.newtaxiusers.appcommon.dependencies.module.AppContainerModule
import com.tkpmnc.newtaxiusers.appcommon.dependencies.module.ApplicationModule
import com.tkpmnc.newtaxiusers.appcommon.dependencies.module.NetworkModule
import com.tkpmnc.newtaxiusers.appcommon.helper.CommonDialog
import com.tkpmnc.newtaxiusers.appcommon.drawpolyline.DownloadTask
import com.tkpmnc.newtaxiusers.appcommon.pushnotification.MyFirebaseInstanceIDService
import com.tkpmnc.newtaxiusers.appcommon.pushnotification.MyFirebaseMessagingService
import com.tkpmnc.newtaxiusers.taxiapp.sendrequest.CancelYourTripActivity
import com.tkpmnc.newtaxiusers.taxiapp.sendrequest.DriverNotAcceptActivity
import com.tkpmnc.newtaxiusers.taxiapp.sendrequest.DriverRatingActivity
import com.tkpmnc.newtaxiusers.taxiapp.sendrequest.SendingRequestActivity
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.AddHome
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.DriverContactActivity
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.EnRoute
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.FareBreakdown
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.Profile
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.Setting
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.referral.ShowReferralOptions
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.trips.Past
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.trips.Receipt
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.trips.TripDetails
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.trips.Upcoming
import com.tkpmnc.newtaxiusers.taxiapp.sidebar.trips.YourTrips
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.newtaxiusers.appcommon.utils.RequestCallback
import com.tkpmnc.newtaxiusers.appcommon.utils.userchoice.UserChoice
import com.tkpmnc.newtaxiusers.appcommon.views.*
import com.tkpmnc.newtaxiusers.taxiapp.views.addCardDetails.AddCardActivity
import com.tkpmnc.newtaxiusers.taxiapp.views.facebookAccountKit.FacebookAccountKitActivity
import com.tkpmnc.newtaxiusers.taxiapp.views.emergency.EmergencyContact
import com.tkpmnc.newtaxiusers.taxiapp.views.emergency.SosActivity
import com.tkpmnc.newtaxiusers.taxiapp.views.firebaseChat.ActivityChat
import com.tkpmnc.newtaxiusers.taxiapp.views.firebaseChat.AdapterFirebaseRecylcerview
import com.tkpmnc.newtaxiusers.taxiapp.views.firebaseChat.FirebaseChatHandler
import com.tkpmnc.newtaxiusers.taxiapp.views.main.MainActivity
import com.tkpmnc.newtaxiusers.taxiapp.views.main.filter.FeaturesInVehicleAdapter
import com.tkpmnc.newtaxiusers.taxiapp.views.peakPricing.PeakPricing
import com.tkpmnc.newtaxiusers.taxiapp.views.search.PlaceSearchActivity
import com.tkpmnc.newtaxiusers.taxiapp.views.signinsignup.*
import com.tkpmnc.newtaxiusers.taxiapp.views.splash.SplashActivity
import com.tkpmnc.newtaxiusers.taxiapp.views.voip.CallProcessingActivity
import com.tkpmnc.newtaxiusers.taxiapp.views.voip.NewTaxiSinchService

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

    fun inject(fareBreakdown: FareBreakdown)

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


    fun inject(featuresInVehicleAdapter: FeaturesInVehicleAdapter)

    fun inject(supportActivityCommon: SupportActivityCommon)

    fun inject(supportAdapter: SupportAdapter)

    fun inject(bannerActivityCommon: BannerActivityCommon)

    fun inject(bannerAdapter: BannerAdapter)

    fun inject(commonActivity: CommonActivity)

    fun inject(userChoice: UserChoice)

}
