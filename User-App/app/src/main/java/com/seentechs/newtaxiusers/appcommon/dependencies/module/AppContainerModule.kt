package com.seentechs.newtaxiusers.appcommon.dependencies.module

/**
 * @package com.seentechs.newtaxiusers
 * @subpackage dependencies.module
 * @category AppContainerModule
 * @author Seen Technologies
 *
 */

import android.app.Application
import android.content.Context
import android.content.SharedPreferences
import com.seentechs.newtaxiusers.R
import com.seentechs.newtaxiusers.appcommon.configs.RunTimePermission
import com.seentechs.newtaxiusers.appcommon.configs.SessionManager
import com.seentechs.newtaxiusers.appcommon.database.SqLiteDb
import com.seentechs.newtaxiusers.appcommon.datamodels.JsonResponse
import com.seentechs.newtaxiusers.appcommon.network.AppController
import com.seentechs.newtaxiusers.appcommon.utils.CommonMethods
import com.seentechs.newtaxiusers.appcommon.utils.userchoice.UserChoice
import com.seentechs.newtaxiusers.taxiapp.views.customize.CustomDialog
import dagger.Module
import dagger.Provides
import java.util.*
import javax.inject.Singleton

/*****************************************************************
 * App Container Module
 */
@Module(includes = [com.seentechs.newtaxiusers.appcommon.dependencies.module.ApplicationModule::class])
class AppContainerModule {

    @Provides
    @Singleton
    fun providesSharedPreferences(application: Application): SharedPreferences {
        return application.getSharedPreferences(application.resources.getString(R.string.app_name), Context.MODE_PRIVATE)
    }

    @Provides
    @Singleton
    fun providesCommonMethods(): CommonMethods {
        return CommonMethods()
    }

    @Provides
    @Singleton
    fun providesSessionManager(): SessionManager {
        return SessionManager()
    }


    @Provides
    @Singleton
    fun providesRunTimePermission(): RunTimePermission {
        return RunTimePermission()
    }

    @Provides
    @Singleton
    fun providesContext(application: Application): Context {
        return application.applicationContext
    }

    @Provides
    @Singleton
    fun providesStringArrayList(): ArrayList<String> {
        return ArrayList()
    }

    @Provides
    @Singleton
    fun providesJsonResponse(): JsonResponse {
        return JsonResponse()
    }


    @Provides
    @Singleton
    fun providesCustomDialog(): CustomDialog {
        return CustomDialog()
    }

    @Provides
    @Singleton
    internal fun providesSqlite(): SqLiteDb {
        return SqLiteDb(AppController.getContext())
    }

    @Provides
    @Singleton
    fun providesUserChoice(): UserChoice {
        return UserChoice()
    }


}
