package com.tkpmnc.newtaxiusers.appcommon.views

import android.annotation.SuppressLint
import android.app.ProgressDialog
import android.content.Context
import android.content.Intent
import android.graphics.Bitmap
import android.os.Bundle
import android.util.Log
import android.webkit.*
import com.tkpmnc.newtaxiusers.R
import com.tkpmnc.newtaxiusers.appcommon.configs.SessionManager
import com.tkpmnc.newtaxiusers.appcommon.helper.Constants
import com.tkpmnc.newtaxiusers.appcommon.network.AppController
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonKeys
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.newtaxiusers.taxiapp.views.customize.CustomDialog
import kotlinx.android.synthetic.main.app_common_header.*
import org.json.JSONException
import org.json.JSONObject
import java.net.URLEncoder
import javax.inject.Inject

class FlutterwaveWebViewActivity : CommonActivity() {
    @Inject
    lateinit var sessionManager: SessionManager

    @Inject
    lateinit var commonMethods: CommonMethods

    @Inject
    lateinit var customDialog: CustomDialog

    var type: String? = null

    lateinit var progressDialog: ProgressDialog

    var payFor: String? = null

    @SuppressLint("SetJavaScriptEnabled")

    private fun setProgress() {
        progressDialog = ProgressDialog(this)
        progressDialog.setMessage(resources.getString(R.string.loading))
        progressDialog.setCancelable(false)
    }

    // Open previous opened link from history on webview when back button pressed
    // Detect when the back button is pressed

    inner class MyJavaScriptInterface(private var ctx: Context) {
        @JavascriptInterface
        fun showHTML(html: String) {
            println("HTML$html")
            var response: JSONObject? = null
            if (progressDialog.isShowing) {
                progressDialog.dismiss()
            }
            try {
                response = JSONObject(html)
                if (response != null) {
                    val statusCode = response.getString("status_code")
                    val statusMessage = response.getString("status_message")

                    Log.d("OUTPUT IS", statusCode)
                    Log.d("OUTPUT IS", statusMessage)
                    redirect(response.toString())
                }
            } catch (e: JSONException) {
                e.printStackTrace()
            } catch (t: Throwable) {
                Log.e("My App", "${t.message} \"$response\"")
            }
        }
    }


}