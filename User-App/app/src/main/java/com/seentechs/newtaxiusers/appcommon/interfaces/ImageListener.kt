package com.seentechs.newtaxiusers.appcommon.interfaces

/**
 * @package com.seentechs.newtaxiusers
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
