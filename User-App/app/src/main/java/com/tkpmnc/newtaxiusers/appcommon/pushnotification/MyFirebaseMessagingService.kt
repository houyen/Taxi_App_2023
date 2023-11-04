package com.tkpmnc.newtaxiusers.appcommon.pushnotification

/**
 *  newtaxiusers
 * @subpackage pushnotification
 * @category FirebaseMessagingService
 *  
 * 
 */


import android.content.Intent
import android.content.res.Configuration
import com.google.firebase.messaging.FirebaseMessagingService
import com.google.firebase.messaging.RemoteMessage
import com.sinch.android.rtc.SinchHelpers
import com.tkpmnc.newtaxiusers.appcommon.configs.SessionManager
import com.tkpmnc.newtaxiusers.appcommon.network.AppController
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonMethods.Companion.DebuggableLogE
import com.tkpmnc.newtaxiusers.taxiapp.views.voip.NewTaxiSinchService
import org.json.JSONObject
import java.util.*
import javax.inject.Inject

/* ************************************************************
   Firebase Messaging Service to base push notification message to activity
   *************************************************************** */
class MyFirebaseMessagingService : FirebaseMessagingService() {
    @Inject
    lateinit var commonMethods: CommonMethods
    @Inject
    lateinit var sessionManager: SessionManager

    override fun onNewToken(s: String) {
        super.onNewToken(s)


        //NewTaxiSinchService.getManagedPush(s).registerPushToken(this);
    }

    override fun onCreate() {
        super.onCreate()
        AppController.appComponent.inject(this)
        setLocale()

    }

    override fun onMessageReceived(remoteMessage: RemoteMessage) {
        DebuggableLogE(TAG, "From tri: " + remoteMessage.from!!)
        DebuggableLogE(TAG, "From tri: $remoteMessage")
        DebuggableLogE(TAG, "Data Payload: " + remoteMessage.data.toString())

        if (SinchHelpers.isSinchPushPayload(remoteMessage.data)) {

        }

        if (SinchHelpers.isSinchPushPayload(remoteMessage.data)) {

            DebuggableLogE("test push noti", "Sinch message")
            initSinchService()

        } else {

            DebuggableLogE("test push noti", "ours")

            // Check if message contains a data payload.
            if (remoteMessage.data.size > 0) {
                DebuggableLogE(TAG, "Data Payload: " + remoteMessage.data.toString())

                try {
                    val json = JSONObject(remoteMessage.data.toString())
                     commonMethods.handleDataMessage(json,this)
                    if (remoteMessage.notification != null) {
                        DebuggableLogE(TAG, "Notification Body: " + remoteMessage.notification!!.body!!)

                    }

                } catch (e: Exception) {
                    DebuggableLogE(TAG, "Exception: " + e.message)
                }

            }
        }
    }


    /**
     * set language
     */
    private fun setLocale() {
        val lang = sessionManager.language

        if (lang != "") {
            val langC = sessionManager.languageCode
            val locale = Locale(langC)
            Locale.setDefault(locale)
            val config = Configuration()
            config.locale = locale
           resources.updateConfiguration(config, this.resources.displayMetrics)
        } else {
            sessionManager.language = "English"
            sessionManager.languageCode = "en"
        }


    }

    private fun initSinchService() {
        /*if (sessionManager.accessToken != "") {
            startService(Intent(this, NewTaxiSinchService::class.java))
        }*/

    }

    private fun stopSinchService() {
        CommonMethods.stopSinchService(this)

    }

    companion object {

        private val TAG = MyFirebaseMessagingService::class.java.simpleName
    }


}
