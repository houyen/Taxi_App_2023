package com.tkpmnc.sgtaxiusers.appcommon.interfaces

/**
 * @package com.tkpmnc.sgtaxiusers
 * @subpackage interfaces
 * @category ServiceListener
 * @author Seen Technologies
 * 
 */

import com.tkpmnc.sgtaxiusers.appcommon.datamodels.JsonResponse

/*****************************************************************
 * ServiceListener
 */
interface ServiceListener {

    fun onSuccess(jsonResp: JsonResponse, data: String)

    fun onFailure(jsonResp: JsonResponse, data: String)
}
