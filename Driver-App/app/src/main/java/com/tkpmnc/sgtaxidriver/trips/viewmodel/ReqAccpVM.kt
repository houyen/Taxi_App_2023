package com.tkpmnc.sgtaxidriver.trips.viewmodel

import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.google.android.gms.maps.model.LatLng
import com.google.gson.Gson
import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.common.helper.CustomDialog
import com.tkpmnc.sgtaxidriver.common.model.JsonResponse
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods.Companion.DebuggablePrintln
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_ARRIVE_NOW
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_BEGIN_TRIP
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_END_TRIP
import com.tkpmnc.sgtaxidriver.common.util.Enums.REQ_TOLL_REASON
import com.tkpmnc.sgtaxidriver.common.util.RequestCallback
import com.tkpmnc.sgtaxidriver.home.interfaces.ApiService
import com.tkpmnc.sgtaxidriver.home.interfaces.ServiceListener
import okhttp3.RequestBody
import javax.inject.Inject

class ReqAccpVM : ViewModel(), ServiceListener {
    @Inject
    lateinit var apiService: ApiService

    @Inject
    lateinit var commonMethods: CommonMethods

    @Inject
    lateinit var customDialog: CustomDialog
    var live_data_response = MutableLiveData<JsonResponse?>()

    @Inject
    lateinit var gson: Gson

    @Inject
    lateinit var sessionManager: SessionManager
    var requestAcceptActivityInterface: RequestAcceptActivityInterface? = null


    fun initAppController() {
        AppController.getAppComponent().inject(this)

    }

    fun getTollReasons(activity: AppCompatActivity) {
        commonMethods.showProgressDialog(activity)
        apiService.getToll_reasons(sessionManager.accessToken!!).enqueue(RequestCallback(REQ_TOLL_REASON, this))

    }


    fun beginTrip(activity: AppCompatActivity) {

        //commonMethods.showProgressDialog(activity)
        apiService.beginTrip(sessionManager.tripId!!, sessionManager.latitude!!, sessionManager.longitude!!, sessionManager.accessToken!!).enqueue(RequestCallback(REQ_BEGIN_TRIP, this))

    }


    fun arriveNow(activity: AppCompatActivity) {
        //commonMethods.showProgressDialog(activity)
        apiService.ariveNow(sessionManager.tripId!!, sessionManager.accessToken!!).enqueue(RequestCallback(REQ_ARRIVE_NOW, this))

    }


    fun endTrip(formBody: RequestBody, activity: AppCompatActivity) {
        //commonMethods.showProgressDialog(activity)
        apiService.endTrip(formBody).enqueue(RequestCallback(REQ_END_TRIP, this))

    }


    /*
     *  Get direction for given locations
     */
    internal fun getDirectionsUrl(origin: LatLng, dest: LatLng): String {

        val str_origin = "origin=" + origin.latitude + "," + origin.longitude

        val str_dest = "destination=" + dest.latitude + "," + dest.longitude

        val sensor = "sensor=false"
        val mode = "mode=driving"
        val parameters = "$str_origin&$str_dest&$sensor&$mode"

        val output = "json"

        DebuggablePrintln("Static Map Url", "https://maps.googleapis.com/maps/api/directions/" + output + "?" + parameters + "&key=" + sessionManager.googleMapKey)
        return "https://maps.googleapis.com/maps/api/directions/" + output + "?" + parameters + "&key=" + sessionManager.googleMapKey
    }


    override fun onSuccess(jsonResp: JsonResponse?, data: String?) {

        live_data_response.value = jsonResp
        requestAcceptActivityInterface?.onSuccessResponse(live_data_response)

    }

    override fun onFailure(jsonResp: JsonResponse?, data: String?) {
        live_data_response.value = jsonResp
        requestAcceptActivityInterface?.onSuccessResponse(live_data_response)
    }
}