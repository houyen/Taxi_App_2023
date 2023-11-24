package com.tkpmnc.sgtaxiusers.appcommon.dependencies.module

/**
 * @package com.tkpmnc.sgtaxiusers
 * @subpackage dependencies.module
 * @category AppContainerModule
 * @author Seen Technologies
 *
 */

import android.app.Application
import android.content.Context
import android.content.SharedPreferences
import com.tkpmnc.sgtaxiusers.R
import com.tkpmnc.sgtaxiusers.appcommon.configs.RunTimePermission
import com.tkpmnc.sgtaxiusers.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiusers.appcommon.database.SqLiteDb
import com.tkpmnc.sgtaxiusers.appcommon.datamodels.JsonResponse
import com.tkpmnc.sgtaxiusers.appcommon.network.AppController
import com.tkpmnc.sgtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiusers.appcommon.utils.userchoice.UserChoice
import com.tkpmnc.sgtaxiusers.taxiapp.views.customize.CustomDialog
import dagger.Module
import dagger.Provides
import java.util.*
import javax.inject.Singleton

/*****************************************************************
 * App Container Module
 */
@Module(includes = [com.tkpmnc.sgtaxiusers.appcommon.dependencies.module.ApplicationModule::class])
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
