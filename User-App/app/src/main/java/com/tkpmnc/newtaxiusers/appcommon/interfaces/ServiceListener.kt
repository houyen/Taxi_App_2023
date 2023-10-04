package com.seentechs.newtaxiusers.appcommon.interfaces

/**
 *  newtaxiusers
 * @subpackage interfaces
 * @category ServiceListener
 *  
 * 
 */

import com.tkpmnc.newtaxiusers.appcommon.datamodels.JsonResponse

/*****************************************************************
 * ServiceListener
 */
interface ServiceListener {

    fun onSuccess(jsonResp: JsonResponse, data: String)

    fun onFailure(jsonResp: JsonResponse, data: String)
}
