package com.seentechs.newtaxidriver.trips.viewmodel

import androidx.lifecycle.LiveData
import com.tkpmnc.newtaxidriver.common.model.JsonResponse

interface RequestAcceptActivityInterface {

    fun onSuccessResponse(jsonResponse: LiveData<JsonResponse>)
    fun onFailureResponse(jsonResponse: LiveData<JsonResponse>)

}