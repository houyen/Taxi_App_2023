package com.tkpmnc.sgtaxidriver.common.network

/**
 * @package com.tkpmnc.sgtaxidriver.common.network
 * @subpackage network
 * @category AppController
 * 
 *
 */

import android.app.Application
import android.content.Context
import android.os.Build
import android.os.LocaleList
import androidx.appcompat.app.AppCompatDelegate
import androidx.multidex.MultiDex
import com.google.firebase.crashlytics.FirebaseCrashlytics
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.common.dependencies.component.AppComponent
import com.tkpmnc.sgtaxidriver.common.dependencies.component.DaggerAppComponent
import com.tkpmnc.sgtaxidriver.common.dependencies.module.ApplicationModule
import com.tkpmnc.sgtaxidriver.common.dependencies.module.NetworkModule
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import java.util.*


class AppController : Application() {
    private var locale: Locale? = null

    override fun onCreate() {
        super.onCreate()
        MultiDex.install(this)
        appContext = this
        instance = this
        setLocale()

        AppCompatDelegate.setCompatVectorFromResourcesEnabled(true)

        appComponent = DaggerAppComponent.builder().applicationModule(ApplicationModule(this)) // This also corresponds to the name of your module: %component_name%Module
                .networkModule(NetworkModule(getString(R.string.apiBaseUrl))).build()

        FirebaseCrashlytics.getInstance().setCrashlyticsCollectionEnabled(true)
    }

    private fun setLocale() {
        locale = Locale("en")
        Locale.setDefault(locale)
        val configuration = baseContext.resources.configuration
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
            configuration.setLocale(locale)
            val localeList = LocaleList(locale)
            LocaleList.setDefault(localeList)
            configuration.setLocales(localeList)
        } else
            configuration.setLocale(locale)
        baseContext.createConfigurationContext(configuration)
    }

    /*
     * Multidex enable
     */
    override fun attachBaseContext(base: Context) {
        super.attachBaseContext(base)
        MultiDex.install(this)
    }

    companion object {

        val TAG = AppController::class.java.simpleName

        @get:Synchronized
        var instance: AppController? = null
            private set
        lateinit private var appComponent: AppComponent
        lateinit var appContext: Context


        /* public static SinchClient sinchClient = null;
    public static Call call;*/

        fun getAppComponent(): AppComponent {
            CommonMethods.DebuggableLogV("non", "null" + appComponent)
            return appComponent
        }

        // or return instance.getApplicationContext();
        val context: Context?
            get() = instance
    }

}