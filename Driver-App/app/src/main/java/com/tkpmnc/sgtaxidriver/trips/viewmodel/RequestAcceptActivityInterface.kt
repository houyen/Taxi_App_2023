package com.tkpmnc.sgtaxidriver.trips.viewmodel

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import com.tkpmnc.sgtaxidriver.common.model.JsonResponse

interface RequestAcceptActivityInterface {

    fun onSuccessResponse(jsonResponse: MutableLiveData<JsonResponse?>)
    fun onFailureResponse(jsonResponse: LiveData<JsonResponse>)

}