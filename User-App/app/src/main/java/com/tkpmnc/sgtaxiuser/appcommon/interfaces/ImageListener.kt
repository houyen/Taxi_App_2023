package com.tkpmnc.sgtaxiusers.appcommon.interfaces

/**
 * @package com.tkpmnc.sgtaxiusers
 * @subpackage interfaces
 * @category ImageListener
 * @author Seen Technologies
 * 
 */

import okhttp3.RequestBody

/*****************************************************************
 * ImageListener
 */

interface ImageListener {
    fun onImageCompress(filePath: String, requestBody: RequestBody?)
}
