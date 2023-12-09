package com.tkpmnc.sgtaxidriver.trips

/**
 * @package com.tkpmnc.sgtaxidriver.home
 * @subpackage home
 * @category RiderContactActivity
 * 
 *
 */

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.View
import android.widget.LinearLayout
import android.widget.TextView
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.common.util.CommonKeys
import com.tkpmnc.sgtaxidriver.common.util.CommonKeys.KEY_CALLER_ID
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import com.tkpmnc.sgtaxidriver.common.views.CommonActivity
import com.tkpmnc.sgtaxidriver.home.firebaseChat.ActivityChat
import com.tkpmnc.sgtaxidriver.trips.voip.CallProcessingActivity
import javax.inject.Inject

/* ************************************************************
                      RiderContactActivity
Its used to get RiderContactActivity details
*************************************************************** */
class RiderContactActivity : CommonActivity() {

    lateinit @Inject
    var sessionManager: SessionManager
    lateinit @Inject
    var commonMethods: CommonMethods

    lateinit @BindView(R.id.mobilenumbertext)
    var mobilenumbertext: TextView
    lateinit @BindView(R.id.ridername)
    var ridername: TextView

   // lateinit @BindView(R.id.ll_message)
    //var llMessage: LinearLayout

    @OnClick(R.id.back)
    fun onBack() {
        onBackPressed()
    }

    @OnClick(R.id.callbutton)
    fun call() {
        if (sessionManager.bookingType == CommonKeys.RideBookedType.manualBooking) {
            val intent =  Intent(Intent.ACTION_DIAL, Uri.parse("tel:" + mobilenumbertext.getText().toString()));
            startActivity(intent);
        }else{
            val intent =  Intent(Intent.ACTION_DIAL, Uri.parse("tel:" + mobilenumbertext.getText().toString()));
            startActivity(intent);
        }
    }


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_rider_contact)
        ButterKnife.bind(this)
        AppController.getAppComponent().inject(this)
        commonMethods.setheaderText(resources.getString(R.string.contact_C),common_header)
        ridername.text = intent.getStringExtra("ridername")
        mobilenumbertext.setText(getIntent().getStringExtra("mobile_number"))
        println("mobilenumbertext ${mobilenumbertext.text.toString()}")
        if (sessionManager.bookingType == CommonKeys.RideBookedType.manualBooking) {
        }
    }

    override fun onBackPressed() {
        super.onBackPressed()
        overridePendingTransition(R.anim.ub__slide_in_left, R.anim.ub__slide_out_right)
    }

    companion object {

        val CALL = 0x2
    }
}
