package com.tkpmnc.sgtaxiuser.appcommon.interfaces

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage interfaces
 * @category ServiceListener
 * 
 * 
 */

import com.tkpmnc.sgtaxiuser.appcommon.datamodels.JsonResponse

/*****************************************************************
 * ServiceListener
 */
interface ServiceListener {

    fun onSuccess(jsonResp: JsonResponse, data: String)

    fun onFailure(jsonResp: JsonResponse, data: String)
}
