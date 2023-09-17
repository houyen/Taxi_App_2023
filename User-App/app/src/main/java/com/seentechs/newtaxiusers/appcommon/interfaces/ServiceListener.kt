package com.seentechs.newtaxiusers.appcommon.interfaces

/**
 * @package com.seentechs.newtaxiusers
 * @subpackage interfaces
 * @category ServiceListener
 * @author Seen Technologies
 * 
 */

import com.seentechs.newtaxiusers.appcommon.datamodels.JsonResponse

/*****************************************************************
 * ServiceListener
 */
interface ServiceListener {

    fun onSuccess(jsonResp: JsonResponse, data: String)

    fun onFailure(jsonResp: JsonResponse, data: String)
}
