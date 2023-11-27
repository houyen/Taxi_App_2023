package com.tkpmnc.sgtaxiuser.appcommon.interfaces

/**
 * @package com.tkpmnc.sgtaxiuser
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
