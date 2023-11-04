package com.tkpmnc.newtaxiusers.taxiapp.database

import android.content.Context
import android.text.TextUtils
import com.google.firebase.database.*
import com.tkpmnc.newtaxiusers.R
import com.tkpmnc.newtaxiusers.appcommon.configs.SessionManager
import com.tkpmnc.newtaxiusers.appcommon.network.AppController
import com.tkpmnc.newtaxiusers.taxiapp.firebase_keys.FirebaseDbKeys
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonKeys
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.newtaxiusers.appcommon.utils.CommonMethods.Companion.DebuggableLogE
import org.json.JSONObject
import javax.inject.Inject

class AddFirebaseDatabase {
    @Inject
    internal lateinit var sessionManager: SessionManager

    @Inject
    lateinit var commonMethods: CommonMethods

    private var mFirebaseDatabase: DatabaseReference? = null
    private var mSearchedDriverReferenceListener: ValueEventListener? = null
    private var query: Query? = null
    private val TAG = "Android_Debug"
    private var firebaseReqListener: IFirebaseReqListener? = null

    init {
        AppController.appComponent.inject(this)
    }

    fun createRequestTable(firebaseReqListener: IFirebaseReqListener,context : Context) {
        this.firebaseReqListener = firebaseReqListener
        mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
        mFirebaseDatabase!!.child(FirebaseDbKeys.Rider).child(sessionManager.userId!!).child(FirebaseDbKeys.TripId).setValue("0")
        query = mFirebaseDatabase!!.child(sessionManager.userId!!)
        addRequestChangeListener()
    }

    fun removeRequestTable() {
        try {
            mFirebaseDatabase!!.database.getReference(FirebaseDbKeys.Rider).child(sessionManager.userId!!).removeValue()
            query!!.removeEventListener(mSearchedDriverReferenceListener!!)
            mFirebaseDatabase!!.removeEventListener(mSearchedDriverReferenceListener!!)
            mSearchedDriverReferenceListener = null
        } catch (e: Exception) {
            e.printStackTrace()
        }
    }

    fun removeNodesAfterCompletedTrip(context : Context) {
        try {
            mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
            query!!.removeEventListener(mSearchedDriverReferenceListener!!)
            mFirebaseDatabase!!.removeEventListener(mSearchedDriverReferenceListener!!)
            mSearchedDriverReferenceListener = null
        } catch (e: Exception) {
            e.printStackTrace()
        }
    }



    fun firebasePushLisener(context : Context){
        mFirebaseDatabase = FirebaseDatabase.getInstance().getReference(context.getString(R.string.real_time_db))
        pushNotifQuery = mFirebaseDatabase!!.child(FirebaseDbKeys.Notification).child(sessionManager.userId!!)

        firebaseDbPush = pushNotifQuery!!.addValueEventListener(object : ValueEventListener {
            override fun onDataChange(dataSnapshot: DataSnapshot) {
                println("JSON FROM DB : ")

                if (dataSnapshot.key.equals(sessionManager.userId!!)) {
                    val pushJson = dataSnapshot.getValue(String::class.java)
                    println("JSON FROM DB : "+pushJson)
                    if (!TextUtils.isEmpty(pushJson)) {
                        val json = JSONObject(pushJson)
                        commonMethods.handleDataMessage(json,context)

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

    private fun addRequestChangeListener() {
        mSearchedDriverReferenceListener = query!!.addValueEventListener(object : ValueEventListener {
            override fun onDataChange(dataSnapshot: DataSnapshot) {
                if (dataSnapshot.hasChild(FirebaseDbKeys.TripId)) {
                    val id = dataSnapshot.child(FirebaseDbKeys.TripId).getValue(String::class.java)
                    println("get Trip id " + id!!)
                    if (!TextUtils.isEmpty(id) && !id.equals("0", ignoreCase = true)) {
                        if (!id.equals(sessionManager.tripId, ignoreCase = true)) {
                            sessionManager.tripId = id
                            firebaseReqListener!!.RequestListener(id)
                        }
                    }
                } else {
                    query!!.removeEventListener(this)
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


    companion object{
        private var firebaseDbPush: ValueEventListener? = null
        private var query: Query? = null
        private var pushNotifQuery: Query? = null
    }

}