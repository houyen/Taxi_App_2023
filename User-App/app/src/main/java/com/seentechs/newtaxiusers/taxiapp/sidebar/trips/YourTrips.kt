package com.seentechs.newtaxiusers.taxiapp.sidebar.trips

/**
 * @package com.seentechs.newtaxiusers
 * @subpackage Side_Bar.trips
 * @category YourTrips
 * @author Seen Technologies
 * 
 */

import android.content.Intent
import android.content.res.Resources
import android.os.Bundle
import com.google.android.material.tabs.TabLayout
import androidx.viewpager.widget.ViewPager
import androidx.appcompat.app.AlertDialog

import com.google.gson.Gson
import com.seentechs.newtaxiusers.R
import com.seentechs.newtaxiusers.taxiapp.adapters.ViewPagerAdapter
import com.seentechs.newtaxiusers.appcommon.configs.SessionManager
import com.seentechs.newtaxiusers.appcommon.interfaces.ApiService
import com.seentechs.newtaxiusers.taxiapp.interfaces.YourTripsListener
import com.seentechs.newtaxiusers.appcommon.network.AppController
import com.seentechs.newtaxiusers.appcommon.utils.CommonMethods
import com.seentechs.newtaxiusers.taxiapp.views.customize.CustomDialog
import com.seentechs.newtaxiusers.taxiapp.views.main.MainActivity

import javax.inject.Inject

import butterknife.ButterKnife
import butterknife.BindView
import butterknife.OnClick

import com.seentechs.newtaxiusers.appcommon.utils.CommonMethods.Companion.DebuggableLogI
import com.seentechs.newtaxiusers.appcommon.views.CommonActivity
import kotlinx.android.synthetic.main.app_activity_add_wallet.*

/* ************************************************************
    YourTrips connect view pager
    *********************************************************** */
class YourTrips : CommonActivity(), TabLayout.OnTabSelectedListener, YourTripsListener {

    lateinit var dialog: AlertDialog
    @Inject
    lateinit var sessionManager: SessionManager
    @Inject
    lateinit var commonMethods: CommonMethods
    @Inject
    lateinit var apiService: ApiService
    @Inject
    lateinit var customDialog: CustomDialog
    @Inject
    lateinit var gson: Gson


    //This is our tablayout
    @BindView(R.id.tabLayout)
    lateinit var tabLayout: TabLayout

    //This is our viewPager
    @BindView(R.id.pager)
    lateinit var viewPager: ViewPager
    protected var isInternetAvailable: Boolean = false

    override val res: Resources
        get() = this@YourTrips.resources

    override val instance: YourTrips
        get() = this@YourTrips

    @OnClick(R.id.back)
    fun onBack() {
        if (intent.getStringExtra("upcome") == "upcome") {
            val intent = Intent(this@YourTrips, MainActivity::class.java)
            intent.putExtra("upcome", "upcome")
            startActivity(intent)
        } else {
            onBackPressed()
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_your_trips)

        AppController.appComponent.inject(this)
        ButterKnife.bind(this)


        /**Commmon Header Text View */
        commonMethods.setheaderText(resources.getString(R.string.YourTrips),common_header)

        isInternetAvailable = commonMethods.isOnline(applicationContext)
        dialog = commonMethods.getAlertDialog(this)

        if (!isInternetAvailable) {
            commonMethods.showMessage(this, dialog, resources.getString(R.string.no_connection))

        } else {
            setupViewPager(viewPager)
            tabLayout.setupWithViewPager(viewPager)
        }
        if (intent.getStringExtra("upcome") == "upcome") {
            switchTab(1)
        } else {
            switchTab(0)
        }


        setupViewPager(viewPager)
        tabLayout.setupWithViewPager(viewPager)
    }

    /**
     * Setup tab
     */

    private fun setupViewPager(viewPager: ViewPager) {
        val adapter = ViewPagerAdapter(supportFragmentManager)
        adapter.addFragment(Past(), resources.getString(R.string.pasttrip))
        adapter.addFragment(Upcoming(), resources.getString(R.string.upcomingtrips))
        viewPager.adapter = adapter
        if (intent.getStringExtra("upcome") == "upcome") {
            switchTab(1)
        } else {
            switchTab(0)
        }
    }

    override fun onTabSelected(tab: TabLayout.Tab) {
        viewPager.currentItem = tab.position

    }

    override fun onTabUnselected(tab: TabLayout.Tab) {
        DebuggableLogI("NewTaxi", "Tab")
    }

    override fun onTabReselected(tab: TabLayout.Tab) {
        DebuggableLogI("NewTaxi", "Tab")
    }

    fun switchTab(tabno: Int) {
        viewPager.currentItem = tabno
    }


}
