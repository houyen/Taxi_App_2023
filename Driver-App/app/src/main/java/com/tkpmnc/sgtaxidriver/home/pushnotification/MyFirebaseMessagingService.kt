package com.tkpmnc.sgtaxidriver.home.pushnotification

/**
 * @package com.tkpmnc.sgtaxidriver.home.pushnotification
 * @subpackage pushnotification model
 * @category MyFirebaseMessagingService
 * 
 *
 */

import android.annotation.SuppressLint
import android.content.Context
import android.content.Intent
import android.content.res.Configuration
import android.os.PowerManager
import android.util.Log
import androidx.localbroadcastmanager.content.LocalBroadcastManager
import com.google.firebase.messaging.FirebaseMessagingService
import com.google.firebase.messaging.RemoteMessage
import com.google.gson.Gson
import com.sinch.android.rtc.SinchHelpers
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.common.helper.CommonDialog
import com.tkpmnc.sgtaxidriver.common.helper.ManualBookingDialog
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.common.util.CommonKeys
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods.Companion.DebuggableLogE
import com.tkpmnc.sgtaxidriver.home.datamodel.TripDetailsModel
import com.tkpmnc.sgtaxidriver.home.firebaseChat.ActivityChat
import com.tkpmnc.sgtaxidriver.trips.RequestAcceptActivity
import com.tkpmnc.sgtaxidriver.trips.RequestReceiveActivity
import com.tkpmnc.sgtaxidriver.trips.voip.NewTaxiSinchService
import org.json.JSONException
import org.json.JSONObject
import java.text.SimpleDateFormat
import java.util.*
import javax.inject.Inject


/* ************************************************************
                MyFirebaseMessagingService
Its used to get the pushnotification FirebaseMessagingService function
*************************************************************** */
class MyFirebaseMessagingService : FirebaseMessagingService() {

    @Inject
    lateinit var sessionManager: SessionManager
    @Inject
    lateinit var commonMethods: CommonMethods

    @Inject
    lateinit var gson: Gson


    override fun onCreate() {
        super.onCreate()
        AppController.getAppComponent().inject(this)
        setLocale()
    }

    override fun onMessageReceived(remoteMessage: RemoteMessage) {
        DebuggableLogE(TAG, "From: " + remoteMessage.from)
        wakeUpScreen()

        if (SinchHelpers.isSinchPushPayload(remoteMessage.data)) {
            // it's Sinch message - relay it to SinchClient
            //AppController.createSinchClient(sessionManager.getUserId(),sessionManager.getSinchKey(), sessionManager.getSinchSecret());
            /*NotificationResult result = NewTaxiSinchService.sinchClient.relayRemotePushNotificationPayload(remoteMessage.getData());*/
            initSinchService()
        } else {

            // Check if message contains a data payload.
            if (remoteMessage.data.size > 0) {
                DebuggableLogE(TAG, "Data Payload: " + remoteMessage.data.toString())

                try {
                    val json = JSONObject(remoteMessage.data.toString())
                    commonMethods.handleDataMessage(json,this)
                    if (remoteMessage.notification != null) {
                        DebuggableLogE(TAG, "Notification Body: " + remoteMessage.notification?.body)
                    }

                } catch (e: Exception) {
                    DebuggableLogE(TAG, "Exception: " + e.message)
                }

            }
        }


    }

    @SuppressLint("InvalidWakeLockTag")
    private fun wakeUpScreen() {
        val pm = this.getSystemService(POWER_SERVICE) as PowerManager
        val isScreenOn = pm.isScreenOn
        Log.e("screen on......", "" + isScreenOn)
        if (!isScreenOn) {
            val wl = pm.newWakeLock(PowerManager.FULL_WAKE_LOCK or PowerManager.ACQUIRE_CAUSES_WAKEUP or PowerManager.ON_AFTER_RELEASE, "MyLock")
            wl.acquire(10000)
            val wl_cpu = pm.newWakeLock(PowerManager.PARTIAL_WAKE_LOCK, "MyCpuLock")
            wl_cpu.acquire(10000)
        }
    }


    private fun handleDataMessage(json: JSONObject , context: Context) {
        DebuggableLogE(TAG, "push json: $json")
        val TripStatus = sessionManager.tripStatus
        val DriverStatus = sessionManager.driverStatus
        val UserId = sessionManager.accessToken
        try {

            /*
             *  Handle push notification and broadcast message to other activity
             */
            sessionManager.pushJson = json.toString()

            if (!NotificationUtils.isAppIsInBackground(context)) {
                try {
                    val json = JSONObject(json.toString())
                    var requestId = ""
                    val isPool = json.getJSONObject("custom").getJSONObject("ride_request").getBoolean("is_pool")


                    val jsonObject = JSONObject(json.toString())
                    if (jsonObject.getJSONObject("custom").has("ride_request")) {
                        requestId = jsonObject.getJSONObject("custom").getJSONObject("ride_request").getString("request_id")
                    }


                    if (!sessionManager.requestId.equals(requestId)) {
                        sessionManager.requestId = requestId


                        if (json.getJSONObject("custom").has("ride_request")) {
                            if (DriverStatus == "Online"
                                    && (TripStatus == null || TripStatus == CommonKeys.TripDriverStatus.EndTrip || TripStatus == "" || isPool)
                                    && UserId != null) {

                                val requstreceivepage = Intent(context, RequestReceiveActivity::class.java)
                                requstreceivepage.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP)
                                requstreceivepage.flags = Intent.FLAG_ACTIVITY_NEW_TASK
                                startActivity(requstreceivepage)
                            }
                        }

                    }


                } catch (e: Exception) {}

                else {
                    DebuggableLogE("Ride Request Received", "unable to process")
                }
            } else {
                DebuggableLogE(TAG, "ELSE: $json")

                // app is in background, show the notification in notification tray
                if (json.getJSONObject("custom").has("ride_request")) {

                    val isPool = json.getJSONObject("custom").getJSONObject("ride_request").getBoolean("is_pool")

                    if (DriverStatus == "Online"
                            && (TripStatus == null || TripStatus == CommonKeys.TripDriverStatus.EndTrip || TripStatus == "" || isPool)
                            && UserId != null) {


                        try {
                            val json = JSONObject(json.toString())
                            var requestId = ""


                            val jsonObject = JSONObject(json.toString())
                            if (jsonObject.getJSONObject("custom").has("ride_request")) {
                                requestId = jsonObject.getJSONObject("custom").getJSONObject("ride_request").getString("request_id")
                            }

                            if (!sessionManager.requestId.equals(requestId)) {
                                sessionManager.requestId = requestId
                                val title = json.getJSONObject("custom").getJSONObject("ride_request").getString("title")

                                val notificationUtils = NotificationUtils(context)
                                notificationUtils.playNotificationSound()
                                notificationUtils.generateNotification(context, "", title)
                                sessionManager.isDriverAndRiderAbleToChat = false
                                CommonMethods.stopFirebaseChatListenerService(context)
                                val intent = Intent(this, RequestReceiveActivity::class.java)
                                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP)
                                intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
                                startActivity(intent)
                            }
                        } catch (e: Exception) {

                        }
                    }
                } else if (json.getJSONObject("custom").has("cancel_trip")) {
                    sessionManager.clearTripID()
                    sessionManager.clearTripStatus()
                    val tripriders=json.getJSONObject("custom").getJSONObject("cancel_trip").getJSONArray("trip_riders")
                    if(tripriders.length()>0){
                        sessionManager.isTrip=true
                    }else{
                        sessionManager.isTrip=false
                    }
                    sessionManager.isDriverAndRiderAbleToChat = false
                    CommonMethods.stopFirebaseChatListenerService(context)
                    stopSinchService()
                    val dialogs = Intent(context, CommonDialog::class.java)
                    dialogs.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
                    dialogs.putExtra("message", resources.getString(R.string.yourtripcanceledrider))
                    dialogs.putExtra("type", 1)
                    dialogs.putExtra("status", 1)
                    startActivity(dialogs)


                } else {
                    DebuggableLogE("Ride Request Received", "unable to process")
                }

            }
        } catch (e: JSONException) {
            DebuggableLogE(TAG, "Json Exception: " + e.message)
            e.printStackTrace()
        } catch (e: Exception) {
            DebuggableLogE(TAG, "Exception: " + e.message)
        }

    }

    private fun initSinchService() {
        if (!sessionManager.accessToken.isNullOrEmpty()) {
            startService(Intent(this, NewTaxiSinchService::class.java))
        }
    }

    private fun stopSinchService() {
        CommonMethods.stopSinchService(this)

    }

    fun manualBookingTripBookedInfo(manualBookedPopupType: Int, jsonObject: JSONObject , context: Context) {
        var riderName = ""
        var riderContactNumber = ""
        var riderPickupLocation = ""
        var riderPickupDateAndTime = ""
        try {
            riderName = jsonObject.getString("rider_first_name") + " " + jsonObject.getString("rider_last_name")
            riderContactNumber = jsonObject.getString("rider_country_code") + " " + jsonObject.getString("rider_mobile_number")
            riderPickupLocation = jsonObject.getString("pickup_location")
            riderPickupDateAndTime = jsonObject.getString("date") + " - " + jsonObject.getString("time")
        } catch (e: JSONException) {
            e.printStackTrace()
        }

        val dialogs = Intent(context, ManualBookingDialog::class.java)
        dialogs.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
        dialogs.putExtra(CommonKeys.KEY_MANUAL_BOOKED_RIDER_NAME, riderName)
        dialogs.putExtra(CommonKeys.KEY_MANUAL_BOOKED_RIDER_CONTACT_NUMBER, riderContactNumber)
        dialogs.putExtra(CommonKeys.KEY_MANUAL_BOOKED_RIDER_PICKU_LOCATION, riderPickupLocation)
        dialogs.putExtra(CommonKeys.KEY_MANUAL_BOOKED_RIDER_PICKU_DATE_AND_TIME, riderPickupDateAndTime)
        dialogs.putExtra(CommonKeys.KEY_TYPE, manualBookedPopupType)
        startActivity(dialogs)

    }

    fun manualBookingTripStarts(jsonResp: JSONObject, context: Context) {


        val riderModel = gson.fromJson(jsonResp.toString(), TripDetailsModel::class.java)
        sessionManager.riderName = riderModel.riderDetails.get(0).name
        sessionManager.riderId = riderModel.riderDetails.get(0).riderId!!
        sessionManager.riderRating = riderModel.riderDetails.get(0).rating
        sessionManager.riderProfilePic = riderModel.riderDetails.get(0).profileImage
        sessionManager.bookingType = riderModel.riderDetails.get(0).bookingType
        sessionManager.tripId = riderModel.riderDetails.get(0).tripId.toString()
        sessionManager.subTripStatus = resources.getString(R.string.confirm_arrived)
        //sessionManager.setTripStatus("CONFIRM YOU'VE ARRIVED");
        sessionManager.tripStatus = CommonKeys.TripDriverStatus.ConfirmArrived

        sessionManager.isDriverAndRiderAbleToChat = true
        CommonMethods.startFirebaseChatListenerService(this)

        val requestaccept = Intent(context, RequestAcceptActivity::class.java)
        requestaccept.putExtra("riderDetails", riderModel)
        requestaccept.putExtra("tripstatus", resources.getString(R.string.confirm_arrived))
        requestaccept.putExtra(CommonKeys.KEY_IS_NEED_TO_PLAY_SOUND, CommonKeys.YES)
        requestaccept.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP or Intent.FLAG_ACTIVITY_NEW_TASK)
        startActivity(requestaccept)
    }




    fun setLocale() {
        val lang = sessionManager.language

        if (lang != "") {
            val langC = sessionManager.languageCode
            val locale = Locale(langC)
            Locale.setDefault(locale)
            val config = Configuration()
            config.locale = locale
            resources.updateConfiguration(
                    config,
                    resources.displayMetrics
            )
        } else {
            sessionManager.language = "English"
            sessionManager.languageCode = "en"
        }


    }

    companion object {

        private val TAG = MyFirebaseMessagingService::class.java.simpleName
    }
}
