package com.tkpmnc.sgtaxiuser.appcommon.pushnotification

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage MyFirebaseInstanceIDService
 * @category Firebase instance service
 * @author Seen Technologies
 * 
 */

import android.text.TextUtils
import com.google.firebase.messaging.FirebaseMessagingService
import com.google.gson.Gson
import com.tkpmnc.sgtaxiuser.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiuser.appcommon.datamodels.JsonResponse
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ApiService
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ServiceListener
import com.tkpmnc.sgtaxiuser.appcommon.network.AppController
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods.Companion.DebuggableLogE
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods.Companion.DebuggableLogV
import com.tkpmnc.sgtaxiuser.appcommon.utils.RequestCallback
import javax.inject.Inject

/* ************************************************************
   Firebase instance service to get device ID
   *************************************************************** */

class MyFirebaseInstanceIDService : FirebaseMessagingService(), ServiceListener {


    @Inject
    lateinit var sessionManager: SessionManager
    @Inject
    lateinit var apiService: ApiService
    @Inject
    lateinit var gson: Gson
    @Inject
    lateinit var commonMethods: CommonMethods

    override fun onNewToken(p0: String) {
        super.onNewToken(p0)

        DebuggableLogE(TAG, "sendRegistrationToServerS: $p0")
        AppController.appComponent.inject(this)
        val refreshedToken = p0 //commonMethods.getFireBaseToken()
        // Saving reg id to shared preferences
        storeRegIdInPref(refreshedToken)

        // sending reg id to your server
        sendRegistrationToServer(refreshedToken)
    }

    private fun sendRegistrationToServer(token: String?) {
        // sending FCM token to server
        DebuggableLogE(TAG, "sendRegistrationToServer: " + token!!)

        sessionManager.deviceId = token

        if ("" != sessionManager.token) {
            /*ManagedPushRegistration managedPushRegistration;
            ManagedPush.registerPushToken(sessionManager.getDeviceId());*/
            /*instanceOfMyPushTokenRegistrationClass.registerPushToken();*/
            storeRegId()
        }
    }

    private fun storeRegIdInPref(token: String?) {
        val pref = applicationContext.getSharedPreferences(Config.SHARED_PREF, 0)
        val editor = pref.edit()
        editor.putString("regId", token)
        editor.apply()
    }

    private fun storeRegId() {
        apiService.updateDevice(sessionManager.accessToken!!, sessionManager.type!!, "2", sessionManager.deviceId!!).enqueue(RequestCallback(this))
    }

    override fun onSuccess(jsonResp: JsonResponse, data: String) {
        if (jsonResp.isSuccess) {
            DebuggableLogV("onsuccess", "onsuccess")
        } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
            DebuggableLogV("onsuccess", "onsuccess")
        }
    }

    override fun onFailure(jsonResp: JsonResponse, data: String) {
        DebuggableLogV("onFailure", "onFailure")
    }

    companion object {
        private val TAG = MyFirebaseInstanceIDService::class.java.simpleName
    }
}