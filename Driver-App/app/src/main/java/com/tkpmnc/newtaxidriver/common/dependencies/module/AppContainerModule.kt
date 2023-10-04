package com.tkpmnc.newtaxidriver.common.dependencies.module

/**
 * @subpackage dependencies.module
 * @category AppContainerModule
 *
 */


import android.app.Application
import android.content.Context
import android.content.SharedPreferences
import com.tkpmnc.newtaxidriver.R
import com.tkpmnc.newtaxidriver.common.configs.SessionManager
import com.tkpmnc.newtaxidriver.common.database.Sqlite
import com.tkpmnc.newtaxidriver.common.helper.CustomDialog
import com.tkpmnc.newtaxidriver.common.helper.RunTimePermission
import com.tkpmnc.newtaxidriver.common.model.JsonResponse
import com.tkpmnc.newtaxidriver.common.network.AppController
import com.tkpmnc.newtaxidriver.common.util.userchoice.UserChoice
import com.tkpmnc.newtaxidriver.home.service.ForeService
import dagger.Module
import dagger.Provides
import java.util.*
import javax.inject.Singleton

/*****************************************************************
 * App Container Module
 */
@Module(includes = [com.tkpmnc.newtaxidriver.common.dependencies.module.ApplicationModule::class])
class AppContainerModule {
    @Provides
    @Singleton
    fun providesSharedPreferences(application: Application): SharedPreferences {
        return application.getSharedPreferences(application.resources.getString(R.string.app_name), Context.MODE_PRIVATE)
    }


    @Provides
    @Singleton
    fun providesContext(application: Application): Context {
        return application.applicationContext
    }

    @Provides
    @Singleton
    fun providesSessionManager(): SessionManager {
        return SessionManager()
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
    fun providesRunTimePermission(): RunTimePermission {
        return RunTimePermission()
    }

    @Provides
    @Singleton
    internal fun providesCustomDialog(): CustomDialog {
        return CustomDialog()
    }


    @Provides
    @Singleton
    internal fun providesForeService(): ForeService {
        return ForeService()
    }

    @Provides
    @Singleton
    internal fun providesSqlite(): Sqlite {
        return Sqlite(AppController.appContext)
    }
    @Provides
    @Singleton
    internal fun providesUserChoice(): UserChoice {
        return UserChoice()
    }


}
