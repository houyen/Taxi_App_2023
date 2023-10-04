package com.tkpmnc.newtaxiusers.appcommon.dependencies.module

/**
 *  newtaxiusers
 * @subpackage dependencies.module
 * @category ApplicationModule
 *  
 *
 */

import android.app.Application

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
}
