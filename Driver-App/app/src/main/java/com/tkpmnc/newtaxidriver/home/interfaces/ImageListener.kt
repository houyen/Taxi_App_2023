package com.seentechs.newtaxidriver.home.interfaces

import okhttp3.RequestBody


interface ImageListener {
    fun onImageCompress(filePath: String, requestBody: RequestBody?)
}

