package com.tkpmnc.sgtaxiuser.appcommon.utils

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage utils
 * @category CommonMethods
 * 
 *
 */

import android.app.Activity
import android.app.ActivityManager
import android.app.Dialog
import android.content.ClipData
import android.content.ClipboardManager
import android.content.Context
import android.content.Intent
import android.content.pm.PackageManager
import android.content.res.Configuration
import android.content.res.Resources
import android.graphics.Bitmap
import android.graphics.Canvas
import android.graphics.Color
import android.graphics.drawable.ColorDrawable
import android.graphics.drawable.Drawable
import android.net.ConnectivityManager
import android.net.Uri
import android.os.Build
import android.os.Environment
import android.os.VibrationEffect
import android.os.Vibrator
import android.provider.MediaStore
import android.text.TextUtils
import android.util.Log
import android.view.*
import android.widget.PopupWindow
import android.widget.Toast
import androidx.annotation.DrawableRes
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat
import androidx.core.content.FileProvider
import androidx.core.content.res.ResourcesCompat
import androidx.localbroadcastmanager.content.LocalBroadcastManager
import com.braintreepayments.api.models.ThreeDSecureAdditionalInformation
import com.braintreepayments.api.models.ThreeDSecurePostalAddress
import com.braintreepayments.api.models.ThreeDSecureRequest
import com.google.android.gms.maps.model.BitmapDescriptor
import com.google.android.gms.maps.model.BitmapDescriptorFactory
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.database.DatabaseReference
import com.google.firebase.database.FirebaseDatabase
import com.google.firebase.messaging.FirebaseMessaging
import com.stripe.android.PaymentConfiguration
import com.stripe.android.Stripe
import com.stripe.android.model.ConfirmPaymentIntentParams
import com.tkpmnc.sgtaxiuser.BuildConfig
import com.tkpmnc.sgtaxiuser.R
import com.tkpmnc.sgtaxiuser.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiuser.appcommon.datamodels.JsonResponse
import com.tkpmnc.sgtaxiuser.appcommon.helper.CommonDialog
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants
import com.tkpmnc.sgtaxiuser.appcommon.network.AppController
import com.tkpmnc.sgtaxiuser.appcommon.pushnotification.Config
import com.tkpmnc.sgtaxiuser.appcommon.pushnotification.MyFirebaseMessagingService
import com.tkpmnc.sgtaxiuser.appcommon.pushnotification.NotificationUtils
import com.tkpmnc.sgtaxiuser.appcommon.views.CommonActivity
import com.tkpmnc.sgtaxiuser.taxiapp.firebase_keys.FirebaseDbKeys
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.DriverRatingActivity
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.SendingRequestActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.customize.CustomDialog
import com.tkpmnc.sgtaxiuser.taxiapp.views.firebaseChat.ActivityChat
import com.tkpmnc.sgtaxiuser.taxiapp.views.main.MainActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.voip.NewTaxiSinchService
import com.tkpmnc.sgtaxiuser.taxiapp.views.voip.NewTaxiSinchService.Companion.sinchClient
import kotlinx.android.synthetic.main.app_common_header.view.*
import org.json.JSONException
import org.json.JSONObject
import java.io.File
import java.io.FileOutputStream
import java.io.IOException
import java.io.InputStream
import java.text.SimpleDateFormat
import java.util.*
import javax.inject.Inject
import kotlin.collections.HashMap
import kotlin.jvm.Throws

/*****************************************************************
 * CommonMethods
 */
class CommonMethods {
    @Inject
    lateinit var sessionManager: SessionManager
    lateinit var context: Context
    private var mFirebaseDatabase: DatabaseReference? = null
    private val TAG = MyFirebaseMessagingService::class.java.simpleName

    lateinit var mProgressDialog: Dialog

    private var stripe: Stripe? = null

    init {
        AppController.appComponent.inject(this)
    }

    fun showProgressDialog(context: Context) {
        try {
            if (this::mProgressDialog.isInitialized && mProgressDialog != null && mProgressDialog.isShowing) {
                mProgressDialog.dismiss()
            }
            mProgressDialog = getLoadingDialog(context, R.layout.app_loader_view)
            mProgressDialog.setCancelable(true)
            mProgressDialog.setCanceledOnTouchOutside(false)
            mProgressDialog.setOnKeyListener { dialog, keyCode, event -> keyCode == KeyEvent.KEYCODE_BACK }
            mProgressDialog.show()
        } catch (e: Exception) {
            e.printStackTrace()
        }

    }

    private fun getDialog(mContext: Context, mLayout: Int): Dialog {
        val mDialog = Dialog(mContext)
        mDialog.requestWindowFeature(Window.FEATURE_NO_TITLE)
        mDialog.window!!.setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN or WindowManager.LayoutParams.SOFT_INPUT_ADJUST_RESIZE)
        mDialog.setContentView(mLayout)
        mDialog.window!!.setBackgroundDrawable(
                ColorDrawable(Color.TRANSPARENT))
        mDialog.window!!.setLayout(
                WindowManager.LayoutParams.MATCH_PARENT,
                WindowManager.LayoutParams.MATCH_PARENT)
        return mDialog
    }


    //Create and Get Dialog
    fun getAlertDialog(context: Context): AlertDialog {
        val builder = AlertDialog.Builder(context)
        builder.setCancelable(true)
        builder.setPositiveButton(context.resources.getString(R.string.ok_c)) { dialogInterface, _ -> dialogInterface.dismiss() }
        val dialog = builder.create()
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE) //before
        return dialog
    }


    ////////////////// CAMERA ///////////////////////////////////
    fun getDefaultFileName(context: Context): File {
        return File(context.getExternalFilesDir(Environment.DIRECTORY_PICTURES), context.resources.getString(R.string.app_name) + System.currentTimeMillis() + ".png")
    }


    fun isNotEmpty(s: Any?): Boolean {
        if (s == null) {
            return false
        }
        if (s is String && s.trim { it <= ' ' }.length > 0) {
            return true
        }
        if (s is ArrayList<*>) {
            return !s.isEmpty()
        }
        if (s is Map<*, *>) {
            return !s.isEmpty()
        }
        if (s is List<*>) {
            return !s.isEmpty()
        }

        return if (s is Array<*>) {
            s.size != 0
        } else false
    }


    fun cameraFilePath(context: Context): File {
        return File(context.getExternalFilesDir(Environment.DIRECTORY_PICTURES), context.resources.getString(R.string.app_name) + System.currentTimeMillis() + ".png")
    }

    fun refreshGallery(context: Context, file: File) {
        try {
            val mediaScanIntent = Intent(Intent.ACTION_MEDIA_SCANNER_SCAN_FILE)
            val contentUri = Uri.fromFile(file) //out is your file you saved/deleted/moved/copied
            mediaScanIntent.data = contentUri
            context.sendBroadcast(mediaScanIntent)
        } catch (e: Exception) {
            e.printStackTrace()
        }

    }

    fun isOnline(context: Context?): Boolean {
        if (context == null) return false
        val connectivityManager = context.getSystemService(Context.CONNECTIVITY_SERVICE) as ConnectivityManager
        val netInfo = connectivityManager.activeNetworkInfo
        return netInfo != null && netInfo.isConnected
    }

    fun getJsonValue(jsonString: String, key: String, `object`: Any): Any {
        var object1 = `object`
        try {
            val jsonObject = JSONObject(jsonString)
            if (jsonObject.has(key)) object1 = jsonObject.get(key)
        } catch (e: Exception) {
            e.printStackTrace()
            return Any()
        }

        return object1
    }

    companion object {

        var popupWindow: PopupWindow? = null
        var progressDialog: CustomDialog? = null
        fun gotoMainActivityWithoutHistory(mActivity: Activity) {
            val mainActivityIntent = Intent(mActivity, MainActivity::class.java)
            mainActivityIntent.flags = Intent.FLAG_ACTIVITY_CLEAR_TOP
            mActivity.startActivity(mainActivityIntent)

        }

        fun showInternetNotAvailableForStoredDataViewer(mContext: Context) {

            val toast: Toast = Toast.makeText(mContext, mContext.resources.getString(R.string.you_are_viewing_old_data), Toast.LENGTH_LONG)
            toast.show()
        }

        fun showNoInternetAlert(context: Context, iNoInternetCustomAlertCallBack: INoInternetCustomAlertCallback) {
            val builder = AlertDialog.Builder(context)
            builder.setCancelable(false)
            builder.setIcon(R.drawable.ic_wifi_off)
            builder.setTitle(context.resources.getString(R.string.no_connection))
            builder.setMessage(context.resources.getString(R.string.enable_connection_and_come_back))

            builder.setPositiveButton(context.resources.getString(R.string.ok_c)) { dialogInterface, i ->
                iNoInternetCustomAlertCallBack.onOkayClicked()
                dialogInterface.dismiss()
            }
            builder.setNeutralButton(context.resources.getString(R.string.retry)) { dialogInterface, i ->
                iNoInternetCustomAlertCallBack.onRetryClicked()
                dialogInterface.dismiss()
            }
            val dialog = builder.create()
            dialog.requestWindowFeature(Window.FEATURE_NO_TITLE)
            dialog.window!!.setBackgroundDrawable(ContextCompat.getDrawable(context, R.drawable.round_shape_corner_20dp))
            dialog.show()
        }
    }




    fun getFireBaseToken(): String {
        var pos = ""

        FirebaseMessaging.getInstance().token.addOnCompleteListener {
            try {
                if (it.isComplete) {
                    pos = it.result.toString()
                    println("Device Id  : new two " + pos)
                    sessionManager.deviceId = pos
                    // DO your thing with your firebase token
                }
            }catch (e:Exception){
                Log.e("FirebaseToken","Token generation exception ${e.message}")
            }
        }.addOnFailureListener {
            println("Device Id  : new two exception " + it.stackTrace)
        }

        return pos

    }

    fun removeLiveTrackingNodesAfterCompletedTrip(context: Context) {
        try {
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
            mFirebaseDatabase!!.child(FirebaseDbKeys.LIVE_TRACKING_NODE).child(sessionManager.tripId!!).removeValue()
        } catch (e: Exception) {
            e.printStackTrace()
        }

        removeChatNodesAfterCompletedTrip(context)
    }

    private fun removeChatNodesAfterCompletedTrip(context: Context) {
        try {
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
            mFirebaseDatabase!!.child(FirebaseDbKeys.chatFirebaseDatabaseName).child(sessionManager.tripId!!).removeValue()
        } catch (e: Exception) {
            e.printStackTrace()
        }
    }

    fun removeTripNodesAfterCompletedTrip(context: Context) {
        try {
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
            mFirebaseDatabase!!.child(FirebaseDbKeys.TRIP_PAYMENT_NODE).child(sessionManager.tripId!!).removeValue()
            mFirebaseDatabase!!.child(FirebaseDbKeys.TRIP_PAYMENT_NODE).child(FirebaseDbKeys.TRIPLIVEPOLYLINE).removeValue()
        } catch (e: Exception) {
            e.printStackTrace()
        }
    }

    /**
     * Create a Payment to Start Payment Process
     */
    private fun createPaymentIntentParams(clientSecret: String, context: Context): ConfirmPaymentIntentParams {
        return ConfirmPaymentIntentParams.create(clientSecret)
    }


    fun getRiderProfile(isFilterUpdate: Boolean, isUpdateFilter: LinkedHashSet<Int>?): HashMap<String, String> {
        val riderProfile = HashMap<String, String>()
        riderProfile["token"] = sessionManager.accessToken!!
        if (isFilterUpdate) {
            riderProfile["options"] = TextUtils.join(",", isUpdateFilter!!)
        }

        return riderProfile
    }


    interface INoInternetCustomAlertCallback {
        fun onOkayClicked()
        fun onRetryClicked()
    }

    fun updateLocale(languageCode: String, newBase: Context?): Context? {
        var newBase = newBase
        val lang: String = languageCode!! // your language or load from SharedPref
        val locale = Locale(lang)
        val config = Configuration(newBase?.resources?.configuration)
        Locale.setDefault(locale)
        config.setLocale(locale)
        newBase = newBase?.createConfigurationContext(config)
        newBase?.resources?.updateConfiguration(config, newBase.resources.displayMetrics)
        return newBase
    }

    fun vectorToBitmap(@DrawableRes id: Int, context: Context): BitmapDescriptor? {
        val vectorDrawable: Drawable = ResourcesCompat.getDrawable(context.resources, id, null)!!
        val bitmap = Bitmap.createBitmap(vectorDrawable.intrinsicWidth,
                vectorDrawable.intrinsicHeight, Bitmap.Config.ARGB_8888)
        val canvas = Canvas(bitmap)
        vectorDrawable.setBounds(0, 0, canvas.width, canvas.height)
        vectorDrawable.draw(canvas)
        return BitmapDescriptorFactory.fromBitmap(bitmap)
    }

    fun setheaderText(string: String, view: View) {
        view.tv_headertext.text = string

    }

    fun cameraIntent(imageFile: File, activity: AppCompatActivity) {
        val cameraIntent = Intent(MediaStore.ACTION_IMAGE_CAPTURE)
        val imageUri = FileProvider.getUriForFile(activity, BuildConfig.APPLICATION_ID + ".provider", imageFile)
        try {
            val resolvedIntentActivities = activity.packageManager.queryIntentActivities(cameraIntent, PackageManager.MATCH_DEFAULT_ONLY)
            for (resolvedIntentInfo in resolvedIntentActivities) {
                val packageName = resolvedIntentInfo.activityInfo.packageName
                activity.grantUriPermission(packageName, imageUri, Intent.FLAG_GRANT_WRITE_URI_PERMISSION or Intent.FLAG_GRANT_READ_URI_PERMISSION)
            }
            cameraIntent.putExtra("return-data", true)
            cameraIntent.addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION)
        } catch (e: Exception) {
            e.printStackTrace()
        }
        cameraIntent.putExtra(MediaStore.EXTRA_OUTPUT, imageUri)
        activity.startActivityForResult(cameraIntent, Constants.PICK_IMAGE_REQUEST_CODE)
        refreshGallery(activity, imageFile)
    }

    fun galleryIntent(activity: AppCompatActivity){
        val i = Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI)
        activity.startActivityForResult(i, Constants.SELECT_FILE)
    }

    /**
     * Input output Stream
     */
    @Throws(IOException::class)
    fun copyStream(input: InputStream?, output: FileOutputStream) {
        val buffer = ByteArray(1024)
        var bytesRead: Int
        while (input!!.read(buffer).also { bytesRead = it } != -1) {
            output.write(buffer, 0, bytesRead)
        }
    }

    fun clearImageCacheWhenAppOpens(context: Context){
        val dir = File (context.getExternalFilesDir(Environment.DIRECTORY_PICTURES).toString())
        if (dir.isDirectory) {
            val children = dir.list()
            for (i in children.indices) {
                File(dir, children[i]).delete()
            }
        }
    }

}