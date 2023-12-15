package com.tkpmnc.sgtaxidriver.home.interfaces;

import com.tkpmnc.sgtaxidriver.common.model.JsonResponse;


public interface ServiceListener {

    void onSuccess(JsonResponse jsonResp, String data);

    void onFailure(JsonResponse jsonResp, String data);


    /*void onSuccessResponse(JsonResponse jsonResp, String data);*/
}

