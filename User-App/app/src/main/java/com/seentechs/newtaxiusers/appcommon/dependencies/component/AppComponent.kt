package com.seentechs.newtaxiusers.appcommon.dependencies.component

/**
 *  newtaxiusers
 * @subpackage dependencies.component
 * @category AppComponent
 *  
 *
 */


import com.seentechs.newtaxiusers.taxiapp.firebase_auth.OTPActivity
import com.seentechs.newtaxiusers.taxiapp.firebase_auth.PhoneActivity
import com.seentechs.newtaxiusers.taxiapp.ScheduleRideDetailActivity
import com.seentechs.newtaxiusers.taxiapp.adapters.CarDetailsListAdapter

import com.seentechs.newtaxiusers.taxiapp.adapters.PastTripsPaginationAdapter
import com.seentechs.newtaxiusers.taxiapp.adapters.PriceRecycleAdapter
import com.seentechs.newtaxiusers.taxiapp.adapters.UpcomingAdapter
import com.seentechs.newtaxiusers.taxiapp.adapters.UpcomingTripsPaginationAdapter
import com.seentechs.newtaxiusers.appcommon.backgroundtask.ImageCompressAsyncTask
import com.seentechs.newtaxiusers.appcommon.configs.RunTimePermission
import com.seentechs.newtaxiusers.appcommon.configs.SessionManager
import com.seentechs.newtaxiusers.taxiapp.database.AddFirebaseDatabase
import com.seentechs.newtaxiusers.appcommon.dependencies.module.AppContainerModule
import com.seentechs.newtaxiusers.appcommon.dependencies.module.ApplicationModule
import com.seentechs.newtaxiusers.appcommon.dependencies.module.NetworkModule
import com.seentechs.newtaxiusers.appcommon.helper.CommonDialog
import com.seentechs.newtaxiusers.appcommon.drawpolyline.DownloadTask
import com.seentechs.newtaxiusers.appcommon.pushnotification.MyFirebaseInstanceIDService
import com.seentechs.newtaxiusers.appcommon.pushnotification.MyFirebaseMessagingService
import com.seentechs.newtaxiusers.taxiapp.sendrequest.CancelYourTripActivity
import com.seentechs.newtaxiusers.taxiapp.sendrequest.DriverNotAcceptActivity
import com.seentechs.newtaxiusers.taxiapp.sendrequest.DriverRatingActivity
import com.seentechs.newtaxiusers.taxiapp.sendrequest.SendingRequestActivity
import com.seentechs.newtaxiusers.taxiapp.sidebar.AddHome
import com.seentechs.newtaxiusers.taxiapp.sidebar.DriverContactActivity
import com.seentechs.newtaxiusers.taxiapp.sidebar.EnRoute
import com.seentechs.newtaxiusers.taxiapp.sidebar.FareBreakdown
import com.seentechs.newtaxiusers.taxiapp.sidebar.Profile
import com.seentechs.newtaxiusers.taxiapp.sidebar.Setting
import com.seentechs.newtaxiusers.taxiapp.sidebar.referral.ShowReferralOptions
import com.seentechs.newtaxiusers.taxiapp.sidebar.trips.Past
import com.seentechs.newtaxiusers.taxiapp.sidebar.trips.Receipt
import com.seentechs.newtaxiusers.taxiapp.sidebar.trips.TripDetails
import com.seentechs.newtaxiusers.taxiapp.sidebar.trips.Upcoming
import com.seentechs.newtaxiusers.taxiapp.sidebar.trips.YourTrips
import com.seentechs.newtaxiusers.appcommon.utils.CommonMethods
import com.seentechs.newtaxiusers.appcommon.utils.RequestCallback
import com.seentechs.newtaxiusers.appcommon.utils.userchoice.UserChoice
import com.seentechs.newtaxiusers.appcommon.views.*
import com.seentechs.newtaxiusers.taxiapp.views.addCardDetails.AddCardActivity
import com.seentechs.newtaxiusers.taxiapp.views.facebookAccountKit.FacebookAccountKitActivity
import com.seentechs.newtaxiusers.taxiapp.views.emergency.EmergencyContact
import com.seentechs.newtaxiusers.taxiapp.views.emergency.SosActivity
import com.seentechs.newtaxiusers.taxiapp.views.firebaseChat.ActivityChat
import com.seentechs.newtaxiusers.taxiapp.views.firebaseChat.AdapterFirebaseRecylcerview
import com.seentechs.newtaxiusers.taxiapp.views.firebaseChat.FirebaseChatHandler
import com.seentechs.newtaxiusers.taxiapp.views.main.MainActivity
import com.seentechs.newtaxiusers.taxiapp.views.main.filter.FeaturesInVehicleAdapter
import com.seentechs.newtaxiusers.taxiapp.views.peakPricing.PeakPricing
import com.seentechs.newtaxiusers.taxiapp.views.search.PlaceSearchActivity
import com.seentechs.newtaxiusers.taxiapp.views.signinsignup.*
import com.seentechs.newtaxiusers.taxiapp.views.splash.SplashActivity
import com.seentechs.newtaxiusers.taxiapp.views.voip.CallProcessingActivity
import com.seentechs.newtaxiusers.taxiapp.views.voip.NewTaxiSinchService

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
