package com.tkpmnc.sgtaxiuser.taxiapp.sendrequest

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage sendrequest
 * @category PaymentAmountPage
 * 
 *
 */

import android.app.ActivityManager
import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import android.content.IntentFilter
import android.os.Bundle
import android.os.Handler
import android.os.StrictMode
import android.text.TextUtils
import android.view.Gravity
import android.view.View
import android.widget.*
import androidx.appcompat.app.AlertDialog
import androidx.core.content.ContextCompat
import androidx.localbroadcastmanager.content.LocalBroadcastManager
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.braintreepayments.api.dropin.DropInRequest
import com.braintreepayments.api.dropin.DropInResult
import com.braintreepayments.api.interfaces.PaymentMethodNonceCreatedListener
import com.braintreepayments.api.models.PaymentMethodNonce
import com.google.firebase.messaging.FirebaseMessaging
import com.google.gson.Gson
import com.squareup.picasso.Picasso
import com.stripe.android.ApiResultCallback
import com.stripe.android.PaymentIntentResult
import com.stripe.android.model.StripeIntent
import com.tkpmnc.sgtaxiuser.R
import com.tkpmnc.sgtaxiuser.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiuser.appcommon.datamodels.JsonResponse
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants.Payment
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ApiService
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ServiceListener
import com.tkpmnc.sgtaxiuser.appcommon.network.AppController
import com.tkpmnc.sgtaxiuser.appcommon.pushnotification.Config
import com.tkpmnc.sgtaxiuser.appcommon.pushnotification.NotificationUtils
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonKeys
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonKeys.REQUEST_CODE_PAYMENT
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods.Companion.DebuggableLogV
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_AFTER_PAY
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_CURRENCY_CONVERT
import com.tkpmnc.sgtaxiuser.appcommon.utils.RequestCallback
import com.tkpmnc.sgtaxiuser.appcommon.views.CommonActivity
import com.tkpmnc.sgtaxiuser.appcommon.views.FlutterwaveWebViewActivity
import com.tkpmnc.sgtaxiuser.appcommon.views.MpesaPaymentWebViewActivity
import com.tkpmnc.sgtaxiuser.appcommon.views.PaymentWebViewActivity
import com.tkpmnc.sgtaxiuser.appcommon.views.PaytmPaymentWebViewActivity
import com.tkpmnc.sgtaxiuser.taxiapp.adapters.PriceRecycleAdapter
import com.tkpmnc.sgtaxiuser.taxiapp.database.AddFirebaseDatabase
import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.payment.PaymentPage
import com.tkpmnc.sgtaxiuser.taxiapp.views.customize.CustomDialog
import com.tkpmnc.sgtaxiuser.taxiapp.views.main.MainActivity
import kotlinx.android.synthetic.main.app_activity_add_wallet.*
import org.json.JSONException
import org.json.JSONObject
import java.util.*
import javax.inject.Inject

/* ************************************************************
    After trip completed driver can send payment
    *************************************************************** */
class PaymentAmountPage : CommonActivity(), ServiceListener, PaymentMethodNonceCreatedListener {

    private var mBraintreeFragment: BraintreeFragment? = null
    lateinit var dialog: AlertDialog

    @Inject
    lateinit var sessionManager: SessionManager

    @Inject
    lateinit var commonMethods: CommonMethods

    @Inject
    lateinit var apiService: ApiService

    @Inject
    lateinit var customDialog: CustomDialog

    @Inject
    lateinit var gson: Gson

    @BindView(R.id.btnSubmit)
    lateinit var rate_submit: Button

    @BindView(R.id.wallet_img)
    lateinit var wallet_img: ImageView

    @BindView(R.id.paymentmethod_type)
    lateinit var paymentmethod_type: TextView// Payment method type show in text view

    @BindView(R.id.rvPrice)
    lateinit var recyclerView: RecyclerView

    @BindView(R.id.paymentmethod)
    lateinit var paymentMethodView: RelativeLayout

    var payable_amt = 0f
    lateinit var total_fare: String
    lateinit var walletType: String
    lateinit var payment_method: String
    protected var isInternetAvailable: Boolean = false
    private var mRegistrationBroadcastReceiver: BroadcastReceiver? = null


    private var statusCode: String? = null


    private val REQUEST_CODE = 101
    private var nonce = ""

    @OnClick(R.id.back)
    fun back() {
        onBackPressed()
    }

    @OnClick(R.id.btnSubmit)
    fun rateSubmit() {
        if (rate_submit.text.toString() == resources.getString(R.string.pay)) {
            if (sessionManager.payementModeWebView!!) {
                val webview = Intent(this, PaymentWebViewActivity::class.java)
                webview.putExtra("payableWalletAmount", payable_amt.toString())
                webview.putExtra(Constants.INTENT_PAY_FOR, CommonKeys.PAY_FOR_TRIP)
                webview.putExtra(Constants.PAY_FOR_TYPE, CommonKeys.AFTER_PAYMENT)
                startActivityForResult(webview, Payment)
            } else {
                if (payment_method.contains(CommonKeys.PAYMENT_CARD, ignoreCase = true)) {
                    afterPayment("")
                } else {
                    currencyConversion(payable_amt.toString())
                }
            }
        } else if (rate_submit.text.toString() == resources.getString(R.string.proceed)) {
            paymentCompleted("")
        }

    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_payment_amount_page)
        ButterKnife.bind(this)
        AppController.appComponent.inject(this)
        /**Commmon Header Text View */
        commonMethods.setheaderText(resources.getString(R.string.paymentdetails),common_header)

        val policy = StrictMode.ThreadPolicy.Builder().permitAll().build()
        StrictMode.setThreadPolicy(policy)

        dialog = commonMethods.getAlertDialog(this)
        isInternetAvailable = commonMethods.isOnline(applicationContext)
        recyclerView.setHasFixedSize(true)
        val layoutManager = LinearLayoutManager(this)
        recyclerView.layoutManager = layoutManager

        // Receive push notification
        receivepushnotification()
    }


    /**
     * Load fare details for current trip
     */
    fun loadData() {
        val adapter = PriceRecycleAdapter(this)
        recyclerView.adapter = adapter
        adapter.notifyDataSetChanged()

        payable_amt = java.lang.Float.valueOf(totalFare)
        total_fare = totalFare

        driver_payout = driverPayout
        payment_method = paymentMode
        if (payable_amt <= 0) {
            rate_submit.isEnabled = true
            rate_submit.background = ContextCompat.getDrawable(this, R.drawable.app_curve_button_yellow)// Check payable amount is available or not ( sometimes wallet and promo to pay full trip amount that time payable amount is 0)
            rate_submit.text = resources.getString(R.string.proceed) // if payable amount is 0 then directly we can proceed to next step
        } else {
            if (payment_method.contains(CommonKeys.PAYMENT_CASH, ignoreCase = true)) {                           // if payment method is cashLayout then driver confirm the driver other wise rider pay the amount to another payment option
                rate_submit.isEnabled = false
                rate_submit.text = resources.getString(R.string.waitfordriver)
                rate_submit.setTextSize(15F)
                rate_submit.background = ContextCompat.getDrawable(this, R.drawable.app_curve_button_yellow_disable)
                ///rate_submit.setBackgroundColor(ContextCompat.getColor(this, R.color.newtaxi_app_black))
            } else {
                rate_submit.visibility = View.VISIBLE
                rate_submit.text = resources.getString(R.string.pay) // Rider pay button
                rate_submit.isEnabled = true
                rate_submit.background = ContextCompat.getDrawable(this, R.drawable.app_curve_button_yellow)
            }
        }
    }

    override fun onDestroy() {
        super.onDestroy()
        mBraintreeFragment?.removeListener(this)

    }

    private fun isMyServiceRunning(serviceClass: Class<*>): Boolean {
        val manager = getSystemService(Context.ACTIVITY_SERVICE) as ActivityManager
        for (service in manager.getRunningServices(Integer.MAX_VALUE)) {
            if (serviceClass.name == service.service.className) {
                return true
            }
        }
        return false
    }

    /**
     * Back button pressed
     */
    override fun onBackPressed() {
        if (intent.getIntExtra("isBack", 0) == 1) {
            super.onBackPressed()
        } else {
            sessionManager.isrequest = false
            sessionManager.isTrip = false
            CommonKeys.IS_ALREADY_IN_TRIP = true
            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent)
            finish()
        }
    }


    /**
     * show dialog for payment completed
     */
    fun statusDialog(message: String) {

        try {
            if (!this.isFinishing) {
                val inflater = layoutInflater
                val view = inflater.inflate(R.layout.addphoto_header, null)
                val tit = view.findViewById<View>(R.id.header) as TextView
                tit.text = resources.getString(R.string.paymentcompleted)
                val builder = android.app.AlertDialog.Builder(this)
                builder.setCustomTitle(view)
                builder.setTitle(message)
                    .setCancelable(false)
                    //.setMessage("Are you sure you want to delete this entry?")
                    .setPositiveButton(resources.getString(R.string.ok_c)) { dialog, _ ->
                        dialog.dismiss()
                        sessionManager.isrequest = false
                        sessionManager.isTrip = false
                        if (CommonKeys.IS_ALREADY_IN_TRIP) {
                            CommonKeys.IS_ALREADY_IN_TRIP = false
                        }
                        CommonMethods.gotoMainActivityWithoutHistory(this@PaymentAmountPage)
                        finish()
                    }

                    .show()
            }
        } catch (e: Exception) {
            e.printStackTrace()
        }

    }


    /**
     * Check payment completed or not
     */
    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == Payment) {
            if (data != null) {
                val statusCode = data.extras?.getString("status_code")
                val message = data.extras?.getString("status_message")
                if (statusCode.equals("1", true)) {
                    CommonMethods.stopFirebaseChatListenerService(this)
                    commonMethods.removeLiveTrackingNodesAfterCompletedTrip(this)
                    commonMethods.removeTripNodesAfterCompletedTrip(this)
                    sessionManager.clearTripID()
                    sessionManager.isDriverAndRiderAbleToChat = false
                    statusDialog(message!!)
                } else {
                    commonMethods.showMessage(this, dialog, message!!)
                }
            }
        } else if (requestCode == REQUEST_CODE) {
            if (data != null) {
                commonMethods.hideProgressDialog()
                try {
                    val result = data.getParcelableExtra<DropInResult>(DropInResult.EXTRA_DROP_IN_RESULT)
                    nonce = result?.paymentMethodNonce!!.nonce
                    isBrainTree = true
                    afterPayment(nonce)
                } catch (e: Exception) {
                    Toast.makeText(this, resources.getString(R.string.internal_server_error), Toast.LENGTH_LONG).show()
                    e.printStackTrace()
                }

            }
        } else {
            if (data != null) {
                commonMethods.hideProgressDialog()
                commonMethods.stripeInstance()!!.onPaymentResult(requestCode, data, object : ApiResultCallback<PaymentIntentResult> {
                    override fun onError(e: Exception) {
                        e.printStackTrace()
                    }

                    override fun onSuccess(result: PaymentIntentResult) {
                        val paymentIntent = result.intent
                        if (paymentIntent.status == StripeIntent.Status.Succeeded) {
                            afterPayment(paymentIntent.id!!)
                        } else {
                            commonMethods.showMessage(this@PaymentAmountPage, dialog, "Failed")
                        }
                    }

                })
            }
        }
    }


    /**
     * Receive push notification for payment completed
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

                    //String message = intent.getStringExtra("message");

                    val JSON_DATA = sessionManager.pushJson


                    var jsonObject: JSONObject?
                    try {
                        jsonObject = JSONObject(JSON_DATA)
                        if (jsonObject.getJSONObject("custom").has("trip_payment")) {
                            //statusDialog(resources.getString(R.string.paymentcompleted))
                        }
                    } catch (e: JSONException) {
                        e.printStackTrace()
                    }


                }
            }
        }
    }

    public override fun onResume() {
        super.onResume()

        commonMethods.dismissDialog()
        if (sessionManager.promoCount > 0) {

            if (sessionManager.paymentMethodkey.equals("") || sessionManager.paymentMethodkey!!.isEmpty()) {
                paymentmethod_type.background = ContextCompat.getDrawable(this, R.drawable.app_curve_button_green)
                paymentmethod_type.text = resources.getString(R.string.promo_applied)
                paymentmethod_type.gravity = Gravity.CENTER
                paymentmethod_type.setTextColor(ContextCompat.getColor(this,R.color.newtaxi_app_yellow))
                paymentmethod_type.isAllCaps = false
                paymentmethod_img.visibility = View.GONE
            } else {

                paymentmethod_type.background = ContextCompat.getDrawable(this, R.drawable.app_curve_button_green)
                paymentmethod_type.text = resources.getString(R.string.promo_applied)
                paymentmethod_type.gravity = Gravity.CENTER
                paymentmethod_type.setTextColor(ContextCompat.getColor(this,R.color.newtaxi_app_yellow))
                paymentmethod_type.isAllCaps = false
                paymentmethod_img.visibility = View.VISIBLE
                Picasso.get().load(sessionManager.paymentMethodImage).into(paymentmethod_img)
            }


        } else {
            if (sessionManager.paymentMethodkey.equals("") || sessionManager.paymentMethodkey!!.isEmpty()) {
                paymentmethod_type.text = resources.getString(R.string.Add_payment_type)
                paymentmethod_img.visibility = View.GONE
            } else {
                if (sessionManager.paymentMethodkey == CommonKeys.PAYMENT_CARD) {
                    if (sessionManager.cardValue != "") {
                        paymentmethod_type.text = "•••• " + sessionManager.cardValue
                    } else {
                        paymentmethod_type.text = resources.getString(R.string.card)
                    }
                    paymentmethod_img.setImageResource(R.drawable.app_ic_card)
                } else {
                    paymentmethod_type.text = sessionManager.paymentMethod
                    Picasso.get().load(sessionManager.paymentMethodImage).into(paymentmethod_img)
                }
                paymentmethod_img.visibility = View.VISIBLE
            }
        }

        //card selected
        if (sessionManager.isWallet) {
            DebuggableLogV("isWallet", "iswallet" + sessionManager.walletAmount)
            //iswallet="Yes";
            if ("" != sessionManager.walletAmount) {
                if (java.lang.Float.valueOf(sessionManager.walletAmount) > 0)
                    wallet_img.visibility = View.VISIBLE
                else
                    wallet_img.visibility = View.GONE
            }

        } else {
            //iswallet="No";
            wallet_img.visibility = View.GONE
        }

        // register FCM registration complete receiver
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver!!,
            IntentFilter(Config.REGISTRATION_COMPLETE))

        // register new push message receiver
        // by doing this, the activity will be notified each time a new message arrives
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver!!,
            IntentFilter(Config.PUSH_NOTIFICATION))

        // clear the notification area when the app is opened
        NotificationUtils.clearNotifications(applicationContext)

        if (isInternetAvailable && !isBrainTree) {
            commonMethods.showProgressDialog(this)
            println("Get Wallet type" + sessionManager.isWallet)
            if (sessionManager.isWallet) {
                walletType = "Yes"
            } else {
                walletType = "No"
            }
            AddFirebaseDatabase().updatePaymentChangedNode(walletType, sessionManager.paymentMethodkey!!, this)
        }
        /*if (dialog.isShowing) {
            dialog.dismiss()
        }*/


        Handler().postDelayed({
            commonMethods.hideProgressDialog()
        }, 3000)

        if (CommonKeys.isPaymentOrCancel) {
            CommonKeys.isPaymentOrCancel = false
            sessionManager.isrequest = false
            sessionManager.isTrip = false
            if (CommonKeys.IS_ALREADY_IN_TRIP) {
                CommonKeys.IS_ALREADY_IN_TRIP = false
            }

            CommonMethods.gotoMainActivityWithoutHistory(this@PaymentAmountPage)
            finish()
        }


    }

    public override fun onPause() {
        super.onPause()
        LocalBroadcastManager.getInstance(this).unregisterReceiver(mRegistrationBroadcastReceiver!!)
    }

    //Change payment mode
    fun gotoPaymentpage() {
        if (commonMethods.isOnline(this)) {
            val intent = Intent(this, PaymentPage::class.java)
            intent.putExtra(CommonKeys.TYPE_INTENT_ARGUMENT_KEY, CommonKeys.StatusCode.startPaymentActivityForView)
            startActivityForResult(intent, CommonKeys.ChangePaymentOpetionBeforeRequestCarApi)
            overridePendingTransition(R.anim.ub__slide_in_right, R.anim.ub__slide_out_left)
        } else {
            CommonMethods.showUserMessage(resources.getString(R.string.turnoninternet))
        }
    }

    companion object {

        private val TAG = "paymentExample"
    }
}