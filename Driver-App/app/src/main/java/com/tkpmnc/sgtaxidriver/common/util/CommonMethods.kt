package com.tkpmnc.sgtaxidriver.common.util

import android.app.Activity
import android.app.ActivityManager
import android.app.ActivityOptions
import android.app.Dialog
import android.content.ClipData
import android.content.ClipboardManager
import android.content.Context
import android.content.Intent
import android.content.pm.PackageManager
import android.content.res.Resources
import android.graphics.Bitmap
import android.graphics.Canvas
import android.graphics.Color
import android.graphics.Typeface
import android.graphics.drawable.ColorDrawable
import android.graphics.drawable.Drawable
import android.net.ConnectivityManager
import android.net.Uri
import android.os.*
import android.provider.MediaStore
import android.text.InputType
import android.text.TextUtils
import android.util.Log
import android.view.*
import android.widget.*
import androidx.annotation.DrawableRes
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.FileProvider
import androidx.core.content.res.ResourcesCompat
import androidx.localbroadcastmanager.content.LocalBroadcastManager
import com.google.android.gms.maps.model.BitmapDescriptor
import com.google.android.gms.maps.model.BitmapDescriptorFactory
import com.google.android.gms.tasks.OnCompleteListener
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.database.FirebaseDatabase
import com.google.firebase.iid.FirebaseInstanceId
import com.google.gson.Gson
import com.tkpmnc.sgtaxidriver.BuildConfig
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.common.custompalette.FontCache
import com.tkpmnc.sgtaxidriver.common.database.AddFirebaseDatabase
import com.tkpmnc.sgtaxidriver.common.helper.CommonDialog
import com.tkpmnc.sgtaxidriver.common.helper.Constants
import com.tkpmnc.sgtaxidriver.common.helper.Constants.RequestEndTime
import com.tkpmnc.sgtaxidriver.common.helper.CustomDialog
import com.tkpmnc.sgtaxidriver.common.helper.ManualBookingDialog
import com.tkpmnc.sgtaxidriver.common.model.JsonResponse
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.home.MainActivity
import com.tkpmnc.sgtaxidriver.home.datamodel.TripDetailsModel
import com.tkpmnc.sgtaxidriver.home.datamodel.firebase_keys.FirebaseDbKeys
import com.tkpmnc.sgtaxidriver.home.firebaseChat.ActivityChat
import com.tkpmnc.sgtaxidriver.home.pushnotification.Config
import com.tkpmnc.sgtaxidriver.home.pushnotification.NotificationUtils
import com.tkpmnc.sgtaxidriver.home.signinsignup.SigninSignupHomeActivity
import com.tkpmnc.sgtaxidriver.trips.RequestAcceptActivity
import com.tkpmnc.sgtaxidriver.trips.RequestReceiveActivity
import com.tkpmnc.sgtaxidriver.trips.voip.NewTaxiSinchService
import com.tkpmnc.sgtaxidriver.trips.voip.NewTaxiSinchService.Companion.sinchClient
import kotlinx.android.synthetic.main.app_common_button_large.view.*
import kotlinx.android.synthetic.main.app_common_header.view.*
import org.json.JSONException
import org.json.JSONObject
import java.io.*
import java.text.ParseException
import java.text.SimpleDateFormat
import java.util.*
import javax.inject.Inject
import kotlin.jvm.Throws


class CommonMethods {

    lateinit @Inject
    internal var sessionManager: SessionManager


    @Inject
    lateinit var gson: Gson

    private val TAG = CommonMethods::class.java.simpleName

    private var stripe: Stripe? = null
    private lateinit var auth: FirebaseAuth

    lateinit var tripfile: File
    lateinit var writer: FileWriter

    lateinit var mProgressDialog: Dialog

    init {
        AppController.getAppComponent().inject(this)
    }

    fun getJsonValue(jsonString: String, key: String, `object`: Any): Any {
        var objct = `object`
        try {
            val jsonObject = JSONObject(jsonString)
            if (jsonObject.has(key)) objct = jsonObject.get(key)
        } catch (e: Exception) {
            e.printStackTrace()
            return Any()
        }

        return objct
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

    private fun getLoadingDialog(mContext: Context, mLay: Int): Dialog {
        val mDialog = getDialog(mContext, mLay)
        mDialog.setCancelable(true)
        mDialog.setCanceledOnTouchOutside(true)

        mDialog.window!!.setLayout(
                WindowManager.LayoutParams.MATCH_PARENT,
                WindowManager.LayoutParams.MATCH_PARENT)
        mDialog.window!!.setGravity(Gravity.CENTER)

        return mDialog
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
        builder.setPositiveButton(context.resources.getString(R.string.ok)) { dialogInterface, i -> dialogInterface.dismiss() }
        val dialog = builder.create()
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE) //before
        return dialog
    }


    /*
     *  Check service is running or not
     */
    public fun isMyServiceRunning(serviceClass: Class<*>, context: Context): Boolean {
        val manager = context.getSystemService(Context.ACTIVITY_SERVICE) as ActivityManager
        for (service in manager.getRunningServices(Integer.MAX_VALUE)) {
            if (serviceClass.name == service.service.className) {
                return true
            }
        }
        return false
    }


    companion object {
        var progressDialog: CustomDialog? = null
        fun gotoMainActivityFromChatActivity(mActivity: Activity) {
            val mainActivityIntent = Intent(mActivity, MainActivity::class.java)
            mainActivityIntent.flags = Intent.FLAG_ACTIVITY_CLEAR_TOP
            mActivity.startActivity(mainActivityIntent)

        }

        fun getAppVersionNameFromGradle(context: Context): String {
            var versionName: String
            try {
                versionName = AppController.context!!.packageManager
                        .getPackageInfo(AppController.context!!.packageName, 0).versionName
            } catch (e: PackageManager.NameNotFoundException) {
                versionName = "0.0"
                e.printStackTrace()
            }

            return versionName
        }

        val appPackageName: String
            get() {
                var packageName: String
                try {
                    packageName = AppController.context!!.packageName
                } catch (e: Exception) {
                    packageName = ""
                    e.printStackTrace()
                }

                return packageName
            }

        fun isMyBackgroundServiceRunning(serviceClass: Class<*>, mContext: Context): Boolean {
            val manager = mContext.getSystemService(Context.ACTIVITY_SERVICE) as ActivityManager
            for (service in manager.getRunningServices(Integer.MAX_VALUE)) {
                if (serviceClass.name == service.service.className) {
                    return true
                }
            }
            return false
        }

        fun playVibration() {
            try {
                val v = AppController.context!!.getSystemService(Context.VIBRATOR_SERVICE) as Vibrator
                // Vibrate for 500 milliseconds
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                    v.vibrate(VibrationEffect.createOneShot(500, VibrationEffect.DEFAULT_AMPLITUDE))
                } else {
                    //deprecated in API 26
                    v.vibrate(500)
                }

            } catch (e: Exception) {
                e.printStackTrace()
            }

        }



        fun showNoInternetAlert(context: Context, iNoInternetCustomAlertCallBack: INoInternetCustomAlertCallback) {
            val builder = AlertDialog.Builder(context)
            builder.setCancelable(false)
            builder.setIcon(R.drawable.ic_wifi_off)
            builder.setTitle(context.resources.getString(R.string.no_connection))
            builder.setMessage(context.resources.getString(R.string.enable_connection_and_come_back))

            builder.setPositiveButton(context.resources.getString(R.string.ok)) { dialogInterface, i ->
                iNoInternetCustomAlertCallBack.onOkayClicked()
                dialogInterface.dismiss()
            }
            builder.setNeutralButton(context.resources.getString(R.string.retry)) { dialogInterface, i ->
                iNoInternetCustomAlertCallBack.onRetryClicked()
                dialogInterface.dismiss()
            }
            val dialog = builder.create()
            dialog.requestWindowFeature(Window.FEATURE_NO_TITLE) //before
            dialog.window!!.setBackgroundDrawable(context.getDrawable(R.drawable.round_shape_corner_20dp))
            dialog.show()
        }

    }

    fun getFireBaseToken(): String {
        var pos = ""

        FirebaseInstanceId.getInstance().getInstanceId()
                .addOnCompleteListener(OnCompleteListener {

                    if (it.isSuccessful()) {
                        //return "";
                        pos = it.result?.token!!
                        sessionManager.deviceId = pos
                        println("Device Id  : " + sessionManager.deviceId)

                    } else {
                        println("Device Id Exception : " + it.exception)

                    }


                });

        return pos

    }

   
    /**
     *  Update Total Distance in Session
     */
    fun updateDistanceInLocal(distance: Double) {
        if (sessionManager.tripStatus.equals(CommonKeys.TripDriverStatus.BeginTrip, true)) {
            if (distance < CommonKeys.CheckGoogleDistanceEvery1M) {
                val totaldistance = sessionManager.totalDistance + distance
                sessionManager.totalDistance = totaldistance.toFloat()
                updateDistanceInFile(sessionManager.totalDistance, "GoogleDistanceEvery1Min")
            }
        }
    }


    fun manualBookingTripBookedInfo(manualBookedPopupType: Int, jsonObject: JSONObject, context: Context) {
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
        context.startActivity(dialogs)

    }

    fun manualBookingTripStarts(jsonResp: JSONObject, context: Context) {


        val riderModel = gson.fromJson(jsonResp.toString(), TripDetailsModel::class.java)
        sessionManager.riderName = riderModel.riderDetails.get(0).name
        sessionManager.riderId = riderModel.riderDetails.get(0).riderId!!
        sessionManager.riderRating = riderModel.riderDetails.get(0).rating
        sessionManager.riderProfilePic = riderModel.riderDetails.get(0).profileImage
        sessionManager.bookingType = riderModel.riderDetails.get(0).bookingType
        sessionManager.tripId = riderModel.riderDetails.get(0).tripId.toString()
        sessionManager.subTripStatus = context.resources.getString(R.string.confirm_arrived)
        //sessionManager.setTripStatus("CONFIRM YOU'VE ARRIVED");
        sessionManager.tripStatus = CommonKeys.TripDriverStatus.ConfirmArrived

        sessionManager.isDriverAndRiderAbleToChat = true
        CommonMethods.startFirebaseChatListenerService(context)

        val requestaccept = Intent(context, RequestAcceptActivity::class.java)
        requestaccept.putExtra("riderDetails", riderModel)
        requestaccept.putExtra("tripstatus", context.resources.getString(R.string.confirm_arrived))
        requestaccept.putExtra(CommonKeys.KEY_IS_NEED_TO_PLAY_SOUND, CommonKeys.YES)
        requestaccept.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP or Intent.FLAG_ACTIVITY_NEW_TASK)
        context.startActivity(requestaccept)
    }



    fun getDate(): String {
        val today = Date()
        val format = SimpleDateFormat("dd-MM-yyyy hh:mm:ss a", Locale.ENGLISH)
        return format.format(today)
    }

    fun getFileWriter(): Boolean {
        return ::writer.isInitialized
    }

    fun getCurrentTime(): String {
        val sdf = SimpleDateFormat("dd MMM yyyy HH:mm:ss", Locale.ENGLISH)
        return sdf.format(Date())
    }

    fun checkTimings(time: String, endtime: String): Boolean {
        val pattern = "dd MMM yyyy HH:mm:ss"
        val sdf = SimpleDateFormat(pattern, Locale.ENGLISH)
        try {
            val date1 = sdf.parse(time)
            val date2 = sdf.parse(endtime)
            return date1.compareTo(date2) < 0  // Date 2
        } catch (e: ParseException) {
            e.printStackTrace()
        }
        return false
    }

    fun getTimeFromLong(time: Long): String {
        val date = Date(time * 1000L) // *1000 is to convert seconds to milliseconds
        val sdf = SimpleDateFormat("dd MMM yyyy HH:mm:ss", Locale.ENGLISH) // the format of your date
        //sdf.timeZone = TimeZone.getTimeZone("GMT-4")
        return sdf.format(date)
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



    fun difference(currentTimeLong: Long, endTimelong: Long): Long {
        return ((endTimelong - currentTimeLong) * 1000)
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
