package com.tkpmnc.sgtaxiusers.taxiapp.sidebar

/**
 * @package com.tkpmnc.sgtaxiusers
 * @subpackage Side_Bar
 * @category FareBreakdown
 * @author Seen Technologies
 *
 */

import android.os.Bundle
import android.widget.TextView
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.tkpmnc.sgtaxiusers.R
import com.tkpmnc.sgtaxiusers.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiusers.appcommon.network.AppController
import com.tkpmnc.sgtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiusers.appcommon.views.CommonActivity
import com.tkpmnc.sgtaxiusers.taxiapp.datamodels.main.NearestCar
import kotlinx.android.synthetic.main.app_activity_add_wallet.*
import java.util.*
import javax.inject.Inject

/* ************************************************************
   Price break for selected car details
    *********************************************************** */
class FareBreakdown : CommonActivity() {

    @Inject
    lateinit var sessionManager: SessionManager

    @BindView(R.id.amount1)
    lateinit var amount1: TextView

    @BindView(R.id.amount2)
    lateinit var amount2: TextView

    @BindView(R.id.amount3)
    lateinit var amount3: TextView

    @BindView(R.id.amount4)
    lateinit var amount4: TextView
    lateinit var searchlist: ArrayList<NearestCar>
    var position: Int = 0

    @Inject
    lateinit var commonMethods: CommonMethods

    @OnClick(R.id.back)
    fun back() {
        onBackPressed()
    }


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_fare_breakdown)
        ButterKnife.bind(this)
        AppController.appComponent.inject(this)
        commonMethods.setheaderText(resources.getString(R.string.farebreakdown), common_header)
        searchlist = intent.getSerializableExtra("list") as ArrayList<NearestCar>
        position = intent.getIntExtra("position", 0)

        /**
         * Show price breakdown for selected car before send request
         */
        amount1.text = sessionManager.currencySymbol + searchlist[position].baseFare
        amount2.text = sessionManager.currencySymbol + searchlist[position].baseFare
        amount3.text = sessionManager.currencySymbol + searchlist[position].perMin
        amount4.text = sessionManager.currencySymbol + searchlist[position].perKm
    }

    /**
     * Back button to close
     */
    override fun onBackPressed() {
        super.onBackPressed()
        overridePendingTransition(R.anim.ub__slide_in_left, R.anim.ub__slide_out_right)
    }
}
