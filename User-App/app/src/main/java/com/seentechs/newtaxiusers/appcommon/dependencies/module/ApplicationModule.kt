package com.seentechs.newtaxiusers.appcommon.dependencies.module

/**
 * @package com.seentechs.newtaxiusers
 * @subpackage dependencies.module
 * @category ApplicationModule
 * @author Seen Technologies
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
