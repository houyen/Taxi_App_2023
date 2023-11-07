package com.tkpmnc.newtaxidriver.common.database

import android.content.Context
import android.text.TextUtils
import com.firebase.geofire.GeoFire
import com.google.firebase.database.*
import com.tkpmnc.newtaxidriver.R
import com.tkpmnc.newtaxidriver.common.configs.SessionManager
import com.tkpmnc.newtaxidriver.common.network.AppController
import com.tkpmnc.newtaxidriver.common.util.CommonMethods
import com.tkpmnc.newtaxidriver.common.util.CommonMethods.Companion.DebuggableLogE
import com.tkpmnc.newtaxidriver.home.datamodel.firebase_keys.FirebaseDbKeys
import org.json.JSONObject
import javax.inject.Inject

class AddFirebaseDatabase {
    @Inject
    lateinit var sessionManager: SessionManager

    @Inject
    lateinit var commonMethods: CommonMethods

    private var mFirebaseDatabase: DatabaseReference? = null
    private var geofire: GeoFire? = null
    private var mSearchedDriverReferenceListener: ValueEventListener? = null
    private var query: Query? = null
    private val TAG = "Android_Debug"
    private val firebaseReqListener: IFirebaseReqListener? = null

    init {
        AppController.getAppComponent().inject(this)
    }

    fun updateRequestTable(riderId: String, tripId: String, context: Context) {
        mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
        mFirebaseDatabase!!.child(FirebaseDbKeys.Rider).child(riderId).child(FirebaseDbKeys.TripId).setValue(tripId)
        query = mFirebaseDatabase!!.child(riderId)
    }


    fun removeNodesAfterCompletedTrip(context: Context) {
        try {
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))

            query!!.removeEventListener(mSearchedDriverReferenceListener!!)
            mFirebaseDatabase!!.removeEventListener(mSearchedDriverReferenceListener!!)
            sessionManager.clearTripID()
            sessionManager.poolIds = ""
            sessionManager.isPool = false
            mSearchedDriverReferenceListener = null
        } catch (e: Exception) {
            e.printStackTrace()
        }
    }

    fun removeLiveTrackingNodesAfterCompletedTrip(context: Context) {
        try {
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
            sessionManager.tripId?.let { mFirebaseDatabase!!.child(FirebaseDbKeys.LIVE_TRACKING_NODE).child(it).removeValue() }
        } catch (e: Exception) {
            e.printStackTrace()
        }
        removeNodesAfterCompletedTrip(context)
    }

    fun removeRequestTable() {

        /* mFirebaseDatabase.getDatabase().getReference(FirebaseDbKeys.Rider).removeValue();
        query.removeEventListener(mSearchedDriverReferenceListener);
        mFirebaseDatabase.removeEventListener(mSearchedDriverReferenceListener);
        mSearchedDriverReferenceListener = null;*/
        query!!.removeEventListener(mSearchedDriverReferenceListener!!)
    }

    fun removeDriverFromGeofire(context: Context) {
        mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db)).child(FirebaseDbKeys.GEOFIRE)
        geofire = GeoFire(mFirebaseDatabase)
        geofire!!.removeLocation(sessionManager.userId)
    }


    fun firebasePushLisener(context: Context) {
        mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
        pushNotifQuery = mFirebaseDatabase!!.child(FirebaseDbKeys.Notification).child(sessionManager.userId!!)

        firebaseDbPush = pushNotifQuery!!.addValueEventListener(object : ValueEventListener {
            override fun onDataChange(dataSnapshot: DataSnapshot) {
                println("JSON FROM DB : ")

                if (dataSnapshot.key.equals(sessionManager.userId!!)) {
                    val pushJson = dataSnapshot.getValue(String::class.java)
                    println("JSON FROM DB : " + pushJson)
                    if (!TextUtils.isEmpty(pushJson) && dataSnapshot.value != null) {
                        val json = JSONObject(pushJson)
                        commonMethods.handleDataMessage(json, context)

                        mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
                        mFirebaseDatabase!!.child(FirebaseDbKeys.Notification).child(sessionManager.userId!!).removeValue()

                    }
                } else {
                    pushNotifQuery!!.removeEventListener(this)
                    mFirebaseDatabase!!.removeEventListener(this)
                    mFirebaseDatabase!!.onDisconnect()
                }
            }

            override fun onCancelled(error: DatabaseError) {
                // Failed to read value
                DebuggableLogE(TAG, "Failed to read user", error.toException())
            }
        })

    }


    fun updateEtaToFirebase(eta: String, context: Context) {
        if (sessionManager.isTrip) {
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
        }

    }

    fun UpdatePolyLinePoints(overviewpolylines: String, context: Context) {
        if (sessionManager.isTrip) {
            val value = overviewpolylines
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
            var poolIds: List<String> = sessionManager.poolIds!!.split(",").map { it.trim() }
        }

    }

    companion object {
        private var firebaseDbPush: ValueEventListener? = null
        private var query: Query? = null
        private var pushNotifQuery: Query? = null
    }
}
