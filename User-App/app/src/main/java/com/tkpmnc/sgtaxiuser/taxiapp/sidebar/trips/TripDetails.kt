package com.tkpmnc.sgtaxiuser.taxiapp.sidebar.trips

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage Side_Bar.trips
 * @category TripDetails
 * 
 *
 */

import android.content.Intent
import android.database.Cursor
import android.os.Bundle
import android.text.TextUtils
import android.view.Gravity
import android.view.View
import android.widget.Button
import android.widget.ImageView
import android.widget.RelativeLayout
import android.widget.TextView
import androidx.appcompat.app.AlertDialog
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import androidx.viewpager.widget.ViewPager
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.google.android.gms.maps.model.LatLng
import com.google.gson.Gson
import com.squareup.picasso.Picasso
import com.tkpmnc.sgtaxiuser.R
import com.tkpmnc.sgtaxiuser.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiuser.appcommon.database.SqLiteDb
import com.tkpmnc.sgtaxiuser.appcommon.datamodels.JsonResponse
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ApiService
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ServiceListener
import com.tkpmnc.sgtaxiuser.appcommon.network.AppController
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods.Companion.showInternetNotAvailableForStoredDataViewer
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods.Companion.showNoInternetAlert
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_TRIP_DETAIL
import com.tkpmnc.sgtaxiuser.appcommon.utils.RequestCallback
import com.tkpmnc.sgtaxiuser.appcommon.views.CommonActivity

import com.tkpmnc.sgtaxiuser.taxiapp.adapters.ViewPagerAdapter
import com.tkpmnc.sgtaxiuser.taxiapp.datamodels.trip.Riders
import com.tkpmnc.sgtaxiuser.taxiapp.datamodels.trip.TripDetailsModel
import com.tkpmnc.sgtaxiuser.taxiapp.sendrequest.DriverRatingActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.customize.CustomDialog
import org.json.JSONException
import com.tkpmnc.sgtaxiuser.taxiapp.adapters.PriceRecycleAdapter
import kotlinx.android.synthetic.main.app_activity_add_wallet.common_header
import kotlinx.android.synthetic.main.app_activity_trip_details.*

import javax.inject.Inject

/* ************************************************************
    Selected Trip details
    *********************************************************** */
class TripDetails : CommonActivity(), ServiceListener {

    @Inject
    lateinit var dbHelper: SqLiteDb
    private var isViewUpdatedWithLocalDB: Boolean = false

    lateinit var tripId: String

    @Inject
    lateinit var sessionManager: SessionManager
    lateinit var dialog: AlertDialog

    @Inject
    lateinit var commonMethods: CommonMethods

    @Inject
    lateinit var apiService: ApiService

    @Inject
    lateinit var customDialog: CustomDialog

    @Inject
    lateinit var gson: Gson

    @BindView(R.id.carname)
    lateinit var carname: TextView

    @BindView(R.id.rlt_mapview)
    lateinit var mapView: RelativeLayout

    @BindView(R.id.driver_name)
    lateinit var driver_name: TextView

    @BindView(R.id.datetime)
    lateinit var datetime: TextView

    @BindView(R.id.amountcard)
    lateinit var amountcard: TextView

    @BindView(R.id.mapimage)
    lateinit var mapimage: ImageView

    @BindView(R.id.iv_profileimage)
    lateinit var ProfileImage: ImageView

    @BindView(R.id.profilelayout)
    lateinit var profilelayout: RelativeLayout

    @BindView(R.id.btnrate)
    lateinit var btnrate: Button

    @BindView(R.id.seatcount)
    lateinit var seatcount: TextView

    @BindView(R.id.rvPrice)
    lateinit var recyclerView: RecyclerView

    @BindView(R.id.tv_tripid)
    lateinit var tvTripid: TextView

    @BindView(R.id.tv_tripstatus)
    lateinit var tripstatus: TextView

    @OnClick(R.id.back)
    fun back() {
        onBackPressed()
    }

    @OnClick(R.id.btnrate)
    fun rate() {
        val rating = Intent(this, DriverRatingActivity::class.java)
        rating.putExtra("imgprofile", tripDetailsModel.driverThumbImage)
        rating.putExtra("tripid", ridersDetails.tripId)
        rating.putExtra("back", 1)
        startActivity(rating)
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_trip_details)
        AppController.appComponent.inject(this)
        ButterKnife.bind(this)
        dialog = commonMethods.getAlertDialog(this)
        /**Commmon Header Text View */
        commonMethods.setheaderText(resources.getString(R.string.tripDetails), common_header)
        val intent = intent
        tripId = intent.getStringExtra("tripId").toString()
        getTripDetails()
    }

    private fun setupViewPager(viewPager: ViewPager) {
        val adapter = ViewPagerAdapter(supportFragmentManager)
        adapter.addFragment(Receipt(), getString(R.string.receipt))
        viewPager.adapter = adapter
    }


    private fun getTripDetails() {
        val allHomeDataCursor: Cursor = dbHelper.getDocument(Constants.DB_KEY_TRIP_DETAILS + tripId)
        if (allHomeDataCursor.moveToFirst()) {
            isViewUpdatedWithLocalDB = true
            //tvOfflineAnnouncement.setVisibility(View.VISIBLE)
            try {
                onSuccessTripDetail(allHomeDataCursor.getString(0))
            } catch (e: JSONException) {
                e.printStackTrace()
            }
        } else {
            followProcedureForNoDataPresentInDB()
        }
    }

    private fun getUserTripsDetail() {
        if (commonMethods.isOnline(this)) {
            apiService.getTripDetails(sessionManager.accessToken!!, tripId).enqueue(RequestCallback(REQ_TRIP_DETAIL, this))
        } else {
            showInternetNotAvailableForStoredDataViewer(this)
        }
    }

    fun followProcedureForNoDataPresentInDB() {
        if (commonMethods.isOnline(this)) {
            commonMethods.showProgressDialog(this)
            getUserTripsDetail()
        } else {
            showNoInternetAlert(this, object : CommonMethods.INoInternetCustomAlertCallback {
                override fun onOkayClicked() {
                    finish()
                }

                override fun onRetryClicked() {
                    followProcedureForNoDataPresentInDB()
                }

            })
        }
    }

    override fun onSuccess(jsonResp: JsonResponse, data: String) {
        commonMethods.hideProgressDialog()
        if (!jsonResp.isOnline) {
            if (!TextUtils.isEmpty(data))
                commonMethods.showMessage(this, dialog, data)
            return
        }
        when (jsonResp.requestCode) {

            REQ_TRIP_DETAIL -> if (jsonResp.isSuccess) {
                commonMethods.hideProgressDialog()
                dbHelper.insertWithUpdate(Constants.DB_KEY_TRIP_DETAILS.toString() + tripId, jsonResp.strResponse)
                onSuccessTripDetail(jsonResp.strResponse)
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.hideProgressDialog()
                commonMethods.showMessage(this, dialog, jsonResp.statusMsg)
            }
        }
    }

    override fun onFailure(jsonResp: JsonResponse, data: String) {
        commonMethods.hideProgressDialog()
        commonMethods.showMessage(this, dialog, data)
    }

    private fun onSuccessTripDetail(jsonResponse: String) {
        tripDetailsModel = gson.fromJson(jsonResponse, TripDetailsModel::class.java)
        ridersDetails = tripDetailsModel!!.riders?.get(0)!!
        recyclerView.setHasFixedSize(true)
        val layoutManager = LinearLayoutManager(this)
        recyclerView.layoutManager = layoutManager
       
        val adapter = PriceRecycleAdapter(this)
        recyclerView.adapter = adapter
        tv_pick_Address.text = ridersDetails.pickup
        tv_drop_address.text = ridersDetails.drop
        tvTripid.text = resources.getString(R.string.trip_id) + ridersDetails.tripId.toString()
        tripstatus.text = ridersDetails.status
        if ("1".equals(resources.getString(R.string.layout_direction))){
            tripstatus.gravity = Gravity.START
        }else{
            tripstatus.gravity = Gravity.END
        }

        if (TextUtils.isEmpty(ridersDetails.mapImage)) {
            val pikcuplatlng = LatLng(java.lang.Double.valueOf(ridersDetails.pickupLat), java.lang.Double.valueOf(ridersDetails.pickupLng))
            val droplatlng = LatLng(java.lang.Double.valueOf(ridersDetails.dropLat), java.lang.Double.valueOf(ridersDetails.dropLng))

            //val pathString = "&path=color:0x000000ff%7Cweight:4%7Cenc:" + ridersDetails.tripPath
            val pickupstr = pikcuplatlng.latitude.toString() + "," + pikcuplatlng.longitude
            val dropstr = droplatlng.latitude.toString() + "," + droplatlng.longitude
            val positionOnMap = "&markers=size:mid|icon:" + resources.getString(R.string.image_url) + "pickup.png|" + pickupstr
            val positionOnMap1 = "&markers=size:mid|icon:" + resources.getString(R.string.image_url) + "drop.png|" + dropstr
            mapView.visibility = View.GONE
        } else {
        
            mapView.visibility = View.VISIBLE
            Picasso.get().load(ridersDetails.mapImage)
                    .into(mapimage)
        }

        if (tripDetailsModel.isPool!! && tripDetailsModel.seats != 0) {
            seatcount.visibility = View.VISIBLE
            seatcount.setText(resources.getString(R.string.seat_count) + " " + tripDetailsModel.seats.toString())
        } else {
            seatcount.visibility = View.GONE
        }
        carname.text = tripDetailsModel.vehicleName
        tv_pick_Address.text = ridersDetails.pickup
        tv_drop_address.text = ridersDetails.drop

        datetime.setText(ridersDetails.creatdate);
        amountcard.text = sessionManager.currencySymbol + ridersDetails.totalFare

        driver_name.text = resources.getString(R.string.your_ride_with) + " " + tripDetailsModel.driverName

        val profileurl = tripDetailsModel.driverThumbImage


        if (profileurl != "") {
            Picasso.get().load(profileurl)
                    .into(ProfileImage)
        }

       
        if (isViewUpdatedWithLocalDB) {
            isViewUpdatedWithLocalDB = false
            getUserTripsDetail()
        }
    }

    companion object {

        lateinit var tripDetailsModel: TripDetailsModel

        lateinit var ridersDetails: Riders
    }
}
