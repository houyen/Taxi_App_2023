package com.tkpmnc.newtaxiusers.appcommon.interfaces

/**
 *  newtaxiusers
 * @subpackage interfaces
 * @category ImageListener
 *  
 * 
 */

import okhttp3.RequestBody

/*****************************************************************
 * ImageListener
 */

interface ImageListener {
    fun onImageCompress(filePath: String, requestBody: RequestBody?)
}
