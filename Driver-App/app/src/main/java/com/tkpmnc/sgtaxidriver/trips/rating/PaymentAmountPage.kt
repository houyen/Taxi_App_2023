package com.tkpmnc.sgtaxidriver.trips.rating

/**
 * @package com.tkpmnc.sgtaxidriver.trips.rating
 * @subpackage rating
 * @category PaymentAmountPage
 * 
 *
 */

import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import android.content.IntentFilter
import android.os.Build
import android.os.Bundle
import android.text.TextUtils
import android.view.View
import android.widget.RelativeLayout
import android.widget.TextView
import androidx.appcompat.app.AlertDialog
import androidx.core.content.ContextCompat
import androidx.localbroadcastmanager.content.LocalBroadcastManager
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.database.FirebaseDatabase
import com.google.firebase.messaging.FirebaseMessaging
import com.google.gson.Gson
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.common.database.AddFirebaseDatabase
import com.tkpmnc.sgtaxidriver.common.helper.CustomDialog
import com.tkpmnc.sgtaxidriver.common.model.JsonResponse
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.common.util.CommonKeys
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_CASH_COLLECTED
import com.tkpmnc.sgtaxidriver.common.util.RequestCallback
import com.tkpmnc.sgtaxidriver.common.views.CommonActivity
import com.tkpmnc.sgtaxidriver.home.MainActivity
import com.tkpmnc.sgtaxidriver.home.datamodel.firebase_keys.FirebaseDbKeys
import com.tkpmnc.sgtaxidriver.home.interfaces.ApiService
import com.tkpmnc.sgtaxidriver.home.interfaces.ServiceListener
import com.tkpmnc.sgtaxidriver.home.pushnotification.Config
import com.tkpmnc.sgtaxidriver.home.pushnotification.NotificationUtils
import kotlinx.android.synthetic.main.activity_payment_amount_page.*
import kotlinx.android.synthetic.main.app_common_button_large.*
import org.json.JSONException
import org.json.JSONObject
import java.util.*
import javax.inject.Inject

/* ************************************************************
                PaymentAmountPage
Its used to get rider payment screen page function
*************************************************************** */
class PaymentAmountPage : CommonActivity(), ServiceListener {

    @Inject
    lateinit var apiService: ApiService

    @Inject
    lateinit var sessionManager: SessionManager

    @Inject
    lateinit var commonMethods: CommonMethods

    @Inject
    lateinit var gson: Gson

    @Inject
    lateinit var customDialog: CustomDialog
    lateinit var dialog: AlertDialog

    @BindView(R.id.adminamountlayout)
    lateinit var adminamountlayout: RelativeLayout

    @BindView(R.id.oweamountlayout)
    lateinit var oweamountlayout: RelativeLayout

    @BindView(R.id.driverpayoutlayout)
    lateinit var driverpayoutlayout: RelativeLayout

    @BindView(R.id.cashcollectamountlayout)
    lateinit var cashcollectamountlayout: RelativeLayout

    @BindView(R.id.basefare_amount)
    lateinit var basefare_amount: TextView

    @BindView(R.id.distance_fare)
    lateinit var distance_fare: TextView

    @BindView(R.id.time_fare)
    lateinit var time_fare: TextView

    @BindView(R.id.fee)
    lateinit var fee: TextView

    @BindView(R.id.totalamount)
    lateinit var totalamount: TextView

    @BindView(R.id.total_payouts)
    lateinit var total_payouts: TextView

    @BindView(R.id.oweamount)
    lateinit var oweamount: TextView

    @BindView(R.id.driverpayout)
    lateinit var driverpayout: TextView

    @BindView(R.id.adminamount)
    lateinit var adminamount: TextView

    @BindView(R.id.rvPrice)
    lateinit var recyclerView: RecyclerView
    private val priceList = ArrayList<HashMap<String, String>>()
    var payment_status: String? = null
    var payment_method: String? = null
    protected var isInternetAvailable: Boolean = false
    private var mRegistrationBroadcastReceiver: BroadcastReceiver? = null
    lateinit internal var addFirebaseDatabase: AddFirebaseDatabase

    private var isPaymentCompleted: Boolean = false


    @OnClick(R.id.back)
    fun backPressed() {
        onBackPressed()
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_payment_amount_page)

        ButterKnife.bind(this)
        AppController.getAppComponent().inject(this)
        /*common header and button text*/
        commonMethods.setButtonText(resources.getString(R.string.waiting_for_payment), common_button)
        commonMethods.setheaderText(resources.getString(R.string.paymentdetails), common_header)
        button.setTextColor(ContextCompat.getColor(this, R.color.newtaxi_app_black))
        paymentAmountPageInstance = this
        dialog = commonMethods.getAlertDialog(this)
        isInternetAvailable = commonMethods.isOnline(this)
        addFirebaseDatabase = AddFirebaseDatabase()


        recyclerView.setHasFixedSize(true)
        val layoutManager = LinearLayoutManager(this)
        recyclerView.layoutManager = layoutManager

        button.setOnClickListener {
            /*
                    *  If trip is cash payment the driver confirm the payment
                    *
                    */
            if (button.text.toString() == resources.getString(R.string.cashcollected)) {
                /*
                    *  Update driver cash collected in server
                    */
                isInternetAvailable = commonMethods.isOnline(applicationContext)
                if (isInternetAvailable) {
                    cashCollected()
                } else {
                    snackBar(resources.getString(R.string.no_connection), resources.getString(R.string.go_online), false, 2)
                }
            } else if (button.text.toString() == resources.getString(R.string.payment_done)) {
                CommonKeys.IS_ALREADY_IN_TRIP = false
                val intent = Intent(applicationContext, MainActivity::class.java)
                startActivity(intent)
            } else {
                AddFirebaseDatabase().removeLiveTrackingNodesAfterCompletedTrip(this)
                AddFirebaseDatabase().removeNodesAfterCompletedTrip(this)
                sessionManager.clearTripID()
                sessionManager.clearTripStatus()
                val main = Intent(applicationContext, MainActivity::class.java)
                startActivity(main)
            }
        }

        println("Delete trip id : " + sessionManager.tripId)
        deleteTripDb(sessionManager.tripId!!, this)
        lookForPaymentNodeChanges()
        receivepushnotification()

    }

    private fun lookForPaymentNodeChanges() {
        addFirebaseDatabase.initPaymentChangeListener(this)
    }

    override fun onBackPressed() {
        CommonKeys.IS_ALREADY_IN_TRIP = true

        sessionManager.isDriverAndRiderAbleToChat = false
        CommonMethods.stopFirebaseChatListenerService(applicationContext)
        val intent = Intent(applicationContext, MainActivity::class.java)
        startActivity(intent)
        finish()

    }

    /*
   *   Load price data
   */
    fun loaddata() {

        recyclerView.removeAllViews()
        val adapter = PriceRecycleAdapter(this)
        recyclerView.adapter = adapter


        var total_fare: String? = ""

        payment_status = paymentStatus
        payment_method = paymentMode
        total_fare = totalFare

        if (CommonKeys.TripStatus.Completed == payment_status) {
            button.setTextColor(resources.getColor(R.color.newtaxi_app_black))
            //   button.setTextColor(resources.getColor(R.color.ub__contact_resolved_green))
            button.setBackground(ContextCompat.getDrawable(applicationContext, R.drawable.app_curve_button_navy))
            button.text = resources.getString(R.string.paid)
        }

        if (payment_method!!.contains("cash", ignoreCase = true)) {
            if (java.lang.Float.valueOf(total_fare!!) > 0) {
                //button.setBackgroundColor(resources.getColor(R.color.app_button))
                button.setTextColor(resources.getColor(R.color.newtaxi_app_black))
                button.setBackground(ContextCompat.getDrawable(applicationContext, R.drawable.app_curve_button_navy))
                button.text = resources.getString(R.string.cashcollected)
                button.isEnabled = true
            } else {
                //button.setBackgroundColor(resources.getColor(R.color.black_alpha_20))
                button.setTextColor(resources.getColor(R.color.newtaxi_app_black))
                button.setBackground(ContextCompat.getDrawable(applicationContext, R.drawable.app_curve_button_navy_disable))
                button.text = resources.getString(R.string.waitforrider)
                button.isEnabled = false
            }
        } else {
            //button.setBackgroundColor(resources.getColor(R.color.black_alpha_20))
            button.setTextColor(resources.getColor(R.color.newtaxi_app_black))
            button.setBackground(ContextCompat.getDrawable(applicationContext, R.drawable.app_curve_button_navy_disable))
            button.text = resources.getString(R.string.waitforrider)
            button.isEnabled = false
        }


    }

    /*
    *   Receive push notification
    */
    fun receivepushnotification() {

        mRegistrationBroadcastReceiver = object : BroadcastReceiver() {
            override fun onReceive(context: Context, intent: Intent) {

                // checking for type intent filter
                if (intent.action == Config.REGISTRATION_COMPLETE) {
                    // FCM successfully registered
                    // now subscribe to `global` topic to receive app wide notifications
                    FirebaseMessaging.getInstance().subscribeToTopic(Config.TOPIC_GLOBAL)


                } else if (intent.action == Config.PUSH_NOTIFICATION) {
                    // new push notification is received


                    val JSON_DATA = sessionManager.pushJson


                    if (JSON_DATA != null) {
                        var jsonObject: JSONObject?
                        try {
                            jsonObject = JSONObject(JSON_DATA)
                            if (jsonObject.getJSONObject("custom").has("trip_payment")) {
                                isPaymentCompleted = true
                                addFirebaseDatabase.removeRequestTable()
                                sessionManager.isDriverAndRiderAbleToChat = false
                                CommonMethods.stopFirebaseChatListenerService(applicationContext)
                                //button.setBackgroundColor(getResources().getColor(R.color.button_material_dark));
                                //button.setTextColor(resources.getColor(R.color.ub__contact_resolved_green))
                                button.setTextColor(resources.getColor(R.color.newtaxi_app_black))
                                /*button.background = ContextCompat.getDrawable(applicationContext, R.drawable.app_curve_button_navy)
                                button.isEnabled = true*/
                                button.text = resources.getString(R.string.payment_done)
                                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.Q && NotificationUtils.isAppIsInBackground(context)) {
                                    showDialog(resources.getString(R.string.paymentcompleted))
                                }
                                // showDialog("Payment completed successfully");
                            }
                        } catch (e: JSONException) {
                            e.printStackTrace()
                        }

                    }


                }
            }
        }
    }

    public override fun onResume() {
        super.onResume()


        // register FCM registration complete receiver
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver!!,
                IntentFilter(Config.REGISTRATION_COMPLETE))

        // register new push message receiver
        // by doing this, the activity will be notified each time a new message arrives
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver!!,
                IntentFilter(Config.PUSH_NOTIFICATION))

        // clear the notification area when the app is opened
        NotificationUtils.clearNotifications(applicationContext)
    }

    public override fun onPause() {
        super.onPause()
    }


}
