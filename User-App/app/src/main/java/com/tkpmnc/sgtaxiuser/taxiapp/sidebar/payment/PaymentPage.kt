package com.tkpmnc.sgtaxiuser.taxiapp.sidebar.payment

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage Side_Bar.payment
 * @category PaymentPage
 * 
 * 
 */

import android.content.Intent
import android.os.Bundle
import android.os.SystemClock
import com.google.android.material.bottomsheet.BottomSheetDialog
import androidx.appcompat.app.AlertDialog
import android.text.TextUtils
import android.view.View
import android.widget.Button
import android.widget.EditText
import android.widget.ImageView
import android.widget.RelativeLayout
import android.widget.TextView

import com.tkpmnc.sgtaxiuser.R
import com.tkpmnc.sgtaxiuser.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiuser.appcommon.datamodels.JsonResponse
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ApiService
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ServiceListener
import com.tkpmnc.sgtaxiuser.appcommon.network.AppController
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonKeys
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums
import com.tkpmnc.sgtaxiuser.appcommon.utils.RequestCallback
import com.tkpmnc.sgtaxiuser.taxiapp.views.customize.CustomDialog

import org.json.JSONException
import org.json.JSONObject

import javax.inject.Inject

import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.google.gson.Gson
import com.tkpmnc.sgtaxiuser.taxiapp.datamodels.PaymentMethodsModel


import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_ADD_CARD
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_ADD_PROMO
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_GET_PROMO
import com.tkpmnc.sgtaxiuser.appcommon.views.CommonActivity
import kotlinx.android.synthetic.main.app_activity_add_wallet.*
import kotlinx.android.synthetic.main.app_activity_add_wallet.common_header
import kotlinx.android.synthetic.main.app_activity_payment_page.*


/* ************************************************************
    Rider can select the payment method
    *********************************************************** */
class PaymentPage : CommonActivity(), ServiceListener,PaymentMethodAdapter.ItemClickListener {


    lateinit var dialog2: AlertDialog
    @Inject
    lateinit var sessionManager: SessionManager
    @Inject
    lateinit var commonMethods: CommonMethods
    @Inject
    lateinit var apiService: ApiService
    @Inject
    lateinit var customDialog: CustomDialog

    @Inject
    lateinit var gson:Gson

    @BindView(R.id.tv_caller_name)
    lateinit var wallet_amt: TextView
    @BindView(R.id.promo_count)
    lateinit var promo_count: TextView

    @BindView(R.id.tv_add_or_change_card)
    lateinit var addCreditOrDebitCardTextView: TextView


    @BindView(R.id.tv_alreadyAvailableCardNumber)
    lateinit var alreadyAvailableCardNumber: TextView
    @BindView(R.id.arrow)
    lateinit var arrow: ImageView
    @BindView(R.id.cash_tickimg)
    lateinit var cashtick_img: ImageView

    @BindView(R.id.cash)
    lateinit var cashLayout: RelativeLayout

    @BindView(R.id.rlt_wallet)
    lateinit var completeWalletLayoutIncludingTitle: RelativeLayout
    lateinit var dialog: BottomSheetDialog
    protected var isInternetAvailable: Boolean = false

    private lateinit var paymentmethodadapter:PaymentMethodAdapter
    private var paymentArryalist=ArrayList<PaymentMethodsModel.PaymentMethods>()


    override fun onItemClick() {
        val stripe = Intent(this, com.tkpmnc.sgtaxiuser.taxiapp.views.addCardDetails.AddCardActivity::class.java)
        startActivityForResult(stripe, CommonKeys.REQUEST_CODE_PAYMENT)
    }


    @OnClick(R.id.cash)
    fun cash() {
        /**
         * Payment method cashLayout click
         */
        showPaymentTickAccordingToTheSelection()
        sessionManager.paymentMethod = CommonKeys.PAYMENT_CASH
        onBackPressed()
    }


    @OnClick(R.id.arrow)
    fun arrow() {
        onBackPressed()
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        // common declerations
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_payment_page)
        AppController.appComponent.inject(this)
        ButterKnife.bind(this)
        /**Commmon Header Text View */
        commonMethods.setheaderText(resources.getString(R.string.payment),common_header)
        dialog2 = commonMethods.getAlertDialog(this)
        isInternetAvailable = commonMethods.isOnline(applicationContext)
        proceedActivityAccordingToType(intent.getIntExtra(CommonKeys.TYPE_INTENT_ARGUMENT_KEY, CommonKeys.StatusCode.startPaymentActivityForView))
        paymentmethodadapter=PaymentMethodAdapter(this@PaymentPage,paymentArryalist,this)
        rv_payment_list.adapter=paymentmethodadapter

        getPaymentMethodList()

    }

    fun  getPaymentMethodList()
    {
        CommonKeys.isFirstSetpaymentMethod=true
        apiService.getPaymentMethodlist(sessionManager.accessToken!!,CommonKeys.isWallet).enqueue(RequestCallback(Enums.REG_GET_PAYMENTMETHOD, this))
    }

    override fun onBackPressed() {
        super.onBackPressed()  //Back button pressed
        overridePendingTransition(R.anim.ub__slide_in_left, R.anim.ub__slide_out_right)
    }

    public override fun onDestroy() {
        super.onDestroy()
    }

    override fun onSuccess(jsonResp: JsonResponse, data: String) {
        commonMethods.hideProgressDialog()
        if (!jsonResp.isOnline) {
            if (!TextUtils.isEmpty(data))
                commonMethods.showMessage(this, dialog2, data)
            return
        }
        when (jsonResp.requestCode) {
            Enums.REG_GET_PAYMENTMETHOD-> if(jsonResp.isSuccess) {
                val paymentmodel = gson.fromJson(jsonResp.strResponse, PaymentMethodsModel::class.java)
                var isDefaultpaymentmethod=""
                sessionManager.paymentMethodDetail = gson.toJson(paymentmodel.paymentlist)
                paymentArryalist.addAll(paymentmodel.paymentlist)

                if (sessionManager.paymentMethodkey!!.isNotEmpty()) {
                    for (i in 0 until paymentmodel.paymentlist.size) {
                        CommonKeys.isSetPaymentMethod=true
                        if (sessionManager.paymentMethodkey.equals(paymentmodel.paymentlist.get(i).paymenMethodKey,ignoreCase = true)) {
                            val paymentmode=paymentmodel.paymentlist.get(i)
                            sessionManager.paymentMethod=paymentmode.paymenMethodvalue
                            sessionManager.paymentMethodkey=paymentmode.paymenMethodKey
                            sessionManager.paymentMethodImage=paymentmode.paymenMethodIcon
                            paymentmethodadapter.notifyDataSetChanged()
                            return
                        } else {
                            if (paymentmodel.paymentlist[i].isDefaultPaymentMethod) {
                                CommonKeys.isSetPaymentMethod=false
                            }
                        }
                    }
                    CommonKeys.isSetPaymentMethod=false
                    sessionManager.paymentMethodkey=""
                } else {
                    for (i in 0 until paymentmodel.paymentlist.size) {
                        if (paymentmodel.paymentlist[i].isDefaultPaymentMethod) {
                            CommonKeys.isSetPaymentMethod=false
                        }
                    }

                }
                paymentmethodadapter.notifyDataSetChanged()

            }else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.showMessage(this, dialog2, jsonResp.statusMsg)
            }
        }
    }

}
