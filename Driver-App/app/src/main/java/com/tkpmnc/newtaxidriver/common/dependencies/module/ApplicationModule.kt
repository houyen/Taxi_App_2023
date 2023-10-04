package com.tkpmnc.newtaxidriver.common.dependencies.module

/**
 * @subpackage dependencies.module
 * @category ApplicationModule
 *
 */

import android.app.Application

import com.tkpmnc.newtaxidriver.common.util.CommonMethods

import javax.inject.Singleton

import dagger.Module
import dagger.Provides

/*****************************************************************
 * Application Module
 */
@Module
class ApplicationModule(private val application: Application) {

    @Provides
    @Singleton
    fun application(): Application {
        return application
    }

    @Provides
    @Singleton
    fun providesCommonMethods(): CommonMethods {
        return CommonMethods()
    }

    /* @Provides
    @Singleton
    public JsonResponse providesJsonResponse() {
        return new JsonResponse();
    }*/
}
