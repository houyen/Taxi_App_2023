package com.tkpmnc.sgtaxidriver.home.datamodel.firebase_keys


import androidx.annotation.StringDef


object FirebaseDbKeys {

    var Rider = "rider"
    var Driver = "driver"
    var TripId = "trip_id"
    var RELEASE_TYPE = "live"
    var TRIPLIVEPOLYLINE = "path"
    var TRIPETA = "eta_min"
    var GEOFIRE = "GeoFire"
    var Notification = "Notification"

    var TRIP_REQUEST = "trip_request"


    var LIVE_TRACKING_NODE = "live_tracking"
    var chatFirebaseDatabaseName = "driver_rider_trip_chats"

    @StringDef(TYPE_CASH)
    @kotlin.annotation.Retention(AnnotationRetention.SOURCE)
    annotation class PaymentChangeMode {
        companion object {
            const val TYPE_CASH = "C"
        }
    }
}
    