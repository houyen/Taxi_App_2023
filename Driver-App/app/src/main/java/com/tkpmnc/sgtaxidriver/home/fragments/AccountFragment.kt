/*
 * Copyright (c) 2017. Truiton (http://www.truiton.com/).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Contributors:
 * Mohit Gupt (https://github.com/mohitgupt)
 *
 */

package com.tkpmnc.sgtaxidriver.home.fragments

/**
 * @package com.tkpmnc.sgtaxidriver.home.fragments
 * @subpackage fragments
 * @category AccountFragment
 * 
 *
 */


import android.annotation.SuppressLint
import android.app.Dialog
import android.content.Context
import android.content.Intent
import android.os.Build
import android.os.Bundle
import android.text.Html
import android.text.TextUtils
import android.view.*
import android.widget.ImageView
import android.widget.ProgressBar
import android.widget.RelativeLayout
import android.widget.TextView
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.google.gson.Gson
import com.squareup.picasso.Callback
import com.squareup.picasso.Picasso
import com.tkpmnc.sgtaxidriver.home.MainActivity
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.home.fragments.Referral.ShowReferralOptionsActivity
import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.home.datamodel.BankDetailsModel
import com.tkpmnc.sgtaxidriver.home.datamodel.CurrencyDetailsModel
import com.tkpmnc.sgtaxidriver.home.datamodel.CurreneyListModel
import com.tkpmnc.sgtaxidriver.home.datamodel.DriverProfileModel
import com.tkpmnc.sgtaxidriver.home.fragments.currency.CurrencyListAdapter
import com.tkpmnc.sgtaxidriver.home.fragments.currency.CurrencyModel
import com.tkpmnc.sgtaxidriver.home.fragments.language.LanguageAdapter
import com.tkpmnc.sgtaxidriver.common.helper.CustomDialog
import com.tkpmnc.sgtaxidriver.home.interfaces.ApiService
import com.tkpmnc.sgtaxidriver.home.interfaces.ServiceListener
import com.tkpmnc.sgtaxidriver.home.managevehicles.SettingActivity.Companion.alertDialogStores1
import com.tkpmnc.sgtaxidriver.home.managevehicles.SettingActivity.Companion.alertDialogStores2
import com.tkpmnc.sgtaxidriver.home.managevehicles.SettingActivity.Companion.currencyclick
import com.tkpmnc.sgtaxidriver.home.managevehicles.SettingActivity.Companion.langclick
import com.tkpmnc.sgtaxidriver.common.model.JsonResponse
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.home.payouts.PayoutDetailsListActivity
import com.tkpmnc.sgtaxidriver.home.payouts.PayoutEmailListActivity
import com.tkpmnc.sgtaxidriver.home.profile.DriverProfile
import com.tkpmnc.sgtaxidriver.home.profile.VehiclInformation
import com.tkpmnc.sgtaxidriver.home.signinsignup.SigninSignupHomeActivity
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_CURRENCY
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_DRIVER_PROFILE
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_LANGUAGE
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_LOGOUT
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_UPDATE_CURRENCY
import com.tkpmnc.sgtaxidriver.common.util.RequestCallback
import java.io.File
import java.util.*
import javax.inject.Inject
import kotlin.collections.ArrayList


/* ************************************************************
                      AccountFragment
Its used get home screen account fragment details
*************************************************************** */

class AccountFragment : Fragment(), ServiceListener {

    @Inject
    lateinit var commonMethods: CommonMethods
    @Inject
    lateinit var apiService: ApiService
    @Inject
    lateinit var sessionManager: SessionManager
    @Inject
    lateinit var gson: Gson
    @Inject
    lateinit var customDialog: CustomDialog

    lateinit @BindView(R.id.imglatout1)
    var imglatout1: RelativeLayout
    lateinit @BindView(R.id.rlt_bank_layout)
    var rltBankLayout: RelativeLayout
    lateinit @BindView(R.id.imglatout2)
    var imglatout2: RelativeLayout
    lateinit @BindView(R.id.documentlayout)
    var documentlayout: RelativeLayout
    lateinit @BindView(R.id.signlayout)
    var signlayout: RelativeLayout
    lateinit @BindView(R.id.rltPayTo)
    var rltPayTo: RelativeLayout
    lateinit @BindView(R.id.currencylayout)
    var currencylayout: RelativeLayout
    lateinit @BindView(R.id.languagelayout)
    var languagelayout: RelativeLayout
    lateinit @BindView(R.id.profile_image1)
    var profile_image1: ImageView
    lateinit @BindView(R.id.profilename)
    var profilename: TextView
    lateinit @BindView(R.id.carno)
    var carno: TextView
    lateinit @BindView(R.id.carname)
    var carname: TextView
    lateinit @BindView(R.id.language)
    var language: TextView
    lateinit @BindView(R.id.currency_code)
    var currency_code: TextView

    lateinit @BindView(R.id.car_image)
    var carImage: ImageView

    lateinit @BindView(R.id.tv_view)
    var tvView: TextView

    lateinit @BindView(R.id.pb_loader)
    var pbLoader: ProgressBar

    lateinit @BindView(R.id.arrarowone)
    var arrarowone: TextView
    lateinit @BindView(R.id.arrarowtwo)
    var arrarowtwo: TextView
    lateinit @BindView(R.id.arrarowthree)
    var arrarowthree: TextView
    lateinit @BindView(R.id.arrarowfour)
    var arrarowfour: TextView
    lateinit @BindView(R.id.arrarowfive)
    var arrarowfive: TextView
    lateinit @BindView(R.id.arrarowsix)
    var arrarowsix: TextView
    lateinit @BindView(R.id.arrarowseven)
    var arrarowseven: TextView

    internal var bankDetailsModel: BankDetailsModel? = null
    var vehicle_name: String? = null
    var vehicle_number: String? = null
    var car_type: String? = null
    var car_image: String? = null
    lateinit var recyclerView1: RecyclerView
    lateinit var languageView: RecyclerView
    lateinit var currencyList: ArrayList<CurrencyModel>
    var languagelist: MutableList<CurrencyModel> = ArrayList<CurrencyModel>()
    lateinit var currencyListAdapter: CurrencyListAdapter
    lateinit var LanguageAdapter: LanguageAdapter
    lateinit var symbol: Array<String?>
    lateinit var currencycode: Array<String?>
    var currency: String=""
    var Language: String? = null
    var LanguageCode: String? = null
    lateinit var driverProfileModel: DriverProfileModel
    lateinit var langocde: String
    private var dialog: AlertDialog? = null
    private var companyName: String? = null
    private var company_id: Int = 0

    lateinit @BindView(R.id.referral_layout)
    var referral_layout: RelativeLayout

    @OnClick(R.id.currencylayout)
    fun currency() {
        currencylayout.isClickable = false
        currency_list()
    }

    /**
     * Driver Profile
     */
    @OnClick(R.id.imglatout1)
    fun profile() {
        val intent = Intent(activity, DriverProfile::class.java)
        startActivity(intent)
    }


    /**
     * Driver Vehicle Profile
     */
    @OnClick(R.id.imglatout2)
    fun vehicleProfile() {
        val intent = Intent(activity, VehiclInformation::class.java)
        intent.putExtra("vehiclename", vehicle_name)
        intent.putExtra("vehiclenumber", vehicle_number)
        intent.putExtra("car_type", car_type)
        intent.putExtra("companyname", companyName)
        intent.putExtra("companyid", company_id)
        intent.putExtra("car_image", car_image)
        startActivity(intent)
    }



    override fun onAttach(context: Context) {
        super.onAttach(context)


    }

    @SuppressLint("UseRequireInsteadOfGet")
    @OnClick(R.id.signlayout)
    fun logoutpopup() {
        val dialog = Dialog(activity!!)
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE)
        dialog.setContentView(R.layout.dialog_logout)
        // set the custom dialog components - text, image and button
        val cancel = dialog.findViewById<View>(R.id.signout_cancel) as TextView
        val signout = dialog.findViewById<View>(R.id.signout_signout) as TextView
        // if button is clicked, close the custom dialog
        cancel.setOnClickListener { dialog.dismiss() }

        signout.setOnClickListener {
            logout()
            dialog.dismiss()
        }
        dialog.show()
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)


    }


    override fun onActivityCreated(savedInstanceState: Bundle?) {
        super.onActivityCreated(savedInstanceState)
    }

    override fun onStart() {
        super.onStart()
    }


    @SuppressLint("UseRequireInsteadOfGet")
    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View? {

        val view = inflater.inflate(R.layout.fragment_account, container, false)

        AppController.getAppComponent().inject(this)
        ButterKnife.bind(this, view)
        commonMethods.imageChangeforLocality(context!!,arrarowone)
        commonMethods.imageChangeforLocality(context!!,arrarowtwo)
        commonMethods.imageChangeforLocality(context!!,arrarowthree)
        commonMethods.imageChangeforLocality(context!!,arrarowfour)
        commonMethods.imageChangeforLocality(context!!,arrarowfive)
        commonMethods.imageChangeforLocality(context!!,arrarowsix)
        commonMethods.imageChangeforLocality(context!!,arrarowseven)
        dialog = commonMethods.getAlertDialog(activity!!)
        pbLoader.visibility = View.VISIBLE
        currency = sessionManager.currencyCode!!
        print("currency" + currency)
        currency_code.text = currency

        return view
    }


    /**
     * Driver Datas
     */
    private fun getDriverProfile() {
        commonMethods.showProgressDialog(activity as AppCompatActivity)
        apiService.getDriverProfile(sessionManager.accessToken!!).enqueue(RequestCallback(REQ_DRIVER_PROFILE, this))
    }

    /**
     * Driver Logout
     */
    private fun logout() {
        commonMethods.showProgressDialog(activity as AppCompatActivity)
        apiService.logout(sessionManager.type!!, sessionManager.accessToken!!).enqueue(RequestCallback(REQ_LOGOUT, this))
    }


    @SuppressLint("UseRequireInsteadOfGet")
    override fun onSuccess(jsonResp: JsonResponse, data: String) {

        commonMethods.hideProgressDialog()
        if (!jsonResp.isOnline) {
            if (!TextUtils.isEmpty(data)) commonMethods.showMessage(activity, dialog, data)
            return
        }

        when (jsonResp.requestCode) {
            REQ_LOGOUT -> if (jsonResp.isSuccess) {
                onSuccessLogOut()
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.showMessage(activity, dialog, jsonResp.statusMsg)
            }
            REQ_DRIVER_PROFILE -> if (jsonResp.isSuccess) {
                onSuccessDriverProfile(jsonResp)
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.showMessage(activity, dialog, jsonResp.statusMsg)
            }
            REQ_CURRENCY -> if (jsonResp.isSuccess) {
                onSuccessgetCurrency(jsonResp)
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.showMessage(activity, dialog, jsonResp.statusMsg)
            }
            REQ_UPDATE_CURRENCY -> if (jsonResp.isSuccess) {
                getDriverProfile()
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.showMessage(activity, dialog, jsonResp.statusMsg)
            }
            REQ_LANGUAGE -> if (jsonResp.isSuccess) {
                setLocale(langocde)
                activity!!.recreate()
                val intent = Intent(activity, MainActivity::class.java)
                intent.flags = Intent.FLAG_ACTIVITY_CLEAR_TOP
                startActivity(intent)
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.showMessage(activity, dialog, jsonResp.statusMsg)
            }
            else -> {
            }
        }
    }


    override fun onFailure(jsonResp: JsonResponse, data: String) {

        CommonMethods.DebuggableLogI("datacheck", "datacheck")
    }

    /**
     * SuccessFully Log out
     */
    @SuppressLint("UseRequireInsteadOfGet")
    private fun onSuccessLogOut() {

        val lang = sessionManager.language
        val langCode = sessionManager.languageCode
     //   CommonMethods.stopSinchService(context)
        CommonMethods.stopSinchService(context!!)
        sessionManager.clearAll()
        clearApplicationData() // Clear cache data

        sessionManager.language = lang
        sessionManager.languageCode = langCode


        val intent = Intent(activity, SigninSignupHomeActivity::class.java)
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP or Intent.FLAG_ACTIVITY_NEW_TASK)
        startActivity(intent)

    }

    fun onSuccessDriverProfile(jsonResponse: JsonResponse) {
        driverProfileModel = gson.fromJson(jsonResponse.strResponse, DriverProfileModel::class.java)
        sessionManager.profileDetail = jsonResponse.strResponse
        loadData(driverProfileModel)
        val carid = ""
        sessionManager.vehicle_id = carid
        CommonMethods.DebuggableLogV("localshared", "Carid==" + sessionManager.vehicle_id)
    }

    /*
     *  Load Driver profile details
     **/
    fun loadData(driverProfileModel: DriverProfileModel) {

        val first_name = driverProfileModel.firstName
        val last_name = driverProfileModel.lastName
        val user_thumb_image = driverProfileModel.profileImage
        sessionManager.firstName = first_name
        sessionManager.phoneNumber = driverProfileModel.mobileNumber
        company_id = driverProfileModel.companyId
        companyName = driverProfileModel.companyName
        //bankDetailsModel = driverProfileModel.bank_detail


        vehicle_name = driverProfileModel.vehicleName
        vehicle_number = driverProfileModel.vehicleNumber
        car_type = driverProfileModel.carType
        car_image = driverProfileModel.carActiveImage
        sessionManager.oweAmount = driverProfileModel.oweAmount
        sessionManager.driverReferral = driverProfileModel.driverReferralEarning


        profilename.text = "$first_name $last_name"
        if (isAdded) {
            Picasso.get().load(user_thumb_image).into(profile_image1)
        }

        if (company_id > 1) {
            rltPayTo.visibility = View.GONE
            referral_layout.visibility = View.GONE
        } else {
            rltPayTo.visibility = View.VISIBLE
            referral_layout.visibility = View.VISIBLE
        }

        if (!TextUtils.isEmpty(vehicle_name) && !TextUtils.isEmpty(vehicle_name)) {
            carno.text = vehicle_number
            carname.text = vehicle_name
        } else {
            pbLoader.visibility = View.GONE
            imglatout2.isEnabled = false
            tvView.visibility = View.GONE
            carImage.visibility = View.VISIBLE
            carno.visibility = View.GONE
            carname.gravity = Gravity.CENTER_HORIZONTAL or Gravity.CENTER_VERTICAL
            carname.text = resources.getString(R.string.no_vehicle_assigned)
        }
        try {
            Picasso.get().load(car_image).error(R.drawable.car).into(carImage, object : Callback {
                override fun onSuccess() {
                    pbLoader.visibility = View.GONE
                }

                override fun onError(e: java.lang.Exception?) {
                    pbLoader.visibility = View.GONE
                }
            })
        } catch (e: Exception) {
            e.printStackTrace()
        }

    }


    /*
     *  Get Driver profile while open the page
     **/
    override fun onResume() {
        super.onResume()
        Language = sessionManager.language
        if (Language != null) {
            language.text = Language
        } else {
            language.text = "English"
        }

        getDriverProfile()

    }


    override fun onPause() {
        super.onPause()

    }

    override fun onStop() {
        super.onStop()

    }

    override fun onDestroyView() {
        super.onDestroyView()

    }

    override fun onDetach() {
        super.onDetach()

    }

    override fun onDestroy() {
        super.onDestroy()

    }

}
