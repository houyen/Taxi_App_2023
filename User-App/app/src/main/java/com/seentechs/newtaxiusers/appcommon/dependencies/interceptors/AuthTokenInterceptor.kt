package com.seentechs.newtaxiusers.appcommon.dependencies.interceptors

/**
 *  newtaxiusers
 * @subpackage dependencies.interceptors
 * @category AuthTokenInterceptor
 *  
 *
 */

import com.seentechs.newtaxiusers.appcommon.configs.SessionManager

import java.io.IOException

import okhttp3.Interceptor
import okhttp3.Request
import okhttp3.Response

/*****************************************************************
 * Auth Token Interceptor
 */
class AuthTokenInterceptor(private val sessionManager: SessionManager) : Interceptor {
    private var requestBuilder: Request.Builder? = null

    @Throws(IOException::class)
    override fun intercept(chain: Interceptor.Chain): Response {
        try {
            val original = chain.request()

            requestBuilder = original.newBuilder().header("Authorization", sessionManager.token.toString()).method(original.method, original.body)
        } catch (e: Exception) {
            e.printStackTrace()
        }

        val request = requestBuilder!!.build()
        return chain.proceed(request)
    }
}
